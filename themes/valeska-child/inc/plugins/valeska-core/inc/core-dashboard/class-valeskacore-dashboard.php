<?php

if ( ! class_exists( 'ValeskaCore_Dashboard' ) ) {
	class ValeskaCore_Dashboard {
		private static $instance;

		private $sub_pages      = array();
		private $validation_url = 'https://api.qodeinteractive.com/purchase-code-validation.php';
		public $licence_field   = 'valeska_purchase_info';
		public $import_field    = 'valeska_import_params';

		function __construct() {
			// Order of hooks is important, dashboard_add_page method needs to be at the end
			add_action( 'admin_menu', array( &$this, 'register_sub_pages' ) );
			add_action( 'admin_menu', array( &$this, 'dashboard_add_page' ) );

			add_action( 'valeska_core_action_on_deactivation', array( &$this, 'remove_redirect' ) );

			if ( 'yes' === get_option( 'valeska_core_activated_first_time' ) ) {
				add_action( 'valeska_core_action_plugin_loaded', array( &$this, 'page_welcome_redirect' ) );
			}

			add_action( 'after_setup_theme', array( $this, 'load_files' ) );
		}

		/**
		 * @return ValeskaCore_Dashboard
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function set_sub_pages( ValeskaCore_Dashboard_Sub_Page $sub_page ) {
			$this->sub_pages[ $sub_page->get_base() ] = $sub_page;
		}

		function get_sub_pages() {
			return $this->sub_pages;
		}

		function load_files() {
			include_once VALESKA_CORE_INC_PATH . '/core-dashboard/rest/include.php';
			include_once VALESKA_CORE_INC_PATH . '/core-dashboard/class-valeskacore-dashboard-registration.php';
			include_once VALESKA_CORE_INC_PATH . '/core-dashboard/class-valeskacore-dashboard-theme-validation.php';
			include_once VALESKA_CORE_INC_PATH . '/core-dashboard/sub-pages/class-valeskacore-dashboard-sub-page.php';

			foreach ( glob( VALESKA_CORE_INC_PATH . '/core-dashboard/sub-pages/*/include.php' ) as $subpages ) {
				include_once $subpages;
			}
		}

		function dashboard_add_page() {

			$page = add_menu_page(
				esc_html__( 'Valeska Dashboard', 'valeska-core' ),
				esc_html__( 'Valeska Dashboard', 'valeska-core' ),
				'administrator',
				'valeska_core_dashboard',
				array( &$this, 'load_dashboard_template' ),
				VALESKA_CORE_INC_URL_PATH . '/core-dashboard/assets/img/admin-logo-icon.png',
				998
			);

			add_action( 'load-' . $page, array( &$this, 'load_admin_css' ) );

			foreach ( $this->get_sub_pages() as $sub_page => $sub_page_value ) {
				$sub_page_instance = add_submenu_page(
					'valeska_core_dashboard',
					$sub_page_value->get_title(),
					$sub_page_value->get_title(),
					'administrator',
					$sub_page,
					array( $sub_page_value, 'render' )
				);

				add_action( 'load-' . $sub_page_instance, array( &$this, 'load_admin_css' ) );
			}
		}

		function load_dashboard_template() {
			$params                 = array();
			$params['theme_name']   = qode_framework_is_installed( 'theme' ) ? esc_html( wp_get_theme()->get( 'Name' ) ) : esc_html__( 'Qode Interactive', 'valeska-core' );
			$params['system_info']  = ValeskaCore_Dashboard_System_Info_Page::get_instance()->get_system_info();
			$params['info']         = $this->purchased_code_info();
			$params['is_activated'] = ! empty( $this->get_purchased_code() );

			valeska_core_template_part( 'core-dashboard', 'templates/core-dashboard', '', $params );
		}

		public function register_sub_pages() {
			$sub_pages = apply_filters( 'valeska_core_filter_add_welcome_sub_page', $icons = array() );

			if ( ! empty( $sub_pages ) ) {
				foreach ( $sub_pages as $sub_page ) {
					$this->set_sub_pages( new $sub_page() );
				}
			}
		}

		function load_admin_css() {
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		}

		function enqueue_styles() {
			wp_enqueue_style( 'select2', QODE_FRAMEWORK_INC_URL_PATH . '/common/assets/plugins/select2/select2.min.css' );
			wp_enqueue_style( 'valeska-core-dashboard-style', VALESKA_CORE_INC_URL_PATH . '/core-dashboard/assets/css/core-dashboard.min.css' );
		}

		function enqueue_scripts() {
			wp_enqueue_script( 'select2', QODE_FRAMEWORK_INC_URL_PATH . '/common/assets/plugins/select2/select2.full.min.js', array(), false, true );
			wp_enqueue_script( 'valeska-core-dashboard-script', VALESKA_CORE_INC_URL_PATH . '/core-dashboard/assets/js/modules/core-dashboard.js', array(), false, true );
			$global_variables = apply_filters( 'valeska_core_filter_dashboard_js_global_variables', array() );

			wp_localize_script(
				'valeska-core-dashboard-script',
				'qodefCoreDashboardGlobalVars',
				array(
					'vars' => $global_variables,
				)
			);
		}

		function remove_redirect() {
			delete_transient( 'valeska_core_welcome_page_redirect' );
		}

		function page_welcome_redirect() {
			$redirect = get_transient( 'valeska_core_welcome_page_redirect' );

			if ( empty( $redirect ) ) {
				set_transient( 'valeska_core_welcome_page_redirect', 1, 31536000 );

				wp_safe_redirect( add_query_arg( array( 'page' => 'valeska_core_dashboard' ), esc_url( admin_url( 'admin.php' ) ) ) );
			}
		}
		function theme_validation() {
			$is_theme_active = qode_framework_is_installed( 'theme' );

			qode_framework_get_ajax_status( 'success', '', array( 'is_theme_active' => $is_theme_active ) );
		}

		function purchase_code_registration() {

			if ( ! isset( $_POST ) || empty( $_POST ) ) {
				return esc_html__( 'All fields are empty', 'valeska-core' );
			} else {
				switch ( $_POST['options']['action'] ) :
					case 'register':
						$this->register_purchase_code( $_POST['options']['post'] );
						break;
					case 'deregister':
						$this->deregister_purchase_code();
						break;
				endswitch;
			}

			wp_die();
		}

		function register_purchase_code() {
			$data        = array();
			$data_string = $_POST['options']['post'];
			parse_str( $data_string, $data );

			if ( empty( $data['purchase_code'] ) || empty( $data['email'] ) ) {
				qode_framework_get_ajax_status(
					'error',
					esc_html__( 'Purchase Code and Email are empty', 'valeska-core' ),
					array(
						'purchase_code' => false,
						'email'         => false,
					)
				);
			} elseif ( empty( $data['purchase_code'] ) ) {
				qode_framework_get_ajax_status( 'error', esc_html__( 'Purchase Code is empty', 'valeska-core' ), array( 'purchase_code' => false ) );
			} elseif ( empty( $data['email'] ) ) {
				qode_framework_get_ajax_status( 'error', esc_html__( 'Email is empty', 'valeska-core' ), array( 'email' => false ) );
			}

			$url = add_query_arg(
				array(
					'purchase_code' => rtrim( $data['purchase_code'] ),
					'email'         => $data['email'],
					'profile'       => VALESKA_CORE_PROFILE_SLUG . '-themes',
					'demo_url'      => esc_url( get_site_url() ),
					'action'        => 'register',
				),
				$this->validation_url
			);

			$json = $this->api_connection( $url );

			if ( isset( $json['success'] ) && $json['success'] ) {

				update_option( $this->licence_field, $json['data']['validation'] );
				update_option( $this->import_field, $json['data']['import'] );
				qode_framework_get_ajax_status( 'success', $this->response_codes( $json['response_code'] ) );

			} elseif ( isset( $json['message'] ) && ! $json['success'] && ( isset( $json['data']['error'] ) && 404 == $json['data']['error'] ) ) {

				qode_framework_get_ajax_status( 'error', $this->response_codes( $json['response_code'] ), array( 'purchase_code' => false ) );

			} elseif ( isset( $json['message'] ) && ! $json['success'] && ( isset( $json['data']['error'] ) && 'used' === $json['data']['error'] ) ) {

				qode_framework_get_ajax_status( 'error', $this->response_codes( $json['response_code'], $json['data'] ), array( 'already_used' => true ) );

			} elseif ( isset( $json['message'] ) && ! $json['success'] ) {

				qode_framework_get_ajax_status( 'error', $this->response_codes( $json['response_code'] ) );
			}
		}

		function deregister_purchase_code() {
			$code = $this->get_purchased_code();

			$url = add_query_arg(
				array(
					'purchase_code' => $code,
					'action'        => 'deregister',
					'profile'       => VALESKA_CORE_PROFILE_SLUG . '-themes',
				),
				$this->validation_url
			);

			$json = $this->api_connection( $url );

			if ( $json['success'] ) {
				delete_option( $this->licence_field );
				delete_option( $this->import_field );
				qode_framework_get_ajax_status( 'success', $this->response_codes( $json['response_code'] ) );
			} else {
				qode_framework_get_ajax_status( 'error', $this->response_codes( $json['response_code'] ) );
			}
		}

		function check_purchase_code( $demo ) {
			$code = $this->get_purchased_code();

			$url = add_query_arg(
				array(
					'purchase_code' => $code,
					'action'        => 'check',
					'profile'       => VALESKA_CORE_PROFILE_SLUG . '-themes',
					'demo'          => $demo,
				),
				$this->validation_url
			);

			$json = $this->api_connection( $url );

			if ( $json['success'] ) {
				return true;
			} else {
				return false;
			}
		}

		function get_purchased_code_data() {
			return get_option( $this->licence_field );
		}

		function purchased_code_info() {
			$info = $this->get_purchased_code_data();

			if ( $info && ! empty( $info ) ) {
				return $info;
			} else {
				return false;
			}
		}

		function get_purchased_code() {
			$info = $this->purchased_code_info();

			if ( is_array( $info ) && isset( $info['purchase_code'] ) ) {
				return $info['purchase_code'];
			}

			return '';
		}
		function get_code() {
			$code = $this->get_purchased_code();

			if ( empty( $code ) && ( in_array( getenv( 'REMOTE_ADDR' ), array( '127.0.0.1', '::1' ), true ) || strpos( getenv( 'HTTP_HOST' ), 'qodeinteractive' ) !== false ) ) {
				$code = true;
			}

			return $code;
		}

		function get_import_params() {
			$params = get_option( $this->import_field );

			if ( is_array( $params ) && count( $params ) > 0 ) {
				return $params;
			}

			return false;
		}

		function api_connection( $url ) {
			$response = wp_remote_get(
				$url,
				array(
					'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . esc_url( home_url( '/' ) ),
					'timeout'    => 30,
				)
			);

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$response_code = wp_remote_retrieve_response_code( $response );
			if ( 200 !== intval( $response_code ) ) {
				return new WP_Error( 'bad_request', esc_html__( 'Bad request', 'valeska-core' ) );
			}

			$json = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $json ) || ! is_array( $json ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Invalid Response', 'valeska-core' ) );
			}

			return $json;
		}

		function response_codes( $code, $data = array() ) {
			$message = '';

			switch ( $code ) :
				case 200:
					$message = esc_html__( 'Failed to validate code due to an error', 'valeska-core' );
					break;
				case 400:
					$message = esc_html__( 'Parameter or argument in the request was invalid', 'valeska-core' );
					break;
				case 401:
					$message = esc_html__( 'The authorization header is missing. Verify that your code is correct.', 'valeska-core' );
					break;
				case 403:
					$message = esc_html__( 'Personal token is incorrect or does not have the required permission(s)', 'valeska-core' );
					break;
				case 404:
					$message = esc_html__( 'The purchase code is invalid', 'valeska-core' );
					break;
				case 601:
					$message = esc_html__( 'You successfully activated theme', 'valeska-core' );
					break;
				case 602:
					$message = esc_html__( 'Code is valid', 'valeska-core' );
					break;
				case 603:
					$message = esc_html__( 'You successfully added demo', 'valeska-core' );
					break;
				case 604:
					$message = esc_html__( 'You successfully deregister theme', 'valeska-core' );
					break;
				case 650:
					$registered_url = '';

					if ( ! empty( $data ) && isset( $data['registered_url'] ) && ! empty( $data['registered_url'] ) ) {
						$registered_url = ' - ' . esc_url( $data['registered_url'] );
					}

					$message = sprintf(
						esc_html__( 'This code was already used to register another domain%s. Please deregister your code there so that you can use it for registering here.', 'masterds-core' ),
						$registered_url
					);
					break;
				case 651:
					$message = esc_html__( 'Error occurred during activation', 'valeska-core' );
					break;
				case 652:
					$message = esc_html__( 'Code is invalid', 'valeska-core' );
					break;
				case 653:
					$message = esc_html__( 'Error occurred during adding', 'valeska-core' );
					break;
				case 654:
					$message = esc_html__( 'Error occurred during deactivation', 'valeska-core' );
					break;
			endswitch;

			return $message;
		}
	}

	ValeskaCore_Dashboard::get_instance();
}

<?php
/*
Plugin Name: Valeska Core
Plugin URI: https://qodeinteractive.com
Description: Plugin that adds portfolio post type, shortcodes and other modules
Author: Qode Interactive
Author URI: https://qodeinteractive.com
Version: 1.0
Text Domain: valeska-core
*/
if ( ! class_exists( 'ValeskaCore' ) ) {
	class ValeskaCore {
		private static $instance;

		function __construct() {
			$this->require_core();

			add_filter( 'qode_framework_filter_register_admin_options', array( $this, 'create_core_options' ) );

			add_action( 'qode_framework_action_before_options_init_' . VALESKA_CORE_OPTIONS_NAME, array( $this, 'init_core_options' ) );

			add_action( 'qode_framework_action_populate_meta_box', array( $this, 'init_core_meta_boxes' ) );

			// Register plugin assets
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

			// Include plugin assets
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			// Make plugin available for translation
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ), 15 ); // permission 15 is set in order to be after the qode-framework initialization

			// Add plugin's body classes
			add_filter( 'body_class', array( $this, 'add_body_classes' ) );

			// Hook to include additional modules when plugin loaded
			do_action( 'valeska_core_action_plugin_loaded' );
		}

		/**
		 * @return ValeskaCore
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function require_core() {
			require_once 'constants.php';
			require_once VALESKA_CORE_ABS_PATH . '/helpers/helper.php';

			// Hook to include additional files before modules inclusion
			do_action( 'valeska_core_action_before_include_modules' );

			foreach ( glob( VALESKA_CORE_INC_PATH . '/*/include.php' ) as $module ) {
				include_once $module;
			}

			// Hook to include additional files after modules inclusion
			do_action( 'valeska_core_action_after_include_modules' );
		}

		function create_core_options( $options ) {
			$valeska_core_options_admin = new QodeFrameworkOptionsAdmin(
				VALESKA_CORE_MENU_NAME,
				VALESKA_CORE_OPTIONS_NAME,
				array(
					'label' => esc_html__( 'Valeska Core Options', 'valeska-core' ),
					'code'  => ValeskaCore_Dashboard::get_instance()->get_code(),
				)
			);

			$options[] = $valeska_core_options_admin;

			return $options;
		}

		function init_core_options() {
			$qode_framework = qode_framework_get_framework_root();

			if ( ! empty( $qode_framework ) ) {
				$page = $qode_framework->add_options_page(
					array(
						'scope'       => VALESKA_CORE_OPTIONS_NAME,
						'type'        => 'admin',
						'slug'        => 'general',
						'title'       => esc_html__( 'General', 'valeska-core' ),
						'description' => esc_html__( 'Global Theme Options', 'valeska-core' ),
						'icon'        => 'fa fa-cog',
					)
				);

				// Hook to include additional options after default options
				do_action( 'valeska_core_action_default_options_init', $page );
			}
		}

		function init_core_meta_boxes() {
			do_action( 'valeska_core_action_default_meta_boxes_init' );
		}

		function register_scripts() {

			// Register 3rd party plugins script
			wp_register_script( 'gsap', VALESKA_CORE_URL_PATH . 'assets/plugins/gsap/gsap.min.js', array( 'jquery' ), false, true );
			wp_register_script( 'jquery-appear', VALESKA_CORE_URL_PATH . 'assets/plugins/appear/jquery.appear.js', array( 'jquery' ), false, true );
            wp_register_script( 'jquery-easing', VALESKA_CORE_URL_PATH . 'assets/plugins/easing/jquery.easing.min.js', array( 'jquery' ), false, true );

            // Hook to include additional registered scripts
			do_action( 'valeska_core_action_registered_scripts' );
		}

		function enqueue_assets() {
			// CSS and JS dependency variables
			$style_dependency_array  = apply_filters( 'valeska_core_filter_style_dependencies', array( 'valeska-main' ) );
			$script_dependency_array = apply_filters( 'valeska_core_filter_script_dependencies', array( 'valeska-main-js' ) );

			// Hook to include additional scripts before plugin's main style
			do_action( 'valeska_core_action_before_main_css' );

			// Enqueue plugin's main style
			wp_enqueue_style( 'valeska-core-style', VALESKA_CORE_URL_PATH . 'assets/css/valeska-core.min.css', $style_dependency_array );
			wp_enqueue_style( 'magnific-popup', VALESKA_CORE_URL_PATH . 'assets/plugins/magnific-popup/magnific-popup.css' );

			// Enqueue plugin's 3rd party scripts
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'modernizr', VALESKA_CORE_URL_PATH . 'assets/plugins/modernizr/modernizr.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'jquery-parallax-scroll', VALESKA_CORE_URL_PATH . 'assets/plugins/parallax-scroll/jquery.parallax-scroll.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'skrollr', VALESKA_CORE_URL_PATH . 'assets/plugins/skrollr/skrollr.min.js', array( 'jquery' ), false, true );
            wp_enqueue_script( 'tweenmax', VALESKA_CORE_URL_PATH . 'assets/plugins/tweenmax/tweenmax.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'jquery-magnific-popup', VALESKA_CORE_URL_PATH . 'assets/plugins/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );


			// Hook to include additional scripts before plugin's main script
			do_action( 'valeska_core_action_before_main_js' );

			// Enqueue plugin's main script
			wp_enqueue_script( 'valeska-core-script', VALESKA_CORE_URL_PATH . 'assets/js/valeska-core.min.js', $script_dependency_array, false, true );
		}

		function load_plugin_textdomain() {
			load_plugin_textdomain( 'valeska-core', false, VALESKA_CORE_REL_PATH . '/languages' );
		}

		function add_body_classes( $classes ) {
			$classes[] = 'valeska-core-' . VALESKA_CORE_VERSION;

			return $classes;
		}
	}
}

if ( ! function_exists( 'valeska_core_instantiate_plugin' ) ) {
	/**
	 * Function that initialize plugin
	 */
	function valeska_core_instantiate_plugin() {
		ValeskaCore::get_instance();
	}

	add_action( 'qode_framework_action_load_dependent_plugins', 'valeska_core_instantiate_plugin' );
}

if ( ! function_exists( 'valeska_core_activation_trigger' ) ) {
	/**
	 * Function that trigger hooks on plugin activation
	 */
	function valeska_core_activation_trigger() {
		// Set global plugin option when plugin is activated
		add_option( 'valeska_core_activated_first_time', 'yes' );

		// Hook to add additional code on plugin activation
		do_action( 'valeska_core_action_on_activation' );
	}

	register_activation_hook( __FILE__, 'valeska_core_activation_trigger' );
}

if ( ! function_exists( 'valeska_core_deactivation_trigger' ) ) {
	/**
	 * Function that trigger hooks on plugin deactivation
	 */
	function valeska_core_deactivation_trigger() {
		// Remove global plugin option during deactivation
		delete_option( 'valeska_core_activated_first_time' );

		// Hook to add additional code on plugin deactivation
		do_action( 'valeska_core_action_on_deactivation' );
	}

	register_deactivation_hook( __FILE__, 'valeska_core_deactivation_trigger' );
}

if ( ! function_exists( 'valeska_core_plugins_loaded_option' ) ) {
	/**
	 * Function that update global option that plugin is activated first time
	 */
	function valeska_core_plugins_loaded_option() {
		if ( 'yes' === get_option( 'valeska_core_activated_first_time' ) ) {
			update_option( 'valeska_core_activated_first_time', 'no' );
		}
	}

	add_action( 'plugins_loaded', 'valeska_core_plugins_loaded_option', 1000 ); //needs to be last, so option can be changed after all actions
}

if ( ! function_exists( 'valeska_core_check_requirements' ) ) {
	/**
	 * Function that check plugin requirements
	 */
	function valeska_core_check_requirements() {
		if ( ! defined( 'QODE_FRAMEWORK_VERSION' ) ) {
			add_action( 'admin_notices', 'valeska_core_admin_notice_content' );
		}
	}

	add_action( 'plugins_loaded', 'valeska_core_check_requirements' );
}

if ( ! function_exists( 'valeska_core_admin_notice_content' ) ) {
	/**
	 * Function that display the error message if the requirements are not met
	 */
	function valeska_core_admin_notice_content() {
		echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html__( 'Qode Framework plugin is required for Valeska Core plugin to work properly. Please install/activate it first.', 'valeska-core' ) );

		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	}
}

<?php
/**
 * WooCommerce product base class.
 *
 * @package WooCommerce\Abstracts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract Product Class
 *
 * The WooCommerce product class handles individual product data.
 *
 * @version 3.0.0
 * @package WooCommerce\Abstracts
 */
abstract class WC_Product_Qodef_Abstract extends WC_Abstract_Legacy_Product {

	/**
	 * This is the name of this object type.
	 *
	 * @var string
	 */
	protected $object_type;

	/**
	 * Post type.
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * Cache group.
	 *
	 * @var string
	 */
	protected $cache_group;

	private function set_object_type( $type ) {
		$this->object_type = $type;
	}

	public function get_object_type() {
		return $this->object_type;
	}

	private function set_post_type( $type ) {
		$this->post_type = $type;
	}

	public function get_post_type() {
		return $this->post_type;
	}

	private function set_cache_group() {
		$this->cache_group = 'qodef-products';
	}

	public function get_cache_group() {
		return $this->cache_group;
	}

	protected $data = array(
		'name'              => '',
		'price'             => '',
		'sold_individually' => false,
		'status'            => true,
		'stock_status'      => 'instock',
		'stock_quantity'    => null,
		'tax_status'        => 'taxable',
		'tax_class'         => '',
		'image_id'          => '',
	);

	/**
	 * Supported features such as 'ajax_add_to_cart'.
	 *
	 * @var array
	 */
	protected $supports = array();

	/**
	 * Get the product if ID is passed, otherwise the product is new and empty.
	 * This class should NOT be instantiated, but the wc_get_product() function
	 * should be used. It is possible, but the wc_get_product() is preferred.
	 *
	 * @param int|WC_Product|object $product Product to init.
	 */
	public function __construct( $product = 0 ) {
		parent::__construct( $product );
		if ( is_numeric( $product ) && $product > 0 ) {
			$this->set_id( $product );
		} elseif ( $product instanceof self ) {
			$this->set_id( absint( $product->get_id() ) );
		} elseif ( ! empty( $product->ID ) ) {
			$this->set_id( absint( $product->ID ) );
		} else {
			$this->set_object_read( true );
		}

		/* BY QODE */
		$post_type = get_post_type( $this->get_id() );
		$this->set_prop( 'name', get_the_title( $this->get_id() ) );
		$this->set_prop( 'price', $this->generate_price() );
		$this->set_prop( 'sold_individually', $this->generate_sold_individually() );
		$this->set_prop( 'stock_status', $this->generate_stock_status() );
		$this->set_prop( 'stock_quantity', $this->generate_stock_quantity() );
		$this->set_prop( 'image_id', get_post_thumbnail_id( $this->get_id() ) );

		$this->set_post_type( $post_type );
		$this->set_object_type( $post_type );
		$this->set_cache_group();

		$this->data_store = WC_Data_Store::load( $this->get_object_type() );
		if ( $this->get_id() > 0 ) {
			$this->data_store->read( $this );
		}
	}

	/* BY QODE */
	abstract protected function generate_price();

	abstract protected function generate_sold_individually();

	abstract protected function generate_stock_status();

	abstract protected function generate_stock_quantity();

	/**
	 * Get internal type. Should return string and *should be overridden* by child classes.
	 *
	 * The product_type property is deprecated but is used here for BW compatibility with child classes which may be defining product_type and not have a get_type method.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_type() {
		return $this->get_object_type();
	}

	/**
	 * Get product name.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_name( $context = 'view' ) {
		return $this->get_prop( 'name', $context );
	}

	/**
	 * Get product slug.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_slug( $context = 'view' ) {
		return $this->get_prop( 'slug', $context );
	}

	/**
	 * Get product created date.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 * @since  3.0.0
	 */
	public function get_date_created( $context = 'view' ) {
		return $this->get_prop( 'date_created', $context );
	}

	/**
	 * Get product modified date.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 * @since  3.0.0
	 */
	public function get_date_modified( $context = 'view' ) {
		return $this->get_prop( 'date_modified', $context );
	}

	/**
	 * Get product status.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_status( $context = 'view' ) {
		return $this->get_prop( 'status', $context );
	}

	/**
	 * If the product is featured.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return boolean
	 * @since  3.0.0
	 */
	public function get_featured( $context = 'view' ) {
		return $this->get_prop( 'featured', $context );
	}

	/**
	 * Get catalog visibility.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_catalog_visibility( $context = 'view' ) {
		return $this->get_prop( 'catalog_visibility', $context );
	}

	/**
	 * Get product description.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_description( $context = 'view' ) {
		return $this->get_prop( 'description', $context );
	}

	/**
	 * Get product short description.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_short_description( $context = 'view' ) {
		return $this->get_prop( 'short_description', $context );
	}

	/**
	 * Get SKU (Stock-keeping unit) - product unique ID.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_sku( $context = 'view' ) {
		return '';
	}

	/**
	 * Returns the product's active price.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string price
	 */
	public function get_price( $context = 'view' ) {
		return $this->get_prop( 'price', $context );
	}

	/**
	 * Returns the product's regular price.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string price
	 */
	public function get_regular_price( $context = 'view' ) {
		return $this->get_prop( 'regular_price', $context );
	}

	/**
	 * Returns the product's sale price.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string price
	 */
	public function get_sale_price( $context = 'view' ) {
		return $this->get_prop( 'sale_price', $context );
	}

	/**
	 * Get date on sale from.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 * @since  3.0.0
	 */
	public function get_date_on_sale_from( $context = 'view' ) {
		return $this->get_prop( 'date_on_sale_from', $context );
	}

	/**
	 * Get date on sale to.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return WC_DateTime|NULL object if the date is set or null if there is no date.
	 * @since  3.0.0
	 */
	public function get_date_on_sale_to( $context = 'view' ) {
		return $this->get_prop( 'date_on_sale_to', $context );
	}

	/**
	 * Get number total of sales.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_total_sales( $context = 'view' ) {
		return $this->get_prop( 'total_sales', $context );
	}

	/**
	 * Returns the tax status.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_tax_status( $context = 'view' ) {
		return $this->get_prop( 'tax_status', $context );
	}

	/**
	 * Returns the tax class.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_tax_class( $context = 'view' ) {
		return $this->get_prop( 'tax_class', $context );
	}

	/**
	 * Return if product manage stock.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return boolean
	 * @since  3.0.0
	 */
	public function get_manage_stock( $context = 'view' ) {
		return $this->get_prop( 'manage_stock', $context );
	}

	/**
	 * Returns number of items available for sale.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int|null
	 */
	public function get_stock_quantity( $context = 'view' ) {
		return $this->get_prop( 'stock_quantity', $context );
	}

	/**
	 * Return the stock status.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_stock_status( $context = 'view' ) {
		return $this->get_prop( 'stock_status', $context );
	}

	/**
	 * Get backorders.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string yes no or notify
	 * @since  3.0.0
	 */
	public function get_backorders( $context = 'view' ) {
		return $this->get_prop( 'backorders', $context );
	}

	/**
	 * Get low stock amount.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int|string Returns empty string if value not set
	 * @since  3.5.0
	 */
	public function get_low_stock_amount( $context = 'view' ) {
		return $this->get_prop( 'low_stock_amount', $context );
	}

	/**
	 * Return if should be sold individually.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return boolean
	 * @since  3.0.0
	 */
	public function get_sold_individually( $context = 'view' ) {
		return $this->get_prop( 'sold_individually', $context );
	}

	/**
	 * Returns the product's weight.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_weight( $context = 'view' ) {
		return $this->get_prop( 'weight', $context );
	}

	/**
	 * Returns the product length.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_length( $context = 'view' ) {
		return $this->get_prop( 'length', $context );
	}

	/**
	 * Returns the product width.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_width( $context = 'view' ) {
		return $this->get_prop( 'width', $context );
	}

	/**
	 * Returns the product height.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 */
	public function get_height( $context = 'view' ) {
		return $this->get_prop( 'height', $context );
	}

	/**
	 * Returns formatted dimensions.
	 *
	 * @param  bool $formatted True by default for legacy support - will be false/not set in future versions to return the array only. Use wc_format_dimensions for formatted versions instead.
	 * @return string|array
	 */
	public function get_dimensions( $formatted = true ) {
		if ( $formatted ) {
			wc_deprecated_argument( 'WC_Product::get_dimensions', '3.0', 'By default, get_dimensions has an argument set to true so that HTML is returned. This is to support the legacy version of the method. To get HTML dimensions, instead use wc_format_dimensions() function. Pass false to this method to return an array of dimensions. This will be the new default behavior in future versions.' );
			return apply_filters( 'woocommerce_product_dimensions', wc_format_dimensions( $this->get_dimensions( false ) ), $this );
		}
		return array(
			'length' => $this->get_length(),
			'width'  => $this->get_width(),
			'height' => $this->get_height(),
		);
	}

	/**
	 * Get upsell IDs.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_upsell_ids( $context = 'view' ) {
		return $this->get_prop( 'upsell_ids', $context );
	}

	/**
	 * Get cross sell IDs.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_cross_sell_ids( $context = 'view' ) {
		return array();
	}

	/**
	 * Get parent ID.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_parent_id( $context = 'view' ) {
		return $this->get_prop( 'parent_id', $context );
	}

	/**
	 * Return if reviews is allowed.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return bool
	 * @since  3.0.0
	 */
	public function get_reviews_allowed( $context = 'view' ) {
		return $this->get_prop( 'reviews_allowed', $context );
	}

	/**
	 * Get purchase note.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_purchase_note( $context = 'view' ) {
		return '';
	}

	/**
	 * Returns product attributes.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 */
	public function get_attributes( $context = 'view' ) {
		return $this->get_prop( 'attributes', $context );
	}

	/**
	 * Get default attributes.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_default_attributes( $context = 'view' ) {
		return $this->get_prop( 'default_attributes', $context );
	}

	/**
	 * Get menu order.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_menu_order( $context = 'view' ) {
		return $this->get_prop( 'menu_order', $context );
	}

	/**
	 * Get post password.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.6.0
	 */
	public function get_post_password( $context = 'view' ) {
		return $this->get_prop( 'post_password', $context );
	}

	/**
	 * Get category ids.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_category_ids( $context = 'view' ) {
		return $this->get_prop( 'category_ids', $context );
	}

	/**
	 * Get tag ids.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_tag_ids( $context = 'view' ) {
		return $this->get_prop( 'tag_ids', $context );
	}

	/**
	 * Get virtual.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return bool
	 * @since  3.0.0
	 */
	public function get_virtual( $context = 'view' ) {
		return $this->get_prop( 'virtual', $context );
	}

	/**
	 * Returns the gallery attachment ids.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 */
	public function get_gallery_image_ids( $context = 'view' ) {
		return $this->get_prop( 'gallery_image_ids', $context );
	}

	/**
	 * Get shipping class ID.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_shipping_class_id( $context = 'view' ) {
		return $this->get_prop( 'shipping_class_id', $context );
	}

	/**
	 * Get downloads.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array
	 * @since  3.0.0
	 */
	public function get_downloads( $context = 'view' ) {
		return $this->get_prop( 'downloads', $context );
	}

	/**
	 * Get download expiry.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_download_expiry( $context = 'view' ) {
		return $this->get_prop( 'download_expiry', $context );
	}

	/**
	 * Get downloadable.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return bool
	 * @since  3.0.0
	 */
	public function get_downloadable( $context = 'view' ) {
		return $this->get_prop( 'downloadable', $context );
	}

	/**
	 * Get download limit.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_download_limit( $context = 'view' ) {
		return $this->get_prop( 'download_limit', $context );
	}

	/**
	 * Get main image ID.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	public function get_image_id( $context = 'view' ) {
		return $this->get_prop( 'image_id', $context );
	}

	/**
	 * Get rating count.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return array of counts
	 */
	public function get_rating_counts( $context = 'view' ) {
		return $this->get_prop( 'rating_counts', $context );
	}

	/**
	 * Get average rating.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return float
	 */
	public function get_average_rating( $context = 'view' ) {
		return $this->get_prop( 'average_rating', $context );
	}

	/**
	 * Get review count.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return int
	 */
	public function get_review_count( $context = 'view' ) {
		return $this->get_prop( 'review_count', $context );
	}

	/*
	|--------------------------------------------------------------------------
	| Setters
	|--------------------------------------------------------------------------
	|
	| Functions for setting product data. These should not update anything in the
	| database itself and should only change what is stored in the class
	| object.
	*/

	/**
	 * Set product name.
	 *
	 * @param string $name Product name.
	 *
	 * @since 3.0.0
	 */
	public function set_name( $name ) {
		$this->set_prop( 'name', $name );
	}

	/**
	 * Set product slug.
	 *
	 * @param string $slug Product slug.
	 *
	 * @since 3.0.0
	 */
	public function set_slug( $slug ) {
		$this->set_prop( 'slug', $slug );
	}

	/**
	 * Set product created date.
	 *
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
	 *
	 * @since 3.0.0
	 */
	public function set_date_created( $date = null ) {
		$this->set_date_prop( 'date_created', $date );
	}

	/**
	 * Set product modified date.
	 *
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
	 *
	 * @since 3.0.0
	 */
	public function set_date_modified( $date = null ) {
		$this->set_date_prop( 'date_modified', $date );
	}

	/**
	 * Set product status.
	 *
	 * @param string $status Product status.
	 *
	 * @since 3.0.0
	 */
	public function set_status( $status ) {
		$this->set_prop( 'status', $status );
	}

	/**
	 * Set if the product is featured.
	 *
	 * @param bool|string $featured Whether the product is featured or not.
	 *
	 * @since 3.0.0
	 */
	public function set_featured( $featured ) {
		$this->set_prop( 'featured', wc_string_to_bool( $featured ) );
	}

	/**
	 * Set catalog visibility.
	 *
	 * @param string $visibility Options: 'hidden', 'visible', 'search' and 'catalog'.
	 *
	 * @throws WC_Data_Exception Throws exception when invalid data is found.
	 * @since  3.0.0
	 */
	public function set_catalog_visibility( $visibility ) {
		$options = array_keys( wc_get_product_visibility_options() );
		if ( ! in_array( $visibility, $options, true ) ) {
			$this->error( 'product_invalid_catalog_visibility', esc_html__( 'Invalid catalog visibility option.', 'valeska-core' ) );
		}
		$this->set_prop( 'catalog_visibility', $visibility );
	}

	/**
	 * Set product description.
	 *
	 * @param string $description Product description.
	 *
	 * @since 3.0.0
	 */
	public function set_description( $description ) {
		$this->set_prop( 'description', $description );
	}

	/**
	 * Set product short description.
	 *
	 * @param string $short_description Product short description.
	 *
	 * @since 3.0.0
	 */
	public function set_short_description( $short_description ) {
		$this->set_prop( 'short_description', $short_description );
	}

	/**
	 * Set SKU.
	 *
	 * @param string $sku Product SKU.
	 *
	 * @throws WC_Data_Exception Throws exception when invalid data is found.
	 * @since  3.0.0
	 */
	public function set_sku( $sku ) {
		$sku = (string) $sku;
		if ( $this->get_object_read() && ! empty( $sku ) && ! wc_product_has_unique_sku( $this->get_id(), $sku ) ) {
			$sku_found = wc_get_product_id_by_sku( $sku );

			$this->error( 'product_invalid_sku', esc_html__( 'Invalid or duplicated SKU.', 'valeska-core' ), 400, array( 'resource_id' => $sku_found ) );
		}
		$this->set_prop( 'sku', $sku );
	}

	/**
	 * Set the product's active price.
	 *
	 * @param string $price Price.
	 */
	public function set_price( $price ) {
		$this->set_prop( 'price', wc_format_decimal( $price ) );
	}

	/**
	 * Set the product's regular price.
	 *
	 * @param string $price Regular price.
	 *
	 * @since 3.0.0
	 */
	public function set_regular_price( $price ) {
		$this->set_prop( 'regular_price', wc_format_decimal( $price ) );
	}

	/**
	 * Set the product's sale price.
	 *
	 * @param string $price sale price.
	 *
	 * @since 3.0.0
	 */
	public function set_sale_price( $price ) {
		$this->set_prop( 'sale_price', wc_format_decimal( $price ) );
	}

	/**
	 * Set date on sale from.
	 *
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
	 *
	 * @since 3.0.0
	 */
	public function set_date_on_sale_from( $date = null ) {
		$this->set_date_prop( 'date_on_sale_from', $date );
	}

	/**
	 * Set date on sale to.
	 *
	 * @param string|integer|null $date UTC timestamp, or ISO 8601 DateTime. If the DateTime string has no timezone or offset, WordPress site timezone will be assumed. Null if their is no date.
	 *
	 * @since 3.0.0
	 */
	public function set_date_on_sale_to( $date = null ) {
		$this->set_date_prop( 'date_on_sale_to', $date );
	}

	/**
	 * Set number total of sales.
	 *
	 * @param int $total Total of sales.
	 *
	 * @since 3.0.0
	 */
	public function set_total_sales( $total ) {
		$this->set_prop( 'total_sales', absint( $total ) );
	}

	/**
	 * Set the tax status.
	 *
	 * @param string $status Tax status.
	 *
	 * @throws WC_Data_Exception Throws exception when invalid data is found.
	 * @since  3.0.0
	 */
	public function set_tax_status( $status ) {
		$options = array(
			'taxable',
			'shipping',
			'none',
		);

		// Set default if empty.
		if ( empty( $status ) ) {
			$status = 'taxable';
		}

		if ( ! in_array( $status, $options, true ) ) {
			$this->error( 'product_invalid_tax_status', esc_html__( 'Invalid product tax status.', 'valeska-core' ) );
		}

		$this->set_prop( 'tax_status', $status );
	}

	/**
	 * Set the tax class.
	 *
	 * @param string $class Tax class.
	 *
	 * @since 3.0.0
	 */
	public function set_tax_class( $class ) {
		$class         = sanitize_title( $class );
		$class         = 'standard' === $class ? '' : $class;
		$valid_classes = $this->get_valid_tax_classes();

		if ( ! in_array( $class, $valid_classes, true ) ) {
			$class = '';
		}

		$this->set_prop( 'tax_class', $class );
	}

	/**
	 * Return an array of valid tax classes
	 *
	 * @return array valid tax classes
	 */
	protected function get_valid_tax_classes() {
		return WC_Tax::get_tax_class_slugs();
	}

	/**
	 * Set if product manage stock.
	 *
	 * @param bool $manage_stock Whether or not manage stock is enabled.
	 *
	 * @since 3.0.0
	 */
	public function set_manage_stock( $manage_stock ) {
		$this->set_prop( 'manage_stock', wc_string_to_bool( $manage_stock ) );
	}

	/**
	 * Set number of items available for sale.
	 *
	 * @param float|null $quantity Stock quantity.
	 *
	 * @since 3.0.0
	 */
	public function set_stock_quantity( $quantity ) {
		$this->set_prop( 'stock_quantity', '' !== $quantity ? wc_stock_amount( $quantity ) : null );
	}

	/**
	 * Set stock status.
	 *
	 * @param string $status New status.
	 */
	public function set_stock_status( $status = 'instock' ) {
		$valid_statuses = wc_get_product_stock_status_options();

		if ( isset( $valid_statuses[ $status ] ) ) {
			$this->set_prop( 'stock_status', $status );
		} else {
			$this->set_prop( 'stock_status', 'instock' );
		}
	}

	/**
	 * Set backorders.
	 *
	 * @param string $backorders Options: 'yes', 'no' or 'notify'.
	 *
	 * @since 3.0.0
	 */
	public function set_backorders( $backorders ) {
		$this->set_prop( 'backorders', $backorders );
	}

	/**
	 * Set low stock amount.
	 *
	 * @param int|string $amount Empty string if value not set.
	 *
	 * @since 3.5.0
	 */
	public function set_low_stock_amount( $amount ) {
		$this->set_prop( 'low_stock_amount', '' === $amount ? '' : absint( $amount ) );
	}

	/**
	 * Set if should be sold individually.
	 *
	 * @param bool $sold_individually Whether or not product is sold individually.
	 *
	 * @since 3.0.0
	 */
	public function set_sold_individually( $sold_individually ) {
		$this->set_prop( 'sold_individually', wc_string_to_bool( $sold_individually ) );
	}

	/**
	 * Set the product's weight.
	 *
	 * @param float|string $weight Total weight.
	 *
	 * @since 3.0.0
	 */
	public function set_weight( $weight ) {
		$this->set_prop( 'weight', '' === $weight ? '' : wc_format_decimal( $weight ) );
	}

	/**
	 * Set the product length.
	 *
	 * @param float|string $length Total length.
	 *
	 * @since 3.0.0
	 */
	public function set_length( $length ) {
		$this->set_prop( 'length', '' === $length ? '' : wc_format_decimal( $length ) );
	}

	/**
	 * Set the product width.
	 *
	 * @param float|string $width Total width.
	 *
	 * @since 3.0.0
	 */
	public function set_width( $width ) {
		$this->set_prop( 'width', '' === $width ? '' : wc_format_decimal( $width ) );
	}

	/**
	 * Set the product height.
	 *
	 * @param float|string $height Total height.
	 *
	 * @since 3.0.0
	 */
	public function set_height( $height ) {
		$this->set_prop( 'height', '' === $height ? '' : wc_format_decimal( $height ) );
	}

	/**
	 * Set upsell IDs.
	 *
	 * @param array $upsell_ids IDs from the up-sell products.
	 *
	 * @since 3.0.0
	 */
	public function set_upsell_ids( $upsell_ids ) {
		$this->set_prop( 'upsell_ids', array_filter( (array) $upsell_ids ) );
	}

	/**
	 * Set crosssell IDs.
	 *
	 * @param array $cross_sell_ids IDs from the cross-sell products.
	 *
	 * @since 3.0.0
	 */
	public function set_cross_sell_ids( $cross_sell_ids ) {
		$this->set_prop( 'cross_sell_ids', array_filter( (array) $cross_sell_ids ) );
	}

	/**
	 * Set parent ID.
	 *
	 * @param int $parent_id Product parent ID.
	 *
	 * @since 3.0.0
	 */
	public function set_parent_id( $parent_id ) {
		$this->set_prop( 'parent_id', absint( $parent_id ) );
	}

	/**
	 * Set if reviews is allowed.
	 *
	 * @param bool $reviews_allowed Reviews allowed or not.
	 *
	 * @since 3.0.0
	 */
	public function set_reviews_allowed( $reviews_allowed ) {
		$this->set_prop( 'reviews_allowed', wc_string_to_bool( $reviews_allowed ) );
	}

	/**
	 * Set purchase note.
	 *
	 * @param string $purchase_note Purchase note.
	 *
	 * @since 3.0.0
	 */
	public function set_purchase_note( $purchase_note ) {
		$this->set_prop( 'purchase_note', $purchase_note );
	}

	/**
	 * Set product attributes.
	 *
	 * Attributes are made up of:
	 *     id - 0 for product level attributes. ID for global attributes.
	 *     name - Attribute name.
	 *     options - attribute value or array of term ids/names.
	 *     position - integer sort order.
	 *     visible - If visible on frontend.
	 *     variation - If used for variations.
	 * Indexed by unqiue key to allow clearing old ones after a set.
	 *
	 * @param array $raw_attributes Array of WC_Product_Attribute objects.
	 *
	 * @since 3.0.0
	 */
	public function set_attributes( $raw_attributes ) {
		$attributes = array_fill_keys( array_keys( $this->get_attributes( 'edit' ) ), null );
		foreach ( $raw_attributes as $attribute ) {
			if ( is_a( $attribute, 'WC_Product_Attribute' ) ) {
				$attributes[ sanitize_title( $attribute->get_name() ) ] = $attribute;
			}
		}

		uasort( $attributes, 'wc_product_attribute_uasort_comparison' );
		$this->set_prop( 'attributes', $attributes );
	}

	/**
	 * Set default attributes. These will be saved as strings and should map to attribute values.
	 *
	 * @param array $default_attributes List of default attributes.
	 *
	 * @since 3.0.0
	 */
	public function set_default_attributes( $default_attributes ) {
		$this->set_prop( 'default_attributes', array_map( 'strval', array_filter( (array) $default_attributes, 'wc_array_filter_default_attributes' ) ) );
	}

	/**
	 * Set menu order.
	 *
	 * @param int $menu_order Menu order.
	 *
	 * @since 3.0.0
	 */
	public function set_menu_order( $menu_order ) {
		$this->set_prop( 'menu_order', intval( $menu_order ) );
	}

	/**
	 * Set post password.
	 *
	 * @param int $post_password Post password.
	 *
	 * @since 3.6.0
	 */
	public function set_post_password( $post_password ) {
		$this->set_prop( 'post_password', $post_password );
	}

	/**
	 * Set the product categories.
	 *
	 * @param array $term_ids List of terms IDs.
	 *
	 * @since 3.0.0
	 */
	public function set_category_ids( $term_ids ) {
		$this->set_prop( 'category_ids', array_unique( array_map( 'intval', $term_ids ) ) );
	}

	/**
	 * Set the product tags.
	 *
	 * @param array $term_ids List of terms IDs.
	 *
	 * @since 3.0.0
	 */
	public function set_tag_ids( $term_ids ) {
		$this->set_prop( 'tag_ids', array_unique( array_map( 'intval', $term_ids ) ) );
	}

	/**
	 * Set if the product is virtual.
	 *
	 * @param bool|string $virtual Whether product is virtual or not.
	 *
	 * @since 3.0.0
	 */
	public function set_virtual( $virtual ) {
		$this->set_prop( 'virtual', wc_string_to_bool( $virtual ) );
	}

	/**
	 * Set shipping class ID.
	 *
	 * @param int $id Product shipping class id.
	 *
	 * @since 3.0.0
	 */
	public function set_shipping_class_id( $id ) {
		$this->set_prop( 'shipping_class_id', absint( $id ) );
	}

	/**
	 * Set if the product is downloadable.
	 *
	 * @param bool|string $downloadable Whether product is downloadable or not.
	 *
	 * @since 3.0.0
	 */
	public function set_downloadable( $downloadable ) {
		$this->set_prop( 'downloadable', wc_string_to_bool( $downloadable ) );
	}

	/**
	 * Set downloads.
	 *
	 * @param array $downloads_array Array of WC_Product_Download objects or arrays.
	 *
	 * @since 3.0.0
	 */
	public function set_downloads( $downloads_array ) {
		$downloads = array();
		$errors    = array();

		foreach ( $downloads_array as $download ) {
			if ( is_a( $download, 'WC_Product_Download' ) ) {
				$download_object = $download;
			} else {
				$download_object = new WC_Product_Download();

				// If we don't have a previous hash, generate UUID for download.
				if ( empty( $download['download_id'] ) ) {
					$download['download_id'] = wp_generate_uuid4();
				}

				$download_object->set_id( $download['download_id'] );
				$download_object->set_name( $download['name'] );
				$download_object->set_file( $download['file'] );
			}

			// Validate the file extension.
			if ( ! $download_object->is_allowed_filetype() ) {
				if ( $this->get_object_read() ) {
					/* translators: %1$s: Downloadable file */
					$errors[] = sprintf( esc_html__( 'The downloadable file %1$s cannot be used as it does not have an allowed file type. Allowed types include: %2$s', 'valeska-core' ), '<code>' . basename( $download_object->get_file() ) . '</code>', '<code>' . implode( ', ', array_keys( $download_object->get_allowed_mime_types() ) ) . '</code>' );
				}
				continue;
			}

			// Validate the file exists.
			if ( ! $download_object->file_exists() ) {
				if ( $this->get_object_read() ) {
					/* translators: %s: Downloadable file */
					$errors[] = sprintf( esc_html__( 'The downloadable file %s cannot be used as it does not exist on the server.', 'valeska-core' ), '<code>' . $download_object->get_file() . '</code>' );
				}
				continue;
			}

			$downloads[ $download_object->get_id() ] = $download_object;
		}

		if ( $errors ) {
			$this->error( 'product_invalid_download', $errors[0] );
		}

		$this->set_prop( 'downloads', $downloads );
	}

	/**
	 * Set download limit.
	 *
	 * @param int|string $download_limit Product download limit.
	 *
	 * @since 3.0.0
	 */
	public function set_download_limit( $download_limit ) {
		$this->set_prop( 'download_limit', - 1 === (int) $download_limit || '' === $download_limit ? - 1 : absint( $download_limit ) );
	}

	/**
	 * Set download expiry.
	 *
	 * @param int|string $download_expiry Product download expiry.
	 *
	 * @since 3.0.0
	 */
	public function set_download_expiry( $download_expiry ) {
		$this->set_prop( 'download_expiry', - 1 === (int) $download_expiry || '' === $download_expiry ? - 1 : absint( $download_expiry ) );
	}

	/**
	 * Set gallery attachment ids.
	 *
	 * @param array $image_ids List of image ids.
	 *
	 * @since 3.0.0
	 */
	public function set_gallery_image_ids( $image_ids ) {
		$image_ids = wp_parse_id_list( $image_ids );

		$this->set_prop( 'gallery_image_ids', $image_ids );
	}

	/**
	 * Set main image ID.
	 *
	 * @param int|string $image_id Product image id.
	 *
	 * @since 3.0.0
	 */
	public function set_image_id( $image_id = '' ) {
		$this->set_prop( 'image_id', $image_id );
	}

	/**
	 * Set rating counts. Read only.
	 *
	 * @param array $counts Product rating counts.
	 */
	public function set_rating_counts( $counts ) {
		$this->set_prop( 'rating_counts', array_filter( array_map( 'absint', (array) $counts ) ) );
	}

	/**
	 * Set average rating. Read only.
	 *
	 * @param float $average Product average rating.
	 */
	public function set_average_rating( $average ) {
		$this->set_prop( 'average_rating', wc_format_decimal( $average ) );
	}

	/**
	 * Set review count. Read only.
	 *
	 * @param int $count Product review count.
	 */
	public function set_review_count( $count ) {
		$this->set_prop( 'review_count', absint( $count ) );
	}

	/*
	|--------------------------------------------------------------------------
	| Other Methods
	|--------------------------------------------------------------------------
	*/

	/**
	 * Ensure properties are set correctly before save.
	 *
	 * @since 3.0.0
	 */
	public function validate_props() {
		// Before updating, ensure stock props are all aligned. Qty, backorders and low stock amount are not needed if not stock managed.
		if ( ! $this->get_manage_stock() ) {
			$this->set_stock_quantity( '' );
			$this->set_backorders( 'no' );
			$this->set_low_stock_amount( '' );
			return;
		}

		$stock_is_above_notification_threshold = ( $this->get_stock_quantity() > get_option( 'woocommerce_notify_no_stock_amount', 0 ) );
		$backorders_are_allowed                = ( 'no' !== $this->get_backorders() );

		if ( $stock_is_above_notification_threshold ) {
			$new_stock_status = 'instock';
		} elseif ( $backorders_are_allowed ) {
			$new_stock_status = 'onbackorder';
		} else {
			$new_stock_status = 'outofstock';
		}

		$this->set_stock_status( $new_stock_status );
	}

	/**
	 * Save data (either create or update depending on if we are working on an existing product).
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function save() {
		$this->validate_props();

		if ( ! $this->data_store ) {
			return $this->get_id();
		}

		/**
		 * Trigger action before saving to the DB. Allows you to adjust object props before save.
		 *
		 * @param WC_Data          $this The object being saved.
		 * @param WC_Data_Store_WP $data_store THe data store persisting the data.
		 */
		do_action( 'woocommerce_before_' . $this->object_type . '_object_save', $this, $this->data_store );

		if ( $this->get_id() ) {
			$this->data_store->update( $this );
		} else {
			$this->data_store->create( $this );
		}

		$this->maybe_defer_product_sync();

		/**
		 * Trigger action after saving to the DB.
		 *
		 * @param WC_Data          $this The object being saved.
		 * @param WC_Data_Store_WP $data_store THe data store persisting the data.
		 */
		do_action( 'woocommerce_after_' . $this->object_type . '_object_save', $this, $this->data_store );

		return $this->get_id();
	}

	/**
	 * Delete the product, set its ID to 0, and return result.
	 *
	 * @param  bool $force_delete Should the product be deleted permanently.
	 * @return bool result
	 */
	public function delete( $force_delete = false ) {
		$deleted = parent::delete( $force_delete );

		if ( $deleted ) {
			$this->maybe_defer_product_sync();
		}

		return $deleted;
	}

	/**
	 * If this is a child product, queue its parent for syncing at the end of the request.
	 */
	protected function maybe_defer_product_sync() {
		$parent_id = $this->get_parent_id();
		if ( $parent_id ) {
			wc_deferred_product_sync( $parent_id );
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Conditionals
	|--------------------------------------------------------------------------
	*/

	/**
	 * Check if a product supports a given feature.
	 *
	 * Product classes should override this to declare support (or lack of support) for a feature.
	 *
	 * @param string $feature string The name of a feature to test support for.
	 *
	 * @return bool True if the product supports the feature, false otherwise.
	 * @since  2.5.0
	 */
	public function supports( $feature ) {
		return apply_filters( 'woocommerce_product_supports', in_array( $feature, $this->supports, true ), $feature, $this );
	}

	/**
	 * Returns whether or not the product post exists.
	 *
	 * @return bool
	 */
	public function exists() {
		return false !== $this->get_status();
	}

	/**
	 * Checks the product type.
	 *
	 * Backwards compatibility with downloadable/virtual.
	 *
	 * @param string|array $type Array or string of types.
	 *
	 * @return bool
	 */
	public function is_type( $type ) {
		return ( $this->get_object_type() === $type || ( is_array( $type ) && in_array( $this->get_object_type(), $type, true ) ) );
	}

	/**
	 * Checks if a product is downloadable.
	 *
	 * @return bool
	 */
	public function is_downloadable() {
		return false;
	}

	/**
	 * Checks if a product is virtual (has no shipping).
	 *
	 * @return bool
	 */
	public function is_virtual() {
		return apply_filters( 'woocommerce_is_virtual', true === $this->get_virtual(), $this );
	}

	/**
	 * Returns whether or not the product is featured.
	 *
	 * @return bool
	 */
	public function is_featured() {
		return true === $this->get_featured();
	}

	/**
	 * Check if a product is sold individually (no quantities).
	 *
	 * @return bool
	 */
	public function is_sold_individually() {
		return apply_filters( 'woocommerce_is_sold_individually', true === $this->get_sold_individually(), $this );
	}

	/**
	 * Returns whether or not the product is visible in the catalog.
	 *
	 * @return bool
	 */
	public function is_visible() {
		return true;
	}

	/**
	 * Returns whether or not the product is visible in the catalog (doesn't trigger filters).
	 *
	 * @return bool
	 */
	protected function is_visible_core() {
		$visible = 'visible' === $this->get_catalog_visibility() || ( is_search() && 'search' === $this->get_catalog_visibility() ) || ( ! is_search() && 'catalog' === $this->get_catalog_visibility() );

		if ( 'trash' === $this->get_status() ) {
			$visible = false;
		} elseif ( 'publish' !== $this->get_status() && ! current_user_can( 'edit_post', $this->get_id() ) ) {
			$visible = false;
		}

		if ( $this->get_parent_id() ) {
			$parent_product = wc_get_product( $this->get_parent_id() );

			if ( $parent_product && 'publish' !== $parent_product->get_status() ) {
				$visible = false;
			}
		}

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && ! $this->is_in_stock() ) {
			$visible = false;
		}

		return $visible;
	}

	/**
	 * Returns false if the product cannot be bought.
	 *
	 * @return bool
	 */
	public function is_purchasable() {
		return apply_filters( 'woocommerce_is_purchasable', $this->exists() && ( 'publish' === $this->get_status() || current_user_can( 'edit_post', $this->get_id() ) || current_user_can( 'owner', $this->get_id() ) ) && '' !== $this->get_price(), $this );
	}

	/**
	 * Returns whether or not the product is on sale.
	 *
	 * @param string $context What the value is for. Valid values are view and edit.
	 *
	 * @return bool
	 */
	public function is_on_sale( $context = 'view' ) {
		if ( '' !== (string) $this->get_sale_price( $context ) && $this->get_regular_price( $context ) > $this->get_sale_price( $context ) ) {
			$on_sale = true;

			if ( $this->get_date_on_sale_from( $context ) && $this->get_date_on_sale_from( $context )->getTimestamp() > time() ) {
				$on_sale = false;
			}

			if ( $this->get_date_on_sale_to( $context ) && $this->get_date_on_sale_to( $context )->getTimestamp() < time() ) {
				$on_sale = false;
			}
		} else {
			$on_sale = false;
		}
		return 'view' === $context ? apply_filters( 'woocommerce_product_is_on_sale', $on_sale, $this ) : $on_sale;
	}

	/**
	 * Returns whether or not the product has dimensions set.
	 *
	 * @return bool
	 */
	public function has_dimensions() {
		return ( $this->get_length() || $this->get_height() || $this->get_width() ) && ! $this->get_virtual();
	}

	/**
	 * Returns whether or not the product has weight set.
	 *
	 * @return bool
	 */
	public function has_weight() {
		return $this->get_weight() && ! $this->get_virtual();
	}

	/**
	 * Returns whether or not the product can be purchased.
	 * This returns true for 'instock' and 'onbackorder' stock statuses.
	 *
	 * @return bool
	 */
	public function is_in_stock() {
		return apply_filters( 'woocommerce_product_is_in_stock', 'outofstock' !== $this->get_stock_status(), $this );
	}

	/**
	 * Checks if a product needs shipping.
	 *
	 * @return bool
	 */
	public function needs_shipping() {
		return false;
	}

	/**
	 * Returns whether or not the product is taxable.
	 *
	 * @return bool
	 */
	public function is_taxable() {
		return apply_filters( 'woocommerce_product_is_taxable', $this->get_tax_status() === 'taxable' && wc_tax_enabled(), $this );
	}

	/**
	 * Returns whether or not the product shipping is taxable.
	 *
	 * @return bool
	 */
	public function is_shipping_taxable() {
		return $this->needs_shipping() && ( $this->get_tax_status() === 'taxable' || $this->get_tax_status() === 'shipping' );
	}

	/**
	 * Returns whether or not the product is stock managed.
	 *
	 * @return bool
	 */
	public function managing_stock() {
		return false;
	}

	/**
	 * Returns whether or not the product can be backordered.
	 *
	 * @return bool
	 */
	public function backorders_allowed() {
		return apply_filters( 'woocommerce_product_backorders_allowed', ( 'yes' === $this->get_backorders() || 'notify' === $this->get_backorders() ), $this->get_id(), $this );
	}

	/**
	 * Returns whether or not the product needs to notify the customer on backorder.
	 *
	 * @return bool
	 */
	public function backorders_require_notification() {
		return false;
	}

	/**
	 * Check if a product is on backorder.
	 *
	 * @param int $qty_in_cart (default: 0).
	 *
	 * @return bool
	 */
	public function is_on_backorder( $qty_in_cart = 0 ) {
		if ( 'onbackorder' === $this->get_stock_status() ) {
			return true;
		}

		return $this->managing_stock() && $this->backorders_allowed() && ( $this->get_stock_quantity() - $qty_in_cart ) < 0;
	}

	/**
	 * Returns whether or not the product has enough stock for the order.
	 *
	 * @param mixed $quantity Quantity of a product added to an order.
	 *
	 * @return bool
	 */
	public function has_enough_stock( $quantity ) {
		return true;
	}

	/**
	 * Returns whether or not the product has any visible attributes.
	 *
	 * @return boolean
	 */
	public function has_attributes() {
		foreach ( $this->get_attributes() as $attribute ) {
			if ( $attribute->get_visible() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Returns whether or not the product has any child product.
	 *
	 * @return bool
	 */
	public function has_child() {
		return 0 < count( $this->get_children() );
	}

	/**
	 * Does a child have dimensions?
	 *
	 * @return bool
	 * @since  3.0.0
	 */
	public function child_has_dimensions() {
		return false;
	}

	/**
	 * Does a child have a weight?
	 *
	 * @return boolean
	 * @since  3.0.0
	 */
	public function child_has_weight() {
		return false;
	}

	/**
	 * Check if downloadable product has a file attached.
	 *
	 * @param string $download_id file identifier.
	 *
	 * @return bool Whether downloadable product has a file attached.
	 * @since 1.6.2
	 *
	 */
	public function has_file( $download_id = '' ) {
		return $this->is_downloadable() && $this->get_file( $download_id );
	}

	/**
	 * Returns whether or not the product has additional options that need
	 * selecting before adding to cart.
	 *
	 * @since  3.0.0
	 * @return boolean
	 */
	public function has_options() {
		return apply_filters( 'woocommerce_product_has_options', false, $this );
	}

	/*
	|--------------------------------------------------------------------------
	| Non-CRUD Getters
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get the product's title. For products this is the product name.
	 *
	 * @return string
	 */
	public function get_title() {
		return apply_filters( 'woocommerce_product_title', $this->get_name(), $this );
	}

	/**
	 * Product permalink.
	 *
	 * @return string
	 */
	public function get_permalink() {
		return get_permalink( $this->get_id() );
	}

	/**
	 * Returns the children IDs if applicable. Overridden by child classes.
	 *
	 * @return array of IDs
	 */
	public function get_children() {
		return array();
	}

	/**
	 * If the stock level comes from another product ID, this should be modified.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_stock_managed_by_id() {
		return $this->get_id();
	}

	/**
	 * Returns the price in html format.
	 *
	 * @param string $deprecated Deprecated param.
	 *
	 * @return string
	 */
	public function get_price_html( $deprecated = '' ) {
		if ( '' === $this->get_price() ) {
			$price = apply_filters( 'woocommerce_empty_price_html', '', $this );
		} elseif ( $this->is_on_sale() ) {
			$price = wc_format_sale_price( wc_get_price_to_display( $this, array( 'price' => $this->get_regular_price() ) ), wc_get_price_to_display( $this ) ) . $this->get_price_suffix();
		} else {
			$price = wc_price( wc_get_price_to_display( $this ) ) . $this->get_price_suffix();
		}

		return apply_filters( 'woocommerce_get_price_html', $price, $this );
	}

	/**
	 * Get product name with SKU or ID. Used within admin.
	 *
	 * @return string Formatted product name
	 */
	public function get_formatted_name() {
		if ( $this->get_sku() ) {
			$identifier = $this->get_sku();
		} else {
			$identifier = '#' . $this->get_id();
		}

		return sprintf( '%2$s (%1$s)', $identifier, $this->get_name() );
	}

	/**
	 * Get min quantity which can be purchased at once.
	 *
	 * @return int
	 * @since  3.0.0
	 */
	public function get_min_purchase_quantity() {
		return 1;
	}

	/**
	 * Get max quantity which can be purchased at once.
	 *
	 * @return int Quantity or -1 if unlimited.
	 * @since  3.0.0
	 */
	public function get_max_purchase_quantity() {
		return $this->is_sold_individually() ? 1 : ( $this->backorders_allowed() || ! $this->managing_stock() ? - 1 : $this->get_stock_quantity() );
	}

	/**
	 * Get the add to url used mainly in loops.
	 *
	 * @return string
	 */
	public function add_to_cart_url() {
		return apply_filters( 'woocommerce_product_add_to_cart_url', $this->get_permalink(), $this );
	}

	/**
	 * Get the add to cart button text for the single page.
	 *
	 * @return string
	 */
	public function single_add_to_cart_text() {
		return apply_filters( 'woocommerce_product_single_add_to_cart_text', esc_html__( 'Add to cart', 'valeska-core' ), $this );
	}

	/**
	 * Get the add to cart button text.
	 *
	 * @return string
	 */
	public function add_to_cart_text() {
		return apply_filters( 'woocommerce_product_add_to_cart_text', esc_html__( 'Read more', 'valeska-core' ), $this );
	}

	/**
	 * Get the add to cart button text description - used in aria tags.
	 *
	 * @return string
	 * @since  3.3.0
	 */
	public function add_to_cart_description() {
		/* translators: %s: Product title */
		return apply_filters( 'woocommerce_product_add_to_cart_description', sprintf( esc_html__( 'Read more about &ldquo;%s&rdquo;', 'valeska-core' ), $this->get_name() ), $this );
	}

	/**
	 * Returns the main product image.
	 *
	 * @param string $size (default: 'woocommerce_thumbnail').
	 * @param array $attr Image attributes.
	 * @param bool $placeholder True to return $placeholder if no image is found, or false to return an empty string.
	 *
	 * @return string
	 */
	public function get_image( $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true ) {
		$image = '';
		if ( $this->get_image_id() ) {
			$image = wp_get_attachment_image( $this->get_image_id(), $size, false, $attr );
		} elseif ( $this->get_parent_id() ) {
			$parent_product = wc_get_product( $this->get_parent_id() );
			if ( $parent_product ) {
				$image = $parent_product->get_image( $size, $attr, $placeholder );
			}
		}

		if ( ! $image && $placeholder ) {
			$image = wc_placeholder_img( $size, $attr );
		}

		return apply_filters( 'woocommerce_product_get_image', $image, $this, $size, $attr, $placeholder, $image );
	}

	/**
	 * Returns the product shipping class SLUG.
	 *
	 * @return string
	 */
	public function get_shipping_class() {
		$class_id = $this->get_shipping_class_id();
		if ( $class_id ) {
			$term = get_term_by( 'id', $class_id, 'product_shipping_class' );

			if ( $term && ! is_wp_error( $term ) ) {
				return $term->slug;
			}
		}
		return '';
	}

	/**
	 * Returns a single product attribute as a string.
	 *
	 * @param string $attribute to get.
	 *
	 * @return string
	 */
	public function get_attribute( $attribute ) {
		$attributes = $this->get_attributes();
		$attribute  = sanitize_title( $attribute );

		if ( isset( $attributes[ $attribute ] ) ) {
			$attribute_object = $attributes[ $attribute ];
		} elseif ( isset( $attributes[ 'pa_' . $attribute ] ) ) {
			$attribute_object = $attributes[ 'pa_' . $attribute ];
		} else {
			return '';
		}

		return $attribute_object->is_taxonomy() ? implode( ', ', wc_get_product_terms( $this->get_id(), $attribute_object->get_name(), array( 'fields' => 'names' ) ) ) : wc_implode_text_attributes( $attribute_object->get_options() );
	}

	/**
	 * Get the total amount (COUNT) of ratings, or just the count for one rating e.g. number of 5 star ratings.
	 *
	 * @param int $value Optional. Rating value to get the count for. By default returns the count of all rating values.
	 *
	 * @return int
	 */
	public function get_rating_count( $value = null ) {
		$counts = $this->get_rating_counts();

		if ( is_null( $value ) ) {
			return array_sum( $counts );
		} elseif ( isset( $counts[ $value ] ) ) {
			return absint( $counts[ $value ] );
		} else {
			return 0;
		}
	}

	/**
	 * Get a file by $download_id.
	 *
	 * @param string $download_id file identifier.
	 *
	 * @return array|false if not found
	 */
	public function get_file( $download_id = '' ) {
		$files = $this->get_downloads();

		if ( '' === $download_id ) {
			$file = count( $files ) ? current( $files ) : false;
		} elseif ( isset( $files[ $download_id ] ) ) {
			$file = $files[ $download_id ];
		} else {
			$file = false;
		}

		return apply_filters( 'woocommerce_product_file', $file, $this, $download_id );
	}

	/**
	 * Get file download path identified by $download_id.
	 *
	 * @param string $download_id file identifier.
	 *
	 * @return string
	 */
	public function get_file_download_path( $download_id ) {
		$files     = $this->get_downloads();
		$file_path = isset( $files[ $download_id ] ) ? $files[ $download_id ]->get_file() : '';

		// allow overriding based on the particular file being requested.
		return apply_filters( 'woocommerce_product_file_download_path', $file_path, $this, $download_id );
	}

	/**
	 * Get the suffix to display after prices > 0.
	 *
	 * @param  string  $price to calculate, left blank to just use get_price().
	 * @param  integer $qty   passed on to get_price_including_tax() or get_price_excluding_tax().
	 * @return string
	 */
	public function get_price_suffix( $price = '', $qty = 1 ) {
		$html = '';

		$suffix = get_option( 'woocommerce_price_display_suffix' );
		if ( $suffix && wc_tax_enabled() && 'taxable' === $this->get_tax_status() ) {
			if ( '' === $price ) {
				$price = $this->get_price();
			}
			$replacements = array(
				'{price_including_tax}' => wc_price( wc_get_price_including_tax( $this, array( 'qty' => $qty, 'price' => $price ) ) ), // @phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing.ArrayItemNoNewLine, WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound
				'{price_excluding_tax}' => wc_price( wc_get_price_excluding_tax( $this, array( 'qty' => $qty, 'price' => $price ) ) ), // @phpcs:ignore WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound
			);
			$html         = str_replace( array_keys( $replacements ), array_values( $replacements ), ' <small class="woocommerce-price-suffix">' . wp_kses_post( $suffix ) . '</small>' );
		}
		return apply_filters( 'woocommerce_get_price_suffix', $html, $this, $price, $qty );
	}

	/**
	 * Returns the availability of the product.
	 *
	 * @return string[]
	 */
	public function get_availability() {
		return apply_filters(
			'woocommerce_get_availability',
			array(
				'availability' => $this->get_availability_text(),
				'class'        => $this->get_availability_class(),
			),
			$this
		);
	}

	/**
	 * Get availability text based on stock status.
	 *
	 * @return string
	 */
	protected function get_availability_text() {
		if ( ! $this->is_in_stock() ) {
			$availability = esc_html__( 'Out of stock', 'valeska-core' );
		} elseif ( $this->managing_stock() && $this->is_on_backorder( 1 ) ) {
			$availability = $this->backorders_require_notification() ? esc_html__( 'Available on backorder', 'valeska-core' ) : '';
		} elseif ( ! $this->managing_stock() && $this->is_on_backorder( 1 ) ) {
			$availability = esc_html__( 'Available on backorder', 'valeska-core' );
		} elseif ( $this->managing_stock() ) {
			$availability = wc_format_stock_for_display( $this );
		} else {
			$availability = '';
		}
		return apply_filters( 'woocommerce_get_availability_text', $availability, $this );
	}

	/**
	 * Get availability classname based on stock status.
	 *
	 * @return string
	 */
	protected function get_availability_class() {
		if ( ! $this->is_in_stock() ) {
			$class = 'out-of-stock';
		} elseif ( ( $this->managing_stock() && $this->is_on_backorder( 1 ) ) || ( ! $this->managing_stock() && $this->is_on_backorder( 1 ) ) ) {
			$class = 'available-on-backorder';
		} else {
			$class = 'in-stock';
		}
		return apply_filters( 'woocommerce_get_availability_class', $class, $this );
	}
}

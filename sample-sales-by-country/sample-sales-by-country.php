<?php
/**
 * Plugin Name: sample-sales-by-country
 *
 * @package WC_Admin
 */

/**
 * Register the JS.
 */
function add_sample_sales_by_country_register_script() {

	if ( ! class_exists( 'Automattic\WooCommerce\Admin\Loader' ) || ! \Automattic\WooCommerce\Admin\Loader::is_admin_page() ) {
		return;
	}

	$script_path       = '/build/index.js';
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require( $script_asset_path )
		: array( 'dependencies' => array(), 'version' => filemtime( $script_path ) );
	$script_url = plugins_url( $script_path, __FILE__ );

	wp_register_script(
		'sample-sales-by-country',
		$script_url,
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);

	wp_register_style(
		'sample-sales-by-country',
		plugins_url( '/build/style.css', __FILE__ ),
		// Add any dependencies styles may have, such as wp-components.
		array(),
		filemtime( dirname( __FILE__ ) . '/build/style.css' )
	);

	wp_enqueue_script( 'sample-sales-by-country' );
	wp_enqueue_style( 'sample-sales-by-country' );
}

add_action( 'admin_enqueue_scripts', 'add_sample_sales_by_country_register_script' );

add_filter('woocommerce_analytics_report_menu_items', 'add_sample_sales_by_country_to_analytics_menu');

function add_sample_sales_by_country_to_analytics_menu($report_pages) {
    $report_pages[] = array(
        'id' => 'sample-sales-by-country',
        'title' => __('Sales by Country', 'sample-sales-by-country'),
        'parent' => 'woocommerce-analytics',
        'path' => '/analytics/sample-sales-by-country',
    );

    return $report_pages;
}
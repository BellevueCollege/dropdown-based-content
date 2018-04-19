<?php
/*
Plugin Name: Dropdown Based Content
Plugin URI: https://github.com/BellevueCollege/dropdown-based-content
Description: Show content based on a combobox or dropdown selection
Author: Bellevue College Integration Team
Version: 0.0.0.1
Author URI: http://www.bellevuecollege.edu
GitHub Plugin URI: BellevueCollege/dropdown-based-content
*/
defined( 'ABSPATH' ) || exit;





/**
 * Add Subresource Integrity - adapted from https://ikreativ.com/async-with-wordpress-enqueue/
 *
 * Allow insertion of SRI integrity tag. Add #addsri=HASH to add this feature.
 */
add_filter( 'clean_url', 'dbc_add_sri', 11, 1 );
function dbc_add_sri( $url ) {
	if ( strpos( $url, '#addsri' ) ) {
		return preg_replace( '/#addsri=(.*)\Z/i', "' integrity='$1", $url ) . "' crossorigin='anonymous";
	} else {
		return $url;
	}
}

/**
 * Enqueue Scripts and Styles 
 */
add_action( 'wp_enqueue_scripts', 'dbc_scripts' );
function dbc_scripts() {
	wp_enqueue_style( 'dbc-style', plugin_dir_url( __FILE__ ) . 'css/dbc.css', null, rand() ); // REMOVE RAND BEFORE RELEASE!
	wp_enqueue_script( 'combobo', 'https://unpkg.com/combobo@2.0.1/dist/combobo.js#addsri=sha384-Wi4+N8V0Z6wGoSZO9v6BJtfdBVOWZPUOueHKSQ6UKforJpdw9Ic/GmkszhdKBIUi', array(), null, false );
	wp_enqueue_script( 'dbc-script', plugin_dir_url( __FILE__ ) . 'js/dbc.js', array('combobo'), rand(), true ); // REMOVE RAND BEFORE RELEASE!
}


// [bartag foo="foo-value"]
function dbc_output_func( $atts ) {
	$a = shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts );

	$output = file_get_contents( plugin_dir_path( __FILE__ ) . 'content.html' );

	return $output;
}
add_shortcode( 'outputtest', 'dbc_output_func' );
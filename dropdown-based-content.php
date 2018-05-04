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
 * Block Initializer.
 * 
 * Structure based on Create Guten Block plugin
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';


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
 * Register Scripts and Styles
 */
add_action( 'wp_enqueue_scripts', 'dbc_scripts_styles' );

function dbc_scripts_styles() {
	wp_register_style( 'bc_dbc-cgb-style-css', plugin_dir_url( __FILE__ ) . 'dist/blocks.style.build.css', null, rand() ); // REMOVE RAND BEFORE RELEASE!
	wp_register_script( 'combobo', 'https://unpkg.com/combobo@2.0.1/dist/combobo.js#addsri=sha384-Wi4+N8V0Z6wGoSZO9v6BJtfdBVOWZPUOueHKSQ6UKforJpdw9Ic/GmkszhdKBIUi', array(), '2.0.1', false );
	wp_register_script( 'dbc-script', plugin_dir_url( __FILE__ ) . 'js/dbc.js', array('combobo'), rand(), true ); // REMOVE RAND BEFORE RELEASE!
}

/**
 * Register [dbc] shortcode
 * 
 * Main wrapper shortcode with single 'label' attribute
 * which allows main container label to be set
 */
add_shortcode( 'dbc', 'dbc_dbc_shortcode_func' );

function dbc_dbc_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'label' => 'I would like to graduate with a degree in:'
	), $atts );

	/**
	 * Enqueue scripts and styles registered previously
	 */
	wp_enqueue_style( 'bc_dbc-cgb-style-css' );
	wp_enqueue_script( 'combobo' );
	wp_enqueue_script( 'dbc-script' );

	$label = $a['label'];

	ob_start();
	require_once( plugin_dir_path( __FILE__ ) . 'templates/dbc.php' );
	return ob_get_clean();
	
}

/**
 * Add [dbc_options] shortcode to wrap combobox options
 * 
 * Options wrapper shortcode with 'button' and 'placeholder' attributes
 * used to set the text of the CTA button, and the input placeholder
 */
add_shortcode( 'dbc_options', 'dbc_dbc_options_shortcode_func' );

function dbc_dbc_options_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'button' => 'Go',
		'placeholder' => 'Search for or select an option',
	), $atts );

	$button = $a['button'];
	$placeholder = $a['placeholder'];

	ob_start();
	require_once( plugin_dir_path( __FILE__ ) . 'templates/dbc_options.php' );
	return ob_get_clean();
}

/**
 * Add [dbc_option] shortcode used for individual combobox options
 * 
 * Has 'title' and 'content_id' attributes, which accept the title of
 * the combobox option (displayed), and the ID to target for content to display
 * Does not accept content
 */
add_shortcode( 'dbc_option', 'dbc_dbc_option_shortcode_func' );

function dbc_dbc_option_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'title' => '',
		'content_id' => '',
	), $atts );

	$title = $a['title'];
	$content_id = $a['content_id'];

	if ( '' != $title && '' != $content_id ) {
		ob_start();
		require( plugin_dir_path( __FILE__ ) . 'templates/dbc_option.php' );
		return ob_get_clean();
	}

}

/**
 * Add [dbc_content] shortcode to wrap content
 * 
 * Has 'id' attribute, used to set element ID.
 * Should be unique, but this is not enforced
 */
add_shortcode( 'dbc_content', 'dbc_dbc_content_shortcode_func' );

function dbc_dbc_content_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'id' => '',
	), $atts );

	$id = $a['id'];
	if ( '' != $id ) {
		ob_start();
		require( plugin_dir_path( __FILE__ ) . 'templates/dbc_content.php' );
		return ob_get_clean();
	}
}

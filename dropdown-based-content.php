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
	wp_enqueue_script( 'combobo', 'https://unpkg.com/combobo@2.0.1/dist/combobo.js#addsri=sha384-Wi4+N8V0Z6wGoSZO9v6BJtfdBVOWZPUOueHKSQ6UKforJpdw9Ic/GmkszhdKBIUi', array(), '2.0.1', false );
	wp_enqueue_script( 'dbc-script', plugin_dir_url( __FILE__ ) . 'js/dbc.js', array('combobo'), rand(), true ); // REMOVE RAND BEFORE RELEASE!
}


// [bartag foo="foo-value"]
// function dbc_output_func( $atts ) {
// 	$a = shortcode_atts( array(
// 		'foo' => 'something',
// 		'bar' => 'something else',
// 	), $atts );

// 	$output = file_get_contents( plugin_dir_path( __FILE__ ) . 'content.html' );

// 	return $output;
// }
// add_shortcode( 'outputtest', 'dbc_output_func' );

function dbc_dbc_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'label' => 'I would like to graduate with a degree in:'
	), $atts );

	$output = '<div class="dbc"><label for="dbc-combobox">' . $a['label'] . '</label>';
	$output .= do_shortcode( $content );
	$output .= '</div>';

	return $output;
}
add_shortcode( 'dbc', 'dbc_dbc_shortcode_func' );



function dbc_dbc_options_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
	), $atts );

	$output = '<div class="input-group input-group-lg">';
	$output .= '<div class="combo-wrap">';
	$output .= '<input type="text" class="combobox form-control" id="dbc-combobox">';
	$output .= '<div class="listbox" aria-labelledby="dbc-combobox">';
	$output .= do_shortcode( $content );
	$output .= '</div></div>';
	$output .= '<span class="input-group-btn">';
	$output .= '<button type="button" class="btn btn-default trigger" aria-hidden="true" id="dbc-combobox-trigger"><span class="glyphicon glyphicon-menu-down" data-trigger="dbc-combobox"></span></button>';
	$output .= '<button type="button" class="btn btn-success disabled" id="dbc-combobox-action">Go!</button>';
	$output .= '</span></div>';

	return $output;
}
add_shortcode( 'dbc_options', 'dbc_dbc_options_shortcode_func' );



function dbc_dbc_option_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'title' => '',
		'content_id' => '',
	), $atts );

	$output = '<div class="option" ' . ( $a['content_id'] ? 'data-target="' . $a['content_id'] . '"' : '') . '>';
	$output .= $a['title'];
	$output .= '</div>';

	return $output;

}
add_shortcode( 'dbc_option', 'dbc_dbc_option_shortcode_func' );



function dbc_dbc_content_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'id' => '',
	), $atts );


	return '<div id="' . $a['id'] . '" class="dbc-content">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'dbc_content', 'dbc_dbc_content_shortcode_func' );


/*
<section class="dbc">
	<label for="dbc-combobox">I would like to graduate with a degree in: </label>
	<div class="input-group input-group-lg">
		<div class="combo-wrap">
			<input type="text" class="combobox form-control" id="dbc-combobox">

			<div class="listbox" aria-labelledby='dbc-combobox'>
				<div class="option" data-target="dbc-content-shirts">Shirts</div>
				<div class="option" data-target="dbc-content-shorts">Shorts</div>
				<div class="option">Pants</div>
				<div class="option">Socks</div>
			</div>

		</div>
		<span class="input-group-btn">
			<button type="button" class="btn btn-default trigger" aria-hidden="true" id="dbc-combobox-trigger"><span class="glyphicon glyphicon-menu-down" data-trigger="dbc-combobox"></span></button>
			<button type="button" class="btn btn-primary" id="dbc-combobox-action">Submit</button>
		</span>
	</div>
	<hr>
	<div class="well dbc-content" id="dbc-content-shorts">
		<h2>Cool Shorts Yo</h2>
		<p>Wow... shorts</p>
	</div>
	<div class="well dbc-content" id="dbc-content-shirts">
		<h2>Cool Shirts Yo</h2>
		<p>Wow... shirts</p>
	</div>
	<div class="well dbc-content" id="dbc-content-default">
		<h2>Default, man</h2>
		<p>Stuff n stuff</p>
	</div>
</section>
*/
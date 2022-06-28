<?php
/**
 * 
 *
 *
 * Template Name: Home Page
 *
 */

add_filter( 'body_class', 'ela_page_custom_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function ela_page_custom_body_class( $classes ) {

	$classes[] = 'uvsc-home';
	$classes[] = 'uvsc-hero';
	$classes[] = 'uvsc-page';

	return $classes;

}

//  remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//  remove main wrapper
add_filter( 'genesis_markup_content', '__return_null' );


//  custom hero area
get_template_part( E_TEMPLATES, 'home-hero' );

//	if ACF flexible content
// if ( have_rows( 'sections' ) ) get_template_part( E_TEMPLATE, 'acf-flexible' );


// Runs the Genesis loop.
genesis();
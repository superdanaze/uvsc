<?php
/**
 * 
 *
 *
 * Template Name: UVSC Elementor
 *
 */

//	custom hero atts
$custom_hero = get_field('add_custom_hero_section');
$hero_type = get_field('hero_section_type');


add_filter( 'body_class', 'rp_page_custom_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function rp_page_custom_body_class( $classes ) {

	$classes[] = 'uvsc-elementor';
	$classes[] = 'uvsc-page';

	//	add custom hero class
	global $custom_hero;
	if ( $custom_hero ) $classes[] = 'has-hero';

	return $classes;

}

//  remove post title
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

//  remove post entry meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//  remove header markup
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//  remove content sidebar wrap div
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

//  remove main wrapper
add_filter( 'genesis_markup_content', '__return_null' );




// Runs the Genesis loop.
genesis();
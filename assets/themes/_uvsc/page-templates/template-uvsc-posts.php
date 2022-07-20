<?php
/**
 * 
 *
 *
 * Template Name: UVSC Posts
 *
 */

//	custom background
$funcs = new ELA_Funcs;
$page_bg = get_field('page_background_image');

//  print css
if ( $page_bg ) {
	$css = '
		body {
			background-image:url('. $page_bg['url'] .');
		}
	';
	$funcs->aggregate_css( 'uvsc-page-bg', $css, true );
}


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

	$classes[] = 'uvsc-posts';
	$classes[] = 'uvsc-page';
	$classes[] = 'uvsc-hero';

	//	add custom hero class
	global $page_bg;
	if ( $page_bg ) $classes[] = 'uvsc-page-bg background cover';

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


//  get hero
get_template_part( E_TEMPLATES, 'posts-type-hero' );

//  get posts layout
$posts_type = get_field('aggregate_posts');
$posts_per_page = get_field('posts_per_page');

get_template_part( E_TEMPLATES, 'aggregate-posts', array( 'posts_type' => $posts_type, 'posts_per_page' => $posts_per_page ) );


// Runs the Genesis loop.
genesis();
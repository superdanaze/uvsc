<?php
/**
 * 
 *
 *
 * Template Name: UVSC Donate
 *
 */

//	custom background
$funcs = new ELA_Funcs;
// $page_bg = get_field('page_background_image');

//  print css
// if ( $page_bg ) {
// 	$css = '
// 		body {
// 			background-image:url('. $page_bg['url'] .');
// 		}
// 	';
// 	$funcs->aggregate_css( 'uvsc-page-bg', $css, true );
// }


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

	$classes[] = 'uvsc-page';
	$classes[] = 'uvsc-hero';

	//	add custom hero class
	// global $page_bg;
	// if ( $page_bg ) $classes[] = 'uvsc-page-bg background cover';

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


//  HERO
get_template_part( E_TEMPLATES, 'page-hero' );


//  VARS
$vars = (object) array(
    'title'                 => get_field('content_title'),
    'subtitle'              => get_field('content_subtitle'),
    'separator_dark'        => get_field( 'separator_dark', 'options' ),
    'paypal_link'           => get_field('paypal_donation_link'),
    'one_time_sc'           => get_field('one_time_donation_form_shortcodes'),
    'one_time_custom_sc'    => get_field('one_time_custom_amount_donation_shortcode'),
    'monthly_sc'            => get_field('monthly_donation_form_shortcodes'),
    'monthly_custom_sc'     => get_field('monthly_custom_amount_donation_shortcode'),
    'cf_title'              => get_field('cancer_fighters_title'),
    'cf_subtext'            => get_field('cancer_fighters_subtext'),
    'pb_title'              => get_field('past_beneficiaries_title'),
    'pb_subtext'            => get_field('past_beneficiaries_subtext'),
    'tt_title'              => get_field('trailing_text_title'),
    'tt_text'               => get_field('trailing_text_text'),
    'row'                   => 1
);
    

//  INTRO CONTENT
function intro_content() {
    global $vars;

    genesis_markup(
        [
            'open'		=> '<section %s>',
            'context'	=> "donate_intro",
            'atts'		=> [ 'class' => "donate-intro full__container rel T_xxlg", 'data-row' => $vars->row++ ]
        ]
    );

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> "donate_intro_inner",
                'atts'		=> [ 'class' => "donate-intro-inner _medium rel L_sm R_sm" ]
            ]
        );

            //  title
            if ( $vars->title ) printf( '<h3 class="content-title text_center nomargin">%s</h3>', trim( $vars->title ) );

            //  separator
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> "donate_intro_separator",
                    'atts'		=> [ 'class' => "donate-intro-separator full__container flex horiz rel T_md B_md" ],
                    'content'   => wp_get_attachment_image( $vars->separator_dark['id'], "medium" ),
                    'close'     => '</div>'
                ]
            );

            //  subtitle
            if ( $vars->subtitle ) printf( '<span>%s</span>', trim( $vars->subtitle ) );


        genesis_markup(
            [
                'context'	=> "donate_intro_inner",
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> "donate_intro",
            'close'		=> '</section>'
        ]
    );

}

add_filter( 'genesis_entry_content', 'intro_content' );



//  DONATION MODULE
function donation_content() {
    global $vars;
    $paypal = '<svg x="0px" y="0px" width="88.438px" height="22.812px" viewBox="0 17.469 88.438 22.812" enable-background="new 0 17.469 88.438 22.812" xml:space="preserve"><g><g><path class="regular easy_does_it easy_does_it" fill="#fafafa" d="M67.929,23.502h-4.743c-0.278,0-0.557,0.278-0.697,0.558l-1.951,12.275c0,0.277,0.139,0.418,0.418,0.418h2.51c0.279,0,0.419-0.141,0.419-0.418l0.559-3.487c0-0.279,0.278-0.559,0.697-0.559h1.533c3.208,0,5.022-1.534,5.44-4.603c0.279-1.256,0-2.372-0.559-3.069C70.719,23.92,69.463,23.502,67.929,23.502 M68.486,28.104c-0.278,1.674-1.534,1.674-2.79,1.674H64.86l0.559-3.208c0-0.14,0.139-0.279,0.418-0.279h0.279c0.836,0,1.673,0,2.092,0.558C68.486,26.989,68.486,27.407,68.486,28.104"></path></g><g><path class="regular easy_does_it" fill="#fafafa" d="M33.756,23.502h-4.744c-0.278,0-0.558,0.278-0.697,0.558l-1.953,12.275c0,0.277,0.14,0.418,0.419,0.418h2.231c0.279,0,0.559-0.279,0.698-0.559l0.559-3.347c0-0.279,0.278-0.559,0.697-0.559H32.5c3.208,0,5.021-1.534,5.44-4.603c0.278-1.256,0-2.372-0.559-3.069C36.545,23.92,35.429,23.502,33.756,23.502 M34.313,28.104c-0.279,1.674-1.535,1.674-2.79,1.674h-0.697l0.558-3.208c0-0.14,0.14-0.279,0.419-0.279h0.278c0.837,0,1.675,0,2.093,0.558C34.313,26.989,34.453,27.407,34.313,28.104"></path></g><g><path class="regular easy_does_it" fill="#fafafa" d="M48.122,27.965h-2.231c-0.14,0-0.419,0.14-0.419,0.279l-0.14,0.697l-0.139-0.279c-0.559-0.697-1.535-0.976-2.65-0.976c-2.511,0-4.742,1.952-5.161,4.603c-0.279,1.395,0.14,2.65,0.837,3.487c0.697,0.836,1.674,1.115,2.929,1.115c2.093,0,3.208-1.255,3.208-1.255l-0.139,0.698c0,0.277,0.139,0.418,0.418,0.418h2.093c0.279,0,0.559-0.279,0.697-0.559l1.256-7.811C48.54,28.244,48.261,27.965,48.122,27.965 M44.914,32.428c-0.279,1.256-1.256,2.232-2.65,2.232c-0.697,0-1.256-0.279-1.534-0.559c-0.279-0.418-0.419-0.977-0.419-1.674c0.14-1.254,1.256-2.231,2.512-2.231c0.697,0,1.115,0.279,1.533,0.559C44.773,31.173,44.914,31.871,44.914,32.428"></path></g><g><path class="regular easy_does_it" fill="#fafafa" d="M82.156,27.965h-2.232c-0.139,0-0.418,0.14-0.418,0.279l-0.139,0.697l-0.141-0.279c-0.557-0.697-1.533-0.976-2.649-0.976c-2.512,0-4.743,1.952-5.161,4.603c-0.279,1.395,0.139,2.65,0.837,3.487c0.697,0.836,1.674,1.115,2.93,1.115c2.092,0,3.208-1.255,3.208-1.255l-0.141,0.698c0,0.277,0.141,0.418,0.42,0.418h2.092c0.278,0,0.558-0.279,0.697-0.559l1.255-7.811C82.575,28.244,82.435,27.965,82.156,27.965 M78.947,32.428c-0.277,1.256-1.254,2.232-2.649,2.232c-0.697,0-1.256-0.279-1.535-0.559c-0.277-0.418-0.418-0.977-0.418-1.674c0.141-1.254,1.256-2.231,2.511-2.231c0.697,0,1.117,0.279,1.535,0.559C78.947,31.173,79.088,31.871,78.947,32.428"></path></g><g><g><path class="regular easy_does_it" fill="#fafafa" d="M60.258,27.965h-2.372c-0.279,0-0.418,0.14-0.559,0.279l-3.067,4.742l-1.395-4.464c-0.141-0.278-0.279-0.418-0.697-0.418h-2.233c-0.278,0-0.418,0.279-0.418,0.558l2.511,7.394l-2.371,3.347c-0.14,0.279,0,0.697,0.278,0.697h2.233c0.277,0,0.418-0.139,0.557-0.278l7.672-11.02C60.814,28.384,60.537,27.965,60.258,27.965"></path></g><g><path class="regular easy_does_it" fill="#fafafa" d="M84.806,23.92l-1.951,12.554c0,0.279,0.139,0.418,0.418,0.418h1.952c0.279,0,0.559-0.279,0.697-0.557l1.953-12.275c0-0.279-0.139-0.419-0.418-0.419h-2.232C85.085,23.502,84.946,23.641,84.806,23.92"></path></g><g><path class="darker easy_does_it" fill="#f5f5f5" d="M16.041,19.317c-0.977-1.116-2.79-1.674-5.3-1.674H3.766c-0.418,0-0.837,0.418-0.977,0.837L0,36.753c0,0.418,0.279,0.697,0.558,0.697h4.324l1.116-6.835v0.279c0.14-0.418,0.559-0.836,0.977-0.836h2.092c4.045,0,7.114-1.674,8.09-6.277c0-0.14,0-0.278,0-0.418c-0.139,0-0.139,0,0,0C17.296,21.548,17.018,20.433,16.041,19.317"></path></g></g><g><path class="regular easy_does_it" fill="#fafafa" d="M17.018,23.362L17.018,23.362c0,0.14,0,0.278,0,0.418c-0.977,4.742-4.046,6.277-8.091,6.277H6.834c-0.418,0-0.837,0.418-0.976,0.836l-1.395,8.508c0,0.279,0.139,0.559,0.558,0.559h3.627c0.418,0,0.836-0.279,0.836-0.697v-0.14l0.697-4.324v-0.279c0-0.419,0.419-0.697,0.837-0.697h0.558c3.487,0,6.276-1.396,6.974-5.579c0.279-1.674,0.14-3.208-0.698-4.185C17.715,23.78,17.436,23.502,17.018,23.362"></path></g><g><path class="darker easy_does_it" fill="#f5f5f5" d="M16.041,22.943c-0.14,0-0.279-0.139-0.418-0.139c-0.14,0-0.279,0-0.419-0.14c-0.558-0.139-1.116-0.139-1.813-0.139h-5.44c-0.14,0-0.279,0-0.418,0.139c-0.279,0.14-0.418,0.418-0.418,0.698l-1.116,7.252v0.279c0.14-0.418,0.559-0.836,0.977-0.836h2.092c4.045,0,7.114-1.674,8.09-6.277c0-0.14,0-0.278,0.14-0.418c-0.278-0.14-0.418-0.279-0.697-0.279C16.18,22.943,16.18,22.943,16.041,22.943"></path></g></g></svg>';

    genesis_markup(
        [
            'open'		=> '<section %s>',
            'context'	=> "donate_content",
            'atts'		=> [ 'id' => "giving", 'class' => "donate-content full__container rel T_lg", 'data-row' => $vars->row++ ]
        ]
    );

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> "donate_content_wrap",
                'atts'		=> [ 'class' => "donate-intro-wrap uvsc-bisque-bg full__container rel T_lg B_lg L_sm R_sm" ]
            ]
        );

            //  donation type buttons
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> "donation_type_wrap",
                    'atts'		=> [ 'class' => "donation-types _small grid noover rel" ]
                ]
            );

                //  give today
                genesis_markup(
                    [
                        'open'      => '<button %s>',
                        'context'	=> "button_one_time",
                        'atts'		=> [ 'class' => "d-type-btn uvsc-before flex horiz vert rel active", 'data-id' => "onetime" ],
                        'content'   => '<span class="nopoint rel">Give Today</span>',
                        'close'     => '</button>'
                    ]
                );

                //  give monthly
                genesis_markup(
                    [
                        'open'      => '<button %s>',
                        'context'	=> "button_monthly",
                        'atts'		=> [ 'class' => "d-type-btn uvsc-before flex horiz vert rel", 'data-id' => "monthly" ],
                        'content'   => '<span class="nopoint rel">Give Monthly</span>',
                        'close'     => '</button>'
                    ]
                );

                //  give with Paypal
                genesis_markup(
                    [
                        'open'      => '<figure %s>',
                        'context'	=> "button_paypal_wrap",
                        'atts'		=> [ 'class' => "d-type-btn uvsc-before paypal flex horiz vert rel" ]
                    ]
                );

                    genesis_markup(
                        [
                            'open'      => '<a %s>',
                            'context'	=> "button_paypal",
                            'atts'		=> [ 'class' => "full__container full__height flex horiz vert rel", 'href' => $vars->paypal_link, 'target' => "_blank", 'rel' => "nofollow" ]
                        ]
                    );

                        print '<span class="r_mini">Give with</span>';
                        print $paypal;

                    genesis_markup(
                        [
                            'context'	=> "button_paypal",
                            'close'     => '</a>'
                        ]
                    );

                genesis_markup(
                    [
                        'context'	=> "button_paypal_wrap",
                        'close'     => '</figure>'
                    ]
                );


            genesis_markup(
                [
                    'context'	=> "donation_type_wrap",
                    'close'		=> '</div>'
                ]
            );



            //  donation blocks
            genesis_markup(
                [
                    'open'      => '<div %s>',
                    'context'	=> "donation_blocks",
                    'atts'		=> [ 'class' => "donation-blocks _small rel T_md easy_does_it" ]
                ]
            );

                //  one time donations
                genesis_markup(
                    [
                        'open'      => '<div %s>',
                        'context'	=> "one_time_donations",
                        'atts'		=> ['id' => "onetime", 'class' => "donation-block one-time full__container rel" ]
                    ]
                );

                    //  pre-determined amounts
                    genesis_markup(
                        [
                            'open'      => '<div %s>',
                            'context'	=> "one_time_donations_inner",
                            'atts'		=> ['class' => "donation-block-inner full__container grid rel" ]
                        ]
                    );

                        if ( $vars->one_time_sc ) {
                            foreach( $vars->one_time_sc as $key => $item ) {
                                print do_shortcode( $item['shortcode'] );
                            }
                        }
                        
                    genesis_markup(
                        [
                            'context'	=> "one_time_donations_inner",
                            'close'      => '</div>'
                        ]
                    );

                    //  other amount
                    genesis_markup(
                        [
                            'open'      => '<div %s>',
                            'context'	=> "other_amount_donations_inner",
                            'atts'		=> ['class' => "donation-block-inner other-amt full__container rel" ]
                        ]
                    );

                        if ( $vars->one_time_custom_sc ) print do_shortcode( $vars->one_time_custom_sc );

                    genesis_markup(
                        [
                            'context'	=> "other_amount_donations_inner",
                            'close'      => '</div>'
                        ]
                    );


                genesis_markup(
                    [
                        'context'	=> "one_time_donations",
                        'close'      => '</div>'
                    ]
                );


                //  monthly recurring donations
                genesis_markup(
                    [
                        'open'      => '<div %s>',
                        'context'	=> "recurring_donations",
                        'atts'		=> ['id' => "monthly", 'class' => "donation-block monthly full__container rel hide" ]
                    ]
                );

                    //  pre-determined amounts
                    genesis_markup(
                        [
                            'open'      => '<div %s>',
                            'context'	=> "recurring_donations_inner",
                            'atts'		=> ['class' => "donation-block-inner full__container grid rel" ]
                        ]
                    );

                        if ( $vars->monthly_sc ) {
                            foreach( $vars->monthly_sc as $key => $item ) {
                                print do_shortcode( $item['shortcode'] );
                            }
                        }
                        
                    genesis_markup(
                        [
                            'context'	=> "recurring_donations_inner",
                            'close'      => '</div>'
                        ]
                    );

                    //  other amount
                    genesis_markup(
                        [
                            'open'      => '<div %s>',
                            'context'	=> "other_amount_donations_inner",
                            'atts'		=> ['class' => "donation-block-inner other-amt full__container rel" ]
                        ]
                    );

                        if ( $vars->monthly_custom_sc ) print do_shortcode( $vars->monthly_custom_sc );
                        
                    genesis_markup(
                        [
                            'context'	=> "other_amount_donations_inner",
                            'close'      => '</div>'
                        ]
                    );


                genesis_markup(
                    [
                        'context'	=> "recurring_donations",
                        'close'      => '</div>'
                    ]
                );


            genesis_markup(
                [
                    'context'	 => "donation_blocks",
                    'close'      => '</div>'
                ]
            );


        genesis_markup(
            [
                'context'	=> "donate_content_wrap",
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> "donate_content",
            'close'		=> '</section>'
        ]
    );
}

add_filter( 'genesis_entry_content', 'donation_content' );



//  CANCER FIGHTERS
function cancer_fighters() {
    global $vars;

    genesis_markup(
        [
            'open'		=> '<section %s>',
            'context'	=> "d_cancer_fighters",
            'atts'		=> [ 'id' => "cancer-fighters", 'class' => "cancer-fighters full__container rel T_xxlg", 'data-row' => $vars->row++ ]
        ]
    );

        get_template_part( E_TEMPLATES, 'cancer-fighters', array( 'title' => $vars->cf_title, 'subtext' => $vars->cf_subtext, 'limit' => -1 ) );

    genesis_markup(
        [
            'context'	=> "d_cancer_fighters",
            'close'		=> '</section>'
        ]
    );
}

add_filter( 'genesis_entry_content', 'cancer_fighters' );


//  PAST BENEFICIARIES
function past_beneficiaries() {
    global $vars;

    genesis_markup(
        [
            'open'		=> '<section %s>',
            'context'	=> "d_past_beneficiaries",
            'atts'		=> [ 'class' => "past-beneficiaries full__container rel T_xxlg", 'data-row' => $vars->row++ ]
        ]
    );

        get_template_part( E_TEMPLATES, 'past-beneficiaries', array( 'title' => $vars->pb_title, 'subtext' => $vars->pb_subtext, 'limit' => -1 ) );

    genesis_markup(
        [
            'context'	=> "d_past_beneficiaries",
            'close'		=> '</section>'
        ]
    );
}

add_filter( 'genesis_entry_content', 'past_beneficiaries' );


//  TRAILING TEXT
function trailing_text() {
    global $vars;

    genesis_markup(
        [
            'open'		=> '<section %s>',
            'context'	=> "d_trailing_text",
            'atts'		=> [ 'class' => "trailing-text full__container rel T_xxlg", 'data-row' => $vars->row++ ]
        ]
    );

        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "tt_inner",
                'atts'		=> [ 'class' => "tt-inner container rel L_sm R_sm" ]
            ]
        );

            if ( $vars->tt_title ) printf( '<h3 class="content-title text_center nomargin">%s</h3>', trim( $vars->tt_title ) );

            if ( $vars->tt_text ) printf( '<div class="_medium text_center T_sm rel">%s</div>', trim( $vars->tt_text ) );


        genesis_markup(
            [
                'context'	=> "tt_inner",
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> "d_trailing_text",
            'close'		=> '</section>'
        ]
    );
}

add_filter( 'genesis_entry_content', 'trailing_text' );



// Runs the Genesis loop.
genesis();
<?php
    //  footer template

    global $page_bg;

    $func = new ELA_Funcs;
    $footer_bg = get_field('footer_background_image', 'options');
    $footer_bg_p = get_field('footer_background_image_position', 'options');
    $logo = get_field( 'logo_light', 'option' );
    $col1_txt = get_field( 'column_1_text', 'options' );
    $col2_txt = get_field( 'column_2_text', 'options' );
    $col2_sc = get_field( 'column_2_form_shortcode', 'options' );
    $col3_txt = get_field( 'column_3_text', 'options' );
    $css = "";

    if ( $page_bg ) {
        $css .= '
            footer.site-footer {
                background-color:transparent;
                border-top:1px solid rgba(255,255,255,0.4);
            }
        ';
    } else {
        $css .= '
            footer.site-footer {
                background-color:transparent;
                background-image:url('. $func->imgsize( $footer_bg ) .');
                background-position:'. $footer_bg_p .';
                border-top:none;
            }
        ';
    }

    //  aggregate section css
    $func->aggregate_css( 'footer', $css, true );


    genesis_markup(
        [
            'open'      => '<section %s>',
            'context'	=> "footer_inner",
            'atts'		=> [ 'class' => "footer-inner full__container grid T_xlg B_xlg" ]
        ]
    );


        //  column 1
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "footer_col1",
                'atts'		=> [ 'class' => "footer-col" ]
            ]
        );

            printf( '<img class="footer-logo image" src="%s" alt="%s" />', $logo['url'], $logo['title'] );

            genesis_markup(
                [
                    'open'      => '<div %s>',
                    'context'	=> "footer_col1_txt",
                    'atts'		=> [ 'class' => "footer-text T_sm" ],
                    'content'   => sprintf( '<p class="f_med nomargin">%s</p>', trim( $col1_txt ) ),
                    'close'     => '</div>'
                ]
            );

        genesis_markup(
            [
                'context'	=> "footer_col1",
                'close'     => '</div>'
            ]
        );


        //  column 2
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "footer_col2",
                'atts'		=> [ 'class' => "footer-col" ]
            ]
        );

            if ( $col2_txt ) printf( '<p class="f_med kern1 nomargin B_md">%s</p>', trim( $col2_txt ) );

            if ( $col2_sc ) {
                genesis_markup(
                    [
                        'open'      => '<div %s>',
                        'context'	=> "footer_col2_sc",
                        'atts'		=> [ 'class' => "footer-sc" ]
                    ]
                );

                    print do_shortcode( trim( $col2_sc ) );

                genesis_markup(
                    [
                        'context'	=> "footer_col2_sc",
                        'close'     => '</div>'
                    ]
                );
            }

        genesis_markup(
            [
                'context'	=> "footer_col2",
                'close'     => '</div>'
            ]
        );

        //  column 3
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "footer_col3",
                'atts'		=> [ 'class' => "footer-col col--3" ]
            ]
        );

            if ( $col3_txt ) printf( '<p class="f_med nomargin">%s</p>', trim( $col3_txt ) );

        genesis_markup(
            [
                'context'	=> "footer_col3",
                'close'     => '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> "footer_inner",
            'close'     => '</section>'
        ]
    );


    //  social
    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'	=> "social_wrap",
            'atts'		=> [ 'class' => "social-wrap full__container flex horiz rel B_lg" ]
        ]
    );

        ELA_Elements::social_menu();

    genesis_markup(
        [
            'context'	=> "social_wrap",
            'close'     => '</div>'
        ]
    );
?>
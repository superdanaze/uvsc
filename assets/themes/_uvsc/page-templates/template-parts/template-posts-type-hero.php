<?php

//  UVSC Posts Template Hero Area

    $funcs = new ELA_Funcs;
    $vars = (object) array(
         'bg_img'               => get_field('hero_background_image'),
         'bg_img_position'      => get_field('hero_background_position'),
         'gradient'             => get_field('hero_gradient_overlay_color'),
         'gradient_opacity'     => get_field('hero_gradient_overlay_opacity'),
         'subtitle'             => get_field('subtitle'),
         'post_type'            => get_field('aggregate_posts'),
         'posts_per_page'       => get_field('posts_per_page')
    );
    $row = 1;
    $rgb = $vars->gradient['red'] .",". $vars->gradient['green'] .",". $vars->gradient['blue'];

    $css = '
        .ph-outerwrap {
            background-image:url('. $funcs->imgsize( $vars->bg_img ) .');
            background-position:'. $vars->bg_img_position .';
        }
        .ph-outerwrap:before {
            background: rgba('. $rgb .',1);
            background: -moz-linear-gradient(left, rgba('. $rgb .',1) 0%, rgba('. $rgb .',1) 5%, rgba('. $rgb .',0) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba('. $rgb .',1)), color-stop(5%, rgba('. $rgb .',1)), color-stop(100%, rgba('. $rgb .',0)));
            background: -webkit-linear-gradient(left, rgba('. $rgb .',1) 0%, rgba('. $rgb .',1) 5%, rgba('. $rgb .',0) 100%);
            background: -o-linear-gradient(left, rgba('. $rgb .',1) 0%, rgba('. $rgb .',1) 5%, rgba('. $rgb .',0) 100%);
            background: -ms-linear-gradient(left, rgba('. $rgb .',1) 0%, rgba('. $rgb .',1) 5%, rgba('. $rgb .',0) 100%);
            background: linear-gradient(to right, rgba('. $rgb .',1) 0%, rgba('. $rgb .',1) 5%, rgba('. $rgb .',0) 100%);
            opacity:'. intval($vars->gradient_opacity) / 100 .';
        }
    ';

    //  print css
    $funcs->aggregate_css( 'posts-hero', $css, true );


    add_filter( 'genesis_entry_content', function() use( $vars, $row ) {

        ob_start();

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'ph_outerwrap',
                'atts'		=> [ 'class' => "ph-outerwrap uvsc-before full__container background l-up-r-5 rel" ]
            ]);

                genesis_markup([
                    'open'		=> '<div %s>',
                    'context'	=> 'ph_container',
                    'atts'		=> [ 'class' => "ph-container container rel L_sm R_sm" ]
                ]);

                    printf( '<h2 class="uvsc-text-light f_med_hvy">%s</h2>', get_the_title() );

                    //  subtitle
                    if ( $vars->subtitle ) printf( '<h6 class="ph-subtitle uvsc-text-light nomargin">%s</h6>', $vars->subtitle );



                genesis_markup([
                    'context'	=> 'ph_container',
                    'close'		=> '</div>'
                ]);

            genesis_markup([
                'context'	=> 'ph_outerwrap',
                'close'		=> '</div>'
            ]);
                      

        $output = ob_get_clean();


        //  OUTPUT
        genesis_markup(
            [
                'open'		=> '<section %s>',
                'context'	=> "posts_hero_" . $row,
                'atts'		=> [ 'class' => "posts-hero full__container rel", 'data-row' => $row ],
                'content'	=> $output,
                'close'		=> '</section>'
            ]
        );
    });

?>
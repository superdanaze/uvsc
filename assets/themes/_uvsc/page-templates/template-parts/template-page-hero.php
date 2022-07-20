<?php

//  page hero template

    $funcs = new ELA_Funcs;
    $vars = (object) array(
         'bg_img'               => get_field('background_image'),
         'bg_img_position'      => get_field('background_image_position'),
         'gradient'             => get_field('overlay_gradient_color'),
         'gradient_opacity'     => get_field('overlay_gradient_opacity'),
         'title'                => get_field('title'),
         'subtitle'             => get_field('subtitle'),
         'cta1'                 => get_field('call_to_action_1'),
         'cta2'                 => get_field('call_to_action_2')
    );
    $row = 1;
    $rgb = $vars->gradient['red'] .",". $vars->gradient['green'] .",". $vars->gradient['blue'];

    $css = '
        @media screen and ( min-width: 1px ) {
            .hh-innerwrap:before {
                background: -moz-linear-gradient(top, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba('. $rgb .',0)), color-stop(100%, rgba('. $rgb .',1)));
                background: -webkit-linear-gradient(top, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -o-linear-gradient(top, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -ms-linear-gradient(top, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: linear-gradient(to bottom, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                opacity:'. intval($vars->gradient_opacity) / 100 .';
            }
        }

        @media screen and ( min-width: 768px ) {
            .hh-innerwrap:before {
                background: -moz-linear-gradient(left, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -webkit-gradient(left top, right top, color-stop(0%, rgba('. $rgb .',0)), color-stop(100%, rgba('. $rgb .',1)));
                background: -webkit-linear-gradient(left, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -o-linear-gradient(left, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: -ms-linear-gradient(left, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                background: linear-gradient(to right, rgba('. $rgb .',0) 0%, rgba('. $rgb .',1) 100%);
                opacity:'. intval($vars->gradient_opacity) / 100 .';
            }
        }
        
    ';


    //  print css
    $funcs->aggregate_css( 'page-hero', $css, true );


    add_filter( 'genesis_entry_content', function() use( $vars, $row ) {

        ob_start();

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'hero_outerwrap',
                'atts'		=> [ 'class' => "hh-outerwrap full__container full__height noover l-up-r-5 rel topleft" ]
            ]);

                //  bg image
                genesis_markup([
                    'open'		=> '<div %s>',
                    'context'	=> 'hero_container',
                    'atts'		=> [ 'class' => "hh-container full__container full__height noover abs topleft" ]
                ]);


                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'hero_innerwrap',
                        'atts'		=> [ 'class' => "hh-innerwrap full__container uvsc-before full__height background scaleout-165 default abs topleft", 'style' => sprintf( "background-image:url(%s); background-position:%s;", $vars->bg_img['url'], $vars->bg_img_position ) ],
                        'close'		=> '</div>'
                    ]);


                genesis_markup([
                    'context'	=> 'hero_container',
                    'close'		=> '</div>'
                ]);


                //  content
                genesis_markup([
                    'open'		=> '<div %s>',
                    'context'	=> 'hero_content_wrap',
                    'atts'		=> [ 'class' => "hh-content-wrap page-hero-content-wrap full__height topleft flex vert rel" ]
                ]);

                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'hero_content_inner',
                        'atts'		=> [ 'class' => "hh-content-inner reverse rel" ]
                    ]);

                        //  title
                        if ( $vars->title ) printf( '<h2 class="title uvsc-text-light f_med_hvy">%s</h2>', trim( $vars->title ) );

                        //  subtitle
                        if ( $vars->subtitle ) printf( '<h6 class="_subtitle uvsc-text-light nomargin T_sm">%s</h6>', trim( $vars->subtitle ) );

                        if ( $vars->cta1 || $vars->cta2 ) {
                            print '<div class="page-hero-cta full__container flex rel T_md">';

                                if ( $vars->cta1 ) {
                                    ELA_Elements::button(array(
                                        // 'size'  => 'md',
                                        'class' => "slate-blue",
                                        'text'  => $vars->cta1['title'],
                                        'parameters' => array( 'href' => $vars->cta1['url'], 'target' => $vars->cta1['target'], 'rel' => "nofollow" )
                                    ));
                                }

                                if ( $vars->cta2 ) {
                                    ELA_Elements::button(array(
                                        // 'size'  => 'md',
                                        'class' => "light",
                                        'text'  => $vars->cta2['title'],
                                        'parameters' => array( 'href' => $vars->cta2['url'], 'target' => $vars->cta2['target'], 'rel' => "nofollow" )
                                    ));
                                }

                            print '</div>';
                        }


                    genesis_markup([
                        'context'	=> 'hero_content_inner',
                        'close'		=> '</div>'
                    ]);

                genesis_markup([
                    'context'	=> 'hero_content_wrap',
                    'close'		=> '</div>'
                ]);


            genesis_markup([
                'context'	=> 'hero_outerwrap',
                'close'		=> '</div>'
            ]);

        $output = ob_get_clean();


        //  OUTPUT
        genesis_markup(
            [
                'open'		=> '<section %s>',
                'context'	=> "page_hero_" . $row,
                'atts'		=> [ 'class' => "page-hero full__container rel", 'data-row' => $row ],
                'content'	=> $output,
                'close'		=> '</section>',
            ]
        );
    });

?>
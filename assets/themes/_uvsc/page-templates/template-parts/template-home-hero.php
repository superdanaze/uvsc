<?php

//  home hero template

    $funcs = new ELA_Funcs;
    $vars = (object) array(
         'bg_img'               => get_field('background_image'),
         'bg_img_orientation'   => get_field('background_image_orientation'),
         'text_color'           => get_field('text_color'),
         'btn_color'            => get_field('button_color'),
         'pretitle'             => get_field('pre_title'),
         'title'                => get_field('title'),
         'subtitle'             => get_field('subtitle'),
         'cta'                  => get_field('call_to_action_button')
    );
    $css = "";
    $row = 1;

    if ( $vars->text_color ) {
        $css .= '
            .hh-content-inner .pretitle,
            .hh-content-inner .title,
            .hh-content-inner ._subtitle {
                color:'. $vars->text_color .';
            }
        ';
    }

    //  print css
    $funcs->aggregate_css( 'home-hero', $css, true );


    add_filter( 'genesis_entry_content', function() use( $vars, $row ) {

        ob_start();

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'hh_outerwrap',
                'atts'		=> [ 'class' => "hh-outerwrap full__container full__height noover l-up-r-5 rel topleft" ]
            ]);

                //  bg image
                genesis_markup([
                    'open'		=> '<div %s>',
                    'context'	=> 'hh_container',
                    'atts'		=> [ 'class' => "hh-container full__container full__height noover abs topleft" ]
                ]);


                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'hh_innerwrap',
                        'atts'		=> [ 'class' => "hh-innerwrap full__container full__height background scaleout-165 default abs topleft", 'style' => sprintf( "background-image:url(%s); background-position:%s;", $vars->bg_img, $vars->bg_img_orientation ) ],
                        'close'		=> '</div>'
                    ]);


                genesis_markup([
                    'context'	=> 'hh_container',
                    'close'		=> '</div>'
                ]);


                //  content
                genesis_markup([
                    'open'		=> '<div %s>',
                    'context'	=> 'hh_content_wrap',
                    'atts'		=> [ 'class' => "hh-content-wrap full__height topleft flex vert rel" ]
                ]);

                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'hh_content_inner',
                        'atts'		=> [ 'class' => "hh-content-inner rel" ]
                    ]);

                        //  pre title
                        if ( $vars->pretitle ) printf( '<h5 class="pretitle b_mini">%s</h5>', trim( $vars->pretitle ) );

                        //  title
                        if ( $vars->title ) printf( '<h2 class="title f_med_hvy">%s</h2>', trim( $vars->title ) );

                        //  subtitle
                        if ( $vars->subtitle ) printf( '<span class="_subtitle nomargin T_sm">%s</span>', trim( $vars->subtitle ) );

                        //  call to action
                        if ( $vars->cta ) {
                            genesis_markup([
                                'open'		=> '<div %s>',
                                'context'	=> 'hh_content_cta',
                                'atts'		=> [ 'class' => "hh-content-cta full__container rel T_md" ]
                            ]);

                                ELA_Elements::button(array(
                                    'size'  => 'md',
                                    'class' => $vars->btn_color,
                                    'text'  => $vars->cta['title'],
                                    'parameters' => array( 'href' => $vars->cta['url'], 'target' => $vars->cta['target'], 'rel' => "nofollow" )
                                ));

                            genesis_markup([
                                'context'	=> 'hh_content_cta',
                                'close'		=> '</div>',
                            ]);
                        }


                    genesis_markup([
                        'context'	=> 'hh_content_inner',
                        'close'		=> '</div>'
                    ]);

                genesis_markup([
                    'context'	=> 'hh_content_wrap',
                    'close'		=> '</div>'
                ]);


            genesis_markup([
                'context'	=> 'hh_outerwrap',
                'close'		=> '</div>'
            ]);

        $output = ob_get_clean();


        //  OUTPUT
        genesis_markup(
            [
                'open'		=> '<section %s>',
                'context'	=> "home_hero_" . $row,
                'atts'		=> [ 'class' => "home-hero full__container rel", 'data-row' => $row ],
                'content'	=> $output,
                'close'		=> '</section>',
            ]
        );
    });

?>
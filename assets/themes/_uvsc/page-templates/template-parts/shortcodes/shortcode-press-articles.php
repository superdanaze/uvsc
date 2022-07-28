<?php

    //  SHORTCODE -- BOARD MEMBERS

    // $args = array(
    //     'post_type'             => 'press_articles',
    //     'post_status'           => 'publish',
    //     'ignore_sticky_posts'   => true,
    //     'posts_per_page'		=> -1,
    //     'orderby'               => 'menu_order', 
    //     'order'                 => 'ASC'
    // );

    // $the_board = new WP_Query($args);

    $articles = get_posts(array(
        'post_type'			=> 'press_articles',
        'post_status'       => 'publish',
        'posts_per_page'	=> -1,
        'meta_key'			=> 'date',
        'orderby'			=> 'meta_value',
        'order'				=> 'DESC'
        )
    ); 


    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'press_articles_wrap',
            'atts'		=> [ 'class' => "press-articles-wrap full__container rel" ]
        ]
    );

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'press_articles_inner',
                'atts'		=> [ 'class' => "press-articles-inner full__container grid rel" ]
            ]
        );

            //  cycle through articles
            foreach( $articles as $key => $article ) {
                
                //  vars
                $id = $article->ID;
                $title = $article->post_title;
                $link = get_field( 'link_to_article', $id );
                $publication = get_field( 'publication', $id );
                $date = get_field( 'date', $id );
                $image = get_field( 'article_image', $id );
                $fallback_img = "https://client.ethosla.com/uvsc/assets/stuff/2016/10/home-page-main.jpg";


                $img = $image ? trim( $image ) : $fallback_img;
                

                //  validate article URL
                if (filter_var($link, FILTER_VALIDATE_URL) === FALSE) continue;
                $headers = get_headers($link);
                if ( !in_array( "HTTP/1.1 200 OK", $headers ) ) continue;


                genesis_markup(
                    [
                        'open'		=> '<a %s>',
                        'context'	=> 'press_article_item_' . $key,
                        'atts'		=> [ 'class' => "press-article-item uvsc-before flex noover rel A_xsm", 'href' => trim( $link ), 'target' => "_blank", 'rel' => "nofollow" ]
                    ]
                );

                    //  background image
                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'press_article_item_bg_' . $key,
                            'atts'		=> [ 'class' => "press-article-item-bg full__container full__height background center topleft abs z0", 'style' => "background-image:url(". $img .");" ],
                            'close'     => '</div>'
                        ]
                    );

                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'pa_item_inner_' . $key,
                            'atts'		=> [ 'class' => "pa-item-inner full__container nopoint rel z1" ],
                        ]
                    );

                        //  date
                        if ( $date ) {
                            genesis_markup(
                                [
                                    'open'		=> '<p %s>',
                                    'context'	=> 'pa_item_date' . $key,
                                    'atts'		=> [ 'class' => "pa-item-date uvsc-text-light f_med nomargin" ],
                                    'content'   => $date,
                                    'close'     => '</p>'
                                ]
                            );
                        }

                        //  publication
                        if ( $publication ) {
                            genesis_markup(
                                [
                                    'open'		=> '<p %s>',
                                    'context'	=> 'pa_item_pub' . $key,
                                    'atts'		=> [ 'class' => "pa-item-publication uvsc-bisque f_med_hvy nomargin B_micro" ],
                                    'content'   => strtoupper( trim($publication) ),
                                    'close'     => '</p>'
                                ]
                            );
                        }

                        //  title
                        genesis_markup(
                            [
                                'open'		=> '<h6 %s>',
                                'context'	=> 'pa_item_title' . $key,
                                'atts'		=> [ 'class' => "pa-item-title uvsc-text-light nomargin" ],
                                'content'   => $title,
                                'close'     => '</h6>'
                            ]
                        );

                    genesis_markup(
                        [
                            'context'	=> 'pa_item_inner_' . $key,
                            'close'		=> '</div>'
                        ]
                    );


                genesis_markup(
                    [
                        'context'	=> 'press_article_item_' . $key,
                        'close'		=> '</a>'
                    ]
                );
                

            }

       

        genesis_markup(
            [
                'context'	=> 'press_articles_inner',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'press_articles_wrap',
            'close'		=> '</div>'
        ]
    );



?>
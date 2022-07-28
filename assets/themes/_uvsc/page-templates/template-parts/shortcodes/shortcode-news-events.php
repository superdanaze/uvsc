<?php

    //  SHORTCODE -- HOME PAGE NEWS AND EVENTS AGGREGATE

    //  VARS
    $func           = new ELA_Funcs;
    $articles       = get_field('news_and_events');
    $has_featured   = get_field('enable_featured');
    $columns        = get_field('news_and_events_columns');
    $fallback_img = "https://client.ethosla.com/uvsc/assets/stuff/2016/10/home-page-main.jpg";


    if ( !$articles ) return;

    
    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'home_news_and_articles',
            'atts'		=> [ 'class' => "news-articles-wrap full__container rel" ]
        ]
    );

        //  FEATURED ARTICLE
        if ( $has_featured ) :

            //  vars
            $id = $articles[0]->ID;
            $title = $articles[0]->post_title;
            $type = get_post_type($id);
            $type_label = get_post_type_object( $type );
            $link = $func->ela_get_post_link( $type, $id );
            $target = $type === "press_articles" ? "_blank" : "_self";
            $image = $func->ela_get_thumbnail( $type, $id );
            $date = $func->ela_get_post_date( $type, $id );
            $k = 1;


            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'home_news_and_articles_featured',
                    'atts'		=> [ 'class' => "news-articles-featured-wrap full__container rel" ]
                ]
            );

                //  individual post
                genesis_markup([
                    'open'		=> '<article %s>',
                    'context'	=> 'post_' . $k,
                    'atts'		=> [ 'class' => "post-item-wrap full__container grid A_xsm rel easy_does_it b_md", 'data-item' => $k ]
                ]);

                    //  image
                    genesis_markup([
                        'open'		=> '<a %s>',
                        'context'	=> 'post_image_' . $k,
                        'atts'		=> [ 'class' => "post-item-image noover", 'href' => $link, 'target' => $target, 'rel' => "nofollow" ],
                        // 'content'   => get_the_post_thumbnail( null, 'medium-large', array( 'class' => "image fit cover easy_does_it" ) ),
                        'content'   => sprintf( '<img class="image fit cover easy_does_it" src="%s" alt="%s" />', $image, $title ),
                        'close'     => '</a>'
                    ]);

                    //  post content
                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'post_content_wrap_' . $k,
                        'atts'		=> [ 'class' => "post-item-content-wrap rel" ]
                    ]);

                        //  title
                        printf( '<h4 class="nomargin"><a class="uvsc-text-dark" href="%s" rel="nofollow">%s</a></h4>', $link, $title );

                        //  post type
                        printf( '<p class="posttype f_med_hvy uvsc-slate-grey nomargin">%s</p>', strtoupper($type_label->labels->singular_name) );

                        //  date
                        printf( '<time class="f_med uvsc-burlywood" datetime="%s">%s</time>', $date, strtoupper($date) );

                        //  categories
                        // if ( $type === "post" ) {
                        //     printf( '<span class="post-cats">%s</span>', get_the_category_list( ", ", null, $id ) );
                        // } else if ( $type === "news_articles" ) {
                        //     $category = $type . "_category";
                        //     $terms = get_the_terms( $id, $category );

                        //     print '<span class="post-cats">';

                        //         foreach( $terms as $key => $term ) {
                        //             $name = $term->name;
                        //             $guid = get_term_link( $term->term_id );

                        //             printf( '<a href="%s" rel="category tag">%s</a>', $guid, $name );

                        //             if ( $key + 1 < count( $terms ) ) print '<span>,%nbsp;</span>';
                        //         }

                        //     print '</span>';
                        // }
                        
                        genesis_markup([
                            'open'		=> '<div %s>',
                            'context'	=> 'post_content_' . $k,
                            'atts'		=> [ 'class' => "post-item-content rel" ]
                        ]);

                            //  content excerpt
                            printf( '<p>%s</p>', trim( wp_trim_words( $articles[0]->post_excerpt, 50 ) ) );

                            //  read more button
                            ELA_Elements::button(array(
                                'class'         => "slate-blue outline--hover",
                                'text'          => "Read More",
                                'parameters'    => array(
                                    'href'          => $link,
                                    'target'        => $target,
                                    'rel'           => 'nofollow'
                                )
                            ));

                        genesis_markup([
                            'context'	=> 'post_content_' . $k,
                            'close'		=> '</div>'
                        ]);

                    genesis_markup([
                        'context'	=> 'post_content_wrap_' . $k,
                        'close'		=> '</div>'
                    ]);

                genesis_markup([
                    'context'	=> 'post_' . $k,
                    'close'		=> '</article>'
                ]);


            genesis_markup(
                [
                    'context'	=> 'home_news_and_articles_featured',
                    'close'		=> '</div>'
                ]
            );

        endif;


        //  OTHER AGGREGATED ARTICLES
        if ( $has_featured && count($articles) < 2 ) return;

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'home_news_and_articles_aggregated',
                'atts'		=> [ 'class' => "news-articles-agg-wrap posts-grid posts-grid-$columns full__container grid rel" ]
            ]
        );

            //  cycle through articles
            foreach( $articles as $key => $article ) {
                
                if ( $has_featured && $key === 0 ) continue;

                //  vars
                $id = $article->ID;
                $title = $article->post_title;
                $type = get_post_type($id);
                $type_label = get_post_type_object( $type );
                $link = $func->ela_get_post_link( $type, $id );
                $target = $type === "press_articles" ? "_blank" : "_self";
                $image = $func->ela_get_thumbnail( $type, $id );
                $date = $func->ela_get_post_date( $type, $id );
                $k = $key + 1;


                //  individual post
                genesis_markup([
                    'open'		=> '<article %s>',
                    'context'	=> 'post_' . $k,
                    'atts'		=> [ 'class' => "post-item-wrap full__container A_xsm rel easy_does_it b_md", 'data-item' => $k ]
                ]);

                    //  image
                    genesis_markup([
                        'open'		=> '<a %s>',
                        'context'	=> 'post_image_' . $k,
                        'atts'		=> [ 'class' => "post-item-image noover rel", 'href' => $link, 'target' => $target, 'rel' => "nofollow" ],
                        'content'   => sprintf( '<img class="image fit cover easy_does_it" src="%s" alt="%s" />', $image, $title ),
                        'close'     => '</a>'
                    ]);

                    //  post content
                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'post_content_wrap_' . $k,
                        'atts'		=> [ 'class' => "post-item-content-wrap rel T_sm" ]
                    ]);

                        //  title
                        printf( '<h5 class="f_med nomargin"><a class="uvsc-text-dark" href="%s" rel="nofollow">%s</a></h5>', $link, $title );

                        //  post type
                        printf( '<p class="posttype f_med_hvy uvsc-slate-grey nomargin">%s</p>', $type_label->labels->singular_name );

                        //  date
                        printf( '<time class="f_med uvsc-burlywood" datetime="%s">%s</time>', $date, strtoupper($date) );
                        
                        genesis_markup([
                            'open'		=> '<div %s>',
                            'context'	=> 'post_content_' . $k,
                            'atts'		=> [ 'class' => "post-item-content rel" ]
                        ]);

                            //  content excerpt
                            printf( '<p>%s</p>', trim( $article->post_excerpt ) );

                            //  read more button
                            ELA_Elements::button(array(
                                'class'         => "slate-blue outline--hover",
                                'text'          => "Read More",
                                'parameters'    => array(
                                    'href'          => $link,
                                    'target'        => $target,
                                    'rel'           => 'nofollow'
                                )
                            ));

                        genesis_markup([
                            'context'	=> 'post_content_' . $k,
                            'close'		=> '</div>'
                        ]);

                    genesis_markup([
                        'context'	=> 'post_content_wrap_' . $k,
                        'close'		=> '</div>'
                    ]);

                genesis_markup([
                    'context'	=> 'post_' . $k,
                    'close'		=> '</article>'
                ]);
                
            }

        genesis_markup(
            [
                'context'	=> 'home_news_and_articles_aggregated',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'home_news_and_articles',
            'close'		=> '</div>'
        ]
    );

?>
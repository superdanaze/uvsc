<?php

    //  cancer fighters template


    $title = $args['title'];
    $subtext = $args['subtext'];
    $limit = $args['limit'];

    $args = array(
        'post_type'             => 'post',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> $limit,
        'cat'                   => 5,
        'order'                 => 'DESC',
    );
    $query = new WP_Query($args);


    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'	=> "cf_inner",
            'atts'		=> [ 'class' => "cf-inner container rel L_sm R_sm" ]
        ]
    );

        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "cf_titles",
                'atts'		=> [ 'class' => "cf-titles full__container rel" ]
            ]
        );

            if ( $title ) printf( '<h3 class="content-title text_center nomargin">%s</h3>', trim( $title ) );

            if ( $subtext ) printf( '<p class="_small text_center T_sm rel">%s</p>', trim( $subtext ) );

        genesis_markup(
            [
                'context'	=> "cf_titles",
                'close'     => '</div>'
            ]
        );

        //  cancer fighters items
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "cf_items_wrap",
                'atts'		=> [ 'class' => "cf-items full__container rel T_lg" ]
            ]
        );

            //  cycle through cancer fighters
            $k = 1;
            if ( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();

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
                        'atts'		=> [ 'class' => "post-item-image noover", 'href' => get_the_permalink(), 'rel' => "nofollow" ],
                        'content'   => get_the_post_thumbnail( null, 'medium-large', array( 'class' => "image fit cover easy_does_it" ) ),
                        'close'     => '</a>'
                    ]);

                    //  post content
                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'post_content_wrap_' . $k,
                        'atts'		=> [ 'class' => "post-item-content-wrap rel" ]
                    ]);

                        //  title
                        printf( '<h4 class="nomargin"><a class="uvsc-text-dark" href="%s" rel="nofollow">%s</a></h4>', get_the_permalink(), get_the_title() );
                        
                        genesis_markup([
                            'open'		=> '<div %s>',
                            'context'	=> 'post_content_' . $k,
                            'atts'		=> [ 'class' => "post-item-content rel" ]
                        ]);

                            //  content excerpt
                            printf( '<p>%s</p>', trim( get_the_excerpt() ) );

                            //  read more button
                            ELA_Elements::button(array(
                                'class'         => "slate-blue outline--hover",
                                'text'          => "Read This Story",
                                'parameters'    => array(
                                    'href'          => get_the_permalink(),
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

                $k++;

            endwhile; endif;

            wp_reset_postdata();

        genesis_markup(
            [
                'context'	=> "cf_items_wrap",
                'close'     => '</div>'
            ]
        );



    genesis_markup(
        [
            'context'	=> "cf_inner",
            'close'     => '</div>'
        ]
    );
    

?>
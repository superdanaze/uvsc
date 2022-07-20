<?php

//  UVSC Aggregate Posts Template

    $funcs = new ELA_Funcs;
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $__args = array(
        'post_type'             => $args['posts_type'],
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> $args['posts_per_page'],
        'order'                 => 'DESC',
        'paged'                 => $paged
    );
    $query = new WP_Query($__args);
    $row = 2;


    add_filter( 'genesis_entry_content', function() use( $query, $row, $funcs ) {

        ob_start();

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'posts_wrap',
                'atts'		=> [ 'class' => "posts-wrap container T_xlg L_xsm R_xsm rel" ]
            ]);

                if ( $query->have_posts() ) :

                    //  posts
                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'posts_inner',
                        'atts'		=> [ 'class' => "posts-container full__container rel" ]
                    ]);

                        $k = 1;
                        while( $query->have_posts() ) : $query->the_post();

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

                                    //  date
                                    printf( '<time class="f_med uvsc-burlywood" datetime="%s">%s</time>', get_the_date(), strtoupper(get_the_date()) );

                                    //  title
                                    printf( '<h4 class="nomargin"><a class="uvsc-text-dark" href="%s" rel="nofollow">%s</a></h4>', get_the_permalink(), get_the_title() );

                                    //  categories
                                    $type = get_post_type();

                                    if ( $type === "post" ) {
                                        printf( '<span class="post-cats">%s</span>', get_the_category_list( ", " ) );
                                    } else {
                                        $category = $type . "_category";
                                        $terms = get_the_terms( get_the_ID(), $category );

                                        print '<span class="post-cats">';

                                            foreach( $terms as $key => $term ) {
                                                $name = $term->name;
                                                $guid = get_term_link( $term->term_id );

                                                printf( '<a href="%s" rel="category tag">%s</a>', $guid, $name );

                                                if ( $key + 1 < count( $terms ) ) print '<span>,%nbsp;</span>';
                                            }

                                        print '</span>';
                                    }
                                    
                                    genesis_markup([
                                        'open'		=> '<div %s>',
                                        'context'	=> 'post_content_' . $k,
                                        'atts'		=> [ 'class' => "post-item-content rel" ]
                                    ]);

                                        //  content excerpt
                                        printf( '<p>%s</p>', trim( wp_trim_words( get_the_content(), 50 ) ) );

                                        //  read more button
                                        ELA_Elements::button(array(
                                            'class'         => "slate-blue outline--hover",
                                            'text'          => "Read More",
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

                        endwhile;

                        //  reset post data
                        wp_reset_postdata();
                    

                    genesis_markup([
                        'context'	=> 'posts_inner',
                        'close'		=> '</div>'
                    ]);


                    //  pagination
                    genesis_markup([
                        'open'		=> '<div %s>',
                        'context'	=> 'posts_pagination',
                        'atts'		=> [ 'class' => "pagination-container pagination full__container flex horiz rel T_md" ]
                    ]);

                        genesis_markup([
                            'open'		=> '<div %s>',
                            'context'	=> 'posts_pagination_inner',
                            'atts'		=> [ 'class' => "pagination-inner rel" ]
                        ]);

                            echo paginate_links( array(
                                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                'total'        => $query->max_num_pages,
                                'current'      => max( 1, get_query_var( 'paged' ) ),
                                'format'       => '?paged=%#%',
                                'show_all'     => false,
                                'type'         => 'plain',
                                'end_size'     => 2,
                                'mid_size'     => 1,
                                'prev_next'    => true,
                                'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
                                'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
                                'add_args'     => false,
                                'add_fragment' => '',
                            ) );
            

                        genesis_markup([
                            'context'	=> 'posts_pagination_inner',
                            'close'		=> '</div>'
                        ]);

                    genesis_markup([
                        'context'	=> 'posts_pagination',
                        'close'		=> '</div>'
                    ]);

                else :
                    
                    print '<h5>Sorry, there are currently no posts available. Please check back soon!</h5>';
                
                endif;

            genesis_markup([
                'context'	=> 'posts_wrap',
                'close'		=> '</div>'
            ]);
            

        $output = ob_get_clean();


        //  OUTPUT
        genesis_markup(
            [
                'open'		=> '<section %s>',
                'context'	=> "posts_all_" . $row,
                'atts'		=> [ 'class' => "posts-all full__container rel", 'data-row' => $row ],
                'content'	=> $output,
                'close'		=> '</section>',
            ]
        );
    });

?>
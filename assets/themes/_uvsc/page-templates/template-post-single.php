<?php

    //  Structure for Single Post Types

    class ELA_Post_Type_Single {

        public function __construct() {
            $this->funcs = new ELA_Funcs;

            //  remove content sidebar wrap div
            add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

            //  remove main wrapper
            add_filter( 'genesis_markup_content', '__return_null' );
            
            add_filter( 'genesis_attr_entry', array( $this, 'article_class' ) );
            add_action('genesis_after_header', array( $this, 'hero' ) );
            add_filter( 'genesis_post_info', array( $this, 'default_entry_meta' ) );
            add_filter( 'genesis_post_meta', array( $this, 'post_footer' ) );
        }


        public function article_class( $attributes ) {
            if ( is_single() || is_archive() ) $attributes['class'] = "uvsc-post _medium T_md r" . $attributes['class'];
    
            return $attributes;
        }


        public function hero() {
            if ( !is_single() ) return;

            $position = get_field('feature_image_position');

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'post_hero_outerwrap',
                'atts'		=> [ 'class' => "post-hero uvsc-before full__container background r-up-l-5 rel", 'style' => "background-image:url(". get_the_post_thumbnail_url() ."); background-position:". $position .";" ],
                'close'		=> '</div>'
            ]);
        }


        public function default_entry_meta( $post_info ) {
            if ( is_single() || is_archive() ) {
                $post_info = sprintf( '<time class="f_med uvsc-burlywood" datetime="%s">%s</time>', get_the_date(), strtoupper(get_the_date()) );

                //  if has categories
                $type = get_post_type();

                if ( $type === "post" ) {
                    if ( count( get_the_category() ) ) {
                        $post_info .= "&nbsp;&nbsp;|&nbsp;&nbsp;";
                        $post_info .= sprintf( '<span class="post-cats">%s</span>', get_the_category_list( ", " ) );
                    }
                } else {
                    $category = $type . "_category";
                    $terms = get_the_terms( get_the_ID(), $category );

                    if ( count( $terms ) ) {

                        $post_info .= "&nbsp;&nbsp;|&nbsp;&nbsp;";

                        $post_info .= '<span class="post-cats">';

                            foreach( $terms as $key => $term ) {
                                $name = $term->name;
                                $guid = get_term_link( $term->term_id );

                                $post_info .= sprintf( '<a href="%s" rel="category tag">%s</a>', $guid, $name );

                                if ( $key + 1 < count( $terms ) ) $post_info .= '<span>,%nbsp;</span>';
                            }

                            $post_info .= '</span>';
                    }
                }
                
            }
            
            return $post_info;
        }


        public function post_footer() {

            $prev = get_previous_post();
            $next = get_next_post();

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'post_meta_nav_links',
                'atts'		=> [ 'class' => "post-meta-nav-links full__container grid duo rel" ]
            ]);

                //  next
                if ( $next ) {
                    genesis_markup([
                        'open'		=> '<a %s>',
                        'context'	=> 'post_meta_nav_link_prev',
                        'atts'		=> [ 'class' => "post-meta-nav-link-prev post-meta-nav-item flex vert easy_does_it", 'href' => get_the_permalink($next->ID), 'rel' => "nofollow" ]
                    ]);
    
                        print '<i class="fal fa-arrow-circle-left r_xsm"></i>';
                        printf( '<p class="nomargin">%s</p>', $next->post_title );
    
    
                    genesis_markup([
                        'context'	=> 'post_meta_nav_link_prev',
                        'close'     => '</a>'
                    ]);
                }
                

                //  previous
                if ( $prev ) {
                    genesis_markup([
                        'open'		=> '<a %s>',
                        'context'	=> 'post_meta_nav_link_next',
                        'atts'		=> [ 'class' => "post-meta-nav-link-next post-meta-nav-item flex vert easy_does_it", 'href' => get_the_permalink($prev->ID), 'rel' => "nofollow" ]
                    ]);
    
                        printf( '<p class="nomargin">%s</p>', $prev->post_title );
                        print '<i class="fal fa-arrow-circle-right l_xsm"></i>';
    
                    genesis_markup([
                        'context'	=> 'post_meta_nav_link_prev',
                        'close'     => '</a>'
                    ]);
                }                

            genesis_markup([
                'context'	=> 'post_meta_nav_links',
                'close'		=> '</div>'
            ]);
        }

    
    }

    $ela_post_type_single = new ELA_Post_Type_Single;

?>
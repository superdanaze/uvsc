<?php

    //  SHORTCODE -- BOARD MEMBERS

    $args = array(
        'post_type'             => 'board_members',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> -1,
        'orderby'               => 'menu_order', 
        'order'                 => 'ASC'
    );

    $the_board = new WP_Query($args);


    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'board_members_wrap',
            'atts'		=> [ 'class' => "board-members-wrap full__container rel T_lg B_lg L_sm R_sm" ]
        ]
    );

        //  section title
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'board_members_title_wrap',
                'atts'		=> [ 'class' => "board-members-title-wrap full__container rel B_md L_sm R_sm" ],
                'content'   => '<h3 class="text_center f_light uvsc-bisque nomargin">OUR BOARD MEMBERS</h3>',
                'close'     => '</div>'
            ]
        );

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'board_members_inner',
                'atts'		=> [ 'class' => "board-members-inner full__container grid rel", 'data-items' => count( $the_board->posts ) ]
            ]
        );

            //  cycle through board members
            foreach( $the_board->posts as $key => $member ) {
                //  VARS
                $id = $member->ID;
                $name = get_the_title($id);
                $position = get_field( 'position', $id );
                $image = get_field( 'bio_image', $id );
                $accent_img = get_field( 'accent_image', $id );
                $bio = get_field( 'biography', $id );


                genesis_markup(
                    [
                        'open'		=> '<figure %s>',
                        'context'	=> 'board_member_' . $key,
                        'atts'		=> [ 'class' => "bm-item noover rel slow_and_smooth" ]
                    ]
                );

                    //  sloped background
                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'board_member_card_bg_' . $key,
                            'atts'		=> [ 'class' => "bm-item-bg r-up-l-15 full__container background center z0", 'style' => sprintf( "background-image:url(%s);", $accent_img['sizes']['medium_large'] ) ],
                            'close'     => '</div>'
                        ]
                    );

                    //  bio image
                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'board_member_img_wrap_' . $key,
                            'atts'		=> [ 'class' => "bm-imgwrap abs z5" ],
                            'content'   => wp_get_attachment_image( $image['ID'], "medium", false, array( 'alt' => $image['filename'] ) ),
                            'close'     => '</div>'
                        ]
                    );

                    //  content
                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'board_member_content_wrap_' . $key,
                            'atts'		=> [ 'class' => "bm-content-wrap full__container text_center" ]
                        ]
                    );

                        //  name
                        printf( '<h5 class="name f_med_hvy nomargin slow_and_smooth">%s</h5>', trim($name) );

                        //  position
                        if ( $position ) printf( '<p class="position nomargin f_med_hvy T_micro slow_and_smooth">%s</p>', trim($position) );

                        //  read bio button
                        ELA_Elements::button(array(
                            'class'         => "slate-blue t_sm",
                            'tag'           => "button",
                            'text'          => "Read More",
                            'parameters'    => array(
                                'data-modal'    => 'board',
                                'data-action'   => 'open'
                            )
                        ));

                        //  biography
                        genesis_markup(
                            [
                                'open'		=> '<div %s>',
                                'context'	=> 'board_member_bio_' . $key,
                                'atts'		=> [ 'class' => "bm-biography hide start" ],
                                'content'   => trim( $bio ),
                                'close'     => '</div>'
                            ]
                        );


                    genesis_markup(
                        [
                            'context'	=> 'board_member_content_wrap_' . $key,
                            'close'     => '</div>'
                        ]
                    );



                    genesis_markup(
                        [
                            'context'	=> 'board_member_card_bg_' . $key,
                            'close'		=> '</figure>'
                        ]
                    );


                genesis_markup(
                    [
                        'context'	=> 'board_member_' . $key,
                        'close'		=> '</figure>'
                    ]
                );

            }


        genesis_markup(
            [
                'context'	=> 'board_members_inner',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'board_members_wrap',
            'close'		=> '</div>'
        ]
    );


    //  board members modal
    $temp = "https://client.ethosla.com/uvsc/assets/stuff/2016/10/bio-jamil-newirth-300x300.jpg";
    $temp2 = "https://client.ethosla.com/uvsc/assets/stuff/2022/06/hawaii-scene-iii-768x512.jpg";
    $temp3 = "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.";

    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'bm_modal',
            'atts'		=> [ 'class' => "bm-modal topleft flex horiz vert fixed start" ]
        ]
    );

        //  underlayment
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'bm_modal_underlay',
                'atts'		=> [ 'class' => "bm-modal-underlay underlayment", 'data-modal' => 'board', 'data-action' => "close" ],
                'close'     => '</div>'
            ]
        );

        //  modal content wrap
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'bm_modal_contentwrap',
                'atts'		=> [ 'class' => "bm-modal-wrap modalwrap uvsc-bisque-bg rel z5 start" ]
            ]
        );

            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'bm_modal_inner',
                    'atts'		=> [ 'class' => "bm-modal-inner grid" ]
                ]
            );

                //  content left
                genesis_markup(
                    [
                        'open'		=> '<div %s>',
                        'context'	=> 'bm_modal_left',
                        'atts'		=> [ 'id' => "bm-modal-left", 'class' => "bm-modal-left background center rel z5", 'style' => 'background-image:url('. $temp2 .');' ]
                    ]
                );

                    //  close X
                    genesis_markup(
                        [
                            'open'		=> '<button %s>',
                            'context'	=> 'bm_modal_close',
                            'atts'		=> [ 'class' => "bm-modal-close close-X kilo", 'data-modal' => 'board', 'data-action' => 'close' ],
                            'content'   => '<span class="nopoint easy_does_it"></span><span class="nopoint easy_does_it"></span>',
                            'close'     => '</button>'
                        ]
                    );

                    print '<img id="bm-modal-bio-image" class="image fit cover" src="'. $temp .'" alt="bio image" />';

                genesis_markup(
                    [
                        'context'	=> 'bm_modal_left',
                        'close'		=> '</div>'
                    ]
                );


                //  content right
                genesis_markup(
                    [
                        'open'		=> '<div %s>',
                        'context'	=> 'bm_modal_right',
                        'atts'		=> [ 'class' => "bm-modal-right full__height rel" ]
                    ]
                );

                    //  close X
                    genesis_markup(
                        [
                            'open'		=> '<button %s>',
                            'context'	=> 'bm_modal_close',
                            'atts'		=> [ 'class' => "bm-modal-close close-X charlie", 'data-modal' => 'board', 'data-action' => 'close' ],
                            'content'   => '<span class="easy_does_it"></span><span class="easy_does_it"></span>',
                            'close'     => '</button>'
                        ]
                    );

                    //  right side inner content
                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'bm_modal_right_inner',
                            'atts'		=> [ 'class' => "bm-modal-right-inner" ]
                        ]
                    );

                        //  name
                        print '<h5 id="bm-modal-name" class="name f_med_hvy nomargin">NAME</h5>';

                        //  position
                        print '<p id="bm-modal-position" class="position nomargin f_med_hvy T_micro">POSITION</p>';

                        //  bio
                        print '<div id="bm-modal-bio" class="nomargin T_md">'. $temp3 .'</div>';

                    genesis_markup(
                        [
                            'context'	=> 'bm_modal_right_inner',
                            'close'		=> '</div>'
                        ]
                    );

                genesis_markup(
                    [
                        'context'	=> 'bm_modal_right',
                        'close'		=> '</div>'
                    ]
                );


            genesis_markup(
                [
                    'context'	=> 'bm_modal_inner',
                    'close'		=> '</div>'
                ]
            );



        genesis_markup(
            [
                'context'	=> 'bm_modal_contentwrap',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'bm_modal',
            'close'		=> '</div>'
        ]
    );

?>
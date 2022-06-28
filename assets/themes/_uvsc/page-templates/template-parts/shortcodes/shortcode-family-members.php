<?php

    //  SHORTCODE -- FAMILY MEMBERS

    $family_members = get_field('family_members');


    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'family_members_wrap',
            'atts'		=> [ 'class' => "family-members-wrap full__container rel" ]
        ]
    );

        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'family_members_inner',
                'atts'		=> [ 'class' => "family-members-inner full__container grid rel" ]
            ]
        );

            //  family members items
            foreach( $family_members as $key => $member ) {
                $id = $member->ID;
                $name = get_the_title($id);
                $image = get_field( 'image', $id );
                $img_orientation = get_field( 'image_orientation', $id );
                $story = get_field( 'bio', $id );


                genesis_markup(
                    [
                        'open'		=> '<figure %s>',
                        'context'	=> 'family_member_item_' . $key,
                        'atts'		=> [ 'class' => "fm-item rel", 'data-item' => $key + 1 ]
                    ]
                );

                    genesis_markup(
                        [
                            'open'		=> '<div %s>',
                            'context'	=> 'fm_item_inner_' . $key,
                            'atts'		=> [ 'class' => "fm-item-inner noover abs" ]
                        ]
                    );

                        //  image
                        genesis_markup(
                            [
                                'open'		=> '<div %s>',
                                'context'	=> 'fm_item_image' . $key,
                                'atts'		=> [ 'class' => "fm-item-image uvsc-before background topleft abs z0", 'style' => sprintf( 'background-image:url(%s); background-position:%s;', $image['sizes']['medium_large'], $img_orientation ) ],
                                'close'     => '</div>'
                            ]
                        );

                        //  name / cta 
                        genesis_markup(
                            [
                                'open'		=> '<figcaption %s>',
                                'context'	=> 'fm_item_peek_' . $key,
                                'atts'		=> [ 'class' => "fm-item-peek full__container botleft nomargin abs z5" ]
                            ]
                        );

                            //  family name
                            printf( '<h6 class="fm-item-name f_med_hvy text_center uvsc-text-dark">%s</h6>', $name );

                            //  read story button
                            ELA_Elements::button(array(
                                'class'         => "slate-blue t_micro",
                                'tag'           => "button",
                                'text'          => "Read Story",
                                'parameters'    => array(
                                    'data-modal'    => 'family',
                                    'data-action'   => 'open'
                                )
                            ));

                        genesis_markup(
                            [
                                'context'	=> 'fm_item_peek_' . $key,
                                'close'		=> '</figcaption>'
                            ]
                        );

                        //  story
                        genesis_markup(
                            [
                                'open'		=> '<span %s>',
                                'context'	=> 'fm_item_story_' . $key,
                                'atts'		=> [ 'class' => "fm-item-story hide start" ],
                                'content'   => trim( $story ),
                                'close'     => '</span>'
                            ]
                        );

                    genesis_markup(
                        [
                            'context'	=> 'fm_item_inner_' . $key,
                            'close'		=> '</div>'
                        ]
                    );

                genesis_markup(
                    [
                        'context'	=> 'family_member_item_' . $key,
                        'close'		=> '</figure>'
                    ]
                );
            }

        genesis_markup(
            [
                'context'	=> 'family_members_inner',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'family_members_wrap',
            'close'		=> '</div>'
        ]
    );



    //  family members modal
    $temp = "https://client.ethosla.com/uvsc/assets/stuff/2016/10/bio-jamil-newirth-300x300.jpg";
    $temp2 = "https://client.ethosla.com/uvsc/assets/stuff/2022/06/hawaii-scene-iii-768x512.jpg";
    $temp3 = "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.";

    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'fm_modal',
            'atts'		=> [ 'class' => "fm-modal topleft flex horiz vert fixed start" ]
        ]
    );

        //  underlayment
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'fm_modal_underlay',
                'atts'		=> [ 'class' => "fm-modal-underlay underlayment", 'data-modal' => 'family', 'data-action' => "close" ],
                'close'     => '</div>'
            ]
        );

        //  close X
        genesis_markup(
            [
                'open'		=> '<button %s>',
                'context'	=> 'fm_modal_close',
                'atts'		=> [ 'class' => "fm-modal-close close-X fixed start", 'data-modal' => 'family', 'data-action' => 'close' ],
                'content'   => '<span class="nopoint easy_does_it"></span><span class="nopoint easy_does_it"></span>',
                'close'     => '</button>'
            ]
        );

        //  modal content wrap
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'fm_modal_contentwrap',
                'atts'		=> [ 'class' => "fm-modal-wrap modalwrap uvsc-text-light-bg rel z5 start" ]
            ]
        );

            //  header
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'fm_modal_header',
                    'atts'		=> [ 'class' => "fm-modal-header full__container flex horiz rel" ]
                ]
            );

                //  image
                genesis_markup(
                    [
                        'open'		=> '<div %s>',
                        'context'	=> 'fm_modal_image',
                        'atts'		=> [ 'id' => 'fm-image', 'class' => "fm-modal-image background abs z1", 'style' => sprintf( 'background-image:url(%s); background-position:%s;', $temp, "center center" ) ],
                        'close'     => '</div>'
                    ]
                );

            genesis_markup(
                [
                    'context'	=> 'fm_modal_header',
                    'close'		=> '</div>'
                ]
            );

            //  content
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'fm_modal_content',
                    'atts'		=> [ 'class' => "fm-modal-content T_xlg B_sm L_sm R_sm" ]
                ]
            );
            
                //  family name
                print '<h5 id="fm-name" class="f_med text_center">Sample Name</h5>';

                //  story
                print '<p id="fm-story" class="nomargin">'. $temp3 .'</p>';

            genesis_markup(
                [
                    'context'	=> 'fm_modal_content',
                    'close'		=> '</div>'
                ]
            );


        genesis_markup(
            [
                'context'	=> 'fm_modal_contentwrap',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> 'fm_modal',
            'close'		=> '</div>'
        ]
    );


    // //  board members modal
    // $temp = "https://client.ethosla.com/uvsc/assets/stuff/2016/10/bio-jamil-newirth-300x300.jpg";
    // $temp2 = "https://client.ethosla.com/uvsc/assets/stuff/2022/06/hawaii-scene-iii-768x512.jpg";
    // $temp3 = "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.";

    // genesis_markup(
    //     [
    //         'open'		=> '<div %s>',
    //         'context'	=> 'bm_modal',
    //         'atts'		=> [ 'class' => "bm-modal topleft flex horiz vert fixed start" ]
    //     ]
    // );

    //     //  underlayment
    //     genesis_markup(
    //         [
    //             'open'		=> '<div %s>',
    //             'context'	=> 'bm_modal_underlay',
    //             'atts'		=> [ 'class' => "bm-modal-underlay underlayment", 'data-modal' => 'board', 'data-action' => "close" ],
    //             'close'     => '</div>'
    //         ]
    //     );

    //     //  modal content wrap
    //     genesis_markup(
    //         [
    //             'open'		=> '<div %s>',
    //             'context'	=> 'bm_modal_contentwrap',
    //             'atts'		=> [ 'class' => "bm-modal-wrap modalwrap uvsc-bisque-bg rel z5 start" ]
    //         ]
    //     );

    //         genesis_markup(
    //             [
    //                 'open'		=> '<div %s>',
    //                 'context'	=> 'bm_modal_inner',
    //                 'atts'		=> [ 'class' => "bm-modal-inner grid" ]
    //             ]
    //         );

    //             //  content left
    //             genesis_markup(
    //                 [
    //                     'open'		=> '<div %s>',
    //                     'context'	=> 'bm_modal_left',
    //                     'atts'		=> [ 'id' => "bm-modal-left", 'class' => "bm-modal-left background center rel z5", 'style' => 'background-image:url('. $temp2 .');' ]
    //                 ]
    //             );

    //                 //  close X
    //                 genesis_markup(
    //                     [
    //                         'open'		=> '<button %s>',
    //                         'context'	=> 'bm_modal_close',
    //                         'atts'		=> [ 'class' => "bm-modal-close close-X kilo", 'data-modal' => 'board', 'data-action' => 'close' ],
    //                         'content'   => '<span class="nopoint easy_does_it"></span><span class="nopoint easy_does_it"></span>',
    //                         'close'     => '</button>'
    //                     ]
    //                 );

    //                 print '<img id="bm-modal-bio-image" class="image fit cover" src="'. $temp .'" alt="bio image" />';

    //             genesis_markup(
    //                 [
    //                     'context'	=> 'bm_modal_left',
    //                     'close'		=> '</div>'
    //                 ]
    //             );


    //             //  content right
    //             genesis_markup(
    //                 [
    //                     'open'		=> '<div %s>',
    //                     'context'	=> 'bm_modal_right',
    //                     'atts'		=> [ 'class' => "bm-modal-right full__height rel" ]
    //                 ]
    //             );

    //                 //  close X
    //                 genesis_markup(
    //                     [
    //                         'open'		=> '<button %s>',
    //                         'context'	=> 'bm_modal_close',
    //                         'atts'		=> [ 'class' => "bm-modal-close close-X charlie", 'data-modal' => 'board', 'data-action' => 'close' ],
    //                         'content'   => '<span class="easy_does_it"></span><span class="easy_does_it"></span>',
    //                         'close'     => '</button>'
    //                     ]
    //                 );

    //                 //  right side inner content
    //                 genesis_markup(
    //                     [
    //                         'open'		=> '<div %s>',
    //                         'context'	=> 'bm_modal_right_inner',
    //                         'atts'		=> [ 'class' => "bm-modal-right-inner" ]
    //                     ]
    //                 );

    //                     //  name
    //                     print '<h5 id="bm-modal-name" class="name f_med_hvy nomargin">NAME</h5>';

    //                     //  position
    //                     print '<p id="bm-modal-position" class="position nomargin f_med_hvy T_micro">POSITION</p>';

    //                     //  bio
    //                     print '<div id="bm-modal-bio" class="nomargin T_md">'. $temp3 .'</div>';

    //                 genesis_markup(
    //                     [
    //                         'context'	=> 'bm_modal_right_inner',
    //                         'close'		=> '</div>'
    //                     ]
    //                 );

    //             genesis_markup(
    //                 [
    //                     'context'	=> 'bm_modal_right',
    //                     'close'		=> '</div>'
    //                 ]
    //             );


    //         genesis_markup(
    //             [
    //                 'context'	=> 'bm_modal_inner',
    //                 'close'		=> '</div>'
    //             ]
    //         );



    //     genesis_markup(
    //         [
    //             'context'	=> 'bm_modal_contentwrap',
    //             'close'		=> '</div>'
    //         ]
    //     );

    // genesis_markup(
    //     [
    //         'context'	=> 'bm_modal',
    //         'close'		=> '</div>'
    //     ]
    // );

?>
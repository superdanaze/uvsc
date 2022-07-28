<?php
    //  footer template

    $func = new ELA_Funcs;
    $enabled = get_field( 'enabledisable_modal', 'options' );
    $pageID = get_field( 'choose_page', 'options' );
    $maxwidth = get_field( 'modal_max_width', 'option' );
    $delay = get_field( 'delay_to_load', 'options' );
    $content = "";
    

    if ( !$enabled || !$pageID ) return;

    $the_query = new WP_Query( 'page_id=' . $pageID[0] );
    
    while ($the_query -> have_posts()) : $the_query -> the_post();
        $content = get_the_content();
    endwhile;


    genesis_markup(
        [
            'open'      => '<div %s>',
            'context'	=> "modal_main",
            'atts'		=> [ 'id' => 'modal-main', 'class' => "modal-common flex horiz vert", 'data-delay' => $delay ]
        ]
    );

        //  underlay
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "modal_underlay",
                'atts'		=> [ 'class' => "underlayment modal-item", 'data-modal' => "modal-main", 'data-action' => 'close' ],
                'close'     => '</div>'
            ]
        );  

        //  content wrap
        genesis_markup(
            [
                'open'      => '<div %s>',
                'context'	=> "modal_content_wrap",
                'atts'		=> [ 'class' => "modal-content-wrap full__container rel A_sm", 'style' => sprintf( 'max-width:%spx;', $maxwidth ) ]
            ]
        );

            //  close X
            genesis_markup(
                [
                    'open'      => '<button %s>',
                    'context'	=> "modal_closeX",
                    'atts'		=> [ 'class' => "fm-modal-close modal-item close-X rel", 'data-modal' => "modal-main", 'data-action' => "close" ],
                    'content'   => '<span class="nopoint easy_does_it"></span><span class="nopoint easy_does_it"></span>',
                    'close'     => '</button>'
                ]
            );


            //  modal content
            genesis_markup(
                [
                    'open'      => '<div %s>',
                    'context'	=> "modal_content",
                    'atts'		=> [ 'class' => "modal-content full__container rel" ]
                ]
            );

                genesis_markup(
                    [
                        'open'      => '<div %s>',
                        'context'	=> "modal_content_inner",
                        'atts'		=> [ 'class' => "modal-content-inner modal-item full__container rel" ],
                        'content'      => apply_filters( 'the_content', $content ),
                        'close'      => '</div>'
                    ]
                );


            genesis_markup(
                [
                    'context'	=> "modal_content",
                    'close'      => '</div>'
                ]
            );


        genesis_markup(
            [
                'context'	=> "modal_content_wrap",
                'close'      => '</div>'
            ]
        );  
        

    genesis_markup(
        [
            'context'	=> "modal_main",
            'close'     => '</>'
        ]
    );


?>
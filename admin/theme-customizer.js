( function( $ ) {

    // BG Image
    wp.customize( 'csx_bg_image', function( value ) {
        value.bind( function( to ) {
            $('#coming-soon-express-page').css('background-image', 'url(' + to + ')');
        } );
    });

    // BG Overlay Color
    wp.customize( 'csx_bg_image_overlay_color', function( value ) {
        value.bind( function( to ) {
            $( '#background-overlay' ).css( 'background-color', to );
        } );
    });

    // BG Overlay Opacity
    wp.customize( 'csx_bg_image_overlay_opacity', function( value ) {
        value.bind( function( to ) {
            $('#csx-custom-styles-bg-overlay-inline-css').text(
                CSXBGOverlayElements + '{ opacity: ' + to + ' !important; }'
            );
        } );
    });

    // Big Title - Text
    wp.customize( 'csx_textcontent_bigtitle', function( value ) {
        value.bind( function( to ) {
            $( '#bigtitle' ).text( to );
        } );
    });

    // Headline - Text
    wp.customize( 'csx_textcontent_headline', function( value ) {
        value.bind( function( to ) {
            $( '#headline' ).text( to );
        } );
    });

    // Description - Text
    wp.customize( 'csx_textcontent_description', function( value ) {
        value.bind( function( to ) {
            $( '#description' ).text( to );
        } );
    });
    wp.customize( 'csx_textcontent_description_tinymce', function( value ) {
        value.bind( function( to ) {
            $( '#description' ).html( to );
        } );
    });

    // Big Title - Text Color
    wp.customize( 'csx_colors_bigtitle', function( value ) {
        value.bind( function( to ) {
            $( '#bigtitle' ).css( 'color', to );
        } );
    });

    // Headline - Text Color
    wp.customize( 'csx_colors_headline', function( value ) {
        value.bind( function( to ) {
            $( '#headline' ).css( 'color', to );
        } );
    });

    // Description - Text Color
    wp.customize( 'csx_colors_description', function( value ) {
        value.bind( function( to ) {
            $( '#description' ).css( 'color', to );
        } );
    });

    // Links - Text Color
    wp.customize( 'csx_colors_links', function( value ) {
        value.bind( function( to ) {
            $( '#csx-custom-styles-links-inline-css' ).text(
                CSXTextLinkElements + '{ color: ' + to + ' !important; }'
            );
        });
    });

    // Links - Hover Text Color
    wp.customize( 'csx_colors_links_hover', function( value ) {

        // Set Hover Text Color on load
        var defaultHover = wp.customize.settings.values.csx_colors_links_hover;
        $( '#csx-custom-styles-links-hover-inline-css' ).text(
            CSXTextLinkHoverElements + '{ color: ' + defaultHover + ' !important; }'
        );

        value.bind( function( to ) {
            $( '#csx-custom-styles-links-hover-inline-css' ).text(
                CSXTextLinkHoverElements + '{ color: ' + to + ' !important; }'
            );
        });

    });

    // Buttons - BG Color
    wp.customize( 'csx_colors_button_bg', function( value ) {
        value.bind( function( to ) {
            // Set Button BG color
            $( '#csx-custom-styles-button-inline-css' ).text(
                CSXButtonElements + '{ background-color: ' + to + ' !important; }'
            );
        });
    });

    // Buttons - Hover BG Color
    wp.customize( 'csx_colors_button_bg_hover', function( value ) {

        // Set Hover BG Color on load
        var defaultHover = wp.customize.settings.values.csx_colors_button_bg_hover;
        $( '#csx-custom-styles-button-hover-inline-css' ).text(
            CSXButtonHoverElements + '{ background-color: ' + defaultHover + ' !important; }'
        );

        value.bind( function( to ) {
            $( '#csx-custom-styles-button-hover-inline-css' ).text(
                CSXButtonHoverElements + '{ background-color: ' + to + ' !important; }'
            );
        });
    });

    // Buttons - Text Color
    wp.customize( 'csx_colors_button_text', function( value ) {
        value.bind( function( to ) {
            $( '#csx-custom-styles-button-text-inline-css' ).text(
                CSXButtonElements + '{ color: ' + to + ' !important; }'
            );
        });
    });

    // Buttons - Text Hover Color
    wp.customize( 'csx_colors_button_text_hover', function( value ) {

        // Set Hover Text Color on load
        var defaultHover = wp.customize.settings.values.csx_colors_button_text_hover;
        $( '#csx-custom-styles-button-text-hover-inline-css' ).text(
            CSXButtonHoverElements + '{ color: ' + defaultHover + ' !important; }'
        );

        value.bind( function( to ) {
            $( '#csx-custom-styles-button-text-hover-inline-css' ).text(
                CSXButtonHoverElements + '{ color: ' + to + ' !important; }'
            );
        });
    });

    // Widgets - Heading Text Color
    wp.customize( 'csx_colors_widget_heading_text', function( value ) {
        value.bind( function( to ) {
            $( '#csx-custom-styles-widget-heading-text-inline-css' ).text(
                CSXWidgetHeadingElements + '{ color: ' + to + ' !important; }'
            );
        });
    });

    // Widgets - Text Color
    wp.customize( 'csx_colors_widget_text', function( value ) {
        value.bind( function( to ) {
            $( '#csx-custom-styles-widget-text-inline-css' ).text(
                CSXWidgetTextElements + '{ color: ' + to + ' !important; }'
            );
        });
    });

    // TinyMCE
    wp.customizerCtrlEditor = {

        init: function() {

            $(window).load(function(){
                var adjustArea = $('textarea.wp-editor-area');
                adjustArea.each(function(){
                    var tArea = $(this),
                        id = tArea.attr('id'),
                        input = $('#_customize-input-csx_tinymce_control'),
                        editor = tinyMCE.get(id),
                        setChange,
                        content;

                    if(editor){
                        editor.onChange.add(function (ed, e) {
                            ed.save();
                            content = editor.getContent();
                            clearTimeout(setChange);
                            setChange = setTimeout(function(){
                                input.val(content).trigger('change');
                            },500);
                        });
                    }

                    if(editor){
                        editor.onChange.add(function (ed, e) {
                            ed.save();
                            content = editor.getContent();
                            clearTimeout(setChange);
                            setChange = setTimeout(function(){
                                input.val(content).trigger('change');
                            },500);
                        });
                    }

                    tArea.css({
                        visibility: 'visible'
                    }).on('keyup', function(){
                        content = tArea.val();
                        clearTimeout(setChange);
                        setChange = setTimeout(function(){
                            input.val(content).trigger('change');
                        },500);
                    });
                });
            });
        }

    };

    wp.customizerCtrlEditor.init();


})( jQuery );

<?php

class Coming_Soon_Express_Customizer_Settings {

    //* Define vars
    protected $wp_customize;
    protected $plugin_domain;
    protected $plugin_path;
    // public $color_defaults;

    //* Array of color defaults
    public $color_defaults = array(
        'csx_colors_bg_overlay' => '#333333',
        'csx_colors_bigtitle' => '#ffffff',
        'csx_colors_headline' => '#ffffff',
        'csx_colors_description' => '#ffffff',
        'csx_colors_links' => '#816394',
        'csx_colors_links_hover' => '#ae85c7',
        'csx_colors_button_bg' => '#816394',
        'csx_colors_button_bg_hover' => '#ae85c7',
        'csx_colors_button_text' => '#ffffff',
        'csx_colors_button_text_hover' => '#ffffff',
        'csx_colors_widget_heading_text' => '#ffffff',
        'csx_colors_widget_text' => '#ffffff',
    );

    protected $csx_plugin_enabled;

    public function __construct() {

        // // Define vars
		$this->plugin_domain = CSEXPRESS_TEXTDOMAIN;
        $this->plugin_path = CSEXPRESS_PLUGIN_PATH;
        $this->csx_plugin_enabled = get_option( 'csx_enable_comingsoon' );

        add_action( 'customize_preview_init', array( $this, 'csx_customize_preview_js' ) );

        //* If plugin setting 'Enable Functionality' is "on"
		if ( $this->csx_plugin_enabled == '1' ) {

            add_action( 'wp_head', array( $this, 'csx_create_inline_styles' ), 99 );

        }

	}

    public function csx_create_inline_styles() {

        // Empty vars
        $setting_bg_overlay_color = '';
        $setting_button_bg_color = '';
        $setting_button_bg_color_hover = '';
        $setting_button_text_color = '';
        $setting_button_text_hover_color = '';
        $setting_widget_heading_text_color = '';
        $setting_widget_text_color = '';
        $setting_links_color = '';
        $setting_links_hover_color = '';
        $button_elements = '';
        $button_hover_elements = '';
        $widget_heading_elements = '';
        $widget_text_elements = '';
        $text_link_elements = '';
        $text_link_hover_elements = '';
        $button_css_output = '';
        $button_hover_css_output = '';
        $widget_heading_text_css_output = '';
        $widget_text_css_output = '';
        $text_link_css_output = '';
        $text_link_hover_css_output = '';
        $button_css = '';
        $button_hover_css = '';
        $button_text_css = '';
        $button_text_hover_css = '';
        $widget_heading_text_css = '';
        $widget_text_css = '';
        $text_link_css = '';
        $text_link_hover_css = '';

        // Get Options/Defaults
        $setting_bg_overlay_color = get_option( 'csx_bg_image_overlay_color', $this->color_defaults['csx_colors_bg_overlay'] );
        $setting_bg_overlay_opacity = get_option( 'csx_bg_image_overlay_opacity', '0.1' );
        $setting_button_bg_color = get_option( 'csx_colors_button_bg', $this->color_defaults['csx_colors_button_bg'] );
        $setting_button_bg_color_hover = get_option( 'csx_colors_button_bg_hover', $this->color_defaults['csx_colors_button_bg_hover'] );
        $setting_button_text_color = get_option( 'csx_colors_button_text', $this->color_defaults['csx_colors_button_text'] );
        $setting_button_text_hover_color = get_option( 'csx_colors_button_text_hover', $this->color_defaults['csx_colors_button_text_hover'] );
        $setting_widget_heading_text_color = get_option( 'csx_colors_widget_heading_text', $this->color_defaults['csx_colors_widget_heading_text'] );
        $setting_widget_text_color = get_option( 'csx_colors_widget_text', $this->color_defaults['csx_colors_widget_text'] );
        $setting_links_color = get_option( 'csx_colors_links', $this->color_defaults['csx_colors_links'] );
        $setting_links_hover_color = get_option( 'csx_colors_links_hover', $this->color_defaults['csx_colors_links_hover'] );

        // Define Elements
        $bg_overlay_elements = "#coming-soon-express-page > #background-overlay";
        $button_elements = "#coming-soon-express-page .button, #coming-soon-express-page button, #coming-soon-express-page input[type='button'], #coming-soon-express-page input[type='submit']";
        $button_hover_elements = "#coming-soon-express-page .button:hover, #coming-soon-express-page button:hover, #coming-soon-express-page input[type='button']:hover, #coming-soon-express-page input[type='submit']:hover";
        $widget_heading_elements = "#coming-soon-express-page .coming-soon-express-widget-container .widget h3, #coming-soon-express-page .coming-soon-express-widget-container .widget-title";
        $widget_text_elements = "#coming-soon-express-page .coming-soon-express-widget-container .widget, #coming-soon-express-page .coming-soon-express-widget-container .widget p";
        $text_link_elements = '#coming-soon-express-page #coming-soon-express-page-container #description a:not(.button),';
        $text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description p a:not(.button),';
        $text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description ul li a:not(.button),';
        $text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget a:not(.button),';
        $text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget p a:not(.button),';
        $text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget ul li a:not(.button)';
        $text_link_hover_elements = '#coming-soon-express-page #coming-soon-express-page-container #description a:not(.button):hover,';
        $text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description p a:not(.button):hover,';
        $text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description ul li a:not(.button):hover,';
        $text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget a:not(.button):hover,';
        $text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget p a:not(.button):hover,';
        $text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container .widget ul li a:not(.button):hover';

        // Define CSS
        $bg_overlay_css_output = "{ background-color: {$setting_bg_overlay_color}; opacity: {$setting_bg_overlay_opacity}; }";
        $button_css_output = "{ background-color: {$setting_button_bg_color}; }";
        $button_hover_css_output = "{ background-color: {$setting_button_bg_color_hover}; }";
        $button_text_css_output = "{ color: {$setting_button_text_color}; }";
        $button_text_hover_css_output = "{ color: {$setting_button_text_hover_color}; }";
        $widget_heading_text_css_output = "{ color: {$setting_widget_heading_text_color}; }";
        $widget_text_css_output = "{ color: {$setting_widget_text_color}; }";
        $text_link_css_output = "{ color: {$setting_links_color}; }";
        $text_link_hover_css_output = "{ color: {$setting_links_hover_color}; }";

        // Combine Elements + CSS
        $bg_overlay_css = $bg_overlay_elements . $bg_overlay_css_output;
        $button_css = $button_elements . $button_css_output;
        $button_hover_css = $button_hover_elements . $button_hover_css_output;
        $button_text_css = $button_elements . $button_text_css_output;
        $button_text_hover_css = $button_hover_elements . $button_text_hover_css_output;
        $widget_heading_text_css = $widget_heading_elements . $widget_heading_text_css_output;
        $widget_text_css = $widget_text_elements . $widget_text_css_output;
        $text_link_css = $text_link_elements . $text_link_css_output;
        $text_link_hover_css = $text_link_hover_elements . $text_link_hover_css_output;

        // BG OVERLAY
        wp_register_style( 'csx-custom-styles-bg-overlay', false );
        wp_enqueue_style( 'csx-custom-styles-bg-overlay' );
        wp_add_inline_style( 'csx-custom-styles-bg-overlay', $bg_overlay_css );

        // LINKS
        wp_register_style( 'csx-custom-styles-links', false );
        wp_enqueue_style( 'csx-custom-styles-links' );
        wp_add_inline_style( 'csx-custom-styles-links', $text_link_css );

        // LINKS - HOVER
        wp_register_style( 'csx-custom-styles-links-hover', false );
        wp_enqueue_style( 'csx-custom-styles-links-hover' );
        wp_add_inline_style( 'csx-custom-styles-links-hover', $text_link_hover_css );

        // BUTTONS
        wp_register_style( 'csx-custom-styles-button', false );
        wp_enqueue_style( 'csx-custom-styles-button' );
        wp_add_inline_style( 'csx-custom-styles-button', $button_css );

        // BUTTONS - HOVER
        wp_register_style( 'csx-custom-styles-button-hover', false );
        wp_enqueue_style( 'csx-custom-styles-button-hover' );
        wp_add_inline_style( 'csx-custom-styles-button-hover', $button_hover_css );

        // BUTTONS - TEXT COLOR
        wp_register_style( 'csx-custom-styles-button-text', false );
        wp_enqueue_style( 'csx-custom-styles-button-text' );
        wp_add_inline_style( 'csx-custom-styles-button-text', $button_text_css );

        // BUTTONS - TEXT HOVER COLOR
        wp_register_style( 'csx-custom-styles-button-text-hover', false );
        wp_enqueue_style( 'csx-custom-styles-button-text-hover' );
        wp_add_inline_style( 'csx-custom-styles-button-text-hover', $button_text_hover_css );

        // WIDGETS - HEADING TEXT COLOR
        wp_register_style( 'csx-custom-styles-widget-heading-text', false );
        wp_enqueue_style( 'csx-custom-styles-widget-heading-text' );
        wp_add_inline_style( 'csx-custom-styles-widget-heading-text', $button_text_css );

        // WIDGETS - TEXT COLOR
        wp_register_style( 'csx-custom-styles-widget-text', false );
        wp_enqueue_style( 'csx-custom-styles-widget-text' );
        wp_add_inline_style( 'csx-custom-styles-widget-text', $button_text_css );

        // DEFINE ELEMENTS FOR JS
        wp_add_inline_script(
            'csx-theme-customizer', // handle name of customizer.js
            sprintf( 'var CSXBGOverlayElements = %s;', wp_json_encode( $bg_overlay_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXTextLinkElements = %s;', wp_json_encode( $text_link_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXTextLinkHoverElements = %s;', wp_json_encode( $text_link_hover_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXButtonElements = %s;', wp_json_encode( $button_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXButtonHoverElements = %s;', wp_json_encode( $button_hover_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXWidgetHeadingElements = %s', wp_json_encode( $widget_heading_elements ) ),
            'before'
        );

        wp_add_inline_script(
            'csx-theme-customizer',
            sprintf( 'var CSXWidgetTextElements = %s', wp_json_encode( $widget_text_elements ) ),
            'before'
        );

    }

    //* Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
    public function csx_customize_preview_js() {

        wp_enqueue_script( 'csx-theme-customizer', CSEXPRESS_ADMIN_PATH . '/theme-customizer.js', array( 'jquery', 'customize-preview' ), '0.1.0', true );

    }

	public function csx_add_customizer_settings($wp_customize) {

        //* Add Panel
        $wp_customize->add_panel( 'ComingSoonExpress_settings_panel', array(
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'title'          => __('Coming Soon Express', $this->plugin_domain ),
            'description'    => __('Settings for the Coming Soon Express Page', $this->plugin_domain ),
        ) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Section in Main Panel: 'Main Settings'
        $wp_customize->add_section( 'ComingSoonExpress_main_settings_section', array(
    		'title'    => __( 'Main Settings', $this->plugin_domain ),
            'panel' => 'ComingSoonExpress_settings_panel',
    		'priority' => 10
    	) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Setting: 'Enable Functionality'
        $wp_customize->add_setting( 'csx_enable_comingsoon', array(
            // 'default' => '',
			'type' => 'option',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
		) );

        $wp_customize->add_control(
            new CSX_Toggle_Control(
                $wp_customize,
                'csx_enable_comingsoon',
                array(
                    'label'         => __( 'Enable Functionality', $this->plugin_domain ),
                    'section'       => 'ComingSoonExpress_main_settings_section',
                    'settings'      => 'csx_enable_comingsoon',
                    'description'   => __( 'If you are logged in, your website will use the Theme you have activated. Users who are logged out will see the Coming Soon Express Page.<br><hr>', $this->plugin_domain )
                )
            )
        );

        //* Add Setting: 'Preview in Customizer'
        $wp_customize->add_setting( 'csx_preview_comingsoonpage', array(
			'type' => 'option',
            'transport' => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'csx_sanitize_checkbox',
            'default' => '1'
		) );

        //* Add Setting Control into 'Main Settings' Section
        $wp_customize->add_control(
            new CSX_Toggle_Control(
                $wp_customize,
                'csx_preview_comingsoonpage',
                array(
                    'label'         => __('Preview in Customizer', $this->plugin_domain),
                    'section'       => 'ComingSoonExpress_main_settings_section',
                    'settings'      => 'csx_preview_comingsoonpage',
                    'description'   => __( 'Preview the Coming Soon Express Page in the Customizer window.', $this->plugin_domain )
                ) )
        );

        //* ------------------------------------------------------------

        //* Add Section in Main Panel: 'Background'
    	$wp_customize->add_section( 'ComingSoonExpress_background_section', array(
    		'title'    => __( 'Background', $this->plugin_domain ),
            'panel' => 'ComingSoonExpress_settings_panel',
    		'priority' => 20,
    	) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Setting: 'Show BG Image'
        $wp_customize->add_setting( 'csx_show_bg_image', array(
            'default' => '1',
			'type' => 'option',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
            'sanitize_callback' => 'csx_sanitize_checkbox',
		) );

        $wp_customize->add_control(
            new CSX_Toggle_Control(
                $wp_customize,
                'csx_show_bg_image',
                array(
                    'label'         => __( 'Show Image', $this->plugin_domain ),
                    'section'       => 'ComingSoonExpress_background_section',
                    'settings'      => 'csx_show_bg_image',
                )
            )
        );

        //* ------------------------------------------------------------

        //* Create an Array of images
    	$images = apply_filters( 'comingsoon_images', array( '1' ) );

        //* Add Setting: 'Background Image'
        $wp_customize->add_setting( 'csx_bg_image', array(
            'default' => CSEXPRESS_TEMPLATE_PATH . '/img/default-bg.jpg',
            'type'     => 'option',
            'transport' => 'postMessage'
            // 'sanitize_callback'	=> 'comingsoon_sanitize_image',
        ) );

        //* Add Setting Control into 'Background' Section
        $wp_customize->add_control(
            new CSX_Image_Control(
                $wp_customize,
                'csx_bg_image',
                array(
                    'label'    => __( 'Background Image:', $this->plugin_domain ),
                    'description' => ' <hr> ',
                    'settings' => 'csx_bg_image',
                    'section'  => 'ComingSoonExpress_background_section',
                )
        ) );

        //* ------------------------------------------------------------

		//* Add Setting: 'Background Position X'
		$wp_customize->add_setting( 'csx_bg_image_position_x', array(
			'type'     => 'option',
            'transport' => 'refresh',
            'default'  => 'center',
			'sanitize_callback' => 'csx_sanitize_select'
		));

        //* Add Setting Control into 'Background' Section
		$wp_customize->add_control(
            'csx_bg_image_position_x',
            array(
    			'label'      => __( 'Background Position Horizontal', $this->plugin_domain ),
                'settings'  => 'csx_bg_image_position_x',
    			'section'    => 'ComingSoonExpress_background_section',
    			'type'       => 'select',
    			'choices'    => array(
    				'left'       => __( 'Left', $this->plugin_domain ),
    				'center'     => __( 'Center', $this->plugin_domain ),
    				'right'      => __( 'Right', $this->plugin_domain ),
    			),
    		)
        );

        //* ------------------------------------------------------------

		//* Add Setting: 'Background Position Y'
		$wp_customize->add_setting( 'csx_bg_image_position_y', array(
			'type' 		=> 'option',
            'transport' => 'refresh',
            'default' 	=> 'center',
			'sanitize_callback' => 'csx_sanitize_select',
		) );

        //* Add Setting Control into 'Background' Section
		$wp_customize->add_control(
            'csx_bg_image_position_y',
            array(
    			'label'		=> __( 'Background Position Vertical', $this->plugin_domain ),
                'settings'  => 'csx_bg_image_position_y',
    			'section'	=> 'ComingSoonExpress_background_section',
    			'type'		=> 'select',
    			'choices'	=> array(
    				'top'		=> __( 'Top', $this->plugin_domain ),
    				'center'	=> __( 'Center', $this->plugin_domain ),
    				'bottom'	=> __( 'Bottom', $this->plugin_domain ),
    			),
    		)
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Background Image Overlay Color'
        $wp_customize->add_setting( 'csx_bg_image_overlay_color', array(
            'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			)
		);

        //* Add Setting Control into 'Background' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_bg_image_overlay_color',
                array(
        			'label'    => __( 'Background Overlay Color:', $this->plugin_domain ),
                    'description' => __( 'Change the color of the overlay for the background image.', $this->plugin_domain ),
                    'settings'    => 'csx_bg_image_overlay_color',
                    'section'  => 'ComingSoonExpress_background_section',
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Background Image Overlay Opacity'
        $wp_customize->add_setting( 'csx_bg_image_overlay_opacity', array(
            'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> '0.1',
			'sanitize_callback' => 'sanitize_text_field',
			)
		);

        //* Add Setting Control into 'Background' Section
		$wp_customize->add_control(
            new CSX_Range_Control(
                $wp_customize,
                'csx_bg_image_overlay_opacity',
                array(
        			'label'    => __( 'Background Overlay Opacity:', $this->plugin_domain ),
                    'description' => __( 'Change the opacity of the overlay for the background image.', $this->plugin_domain ),
                    'settings'    => 'csx_bg_image_overlay_opacity',
                    'section'  => 'ComingSoonExpress_background_section',
                    'type'       => 'range-value',
					'input_attrs' => array(
        				'min' => 0.0,
        				'max' => 1.0,
        				'step' => 0.01,
    				),
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Section in Main Panel: 'Text Content'
    	$wp_customize->add_section( 'ComingSoonExpress_textcontent_section', array(
    		'title'    => __( 'Text Content', $this->plugin_domain ),
            'panel' => 'ComingSoonExpress_settings_panel',
    		'priority' => 30,
    	) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Setting: 'Big Title'
		$wp_customize->add_setting( 'csx_textcontent_bigtitle', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> __( 'T minus 3... 2...', $this->plugin_domain ),
            'sanitize_callback' => 'csx_sanitize_text'
		) );

        //* Add Setting Control into 'Text Content' Section
		// $wp_customize->add_control(
        //     'csx_textcontent_bigtitle',
        //     array(
    	// 		'label'		=> __( 'Big Title', $this->plugin_domain ),
        //         'settings'  => 'csx_textcontent_bigtitle',
    	// 		'section'	=> 'ComingSoonExpress_textcontent_section',
    	// 		'type'		=> 'text'
    	// 	)
        // );
        $wp_customize->add_control(
            new CSX_VisibilityText_Control(
                $wp_customize,
                'csx_textcontent_bigtitle',
                array(
                    'label'    => __( 'Big Title', $this->plugin_domain ),
                    'settings' => 'csx_textcontent_bigtitle',
                    'section'  => 'ComingSoonExpress_textcontent_section',
                )
        ) );

        //* ------------------------------------------------------------

        //* Add Setting: 'Show BigTitle'
        $wp_customize->add_setting( 'csx_show_bigtitle', array(
            'type' => 'option',
            'transport' => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'csx_sanitize_visibility',
            'default' => '1'
		) );

        // $wp_customize->add_control(
        //     'csx_show_bigtitle',
        //     array(
    	// 		'label'		=> '',
        //         'settings'  => 'csx_show_bigtitle',
    	// 		'section'	=> 'ComingSoonExpress_textcontent_section',
    	// 		'type'		=> 'hidden'
    	// 	)
        // );
        $wp_customize->add_control(
            new CSX_HiddenVisibilityCBox_Control(
                $wp_customize,
                'csx_show_bigtitle',
                array(
                    'label'    => '',
                    'settings' => 'csx_show_bigtitle',
                    'section'  => 'ComingSoonExpress_textcontent_section',
                )
        ) );

        //* ------------------------------------------------------------

        //* Add Setting: 'Headline'
		$wp_customize->add_setting( 'csx_textcontent_headline', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> __( 'We\'re getting ready to launch!', $this->plugin_domain ),
            'sanitize_callback' => 'csx_sanitize_text'
		) );

        //* Add Setting Control into 'Text Content' Section
		// $wp_customize->add_control(
        //     'csx_textcontent_headline',
        //     array(
    	// 		'label'		=> __( 'Headline', $this->plugin_domain ),
        //         'settings'  => 'csx_textcontent_headline',
    	// 		'section'	=> 'ComingSoonExpress_textcontent_section',
    	// 		'type'		=> 'text'
    	// 	)
        // );
        $wp_customize->add_control(
            new CSX_VisibilityText_Control(
                $wp_customize,
                'csx_textcontent_headline',
                array(
                    'label'    => __( 'Headline', $this->plugin_domain ),
                    'settings' => 'csx_textcontent_headline',
                    'section'  => 'ComingSoonExpress_textcontent_section',
                )
        ) );

        //* ------------------------------------------------------------

        //* Add Setting: 'Show Headline'
        $wp_customize->add_setting( 'csx_show_headline', array(
            'type' => 'option',
            'transport' => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'csx_sanitize_visibility',
            'default' => '1'
		) );

        // $wp_customize->add_control(
        //     'csx_show_headline',
        //     array(
    	// 		'label'		=> '',
        //         'settings'  => 'csx_show_headline',
    	// 		'section'	=> 'ComingSoonExpress_textcontent_section',
    	// 		'type'		=> 'hidden'
    	// 	)
        // );
        $wp_customize->add_control(
            new CSX_HiddenVisibilityCBox_Control(
                $wp_customize,
                'csx_show_headline',
                array(
                    'label'    => '',
                    'settings' => 'csx_show_headline',
                    'section'  => 'ComingSoonExpress_textcontent_section',
                )
        ) );

        //* ------------------------------------------------------------

        // TINYMCE
        //* Add Setting: 'Description'
        $wp_customize->add_setting( 'csx_textcontent_description_tinymce', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> __( sprintf( "Don't miss our liftoff — fill out your email address below, and we'll notify you when engines ignite.<br><br>If you need immediate assistance, please email %s", '<a href="mailto:test@email.com">test@email.com</a>' ) , $this->plugin_domain ),
            'sanitize_callback' => 'wp_kses_post'
		) );

        //* Add Setting Control into 'Text Content' Section
        $wp_customize->add_control(
            new CSX_TinyMCE_Control(
                $wp_customize,
                'csx_textcontent_description_tinymce',
                array(
        			'label'		=> __( 'Description', $this->plugin_domain ),
                    'settings'  => 'csx_textcontent_description_tinymce',
        			'section'	=> 'ComingSoonExpress_textcontent_section',
                    'type'      => 'textarea'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Show Description'
        $wp_customize->add_setting( 'csx_show_description', array(
            'type' => 'option',
            'transport' => 'refresh',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'csx_sanitize_visibility',
            'default' => '1'
		) );

        // $wp_customize->add_control(
        //     'csx_show_description',
        //     array(
    	// 		'label'		=> '',
        //         'settings'  => 'csx_show_description',
    	// 		'section'	=> 'ComingSoonExpress_textcontent_section',
    	// 		'type'		=> 'hidden'
    	// 	)
        // );
        $wp_customize->add_control(
            new CSX_HiddenVisibilityCBox_Control(
                $wp_customize,
                'csx_show_description',
                array(
                    'label'    => '',
                    'settings' => 'csx_show_description',
                    'section'  => 'ComingSoonExpress_textcontent_section',
                )
        ) );

        //* ------------------------------------------------------------

        //* Add Section in Main Panel: 'Colors'
    	$wp_customize->add_section( 'ComingSoonExpress_colors_section', array(
    		'title'    => __( 'Colors', $this->plugin_domain ),
            'panel' => 'ComingSoonExpress_settings_panel',
    		'priority' => 40,
    	) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Setting: 'Big Title Color'
		$wp_customize->add_setting( 'csx_colors_bigtitle', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_bigtitle'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_bigtitle',
                array(
        			'label'		=> __( 'Big Title Color', $this->plugin_domain ),
                    'description'   => __( 'The color of the Big Title text.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_bigtitle',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Headline Color'
		$wp_customize->add_setting( 'csx_colors_headline', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_headline'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_headline',
                array(
        			'label'		=> __( 'Headline Color', $this->plugin_domain ),
                    'description'   => __( 'The color of the Headline text.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_headline',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Description Color'
		$wp_customize->add_setting( 'csx_colors_description', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_description'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_description',
                array(
        			'label'		=> __( 'Description Color', $this->plugin_domain ),
                    'description'   => __( 'The color of the Description text.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_description',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Links Color'
		$wp_customize->add_setting( 'csx_colors_links', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_links'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_links',
                array(
        			'label'		=> __( 'Links Color', $this->plugin_domain ),
                    'description'   => __( 'The color of links in the Description text and Widgets.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_links',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Links Hover Color'
		$wp_customize->add_setting( 'csx_colors_links_hover', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_links_hover'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_links_hover',
                array(
        			'label'		=> __( 'Links Hover Color', $this->plugin_domain ),
                    'description'   => __( 'The hover color of links in the Description text and Widgets.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_links_hover',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Button Background Color'
		$wp_customize->add_setting( 'csx_colors_button_bg', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_button_bg'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_button_bg',
                array(
        			'label'		=> __( 'Button Background Color', $this->plugin_domain ),
                    'description'   => __( 'The background color of buttons.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_button_bg',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Button Text Color'
		$wp_customize->add_setting( 'csx_colors_button_text', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_button_text'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_button_text',
                array(
        			'label'		=> __( 'Button Text Color', $this->plugin_domain ),
                    'description'   => __( 'The color of button text.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_button_text',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Button Background Hover Color'
		$wp_customize->add_setting( 'csx_colors_button_bg_hover', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_button_bg_hover'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_button_bg_hover',
                array(
        			'label'		=> __( 'Button Background Hover Color', $this->plugin_domain ),
                    'description'   => __( 'The background color of buttons on hover.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_button_bg_hover',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Button Text Hover Color'
		$wp_customize->add_setting( 'csx_colors_button_text_hover', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_button_text_hover'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_button_text_hover',
                array(
        			'label'		=> __( 'Button Text Hover Color', $this->plugin_domain ),
                    'description'   => __( 'The color of button text on hover.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_button_text_hover',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Widget Heading Text Color'
		$wp_customize->add_setting( 'csx_colors_widget_heading_text', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_widget_heading_text'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_widget_heading_text',
                array(
        			'label'		=> __( 'Widget Heading Text Color', $this->plugin_domain ),
                    'description'   => __( 'The text color of Widget Headings.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_widget_heading_text',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Setting: 'Widget Text Color'
		$wp_customize->add_setting( 'csx_colors_widget_text', array(
			'type' 		=> 'option',
            'transport' => 'postMessage',
            'default' 	=> $this->color_defaults['csx_colors_widget_text'],
            'sanitize_callback' => 'sanitize_hex_color',
		) );

        //* Add Setting Control into 'Colors' Section
		$wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'csx_colors_widget_text',
                array(
        			'label'		=> __( 'Widget Text Color', $this->plugin_domain ),
                    'description'   => __( 'The color of text inside Widgets.<hr>', $this->plugin_domain ),
                    'settings'  => 'csx_colors_widget_text',
        			'section'	=> 'ComingSoonExpress_colors_section'
        		)
            )
        );

        //* ------------------------------------------------------------

        //* Add Section in Main Panel: 'Custom CSS'
    	$wp_customize->add_section( 'ComingSoonExpress_custom_css_section', array(
    		'title'    => __( 'Custom CSS', $this->plugin_domain ),
            'panel' => 'ComingSoonExpress_settings_panel',
    		'priority' => 60, // 50 is set for 'CSX Widget'
    	) );

        //* ------------------------------------------------------------
        //* ------------------------------------------------------------

        //* Add Setting: 'Description'
		$wp_customize->add_setting( 'csx_custom_css_content', array(
			'type' 		=> 'option',
            'transport' => 'refresh',
            'default' 	=> '',
            // 'sanitize_callback' => 'csx_sanitize_text'
		) );

        //* Add Setting Control into 'Custom CSS' Section
		$wp_customize->add_control(
            'csx_custom_css_content',
            array(
                'type'          => 'textarea',
    			'label'		    => __( 'Custom CSS Code', $this->plugin_domain ),
                'description'   => __( 'Enter your custom CSS code here.<hr>', $this->plugin_domain ),
                'settings'      => 'csx_custom_css_content',
    			'section'       => 'ComingSoonExpress_custom_css_section',
    		)
        );

        //* ------------------------------------------------------------


        //* CALLBACKS
        //* ------------------------------------------------------------

        // Sanitize text
    	function csx_sanitize_text( $text ) {

    	    return sanitize_text_field( $text );

    	}

        // Fix for returning expected checkbox values
        function csx_sanitize_checkbox( $input ) {

            // Checkboxes can be stored in db as either 'True' or '1'
        	if ( $input === true || $input === '1' ) {

                // Return a string
        		return '1';
        	}

            // Return empty
        	return '';

        }

        // Fix for returning expected Visibility checkbox values
        function csx_sanitize_visibility( $input ) {

            // Checkboxes can be stored in db as either 'True' or '1'
        	if ( $input === true || $input === '1' ) {

                // Return a string
        		return '1';
        	}

            // Return 0 so value is not null
        	return '0';

        }

        function csx_sanitize_select( $input, $setting ) {

            //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
            $input = sanitize_key($input);

            //get the list of possible select options
            $choices = $setting->manager->get_control( $setting->id )->choices;

            //return input if valid or return default option
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

        }

    }

}

<?php

class Coming_Soon_Express {

	// Define vars
	protected $loader;
	protected $plugin_domain;
	protected $plugin_path;
	protected $version;
	protected $csx_plugin_enabled;

	// Class constructor
	function __construct() {

		$this->plugin_domain = CSEXPRESS_TEXTDOMAIN;
		$this->version = CSEXPRESS_PLUGIN_VERSION;
		$this->plugin_path = CSEXPRESS_PLUGIN_PATH;

		$this->csx_load_dependencies();
		$this->csx_define_admin_hooks();
		$this->csx_plugin_enabled = get_option( 'csx_enable_comingsoon' );

		// Check if user is logged in
		add_action( 'wp', array( $this, 'csx_check_logged_in' ) );

		// Add Admin Toolbar warning
		add_action( 'admin_bar_menu', array( $this, 'csx_admin_toolbar_warning' ), 9999 );

		//* If plugin setting 'Enable Functionality' is "on"
		if ( $this->csx_plugin_enabled == '1' ) {

			// Remove Default Styles
			add_filter( 'style_loader_src', array( $this, 'csx_remove_default_css' ), 999 );

		}

		// Google Fonts
		add_action( 'customize_controls_print_styles', array( $this, 'csx_enqueue_googlefonts' ) );

		// FontAwesome
		add_action( 'customize_controls_print_styles', array( $this, 'csx_enqueue_fontawesome' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'csx_enqueue_fontawesome' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'csx_enqueue_fontawesome' ) );

		// Admin styles
		add_action( 'admin_enqueue_scripts', array( $this, 'csx_enqueue_admin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'csx_enqueue_admin_styles' ) );

		// Customizer Styles
		add_action( 'customize_controls_print_styles', array( $this, 'csx_enqueue_customizer_styles' ) );

		// Custom Widget
		add_action( 'widgets_init', array( $this, 'csx_custom_widget' ) );

		// Move widget into Customizer
		add_filter( 'customizer_widgets_section_args', array( $this, 'csx_move_widgets_customizer' ), 10, 3 );

	}

	// Function to check if user is logged in
	public function csx_check_logged_in() {

		global $wp_customize;

		// $csx_plugin_enabled = get_option( 'csx_enable_comingsoon' );
		$csx_preview_in_customizr = get_option( 'csx_preview_comingsoonpage' );

		//* If plugin setting 'Enable Functionality' is "on"
		if ( $this->csx_plugin_enabled == '1' ) {

			//* If user is NOT logged in
			if ( !is_user_logged_in() ) {

				// Show Coming Soon Express Page
				add_action( 'template_redirect', array( $this, 'csx_display_comingsoon_page' ) );

			}

			if ( is_customize_preview() ){
				// We are in Customizer Preview mode

				// If 'Preview in Customizer' option is not empty
				if ( $csx_preview_in_customizr == '1' ) {

					// Show Coming Soon Express Page
					add_action( 'template_redirect', array( $this, 'csx_display_comingsoon_page' ) );

				} else {
					return;
				}

			}

		}

	}

	// Function to remove theme CSS
	public function csx_remove_default_css( $src ) {

		//* If user is NOT logged in
		if ( !is_user_logged_in() ) {

			// Get theme style
			$themeCSSfile = get_stylesheet_directory_uri();

			if ( strpos( $src, $themeCSSfile ) === 0 ) {
				// Is theme style, do not add this to the queue
				return false;
			}

		}

		return $src;

	}

	// Function to return plugin version
	public function get_version() {

		return $this->version;

	}

	//* Setup Custom Controls
	public function csx_define_new_custom_controls() {

		require_once $this->plugin_path . 'admin/custom-controls.php';

	}

	// Load required files
	public function csx_load_dependencies() {

		// The Filter & Action Hooks loader
		require_once $this->plugin_path . 'includes/class-coming-soon-express-loader.php';
		$this->loader = new Coming_Soon_Express_Loader();

		// Customizer Settings
		require_once $this->plugin_path . 'admin/class-coming-soon-express-customizer-settings.php';

	}

	// Define Admin Hooks to be run via the 'loader'
	public function csx_define_admin_hooks() {

		// $csx_comingsoonpage = new Coming_Soon_Express_Page();
		$csx_customizer_settings = new Coming_Soon_Express_Customizer_Settings();

		// Define Custom Controls
		$this->loader->add_action( 'customize_register', $this, 'csx_define_new_custom_controls', 8 );

		// Load Customizer Settings
		$this->loader->add_action( 'customize_register', $csx_customizer_settings, 'csx_add_customizer_settings', 9 );

	}

	public function csx_enqueue_googlefonts() {

		// Google Fonts
		wp_enqueue_style( 'csx-google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400,700', array(), $this->version );

	}

	public function csx_enqueue_fontawesome() {

		// Font Awesome
		$fontawesome = 'fontawesome';
		$font_awesome = 'font-awesome';
		if ( wp_script_is( $font_awesome, 'enqueued' ) || wp_script_is( $fontawesome, 'enqueued' ) ) {
			return;
		} else {
			wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1' );
		}

	}

	public function csx_enqueue_admin_styles() {

		if ( wp_script_is( 'csx-admin-styles', 'enqueued' ) ) {
			return;
		} else {
			wp_enqueue_style( 'csx-admin-styles', CSEXPRESS_ADMIN_PATH . '/coming-soon-express-admin-styles.css', array(), $this->version );
		}

	}

	public function csx_enqueue_customizer_styles() {

		wp_enqueue_style( 'csx-customizer-styles', CSEXPRESS_ADMIN_PATH . '/coming-soon-express-customizer-styles.css', array(), $this->version );

	}

	// Function to create the CSX Widget
	public function csx_custom_widget() {

		register_sidebar(
			array(
				'name' => __( 'CSX Widget', $this->plugin_domain ),
				'id' => 'coming-soon-express-widget',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			)
		);

	}

	// Function to move the widget into the Customizer
	public function csx_move_widgets_customizer( $section_args, $section_id, $sidebar_id ) {

		if( $sidebar_id === 'coming-soon-express-widget' ) {
	        $section_args['panel'] = 'ComingSoonExpress_settings_panel';
			$section_args['priority'] = 50;
	    }

	    return $section_args;

	}

	// Function to add Admin Toolbar warning message
	function csx_admin_toolbar_warning( $wp_admin_bar ) {

		$csx_plugin_enabled = get_option( 'csx_enable_comingsoon' );

		//* If plugin setting 'Enable Functionality' is "on"
		if ( $csx_plugin_enabled == '1' ) {

			// Build query link to autofocus on the exact CSX Control to enable/disable
			$query['autofocus[control]'] = 'csx_enable_comingsoon';
			$control_link = add_query_arg( $query, admin_url( 'customize.php' ) );

			// $customizerURL = get_admin_url() . 'customize.php?autofocus%5Bpanel%5D=ComingSoonExpress_settings_panel';
			$customizerURL = esc_url( $control_link );

			$title = __( 'CSX is ACTIVE', CSEXPRESS_TEXTDOMAIN  );

			$args = array(
				'id'    => 'csx_admin_toolbar_warning',
				'title' => $title,
				'href'  => $customizerURL,
				'meta'  => array( 'class' => 'csx-warning-message' )
			);

			$wp_admin_bar->add_node( $args );

		}

	}

	//* Get the saved options and use for Coming Soon Express Page CSS
	function get_csx_page_CSS() {

		function csx_convert_hex2rgba( $color, $opacity = false ) {

			$default = 'rgb(0,0,0)';

			if ( empty( $color ) ) {
				return $default;
			}

			if ( '#' === $color[0] ) {
				$color = substr( $color, 1 );
			}

			if ( strlen( $color ) === 6 ) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) === 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}

			$rgb = array_map( 'hexdec', $hex );

			if ( $opacity ) {

				if ( abs( $opacity ) > 1 ) {
					$opacity = 1.0;
				}

				$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';

			} else {

				$output = 'rgb(' . implode( ',', $rgb ) . ')';

			}

			return $output;
		}

		//* Default vars
		$extraCSS = '';

		// ------------------------------------------------------------

		//* BG Image
		$show_bgImage = '';
		$show_bgImage = get_option( 'csx_show_bg_image' );

		if ( '' != $show_bgImage ) {

			$bgImage = $bgImagePosX = $bgImagePosY = '';
			$bgImage = get_option( 'csx_bg_image' );

			// Assign position_x
			if ( get_option( 'csx_bg_image_position_x' ) != "" ) {
				$bgImagePosX = get_option( 'csx_bg_image_position_x' );
			} else {
				$bgImagePosX = 'center';
			}

			// Assign position_y
			if ( get_option( 'csx_bg_image_position_y' ) != "" ) {
				$bgImagePosY = get_option( 'csx_bg_image_position_y' );
			} else {
				$bgImagePosY = 'center';
			}

			// // Assign bgImage
			// if ( ( '' != $bgImage ) && !empty( $bgImage ) ) {
			//
			// 	$bgImage = get_option( 'csx_bg_image' );
			//
			// }

			// Output CSS
			$extraCSS .= '#coming-soon-express-page { '."\n";
			$extraCSS .= 'background-image: url("'.$bgImage.'"); '."\n";
			$extraCSS .= 'background-position: ' . $bgImagePosX . ' ' . $bgImagePosY . '; '."\n";
			$extraCSS .= '}'."\n";

		}

		// BG Overlay Color
		$background_overlay_color = $background_overlay_rgba = '';
		$background_overlay_color = get_option( 'csx_bg_image_overlay_color' );
		if ( '' == $background_overlay_color ) {
			$background_overlay_color = '#333333';
		}

		// BG Overlay Opacity
		$background_overlay_opacity = '';
		$background_overlay_opacity = get_option( 'csx_bg_image_overlay_opacity' );
		if ( '' == $background_overlay_opacity ) {
			$background_overlay_opacity = '0.1';
		}

		$extraCSS .= '#background-overlay { background-color: ' . $background_overlay_color . '; opacity: '. $background_overlay_opacity .'; }'."\n";

		// ------------------------------------------------------------

		//* Text Colors
		$settingBigTitleColor = '';
		$settingBigTitleColor = get_option( 'csx_colors_bigtitle' );

		if ( ( '' != $settingBigTitleColor ) && !empty( $settingBigTitleColor ) ) {

			$settingBigTitleColor = get_option( 'csx_colors_bigtitle' );

		} else {

			// DEFAULT
			$settingBigTitleColor = '#ffffff';

		}

		$extraCSS .= '#bigtitle, .bigtitle { '."\n";
		$extraCSS .= 'color: '.$settingBigTitleColor.'; '."\n";
		$extraCSS .= '}'."\n";

		// ------------------------------------------------------------

		$settingHeadlineColor = '';
		$settingHeadlineColor = get_option( 'csx_colors_headline' );

		if ( ( '' != $settingHeadlineColor ) && !empty( $settingHeadlineColor ) ) {

			$settingHeadlineColor = get_option( 'csx_colors_headline' );

		} else {

			// DEFAULT
			$settingHeadlineColor = '#ffffff';

		}

		$extraCSS .= '#headline, .headline { '."\n";
		$extraCSS .= 'color: '.$settingHeadlineColor.'; '."\n";
		$extraCSS .= '}'."\n";

		// ------------------------------------------------------------

		$settingDescriptionColor = '';
		$settingDescriptionColor = get_option( 'csx_colors_description' );

		if ( ( '' != $settingDescriptionColor ) && !empty( $settingDescriptionColor ) ) {

			$settingDescriptionColor = get_option( 'csx_colors_description' );

		} else {

			// DEFAULT
			$settingDescriptionColor = '#ffffff';

		}

		$extraCSS .= '#description, .description { '."\n";
		$extraCSS .= 'color: '.$settingDescriptionColor.'; '."\n";
		$extraCSS .= '}'."\n";

		// ------------------------------------------------------------

		$settingLinksColor = $text_link_elements = '';
		$settingLinksColor = get_option( 'csx_colors_links' );

		if ( ( '' != $settingLinksColor ) && !empty( $settingLinksColor ) ) {

			$text_link_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container #description p a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container #description ul li a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .description a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .description p a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .description ul li a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .widget a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .widget p a:not(.button),
#coming-soon-express-page #coming-soon-express-page-container .widget ul li a:not(.button)';

			$extraCSS .= $text_link_elements . ' { '."\n";
			$extraCSS .= 'color: '.$settingLinksColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingLinksHoverColor = $text_link_hover_elements = '';
		$settingLinksHoverColor = get_option( 'csx_colors_links_hover' );

		if ( ( '' != $settingLinksHoverColor ) && !empty( $settingLinksHoverColor ) ) {

			$text_link_hover_elements .= '#coming-soon-express-page #coming-soon-express-page-container #description a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container #description p a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container #description ul li a:hover,
#coming-soon-express-page #coming-soon-express-page-container .description a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container .description p a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container .description ul li a:hover,
#coming-soon-express-page #coming-soon-express-page-container .widget a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container .widget p a:not(.button):hover,
#coming-soon-express-page #coming-soon-express-page-container .widget ul li a:not(.button):hover';

			$extraCSS .= $text_link_hover_elements . ' { '."\n";
			$extraCSS .= 'color: '.$settingLinksHoverColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingButtonBGColor = '';
		$settingButtonBGColor = get_option( 'csx_colors_button_bg' );

		if ( ( '' != $settingButtonBGColor ) && !empty( $settingButtonBGColor ) ) {

			$extraCSS .= '#coming-soon-express-page a.button,
#coming-soon-express-page button,
#coming-soon-express-page input[type="button"],
#coming-soon-express-page input[type="submit"] { '."\n";
			$extraCSS .= 'background-color: '.$settingButtonBGColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingButtonBGHoverColor = '';
		$settingButtonBGHoverColor = get_option( 'csx_colors_button_bg_hover' );

		if ( ( '' != $settingButtonBGHoverColor ) && !empty( $settingButtonBGHoverColor ) ) {

			$extraCSS .= '#coming-soon-express-page a.button:hover,
#coming-soon-express-page button:hover,
#coming-soon-express-page input[type="button"]:hover,
#coming-soon-express-page input[type="submit"]:hover { '."\n";
			$extraCSS .= 'background-color: '.$settingButtonBGHoverColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingButtonTextColor = '';
		$settingButtonTextColor = get_option( 'csx_colors_button_text' );

		if ( ( '' != $settingButtonTextColor ) && !empty( $settingButtonTextColor ) ) {

			$extraCSS .= '#coming-soon-express-page a.button,
#coming-soon-express-page button,
#coming-soon-express-page input[type="button"],
#coming-soon-express-page input[type="submit"] { '."\n";
			$extraCSS .= 'color: '.$settingButtonTextColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingButtonTextHoverColor = '';
		$settingButtonTextHoverColor = get_option( 'csx_colors_button_text_hover' );

		if ( ( '' != $settingButtonTextHoverColor ) && !empty( $settingButtonTextHoverColor ) ) {

			$extraCSS .= '#coming-soon-express-page a.button:hover,
#coming-soon-express-page button:hover,
#coming-soon-express-page input[type="button"]:hover,
#coming-soon-express-page input[type="submit"]:hover { '."\n";
			$extraCSS .= 'color: '.$settingButtonTextHoverColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingWidgetHeadingTextColor = '';
		$settingWidgetHeadingTextColor = get_option( 'csx_colors_widget_heading_text' );

		if ( ( '' != $settingWidgetHeadingTextColor ) && !empty( $settingWidgetHeadingTextColor ) ) {

			$extraCSS .= '#coming-soon-express-page .coming-soon-express-widget-container .widget h3,
#coming-soon-express-page .coming-soon-express-widget-container .widget-title { '."\n";
			$extraCSS .= 'color: '.$settingWidgetHeadingTextColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		$settingWidgetTextColor = '';
		$settingWidgetTextColor = get_option( 'csx_colors_widget_text' );

		if ( ( '' != $settingWidgetTextColor ) && !empty( $settingWidgetTextColor ) ) {

			$extraCSS .= '#coming-soon-express-page .coming-soon-express-widget-container .widget,
#coming-soon-express-page .coming-soon-express-widget-container .widget p { '."\n";
			$extraCSS .= 'color: '.$settingWidgetTextColor.'; '."\n";
			$extraCSS .= '}'."\n";

		}

		// ------------------------------------------------------------

		return $extraCSS;

	}

	function get_item_text( $itemname ) {

		$csx_textcontent_defaults = array(
			'csx_textcontent_bigtitle' => __( 'T minus 3... 2...', $this->plugin_domain ),
			'csx_textcontent_headline' => __( 'We\'re getting ready to launch!', $this->plugin_domain ),
			'csx_textcontent_description' => __( 'Don\'t miss our liftoff — fill out your email address below, and we\'ll notify you when engines ignite.', $this->plugin_domain ),
			'csx_textcontent_description_tinymce' => __( 'Don\'t miss our liftoff — fill out your email address below, and we\'ll notify you when engines ignite.', $this->plugin_domain ),
		);

		$returnval = '';

		if ( !empty( get_option( $itemname ) ) ) {

			if ( get_option( $itemname ) != "" ) {

				$returnval .= get_option( $itemname );

			} else {

				// NOT SET
				// Get default value from Array
				$returnval .= $csx_textcontent_defaults[$itemname];

			}

		} else {

			// EMPTY
			// Get default value from Array
			$returnval .= $csx_textcontent_defaults[$itemname];

		}

		return $returnval;

	}

    /**
     * Display the coming soon page
     */
    function csx_display_comingsoon_page() {

        // Prevent Plugins from caching
        // Disable caching plugins. This should take care of:
        //   - W3 Total Cache
        //   - WP Super Cache
        //   - ZenCache (Previously QuickCache)
        if ( !defined('DONOTCACHEPAGE')) {
          define('DONOTCACHEPAGE', true);
        }
        if ( !defined('DONOTCDN')) {
          define('DONOTCDN', true);
        }
        if ( !defined('DONOTCACHEDB')) {
          define('DONOTCACHEDB', true);
        }
        if ( !defined('DONOTMINIFY')) {
          define('DONOTMINIFY', true);
        }
        if ( !defined('DONOTCACHEOBJECT')) {
          define('DONOTCACHEOBJECT', true);
        }
        header('Cache-Control: max-age=0; private');

		$extraCSS = '';
		$extraCSS = $this->get_csx_page_CSS();

		$customCSS = '';
		$customCSS = get_option( 'csx_custom_css_content' );

		$bigtitle_text = '';
		$bigtitle_text = $this->get_item_text('csx_textcontent_bigtitle');

		$headline_text = '';
		$headline_text = $this->get_item_text('csx_textcontent_headline');

		$description_text = '';
		$description_text = $this->get_item_text('csx_textcontent_description_tinymce');

		$csx_page_content = '';
		ob_start();
?>
<!DOCTYPE html>
<html class="coming-soon-express" lang="en">
<head>
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo CSEXPRESS_TEMPLATE_PATH ?>/css/style.css">
<style>
<?php echo $extraCSS; ?>
</style>
<style id="csx-custom-css-content">
<?php echo $customCSS; ?>
</style>
</head>
<body class="coming-soon-express home">
<div id="coming-soon-express-page">
<div id="background-overlay"></div>
<div id="coming-soon-express-page-container">
<div class="coming-soon-express-text-content">
<?php
if ( '1' == get_option( 'csx_show_bigtitle' ) ) {
?>
<h1 id="bigtitle"><?php echo $bigtitle_text; ?></h1>
<?php
}
?>
<?php
if ( '1' == get_option( 'csx_show_headline' ) ) {
?>
<h2 id="headline"><?php echo $headline_text; ?></h2>
<?php
}
?>
<?php
if ( '1' == get_option( 'csx_show_description' ) ) {
?>
<div id="description"><?php echo $description_text; ?></div>
<?php
}
?>
</div>
<?php if ( is_active_sidebar( 'coming-soon-express-widget' ) ) { ?>
<div class="coming-soon-express-widget-container">
<?php dynamic_sidebar( 'coming-soon-express-widget' ); ?>
</div>
<?php } ?>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
<!-- Coming Soon Express by brandiD -->
<?php
		$csx_page_content = ob_get_clean();

		echo $csx_page_content;

     	exit;

    }

	// Run everything
	public function run() {

		$this->loader->run();

	}

}

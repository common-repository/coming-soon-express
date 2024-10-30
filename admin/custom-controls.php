<?php
//* Custom Text Control w/ Visibility Icon
if ( class_exists( 'WP_Customize_Control' ) ) {

    class CSX_VisibilityText_Control extends WP_Customize_Control {

        public $type = 'text';

        public function enqueue() {
            wp_enqueue_script( 'csx-visibility-text-control-js', CSEXPRESS_ADMIN_PATH . '/csx-visibility-text-control.js', array('jquery'), false, true );
            wp_enqueue_style( 'csx-visibility-text-css', CSEXPRESS_ADMIN_PATH . '/csx-visibility-text-control.css', array(), rand() );
    	}

        public function render_content() {
            ?>
            <div class="label">
        		<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                <span class="visibility"></span>
            </div>
            <input type="text" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
            <?php if ( ! empty( $this->description ) ) { ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php } ?>
            <?php
        }

    }
}

if ( class_exists( 'WP_Customize_Control' ) ) {

    class CSX_HiddenVisibilityCBox_Control extends WP_Customize_Control {

        public $type = 'checkbox';

        public function render_content() {
    		?>
            <label class="customize-control-title">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input id="vt-<?php echo $this->instance_number ?>" class="visibility-tb" type="hidden" value="<?php echo esc_html( $this->value() ); ?>" <?php $this->link(); ?> />
    		</label>
    		<?php
    	}

    }

}


//* Custom Image Control
if ( class_exists( 'WP_Customize_Image_Control' ) ) {

    class CSX_Image_Control extends WP_Customize_Image_Control {

        // Nothing to see here, move along.

    }
}

//* On/Off Toggle Control
if ( class_exists( 'WP_Customize_Control' ) ) {

    class CSX_Toggle_Control extends WP_Customize_Control {

    	public $type = 'light';

    	public function enqueue() {
    		// wp_enqueue_script( 'csx-toggle-control-js', CSEXPRESS_ADMIN_PATH . '/csx-toggle-control.js', array( 'jquery' ), rand(), true );
    		wp_enqueue_style( 'csx-toggle-control-css', CSEXPRESS_ADMIN_PATH . '/csx-toggle-control.css', array(), rand() );
    		$css = '
    			.disabled-control-title {
    				color: #a0a5aa;
    			}
    			input[type=checkbox].tgl-light:checked + .tgl-btn {
    				background: #0085ba;
    			}
    			input[type=checkbox].tgl-light + .tgl-btn {
    			  background: #a0a5aa;
    			}
    			input[type=checkbox].tgl-light + .tgl-btn:after {
    			  background: #f7f7f7;
    			}
    		';
    		wp_add_inline_style( 'csx-toggle-control-inline-css' , $css );
    	}

    	public function render_content() {
    		?>
    		<label class="customize-control-title">
    			<div style="display:flex;flex-direction: row;justify-content: flex-start;">
    				<span class="customize-control-title" style="flex: 2 0 0; vertical-align: middle;"><?php echo esc_html( $this->label ); ?></span>
    				<input id="cb<?php echo $this->instance_number ?>" type="checkbox" class="tgl tgl-<?php echo $this->type?>" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
    				<label for="cb<?php echo $this->instance_number ?>" class="tgl-btn"></label>
    			</div>
    			<?php if ( ! empty( $this->description ) ) : ?>
    			<span class="description customize-control-description"><?php echo $this->description; ?></span>
    			<?php endif; ?>
    		</label>
    		<?php
    	}

    }

}

//* TinyMCE Editor Control
if ( class_exists( 'WP_Customize_Control' ) ) {

    class CSX_TinyMCE_Control extends WP_Customize_Control {

        public $type = 'textarea';

        /**
         * Render the content on the theme customizer page
         */
        public function render_content() {
            ?>
            <!-- <label for="_customize-input-csx_tinymce_control" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label> -->
            <div class="label">
        		<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
                <span class="visibility"></span>
            </div>
            <!-- <span class="customize-text_editor"><?php //echo esc_html( $this->label ); ?></span> -->
            <input id="_customize-input-csx_tinymce_control" class="wp-editor-area" type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
            <?php
            $content = $this->value();
            $editor_id = $this->id;
            $settings = array(
                'textarea_name' => $this->id,
                'media_buttons' => false,
                'drag_drop_upload' => false,
                'teeny' => true,
                'quicktags' => true,
                'textarea_rows' => 10,
                // MAKE SURE TINYMCE CHANGES ARE LINKED TO CUSTOMIZER
                'tinymce' => [
                'toolbar1'=> 'bold,italic,underline,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink',
                'setup' => "function (editor) {
                    var cb = function () {
                        var linkInput = document.getElementById('_customize-input-csx_tinymce_control')
                        linkInput.value = editor.getContent()
                        linkInput.dispatchEvent(new Event('change'))
                    }
                    editor.on('Change', cb)
                    editor.on('Undo', cb)
                    editor.on('Redo', cb)
                    editor.on('KeyUp', cb) // Remove this if it seems like an overkill
                }"
                ]
            );
            wp_editor( $content, $editor_id, $settings );
            ?>

            <?php
            do_action('admin_print_footer_scripts');

        }

    };

}

//* Range Slider Control
if ( class_exists( 'WP_Customize_Control' ) ) {

    class CSX_Range_Control extends WP_Customize_Control {

        public $type = 'range-value';

        public function enqueue() {
            wp_enqueue_script( 'csx-range-control-js', CSEXPRESS_ADMIN_PATH . '/csx-range-control.js', array('jquery'), false, true );
    		wp_enqueue_style( 'csx-range-control-css', CSEXPRESS_ADMIN_PATH . '/csx-range-control.css', array(), rand() );
    	}

        /**
         * Render the content on the theme customizer page
         */
        public function render_content() {
            ?>
    		<label class="customize-control-title">
    			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    			<div id="_customize-input-csx_range_control" class="range-slider"  style="width:100%; display:flex;flex-direction: row;justify-content: flex-start;">
    				<span  style="width:100%; flex: 1 0 0; vertical-align: middle;">
                        <input class="range-slider__range" type="range" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->input_attrs(); $this->link(); ?>>
		                <span class="range-slider__value"><?php echo esc_attr( $this->value() ); ?></span>
                    </span>
    			</div>
    			<?php if ( ! empty( $this->description ) ) : ?>
    			<span class="description customize-control-description"><?php echo $this->description; ?></span>
    			<?php endif; ?>
    		</label>
		<?php
        }

    }

}

<?php
vc_map( 
	array( 
		'base' => 'dh_typed', 
		'name' => __( 'Animated typing', 'forward' ), 
		"description" => __( "Animated text typing", "forward" ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_typed', 
		'icon' => 'dh-vc-icon-dh_typed', 
		'params' => array( 
			array( 
				'type' => 'textarea', 
				'heading' => __( 'Content', 'forward' ), 
				'param_name' => 'typed_text', 
				'value' => 'Hi there! *I am Animated typing;Do you like it?*', 
				'description' => '
			Enter the content to display with typing text. You can apply HTML markup too.
			<br />
			<small>Text within <u>*</u> will be animated, example: <strong>*Sample text*</strong>.
			<br />
			Text separator is ; (semicolon), example: <strong>*First sentence; second sentence*</strong>
			<br />
			Pausing inside texts: <u>^1000</u> in milliseconds unit, example: <strong>*Hey, ^800 how are you?;Well, ^2000 I am Fine!*</strong>
			</small>' ), 
			array( 
				'param_name' => 'typed_font_size', 
				'heading' => __( 'Font Size (ex: 30px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '22px', 
				'data_min' => '0', 
				'data_max' => '50' ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Animated Text Color', 'forward' ), 
				'param_name' => 'typed_text_color', 
				'description' => __( 'Animated Text Color.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Animated Text Background Color', 'forward' ), 
				'param_name' => 'typed_text_bg', 
				'description' => __( 'Animated Background Text Color.', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Show more options', 'forward' ), 
				'param_name' => 'typed_show_options', 
				'std' => 'no', 
				'value' => array( __( 'Yes', 'forward' ) => 'yes', __( 'No', 'forward' ) => 'no' ), 
				'description' => __( 'Configure animation options.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Character for cursor', 'forward' ), 
				'value' => '|', 
				'description' => __( 'Leave empty to remove the blinking cursor.', 'forward' ), 
				'param_name' => 'typed_options_cursorchar', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Iteration loop', 'forward' ), 
				'value' => '', 
				'description' => __( 'Leave empty for single loop only. Set -1 for infinite loop.', 'forward' ), 
				'param_name' => 'typed_options_loopcount', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Type speed', 'forward' ), 
				'value' => '10', 
				'description' => __( 'Type of speed when entering the text. (Unit is milliseconds)', 'forward' ), 
				'param_name' => 'typed_options_typespeed', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Back speed', 'forward' ), 
				'value' => '20', 
				'description' => __( 'Back speed when deleting the text. (Unit is milliseconds)', 'forward' ), 
				'param_name' => 'typed_options_backspeed', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Start delay', 'forward' ), 
				'value' => '0', 
				'description' => __( 'Set delay before starting text typing. (Unit is milliseconds)', 'forward' ), 
				'param_name' => 'typed_options_startdelay', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Back delay', 'forward' ), 
				'value' => '500', 
				'description' => __( 'Set back delay after text is typed. (Unit is milliseconds)', 'forward' ), 
				'param_name' => 'typed_options_backdelay', 
				'dependency' => array( 'element' => 'typed_show_options', 'value' => array( 'yes' ) ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ), 
			array( 
				'type' => 'css_editor', 
				'heading' => __( 'Css', 'forward' ), 
				'param_name' => 'css', 
				'group' => __( 'Design options', 'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Typed extends DHWPBakeryShortcode {

	protected function _esc_script( $str = '' ) {
		$str = str_ireplace( array( '<script', '</script>' ), array( '&lt;script', '&lt;/script&gt;' ), $str );
		
		return $str;
	}

	public function process_entry( 
		$typed_syntax = '', 
		$typed_options = array(), 
		$typed_font_size = '', 
		$typed_text_bg = '', 
		$typed_text_color = '' ) {
		$typed_element = $typed_script = '';
		$typed_text_bg = dh_format_color( $typed_text_bg );
		$custom_css = '';
		if ( ! empty( $typed_text_bg ) )
			$custom_css .= 'background-color:' . $typed_text_bg . ';';
		$typed_text_color = dh_format_color( $typed_text_color );
		if ( ! empty( $typed_text_color ) )
			$custom_css .= 'color:' . $typed_text_color . ';';
		
		if ( in_array( '*', array( substr( $typed_syntax, 0, 1 ), substr( $typed_syntax, - 1, 1 ) ) ) ) {
			// Typed.js Defaults
			$defaults = array( 'cursorChar' => '|', 'contentType' => 'html', 

			'loop' => false, 'loopCount' => false, 

			'typeSpeed' => 40, 'backSpeed' => 0, 

			'startDelay' => 0, 'backDelay' => 500 );
			
			$defaults = array_merge( $defaults, $typed_options );
			
			$element_id = 'el_' . uniqid();
			
			$typed_syntax = substr( $typed_syntax, 1, - 1 );
			
			$typed_syntax = $this->_esc_script( $typed_syntax );
			
			$animate_entries = explode( ';', $typed_syntax );
			$animate_entries = array_map( 'trim', $animate_entries );
			
			$defaults = array_merge( $defaults, array( 'strings' => $animate_entries ) );
			// Text
			ob_start();
			?>
<div class="dh-typed-text-wrap" <?php if(!empty($custom_css)){?>style="<?php echo $custom_css ?>"<?php }?>>
	<div class="dh-typed-text"
		data-options="<?php echo esc_attr(json_encode($defaults, JSON_NUMERIC_CHECK))?>"></div>
</div>
<?php
			$typed_element = ob_get_clean();
		}
		
		return array( 'el' => $typed_element );
	}
}
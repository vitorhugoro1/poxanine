<?php

/**
* 
*/
class VHR_Search_Widget extends WP_Widget
{
	
	function vhr_search_widget()
	{
		parent::WP_Widget(false, $name = 'VHR Search Widget');
	}

		// widget form creation
	function form($instance) {	
		if($instance){
			$title = esc_attr($instance['title']);
		} else {
			$title = 'Pesquisar';
		}

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titulo'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"  name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
			</p>
		<?php
	}


	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );

		$widget = $before_widget;

		if ( $title ) {
		$widget .= $before_title . $title . $after_title;
	    }

		$widget .= '<div class="search-input">';

		$widget .= '<form method="get">';
        $widget .= '<input type="text" name="s" placeholder="Busca.." required>';
        $widget .= "</form>";

		$widget .= '</div>';

		echo $widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("vhr_search_widget");'));

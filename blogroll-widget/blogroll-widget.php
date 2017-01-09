<?php

/**
* 
*/
class VHR_Blogroll_Widget extends WP_Widget
{
	
	function vhr_blogroll_widget()
	{
		parent::WP_Widget(false, $name = 'Blogroll Widget');
	}

	// widget form creation
	function form($instance) {	
		if($instance){
			$title = esc_attr($instance['title']);
			$qtd = esc_attr($instance['qtd']);
		} else {
			$title = 'Blogroll';
			$qtd = 9; 
		}

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titulo'; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"  name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('qtd'); ?>"><?php echo 'Quantidade de blogs'; ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('qtd'); ?>"  name="<?php echo $this->get_field_name('qtd'); ?>">
					<option value="3" <?php selected( 3 , $qtd); ?>>3</option>
					<option value="6" <?php selected( 6 , $qtd); ?>>6</option>
					<option value="9" <?php selected( 9 , $qtd); ?>>9</option>
				</select>
			</p>
		<?php
	}


	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['qtd'] = strip_tags($new_instance['qtd']);

		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract($args);

		$blogroll = get_posts(array('post_type' => 'blogroll', 'orderby' => 'rand', 'post_status' => 'publish', 'posts_per_page' => $instance['qtd']));

		$title = apply_filters('widget_title', $instance['title'] );

		$widget = $before_widget;

		if ( $title ) {
		$widget .= $before_title . $title . $after_title;
	    }

		$widget .= '<div class="blogroll">';

		if(count($blogroll) > 0){
			$widget .= '<ul class="blogroll-list">';
			
			foreach($blogroll as $blog){
				$widget .= '<li class="blogroll-item">';
					$widget .= '<a href="' . esc_url(get_post_meta($blog->ID, '_vhr_url', true)) .'" target="_blank">';
					$widget .= "<img src='" . get_the_post_thumbnail_url($blog->ID, 'full') . "' title='" . get_the_title( $blog->ID ) . "'>";
					$widget .= '</a>';
				$widget .= '</li>';
			}

			$widget .= '</ul>';
		}

		$widget .= '<div>';

		echo $widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("vhr_blogroll_widget");'));

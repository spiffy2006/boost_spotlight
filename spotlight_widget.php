<?php
/*
Plugin Name: Boostability Spotlights
Plugin URI: http://www.wpexplorer.com/
Description: Monthly spotlight for Boost employees.
Version: 1.0
Author: Jake Cox
*/

function spotlight_js() {
	wp_enqueue_script( 'spotlight-js', plugins_url() . 'spotlight.js', array( 'jquery' ), false );
}

add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );

class boost_spotlight extends WP_Widget {
	function boost_spotlight() {
		 parent::WP_Widget(false, $name = __('Boost Spotlight', 'boost_spotlight_plugin') );
	}

	function form($instance) {
		if($instance) {
			 $category = esc_attr($instance['category']);
		} else {
			 $category = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'boost_spotlight_plugin'); ?></label>
		<?php wp_dropdown_categories(); ?>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['category'] = strip_tags($new_instance['category']);
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$category = $instance['category'];
		echo $before_widget;
		// Display the widget
		echo '<div class="boost_spotlight">';
    $post_info = array();
		$counter = 1;
		if ( have_posts() ) : while ( have_posts() ) : the_post();
				if ( in_category($category) ) {
          $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					echo $counter == 1 ? '<div id="full-spot"><img class="spotlight" data="' . $counter . '" src="' . $url .'" /></div><div id="spot-thumbs"' : '<img class="spotlight" data="' . $counter . '" src="' . $url .'" />';
					$post_info[$counter] = array(
						'title' => the_title(),
						'content' => the_exerpt(),
						'permalink' => the_permalink(),
					);
				}
		$counter ++;
		endif;
		echo '</div><div data-info="' . json_encode($post_info) . '" id="spot_info"></div>';
		echo '</div>';
		echo $after_widget;
	}
}
add_action('widgets_init', create_function('', 'return register_widget("boost_spotlight");'));

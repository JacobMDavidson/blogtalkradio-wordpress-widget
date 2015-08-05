<?php
	/*
	Plugin Name: Blog Talk Radio Player Widget
	Description: Embed your blogtalkradio show in this easy to use widget.
	Version: 1.0
	Author: Jacob Davidson
	Author URI: http://jacobmdavidson.com
	License: MIT
	License URI: http://opensource.org/licenses/MIT
	*/

	class Blogtalkradio_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'blogtalkradio_widget',
				'Blogtalkradio',
				array( 'description' => __( 'Blogtalkradio player', 'text_domain' ), )
			);
		}

		/**
		 * Front-end display of the widget.
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			extract( $args );
			
			// Retrieve the widget settings
			$title = apply_filters( 'widget_title', $instance['title'] );
			$count = apply_filters( 'widget_title', $instance['count'] );
			$show = apply_filters( 'widget_title', $instance['show'] );
			
			// Display the widget
			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
			echo '
				<iframe width="100%" height="' . (min(370, max($count * 50 + 70, 150))) . '
					" src="http://player.cinchcast.com/?userurl=' . $show . 
					'&platformId=1&assetType=multi&itemcount=' . $count . '"
				 	frameborder="0" allowfullscreen>
				</iframe>
				';
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from the database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['count'] = strip_tags( $new_instance['count'] );
			$instance['show'] = strip_tags( $new_instance['show'] );
			return $instance;
		}

		/**
		 * Backend widget form.
		 *
		 * @param array $instance Previously saved values from the database.
		 */
		public function form( $instance ) {
		
			// Retrieve the previously saved widget title
			if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}
			else {
				$title = __( 'Enter the widget title', 'text_domain' );
			}
			
			// Retrieve the previously saved blogtalkradio show name
			if ( isset( $instance[ 'show' ] ) ) {
				$show = $instance[ 'show' ];
			}
			else {
				$show = __( 'Enter the blogtalkradio show name', 'text_domain' );
			}
			
			// Retrieve the previously set maximum number of episodes to display
			if ( isset( $instance['count'] ) ) {
				$count = $instance[ 'count' ];
			}
			else {
				$count = __( 'Number of episodes', 'text_domain' );
			}
			?>
			
			<!-- Display the settings form -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">
					<?php _e( 'Widget Title:' ); ?>
				</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" 
					name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" 
					value="<?php echo esc_attr( $title ); ?>" 
				/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show' ); ?>">
					<?php _e( 'Blogtalkradio Show Name:' ); ?>
				</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'show' ); ?>" 
					name="<?php echo $this->get_field_name( 'show' ); ?>" 
					type="text" value="<?php echo esc_attr( $show ); ?>"
				/>	
			</p>
			<p>	
				<label for="<?php echo $this->get_field_id( 'count' ); ?>">
					<?php _e( 'Number of Episodes to Display:' ); ?>
				</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" 
					name="<?php echo $this->get_field_name( 'count' ); ?>" 
					type="text" value="<?php echo esc_attr( $count ); ?>" 
				/>
			</p>
			<?php 
		}

	} 
	
	// register Blocktalkradio_Widget
	add_action( 'widgets_init', function(){
		 register_widget( 'Blogtalkradio_Widget' );
	});




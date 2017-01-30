<?php
/**
 * Adds Foo_Widget widget.
 */
class Upcoming_Events_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Upcoming_Events_widget', // Base ID
			esc_html__( 'Weil Upcoming Events', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'An Upcoming Events Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			
			//last thing to do here: Find a way for the underline NOT to display if there's no events post'

			$post_type 	= $instance['post_type']; // the post_type of categories to show
			$category_name 	= $instance['category_name']; // the category_name to display
		} 
			///Outputs All Posts Categorized 'Upcoming Events

				$args1 = array(
					'post_type' => 'post', 
					'category_name'=> 'events'
				); 

				$events_array = get_posts( $args1 );

				if($events_array): ?>

				<h2 class="widget-title"><?php echo apply_filters( 'widget_title', $instance['title'] ); ?></h2>

				<ul>

			<?php	foreach ( $events_array as $post) : setup_postdata( $post ); ?>
					<li>
						<a href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a>
					</li>
				<?php endforeach; 
				wp_reset_postdata(); 
				?>
				</ul>
				<?php endif; 
		//  TODO: this is showing error. Review the Codex Example for Widgets_API: https://codex.wordpress.org/Widgets_API 
		echo $args['after_widget']; 
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
<?php	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_type'] = ( ! empty($new_instance['post_type'] ) ) ? strip_tags($new_instance['post_type'] ) : '';
		$instance['category_name'] = ( ! empty( $new_instance['category_name'] ) ) ? strip_tags( $new_instance['category_name'] ) : '';
		
		return $instance;
	}

} // class Foo_Widget

// register Upcoming_Events_Widget widget
function register_upcoming_events_widget() {
    register_widget( 'Upcoming_Events_Widget' );
}
add_action( 'widgets_init', 'register_upcoming_events_widget' );

?>
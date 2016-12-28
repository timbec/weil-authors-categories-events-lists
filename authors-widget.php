<?php

class Weil_Author_List_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */

	 ////http://wordpress.stackexchange.com/questions/80414/what-is-the-correct-way-to-build-a-widget-using-oop
	function __construct() {
		parent::__construct(
			'weil-author-list', // Base ID
			esc_html__( 'Simple Author Display List', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'A simple author display widget', 'text_domain' ), ) // Args
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
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		$exclude = ! empty( $instance['exclude'] ) ? $instance['exclude'] : esc_html__( 'New exclude', 'text_domain' );
		var_dump($exclude); 


	$args1 = array(
			'number' => -1,
			'exclude' => $exclude,
			'has_published_posts' => false,
            'orderby' => 'name',
            'order' => 'ASC'
		);

$users = get_users( $args1 ); ?>

			 <select onchange="window.location=this.options[this.selectedIndex].value">
        <?php if( !empty( $users ) ) { ?>
           
                <option value="#">Select The Author</option>
            <?php	foreach( $users as $user ) { ?>
                    <option value="<?php echo bloginfo('url') . '/author/' . $user->user_nicename; ?>">
                    <a href="<?php echo bloginfo('url') . '/author/' . $user->user_nicename; ?>"><?php echo $user->display_name; ?></a>
                </option>	
            <?php	}
            } else {
                echo 'No Authors to show'; 
            } ?>
			</select>

		<?php }
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
		$title =(! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Author List Widget', 'text_domain' );
		$exclude =(! empty( $instance['exclude'] ) ) ? $instance['exclude'] : esc_html__( 'Author List Widget', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

		<!--TODO: No errors but don't know if I should exclude by role or id.  -->
		<label for="<?php echo $this->get_field_name( 'exclude' ); ?>"><?php _e( 'Exclude Authors by ID:', 'author-list' ) ?> </label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" type="text" value="<?php echo esc_attr( $exclude ); ?>" />
		</p>
		<?php 
	}

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
		$instance['exclude'] = ( ! empty( $new_instance['exclude'] ) ) ? strip_tags( $new_instance['exclude'] ) : '';

		return $instance;
	}

} // class Weil Custom Author list 

// register Foo_Widget widget
function register_customauthorlist_widget() {
    register_widget( 'Weil_Author_List_Widget' );
}
add_action( 'widgets_init', 'register_customauthorlist_widget' );
?>
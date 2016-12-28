<?php

class DisplayCategoriesWidget extends WP_Widget
{
 
  function __construct()
  {
      parent::__construct(
          'weil-category-list', 
          esc_html__('DisplayCategoriesWidget', 'text_domain'), 
          array( 'description' => esc_html__( 'A simple category display widget', 'text_domain'), )
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
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']); 
    $dcw_exclude = $instance['dcw_exclude'];
    $display_empty_categories = $instance['display_empty_categories'];
    $show_format = $instance['show_format'];
    
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
     
if($instance['show_format']==0) 
{
  echo "<style>.dcw_c1 {float:left; width:100%} .dcw_c2 {float:left; width:50%} .dcw_c3 {float:left; width:33%}</style>";
	
  echo "<ul class='dcw'>"; 
	wp_list_categories('orderby=name&show_count='.$showcount_value.'&child_of='.$cat_id.'&hide_empty='.$display_empty_categories.'&title_li=&number='.$dcw_limit.'&exclude='.$dcw_exclude.'&depth='.$dcw_depth);
  echo "</ul>";
  $class_definer="dcw_c".$instance['dcw_column'];
  echo "<script>jQuery('ul.dcw').find('li').addClass('$class_definer');</script>";
}
if($instance['show_format']==2) 
{
?>
  <form action="<?php bloginfo('url'); ?>" method="get">
  <div>
    <!--Have to filter out variables no longer being used. -->
  <?php wp_dropdown_categories('hide_empty='.$display_empty_categories.'&title_li=&number='.'&exclude='.$dcw_exclude); ?>
  <script type="text/javascript">

    var dropdown = document.getElementById("cat");
    function onCatChange() {
      if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
        location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat="+dropdown.options[dropdown.selectedIndex].value;
      }
    }
    dropdown.onchange = onCatChange;
  </script>
  </div>
  </form>
  
<?php
}
    echo $after_widget;
  }

  /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
  public function form($instance)
  {

    /*A lot of notices here, not sure why. Perhaps this offers some solution: https://wordpress.org/support/topic/notice-undefined-index-aiosp_can_set_protocol
    Also http://stackoverflow.com/questions/35499320/error-undefined-variables/35499858 Also wondering why the form is put first - most other plugins I've seen it's at the bottom. */
    $instance = wp_parse_args( (array) $instance, array( 'title' => '','cat_id' => '' ) );
   // $title = $instance['title']; 
    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
    var_dump($title);
    //$dcw_exclude = $instance['dcw_exclude'];
    $dcw_exclude = ! empty( $instance['dcw_exclude'] ) ? $instance['dcw_exclude'] : esc_html__( '', 'text_domain' );
    var_dump($dcw_exclude); 
    //$show_format = $instance['show_format']; 
    $show_format = ! empty( $instance['show_format'] ) ? $instance['show_format'] : esc_html__( '', 'text_domain' );
    var_dump($show_format); 
    $display_empty_categories = ! empty( $instance['display_empty_categories'] ) ? $instance['display_empty_categories'] : esc_html__( '', 'text_domain' );
    var_dump($display_empty_categories); 
	   // Get the existing categories and build a simple select dropdown for the user.
		$categories = get_categories(array( 'hide_empty' => 0));
 

?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
  <!--Categories to exclude-->
<p><label for="<?php echo $this->get_field_id('dcw_exclude'); ?>"><?php _e('Category ID\'s to exclude (optional):'); ?> <input class="widefat" id="<?php echo $this->get_field_id('dcw_exclude'); ?>" name="<?php echo $this->get_field_name('dcw_exclude'); ?>" type="text" value="<?php echo esc_attr($dcw_exclude); ?>" /></label><br><?php _e('<small>Ex: 26,32,54 (comma-separated list of category ids)</small>'); ?></p>

<p><?php _e('Show? (optional):'); ?> <br><input name="<?php echo $this->get_field_name('show_format'); ?>" type="radio" value="0" <?php if(esc_attr($show_format)==0) echo "checked"; ?> />List &nbsp; <input name="<?php echo $this->get_field_name('show_format'); ?>" type="radio" value="2"  <?php if(esc_attr($show_format)==2) echo "checked"; ?>/>Drop Down </p>
<p><?php _e('Display Empty categories? (optional):'); ?> <br><input name="<?php echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="0" <?php if(esc_attr($display_empty_categories)==0) echo "checked"; ?> />Yes &nbsp; <input name="<?php echo $this->get_field_name('display_empty_categories'); ?>" type="radio" value="1"  <?php if(esc_attr($display_empty_categories)==1) echo "checked"; ?>/>No </p>
 
  <?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['dcw_exclude'] = $new_instance['dcw_exclude'];
    $instance['display_empty_categories'] = $new_instance['display_empty_categories'];
    $instance['show_format'] = $new_instance['show_format'];
    
    
    return $instance;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("DisplayCategoriesWidget");') );

?>
<?php

/**
 * Social  Widget
 * Dazzling Theme
 */
class dazzling_social_widget extends WP_Widget
{
    function __construct(){

       $widget_ops = array('classname' => 'dazzling-social','description' => esc_html__( "Dazzling Social Widget" ,'dazzling') );
       parent::__construct('dazzling-social', esc_html__('Dazzling Social Widget','dazzling'), $widget_ops);
    }

    function widget($args , $instance) {
    	extract($args);
        $title = isset($instance['title']) ? $instance['title'] : esc_html__('Follow us' , 'dazzling');

        echo $before_widget;
        echo $before_title;
        echo esc_html( $title );
        echo $after_title;

        /**
         * Widget Content
         */ ?>

        <!-- social icons -->
        <div class="social-icons sticky-sidebar-social">

            <?php dazzling_social_icons(); ?>

        </div><!-- end social icons --><?php

        echo $after_widget;
    }

    /**
     * Sanitize the widget settings on save.
     *
     * Without this, WP_Widget::update() stores $new_instance verbatim.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }

    function form($instance) {
      if(!isset($instance['title'])) $instance['title'] = esc_html__('Follow us' , 'dazzling'); ?>

      <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title ','dazzling') ?></label>

      <input type="text" value="<?php echo esc_attr($instance['title']); ?>"
                          name="<?php echo esc_attr( $this->get_field_name('title') ); ?>"
                          id="<?php echo esc_attr( $this->get_field_id('title') ); ?>"
                          class="widefat" />
      </p><?php
    }

}
?>
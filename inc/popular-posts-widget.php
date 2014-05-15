<?php
/**
 * Plugin Name: Popular Posts
 */

class dazzling_popular_posts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function dazzling_popular_posts_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'dazzling_tabbed_widget', 'description' => __('Displays tabbed list of popular posts, recent posts & comments', 'dazzling') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'dazzling_tabbed_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'dazzling_tabbed_widget', __('Dazzling Popular Posts Widget', 'dazzling'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$number = $instance['number'];

		?>

        <div class="widget tabbed">
            <div class="tabs-wrapper">
                <ul class="nav nav-tabs">
                      <li class="active"><a href="#popular-posts" data-toggle="tab"><?php esc_attr_e( 'Popular', 'dazzling' ); ?></a></li>
                      <li><a href="#recent" data-toggle="tab"><?php esc_attr_e( 'Recent', 'dazzling' ); ?></a></li>
                      <li><a href="#messages" data-toggle="tab"><i class="fa fa-comments tab-comment"></i></a></li>
                </ul>

            <div class="tab-content">
                <ul id="popular-posts" class="tab-pane active">

                    <?php
                        $recent_posts = new WP_Query(array('showposts' => $number, 'ignore_sticky_posts' => 1, 'post_status' => 'publish', 'order'=> 'DESC', 'showposts' => $number, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value'));
                    ?>

                    <?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                        <li>
                            <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php echo get_permalink() ?>" class="tab-thumb thumbnail" rel="bookmark" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail('tab-small'); ?>
                            </a>
                            <?php endif; ?>
                            <div class="content">
                                <a class="tab-entry" href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                <i>
                                    <?php the_time('M j, Y') ?>
                                </i>
                            </div>
                        </li>
                    <?php endwhile; ?>

                </ul>
                <?php wp_reset_postdata(); ?>

                <ul id="recent" class="tab-pane">

                    <?php
                    $recent_posts = new WP_Query(array('showposts' => $number,'post_status' => 'publish', 'ignore_sticky_posts' => 1 ));
                    ?>

                    <?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                        <li>
                            <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php echo get_permalink() ?>" class="tab-thumb thumbnail" rel="bookmark" title="<?php the_title(); ?>">
                                <?php the_post_thumbnail('tab-small'); ?>
                            </a>
                            <?php endif; ?>
                            <div class="content">
                                <a class="tab-entry" href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                <i>
                                    <?php the_time('M j, Y') ?>
                                </i>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php wp_reset_postdata(); ?>

                <ul id="messages" class="tab-pane">

                <?php
                $recent_comments = get_comments( array(
                    'number'    => $number,
                    'status'    => 'approve'
                ) );
                //var_dump($recent_comments);
                ?>
                <?php foreach($recent_comments as $comment) : ?>

                    <li>
                        <div class="content">
                            <?php if ( $comment->comment_author ) { echo $comment->comment_author; } else { _e('Anonymous','dazzling'); } ?> <?php _e('on','dazzling'); ?>
                            <a href="<?php echo get_permalink($comment->comment_post_ID) ?>" rel="bookmark" title="<?php echo get_the_title($comment->comment_post_ID); ?>">
                                <?php echo get_the_title($comment->comment_post_ID); ?>
                            </a>
                            <p>
                            <?php echo substr( $comment->comment_content, 0, strrpos( substr( $comment->comment_content, 0, 60), ' ' ) );?>
                            <?php if (strlen($comment->comment_content) > 60 ) {echo '(...)'; } ?>
                            </p>
                        </div>
                    </li>


                 <?php endforeach; ?>

                </ul>
                </div>
            </div>
        </div>

		<?php
	}
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['number'] = strip_tags( $new_instance['number'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array('number' => 3);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of posts to show','dazzling') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>

	<?php
	}
}
?>
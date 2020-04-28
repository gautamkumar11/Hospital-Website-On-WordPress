<?php
if (!class_exists('Tabs_Widget')) {
    class Tabs_Widget extends WP_Widget
    {

        function __construct() {
            $widget_ops = array( 'classname' => 'tabs-widget', 'description' => __( 'This widget displays popular posts, recent posts and recent comments.', 'framework' ) );
            parent::__construct( 'Tabs_Widget', __( 'MedicalPress - Tabs', 'framework'), $widget_ops );
        }

        function widget($args, $instance)
        {
            extract($args);

            $tab_title_one = $instance['tab_title_one'];
            $tab_title_two = $instance['tab_title_two'];
            $tab_title_three = $instance['tab_title_three'];

            $theme_tab_one = $instance['theme_tab_one'];
            $theme_tab_two = $instance['theme_tab_two'];
            $theme_tab_three = $instance['theme_tab_three'];

            if (empty($instance['number']) || !$number = absint($instance['number']))
                $number = 5;


            echo $before_widget;

            echo '<div class="tabs clearfix">';

            /* Tabs Titles */
            if ($tab_title_one) echo '<div class = "tab-head active"><h6>' . $tab_title_one . '</h6></div>';
            if ($tab_title_two) echo '<div class = "tab-head "><h6>' . $tab_title_two . '</h6></div>';
            if ($tab_title_three) echo '<div class = "tab-head "><h6>' . $tab_title_three . '</h6></div>';


            /* 1st Tab */
            if ($tab_title_one) {
                echo '<div class="tabs-content clearfix">';
                $this->theme_loop($theme_tab_one, $number);
                echo '</div>';
            }

            /* 2nd Tab */
            if ($tab_title_two) {
                echo '<div class="tabs-content clearfix">';
                $this->theme_loop($theme_tab_two, $number);
                echo '</div>';
            }

            /* 3rd Tab */
            if ($tab_title_three) {
                echo '<div class="tabs-content clearfix">';
                $this->theme_loop($theme_tab_three, $number);
                echo '</div>';
            }

            echo '</div>';

            echo $after_widget;
        }


        function theme_loop($loop_type = 'popular_posts', $number = 3)
        {
            if ($loop_type == 'comments') {
                /* recent comments */
                $comments = get_comments(apply_filters('widget_comments_args', array(
                    'number' => $number,
                    'status' => 'approve',
                    'post_status' => 'publish'
                )));
                if ($comments) {
                    foreach ((array)$comments as $comment) {
                        ?>
                        <div class="tab-post-listing clearfix">
                            <figure>
                                <?php echo '<a href="' . get_comment_link($comment->comment_ID) . '">' . get_avatar($comment, 64) . '</a>'; ?>
                            </figure>
                            <div class="post-content">
                                <?php echo sprintf(_x(' <h6>%2$s</h6>', 'widgets', 'framework'), get_comment_author_link($comment->comment_ID), '<a href="' . esc_url(get_comment_link($comment->comment_ID)) . '">' . get_the_title($comment->comment_post_ID) . '</a>'); ?>
                                <span><?php inspiry_comment_excerpt(4, $comment->comment_content); ?></span>
                            </div>
                        </div>
                    <?php
                    }
                }
            } elseif ($loop_type == 'popular_posts') {
                /* popular posts */
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number,
                    'orderby' => 'comment_count',
                    'ignore_sticky_posts' => true,
                    'meta_query' => array(
                        array(
                            'key' => '_thumbnail_id',
                            'compare' => 'EXISTS'
                        )
                    )
                );

                $this->theme_list_posts($args);
            } else {
                /* recent posts */
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $number,
                    'ignore_sticky_posts' => true,
                    'meta_query' => array(
                        array(
                            'key' => '_thumbnail_id',
                            'compare' => 'EXISTS'
                        )
                    )
                );
                $this->theme_list_posts($args);
            }

        }


        function theme_list_posts($args)
        {
            $get_posts_query = new WP_Query($args);

            if ($get_posts_query->have_posts()):
                while ($get_posts_query->have_posts()):
                    $get_posts_query->the_post();
                    ?>
                    <div class="tab-post-listing clearfix">
                        <?php
                        if (has_post_thumbnail()) {
                            ?>
                            <figure>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'tabs-thumb')); ?>
                                </a>
                            </figure>
                        <?php
                        }
                        ?>
                        <div class="post-content">
                            <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                            <span><?php the_time('F d, Y'); ?></span>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_query();
            endif;
        }

        function form($instance)
        {
            $instance = wp_parse_args((array)$instance, array(
                    'tab_title_one' => __('Popular', 'framework'),
                    'tab_title_two' => __('Latest', 'framework'),
                    'tab_title_three' => __('Comments', 'framework'),
                    'theme_tab_one' => 'popular_posts',
                    'theme_tab_two' => 'recent_posts',
                    'theme_tab_three' => 'comments')
            );

            $number = isset($instance['number']) ? absint($instance['number']) : 3;

            $tab_title_one = esc_attr($instance['tab_title_one']);
            $tab_title_two = esc_attr($instance['tab_title_two']);
            $tab_title_three = esc_attr($instance['tab_title_three']);

            $theme_tab_one = $instance['theme_tab_one'];
            $theme_tab_two = $instance['theme_tab_two'];
            $theme_tab_three = $instance['theme_tab_three'];

            ?>
            <p>
                <label for="<?php echo $this->get_field_id('tab_title_one'); ?>"><?php _e('First Tab Title', 'framework'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab_title_one'); ?>" name="<?php echo $this->get_field_name('tab_title_one'); ?>" type="text" value="<?php echo $tab_title_one; ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tab_title_two'); ?>"><?php _e('Second Tab Title', 'framework'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab_title_two'); ?>" name="<?php echo $this->get_field_name('tab_title_two'); ?>" type="text" value="<?php echo $tab_title_two; ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('tab_title_three'); ?>"><?php _e('Third Tab Title', 'framework'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('tab_title_three'); ?>" name="<?php echo $this->get_field_name('tab_title_three'); ?>" type="text" value="<?php echo $tab_title_three; ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('theme_tab_one'); ?>"><?php _e('First Tab Content', 'framework'); ?></label>
                <select name="<?php echo $this->get_field_name('theme_tab_one'); ?>" id="<?php echo $this->get_field_id('theme_tab_one'); ?>">
                    <option value="popular_posts"<?php selected($theme_tab_one, 'popular_posts'); ?>><?php _e('Popular Posts', 'framework'); ?></option>
                    <option value="recent_posts"<?php selected($theme_tab_one, 'recent_posts'); ?>><?php _e('Recent Posts', 'framework'); ?></option>
                    <option value="comments"<?php selected($theme_tab_one, 'comments'); ?>><?php _e('Comments', 'framework'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('theme_tab_two'); ?>"><?php _e('Second Tab Content', 'framework'); ?></label>
                <select name="<?php echo $this->get_field_name('theme_tab_two'); ?>" id="<?php echo $this->get_field_id('theme_tab_two'); ?>">
                    <option value="popular_posts"<?php selected($theme_tab_two, 'popular_posts'); ?>><?php _e('Popular Posts', 'framework'); ?></option>
                    <option value="recent_posts"<?php selected($theme_tab_two, 'recent_posts'); ?>><?php _e('Recent Posts', 'framework'); ?></option>
                    <option value="comments"<?php selected($theme_tab_two, 'comments'); ?>><?php _e('Comments', 'framework'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('theme_tab_three'); ?>"><?php _e('Third Tab Content', 'framework'); ?></label>
                <select name="<?php echo $this->get_field_name('theme_tab_three'); ?>" id="<?php echo $this->get_field_id('theme_tab_three'); ?>">
                    <option value="popular_posts"<?php selected($theme_tab_three, 'popular_posts'); ?>><?php _e('Popular Posts', 'framework'); ?></option>
                    <option value="recent_posts"<?php selected($theme_tab_three, 'recent_posts'); ?>><?php _e('Recent Posts', 'framework'); ?></option>
                    <option value="comments"<?php selected($theme_tab_three, 'comments'); ?>><?php _e('Comments', 'framework'); ?></option>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of items to show:', 'framework'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="5"/>
            </p>
        <?php
        }


        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['tab_title_one'] = strip_tags($new_instance['tab_title_one']);
            $instance['tab_title_two'] = strip_tags($new_instance['tab_title_two']);
            $instance['tab_title_three'] = strip_tags($new_instance['tab_title_three']);
            $instance['theme_tab_one'] = $new_instance['theme_tab_one'];
            $instance['theme_tab_two'] = $new_instance['theme_tab_two'];
            $instance['theme_tab_three'] = $new_instance['theme_tab_three'];
            $instance['number'] = absint($new_instance['number']);

            return $instance;
        }

    }
}

/* register tabs widget */
if (!function_exists('inspiry_register_tab_widgets')) {
    function inspiry_register_tab_widgets()
    {
        register_widget('Tabs_Widget');
    }
}
add_action('widgets_init', 'inspiry_register_tab_widgets');

?>
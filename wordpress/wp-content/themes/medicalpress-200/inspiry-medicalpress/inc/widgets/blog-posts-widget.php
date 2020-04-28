<?php
if ( ! class_exists( 'Inspiry_Posts_Widget' ) ) {

	class Inspiry_Posts_Widget extends WP_Widget {

		function __construct() {
			$widget_ops = array(
				'classname'   => 'widget-popular-blog-posts',
				'description' => __( 'Displays popular or recent blog posts.', 'framework' )
			);
			parent::__construct( 'Inspiry_Posts_Widget', __( 'MedicalPress - Blog Posts', 'framework' ), $widget_ops );
		}

		function widget( $args, $instance ) {

			$title = ( ! empty( $instance['title'] ) ? $instance['title'] : __( 'Popular Blog Posts', 'framework' ) );
			$title = apply_filters( 'inspiry_posts_widget_title', $title );

			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 2;

			if ( ! $number ) {
				$number = 2;
			}

			$get_posts_args = array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true
			);

			$sort_by = ( isset( $instance['sort_by'] ) ? $instance['sort_by'] : 'popular' );

			if ( $sort_by == "popular" ) {
				$get_posts_args['orderby'] = "comment_count";
			} else {
				$get_posts_args['orderby'] = "date";
			}

			$get_posts_query = new WP_Query( $get_posts_args );

			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			}

			if ( $get_posts_query->have_posts() ) : ?>
                <ul class="widget-popular-blog-posts-list">
					<?php

					while ( $get_posts_query->have_posts() ):

						$get_posts_query->the_post(); ?>
                        <li>
                            <figure class="widget-popular-blog-posts-figure">
                                <a href="<?php the_permalink(); ?>">
								    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'tabs-thumb' ) ); ?>
                                </a>
                            </figure>
                            <div class="widget-popular-blog-posts-content">
                                <h4 class="widget-popular-blog-posts-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                </h4>
                                <div class="widget-popular-blog-posts-meta">
                                    <span class="posted-on">
                                        <time class="entry-date published"
                                              datetime="<?php the_time( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
                                    </span>
                                    <span class="author">
                                        <?php
                                        printf( _x( '<span>by</span> %s', 'author byline', 'framework' ),
	                                        sprintf( '<a class="vcard fn" href="%1$s">%2$s</a>',
		                                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		                                        esc_html( get_the_author_meta( 'display_name' ) )
	                                        )
                                        ); ?>
                                    </span>
                                </div>
                            </div>
                        </li>
						<?php
					endwhile;

					$show_blog_link = ( isset( $instance['show_blog_link'] ) ? $instance['show_blog_link'] : false );
					$blog_link_text = ( isset( $instance['blog_link_text'] ) ? $instance['blog_link_text'] : esc_html__( 'Checkout all Posts', 'framework' ) );

					if ( $show_blog_link ) {
						$blog_page = get_option( 'page_for_posts' );
						printf( '<a class="blog-link" href="%s">%s<i class="fas fa-long-arrow-alt-right"></i></a>', get_page_link( $blog_page ), $blog_link_text );
					}
					?>
                </ul>
				<?php
				wp_reset_postdata();

			endif;

			echo $args['after_widget'];
		}

		function update( $new_instance, $old_instance ) {
			$instance                   = $old_instance;
			$instance['title']          = sanitize_text_field( $new_instance['title'] );
			$instance['number']         = absint( $new_instance['number'] );
			$instance['sort_by']        = $new_instance['sort_by'];
			$instance['show_blog_link'] = isset( $new_instance['show_blog_link'] ) ? (bool) $new_instance['show_blog_link'] : false;
			$instance['blog_link_text'] = sanitize_text_field( $new_instance['blog_link_text'] );

			return $instance;
		}

		function form( $instance ) {
			$title          = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
			$number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 2;
			$sort_by        = isset( $instance['sort_by'] ) ? $instance['sort_by'] : 'popular';
			$show_blog_link = isset( $instance['show_blog_link'] ) ? (bool) $instance['show_blog_link'] : false;
			$blog_link_text = isset( $instance['blog_link_text'] ) ? sanitize_text_field( $instance['blog_link_text'] ) : esc_html__( 'Checkout all Posts', 'framework' );
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
					<?php esc_html_e( 'Title:', 'framework' ); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
					<?php esc_html_e( 'Number of Posts to Display:', 'framework' ); ?>
                </label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="5"/>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>">
					<?php esc_html_e( 'Sort By:', 'framework' ) ?>
                </label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'sort_by' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sort_by' ) ); ?>" class="widefat">
                    <option value="popular"<?php selected( $sort_by, 'popular' ); ?>><?php esc_html_e( 'Popular', 'framework' ); ?></option>
                    <option value="recent"<?php selected( $sort_by, 'recent' ); ?>><?php esc_html_e( 'Most Recent', 'framework' ); ?></option>
                </select>
            </p>
            <p>
                <input class="checkbox" type="checkbox"<?php checked( $show_blog_link ); ?> id="<?php echo $this->get_field_id( 'show_blog_link' ); ?>" name="<?php echo $this->get_field_name( 'show_blog_link' ); ?>"/>
                <label for="<?php echo $this->get_field_id( 'show_blog_link' ); ?>">
					<?php esc_html_e( 'Display blog link?', 'framework' ); ?>
                </label>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'blog_link_text' ) ); ?>">
					<?php esc_html_e( 'Blog Link Text:', 'framework' ) ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'blog_link_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'blog_link_text' ) ); ?>" type="text" value="<?php echo esc_attr( $blog_link_text ); ?>"/>
            </p>
			<?php
		}
	}
}

if ( ! function_exists( 'inspiry_register_posts_widget' ) ):
	/**
	 * Register inspiry posts widget
	 */
	function inspiry_register_posts_widget() {
		register_widget( 'Inspiry_Posts_Widget' );
	}

	add_action( 'widgets_init', 'inspiry_register_posts_widget' );
endif;
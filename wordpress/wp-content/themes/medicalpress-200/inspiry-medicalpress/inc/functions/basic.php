<?php
if ( ! function_exists( 'inspiry_standard_thumbnail' ) ) {
	/**
	 * Inspiry Standard Featured Image
	 */
	function inspiry_standard_thumbnail( $size = 'blog-page' ) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) && ( is_singular( 'post' ) || is_singular( 'doctor' ) || is_singular( 'service' ) || is_singular( 'gallery-item' ) ) ) {
			$image_id       = get_post_thumbnail_id();
			$full_image_url = wp_get_attachment_url( $image_id );
			?>
            <figure>
                <a class="swipebox" href="<?php echo $full_image_url; ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( $size ); ?>
                </a>
            </figure>
			<?php
		} else if ( has_post_thumbnail( $post->ID ) ) {
			?>
            <figure>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail( $size ); ?>
                </a>
            </figure>
			<?php
		}
	}
}

if ( ! function_exists( 'inspiry_list_gallery_images' ) ) {
	/**
	 * List Gallery Images
	 */
	function inspiry_list_gallery_images( $size = 'blog-post-thumb' ) {
		?>
        <ul class="slides">
			<?php
			global $post;

			$gallery_images = rwmb_meta( 'MEDICAL_META_gallery', 'type=plupload_image&size=' . $size, $post->ID );

			if ( ! empty( $gallery_images ) ) {
				foreach ( $gallery_images as $gallery_image ) {
					$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
					echo '<li><a href="' . $gallery_image['full_url'] . '" title="' . $caption . '" >';
					echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
					echo '</a></li>';
				}
			} else if ( has_post_thumbnail( $post->ID ) ) {
				echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
				the_post_thumbnail( $size );
				echo '</a></li>';
			}
			?>
        </ul>
		<?php
	}
}

if ( ! function_exists( 'inspiry_list_custom_gallery_images' ) ) {
	/**
	 * List Gallery Images based on custom gallery meta data
	 */
	function inspiry_list_custom_gallery_images( $size = 'gallery-post-single' ) {
		?>
        <ul class="slides">
			<?php
			global $post;
			$gallery_images = rwmb_meta( 'MEDICAL_META_custom_gallery', 'type=plupload_image&size=' . $size, $post->ID );
			if ( ! empty( $gallery_images ) ) {
				foreach ( $gallery_images as $gallery_image ) {
					$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
					echo '<li><a href="' . $gallery_image['full_url'] . '" title="' . $caption . '" >';
					echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
					echo '</a></li>';
				}
			} else if ( has_post_thumbnail( $post->ID ) ) {
				echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
				the_post_thumbnail( $size );
				echo '</a></li>';
			}
			?>
        </ul>
		<?php
	}
}

if ( ! function_exists( 'get_banner_image' ) ) {
	/**
	 * Get Banner Image
	 */
	function get_banner_image() {
		$post_id = get_the_ID();

		if ( is_home() ) {
			$post_id = get_option( 'page_for_posts' );
		}

		$banner_image_id = get_post_meta( $post_id, 'MEDICAL_META_page_banner', true );
		if ( $banner_image_id ) {
			$banner_image_path = wp_get_attachment_url( $banner_image_id );
		} else {
			$banner_image_path = get_default_banner();
		}

		return $banner_image_path;
	}
}

if ( ! function_exists( 'get_default_banner' ) ) {
	/**
	 * Get Default Banner
	 */
	function get_default_banner() {
		global $theme_options;
		$banner_image_path = "";
		if ( ! empty( $theme_options['default_page_banner'] ) ) {
			$banner_image_path = $theme_options['default_page_banner']['url'];
		}

		return empty( $banner_image_path ) ? INSPIRY_ASSETS_DIR_URI . '/images/banner.jpg' : $banner_image_path;
	}
}

if ( ! function_exists( 'theme_breadcrumb' ) ) {
	/**
	 * Theme Breadcrumb
	 */
	function theme_breadcrumb() {
		global $theme_options;
		if ( $theme_options['breadcrumb'] == '0' ) {
			return;
		}

		echo '<ul class="breadcrumb clearfix">';

		/* For all pages other than front page */
		if ( ! is_front_page() ) {
			echo '<li>';
			echo '<a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>';
			echo '<span class="divider"></span></li>';
		}

		/* For index.php OR blog posts page */
		if ( is_home() ) {
			$page_for_posts = get_option( 'page_for_posts' );
			if ( $page_for_posts ) {
				$blog = get_post( $page_for_posts );
				echo '<li class="active">';
				echo $blog->post_title;
				echo '</li>';
			} else {
				echo '<li class="active">';
				_e( 'Blog', 'framework' );
				echo '<li>';
			}
		}

		if ( is_singular( 'post' ) || is_singular( 'doctor' ) || is_singular( 'service' ) || is_singular( 'gallery-item' ) || is_singular( 'product') || is_page() ) {

			global $post;

			if ( is_page() ) {
				inspiry_page_parent_breadcrumbs( $post );
			} elseif ( is_singular( 'doctor' ) ) {
				$inspiry_doctors_page = $theme_options['inspiry_doctors_page'];
				if ( ! empty( $inspiry_doctors_page ) ) {
					inspiry_page_parent_breadcrumbs( get_post( $inspiry_doctors_page ) );
					inspiry_page_breadcrumb( $inspiry_doctors_page );
				}
			} elseif ( is_singular( 'service' ) ) {
				$inspiry_services_page = $theme_options['inspiry_services_page'];
				if ( ! empty( $inspiry_services_page ) ) {
					inspiry_page_parent_breadcrumbs( get_post( $inspiry_services_page ) );
					inspiry_page_breadcrumb( $inspiry_services_page );
				}
			} elseif ( is_singular( 'gallery-item' ) ) {
				$inspiry_gallery_page = $theme_options['inspiry_gallery_page'];
				if ( ! empty( $inspiry_gallery_page ) ) {
					inspiry_page_parent_breadcrumbs( get_post( $inspiry_gallery_page ) );
					inspiry_page_breadcrumb( $inspiry_gallery_page );
				}
			}

			// Simple title
			echo '<li class="active">';
			the_title();
			echo '</li>';
		}

		if ( is_category() ) {
		    $cats = get_category_parents( get_query_var( 'cat' ), true, ',' );
			$cats = preg_replace( '/,\s$|,$/', '', $cats );
			$cats = explode( ',', $cats );
			array_pop( $cats );
			foreach ( $cats as $cat ) {
				echo '<li>' . $cat . '<span class="divider"></span></li>';
			}
			echo '<li class="active">' . single_cat_title( '', false ) . '</li>';
		}

		if ( is_tag() ) {
			echo '<li class="active">';
			echo single_tag_title( '', false );
			echo '</li>';
		}

		if ( is_author() ) {
			echo '<li class="active">';
			_e( 'Author', 'framework' );
			echo '</li>';
		}

		if ( is_year() || is_month() || is_day() ) {
			echo '<li class="active">';
			_e( 'Archives', 'framework' );
			echo '</li>';
		}

		if ( is_tax() ) {
			$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			if ( ! empty( $current_term->name ) ) {
				echo '<li class="active">';
				echo $current_term->name;
				echo '</li>';
			}
		}

		if ( is_404() ) {
			echo '<li class="active">';
			_e( '404 - Page not Found', 'framework' );
			echo '</li>';

		}

		if ( is_search() ) {
			echo '<li class="active">';
			_e( 'Search', 'framework' );
			echo '</li>';
		}

		if ( function_exists( 'is_shop' ) ) {

			if ( is_shop() ) {
				echo '<li class="active">';
				_e( 'Shop', 'framework' );
				echo '</li>';
			}
		}

		echo "</ul>";
	}
}

if ( ! function_exists( 'inspiry_page_parent_breadcrumbs' ) ) {
	function inspiry_page_parent_breadcrumbs( $page ) {
		$parent_id = $page->post_parent;
		if ( $parent_id ) {

			$parents = array();

			while ( $parent_id ) {
				$parents[] = $parent_id;
				$page      = get_post( $parent_id );
				$parent_id = $page->post_parent;
			}

			$parents_count = count( $parents );
			for ( $i = $parents_count; $i > 0; ) {
				$parent_id = $parents[ -- $i ];
				echo '<li>';
				echo '<a href="' . get_the_permalink( $parent_id ) . '">';
				echo get_the_title( $parent_id );
				echo '</a>';
				echo '<span class="divider"></span>';
				echo '</li>';
			}
		}
	}
}

if ( ! function_exists( 'inspiry_page_breadcrumb' ) ) {
	/**
	 * Output single page breadcrumb part
	 * Example: Page Title -->
	 *
	 * @param $page_id
	 */
	function inspiry_page_breadcrumb( $page_id ) {
		printf( '<li><a href="%1$s">%2$s</a><span class="divider"></span></li>',
			esc_url( get_the_permalink( $page_id ) ),
			get_the_title( $page_id )
		);
	}
}

if ( ! function_exists( 'inspiry_pagination' ) ) {
	/**
	 * Inspiry Theme Pagination
	 */
	function inspiry_pagination( $query ) {
		$prev_text = ( INSPIRY_DESIGN_VARIATION == 'default' ? ' < ' : '<i class="fas fa-long-arrow-alt-left"></i>' );
		$next_text = ( INSPIRY_DESIGN_VARIATION == 'default' ? ' > ' : '<i class="fas fa-long-arrow-alt-right"></i>' );

		echo "<div class='pagination'>";
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'prev_text' => $prev_text,
			'next_text' => $next_text,
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $query->max_num_pages
		) );
		echo "</div>";
	}
}

if ( ! function_exists( 'add_class_next_post_link' ) ) {
	/**
	 * Add Class Next Post Link
	 */
	function add_class_next_post_link( $html ) {
		$html = str_replace( '<a', '<a class="next fa fa-chevron-right"', $html );

		return $html;
	}

	add_filter( 'next_post_link', 'add_class_next_post_link', 10, 1 );
}

if ( ! function_exists( 'add_class_previous_post_link' ) ) {
	function add_class_previous_post_link( $html ) {
		$html = str_replace( '<a', '<a class="prev fa fa-chevron-left"', $html );

		return $html;
	}

	add_filter( 'previous_post_link', 'add_class_previous_post_link', 10, 1 );
}

if ( ! function_exists( 'inspiry_excerpt' ) ) {
	/**
	 * Custom Excerpt Method
	 */
	function inspiry_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			$last_item = array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";
		echo $excerpt;
	}
}

if ( ! function_exists( 'get_inspiry_excerpt' ) ) {
	function get_inspiry_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			$last_item = array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'inspiry_comment_excerpt' ) ) {
	function inspiry_comment_excerpt( $len = 15, $comment_content = "", $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $comment_content, $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			$last_item = array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";
		echo $excerpt;
	}
}

if ( ! function_exists( 'nothing_found' ) ) {
	/**
	 * Some Helper Functions
	 */
	function nothing_found( $message ) {
		?>
        <div class="<?php bc_all( '12' ); ?>">
            <p class="nothing-found"><?php echo $message; ?></p>
        </div>
		<?php
	}
}

if ( ! function_exists( 'bc' ) ) {
	/**
	 * Function to output different bootstrap classes
	 */
	function bc( $col_lg = null, $col_md = null, $col_sm = null, $col_xs = null ) {
		echo get_bc( $col_lg, $col_md, $col_sm, $col_xs );
	}
}

if ( ! function_exists( 'get_bc' ) ) {
	function get_bc( $col_lg = null, $col_md = null, $col_sm = null, $col_xs = null ) {
		$bootstrap_classes = "";
		if ( ! empty( $col_lg ) ) {
			$bootstrap_classes .= "col-lg-$col_lg ";
		}
		if ( ! empty( $col_md ) ) {
			$bootstrap_classes .= "col-md-$col_md ";
		}
		if ( ! empty( $col_sm ) ) {
			$bootstrap_classes .= "col-sm-$col_sm ";
		}
		if ( ! empty( $col_xs ) ) {
			$bootstrap_classes .= "col-xs-$col_xs ";
		}

		return $bootstrap_classes;
	}
}

if ( ! function_exists( 'bc_all' ) ) {
	function bc_all( $column ) {
		echo get_bc_all( $column );
	}
}

if ( ! function_exists( 'get_bc_all' ) ) {
	function get_bc_all( $column ) {
		return "col-lg-$column col-md-$column col-sm-$column";
	}
}

if ( ! function_exists( 'inspiry_filters' ) ) {
	function inspiry_filters( $term, $all_text = '', $isotope = true ) {
		echo get_inspiry_filters( $term, $all_text, $isotope );
	}
}

if ( ! function_exists( 'get_inspiry_filters' ) ) {
	function get_inspiry_filters( $term, $all_text = '', $isotope = true ) {

		global $post, $link_class;

		if ( ! $isotope ) {
			$link_class = 'class="no-isotope"';
		}

		$args = array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
		);

		$html = '<ul id="filters" class="filters clearfix">';

		if ( ! $all_text ) {
			$all_text = __( 'All', 'framework' );
		}

		$html .= ' <li class="active"><a ' . $link_class . ' href="#" data-filter="*">' . $all_text . '</a></li>';

		if ( $term ) {

			$terms = get_terms( $term, $args );

			if ( ! empty( $terms ) ) {

				foreach ( $terms as $term ) {

					$html .= '<li><a ' . $link_class . ' href="' . get_term_link( $term->slug, $term->taxonomy ) . '" data-filter=".' . $term->slug . '">' . $term->name . '</a></li>';
				}
			}
		}

		$html .= '</ul>';

		return $html;
	}
}

if ( ! function_exists( 'inspiry_social_nav' ) ) {
	function inspiry_social_nav( $nav_class = '', $display_option = '' ) {
		echo get_inspiry_social_nav( $nav_class, $display_option );
	}
}

if ( ! function_exists( 'get_inspiry_social_nav' ) ) {
	function get_inspiry_social_nav( $nav_class = '', $display_option = '' ) {

		global $theme_options;

		if ( isset( $theme_options[ $display_option ] ) && '1' == $theme_options[ $display_option ] ) {

			$html = '<ul class="' . esc_attr( $nav_class ) . ' list-unstyled clearfix">';

			if ( ! empty( $theme_options['twitter_url'] ) ) {
				$html .= '<li><a class="twitter" target="_blank" href="' . $theme_options['twitter_url'] . '"><i class="fab fa-twitter"></i></a></li>';
			}

			if ( ! empty( $theme_options['facebook_url'] ) ) {
				$html .= '<li><a class="facebook" target="_blank" href="' . $theme_options['facebook_url'] . '"><i class="fab fa-facebook"></i></a></li>';
			}

			if ( ! empty( $theme_options['google_url'] ) ) {
				$html .= '<li><a class="google" target="_blank" href="' . $theme_options['google_url'] . '"><i class="fab fa-google-plus-g"></i></a></li>';
			}

			if ( ! empty( $theme_options['linkedin_url'] ) ) {
				$html .= '<li><a class="linkedin" target="_blank" href="' . $theme_options['linkedin_url'] . '"><i class="fab fa-linkedin-in"></i></a></li>';
			}

			if ( ! empty( $theme_options['instagram_url'] ) ) {
				$html .= '<li><a class="instagram" target="_blank" href="' . $theme_options['instagram_url'] . '"><i class="fab fa-instagram"></i></a></li>';
			}

			if ( ! empty( $theme_options['youtube_url'] ) ) {
				$html .= '<li><a class="youtube" target="_blank" href="' . $theme_options['youtube_url'] . '"><i class="fab fa-youtube"></i></a></li>';
			}

			if ( ! empty( $theme_options['skype_username'] ) ) {
				$html .= '<li><a class="skype" target="_blank" href="skype:' . $theme_options['skype_username'] . '?add"><i class="fab fa-skype"></i></a></li>';
			}

			if ( ! empty( $theme_options['rss_url'] ) ) {
				$html .= '<li><a class="rss" target="_blank" href="' . $theme_options['rss_url'] . '"><i class="fas fa-rss"></i></a></li>';
			}

			$html .= '</ul>';

			return $html;

		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_get_option' ) ) {

	function inspiry_get_option( $option, $echo = false ) {

		global $theme_options;

		if ( isset( $theme_options[ $option ] ) && ! empty( $theme_options[ $option ] ) ) {

			if( $echo ){
				echo $theme_options[ $option ];
			}else{
				return $theme_options[ $option ];
			}
		}

		return false;
	}
}
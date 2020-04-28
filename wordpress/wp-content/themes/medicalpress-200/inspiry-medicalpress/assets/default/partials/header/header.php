<?php
global  $theme_options;

if ($theme_options['display_top_header']) {
	?>
	<div class="header-top clearfix">
		<div class="container">
			<div class="row">
				<div class="<?php bc('5', '5', '', ''); ?>">
					<?php
					if (!empty($theme_options['top_header_text'])) {
						?>
						<p><?php echo $theme_options['top_header_text']; ?></p>
						<?php
					}
					?>
				</div>
				<?php
				if ((!empty($theme_options['header_opening_hours'])) || (!empty($theme_options['header_contact_number']))) {
					?>
					<div class="<?php bc('7', '7', '', ''); ?> text-right">
						<?php
						/* WPML Language Switcher */
						if($theme_options['display_wpml_flags']){
							if(function_exists('icl_get_languages')){
								$languages = icl_get_languages('skip_missing=0&orderby=code');
								if(!empty($languages)){
									echo '<div id="inspiry_language_list"><ul class="clearfix">';
									foreach($languages as $l){
										echo '<li>';
										if($l['country_flag_url']){
											if(!$l['active']) echo '<a href="'.$l['url'].'" title="'.$l['translated_name'].'">';
											echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['translated_name'].'" width="18" />';
											if(!$l['active']) echo '</a>';
										}
										echo '</li>';
									}
									echo '</ul></div>';
								}
							}
						}
						?>
						<p>
							<?php
							if ( isset( $theme_options[ 'header_opening_hours' ] ) && ! empty( $theme_options[ 'header_opening_hours' ] ) ) {
								echo isset( $theme_options[ 'header_opening_hours_label' ] ) ? $theme_options[ 'header_opening_hours_label' ] : esc_html__( 'Opening Hours', 'framework' ) ;
								echo ' : ';
								echo '<span>' . $theme_options[ 'header_opening_hours' ] . '</span>';
							}

							if ( isset( $theme_options[ 'header_contact_number' ] ) && ! empty( $theme_options[ 'header_contact_number' ] ) ) {
								echo '<br class="visible-xs" />';
								echo '&nbsp;&nbsp;';
								echo isset( $theme_options[ 'header_contact_number_label' ] ) ? $theme_options[ 'header_contact_number_label' ] : esc_html__( 'Contact', 'framework' ) ;
								echo ' : ';
								echo '<span>' . $theme_options[ 'header_contact_number' ] . '</span>';
							}
							?>
						</p>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
?>
	<header id="header">
		<div class="container">
			<div class="row">
				<div class="<?php bc_all('12'); ?>">

					<!-- Website Logo -->
					<div class="logo clearfix">
						<?php
						$logo_path        = isset( $theme_options['website_logo']['url'] ) ? $theme_options['website_logo']['url'] : '';
						$retina_logo_path = isset( $theme_options['website_retina_logo']['url'] ) ? $theme_options['website_retina_logo']['url'] : '';

						if ( ! empty( $logo_path ) || ! empty( $retina_logo_path ) ) {
							?>
							<a href="<?php echo esc_url(home_url('/')); ?>"><?php inspiry_logo_img( $logo_path, $retina_logo_path ); ?></a>
							<?php
						} else {
							?>
							<h1>
								<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php $site_title = get_bloginfo('name'); echo strip_tags(html_entity_decode($site_title)); ?>">
									<?php echo html_entity_decode($site_title); ?>
								</a>
							</h1>
							<?php
						}
						?>
					</div>

					<!-- Main Navigation -->
					<nav class="main-menu">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'main-menu',
							'container' => false,
							'menu_class' => 'header-nav clearfix'
						));
						?>
					</nav>

					<div id="responsive-menu-container"></div>

				</div>
			</div>
		</div>
	</header>

<?php
/*
 * Include Banner
*/
if ( ! is_page_template( array(
	'templates/home.php',
	'templates/demo-home-two.php',
	'templates/demo-home-three.php',
	'templates/demo-home-four.php',
	'templates/demo-home-five.php'
) ) ) {
	get_template_part( INSPIRY_PARTIALS . '/common/banner' );
}
?>
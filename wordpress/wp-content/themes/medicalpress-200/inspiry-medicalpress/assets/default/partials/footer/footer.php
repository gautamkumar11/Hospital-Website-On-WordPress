<footer id="main-footer" class="site-footer clearfix">
	<div class="container">
		<div class="row">
			<div class="animated fadeInLeft <?php bc('3', '3', '6', ''); ?> ">
				<?php dynamic_sidebar('footer-1st-column'); ?>
			</div>

			<div class="animated fadeInLeft <?php bc('3', '3', '6', ''); ?> ">
				<?php dynamic_sidebar('footer-2nd-column'); ?>
			</div>

			<div class="clearfix visible-sm"></div>

			<div class="animated fadeInLeft <?php bc('3', '3', '6', ''); ?> ">
				<?php dynamic_sidebar('footer-3rd-column'); ?>
			</div>

			<div class="animated fadeInLeft <?php bc('3', '3', '6', ''); ?> ">
				<?php dynamic_sidebar('footer-4th-column'); ?>
			</div>

			<div class="<?php bc_all('12'); ?> ">
				<div class="footer-bottom animated fadeInDown clearfix">
					<div class="row">
						<?php
						global $theme_options;

						if (!empty($theme_options['footer_copyright'])) : ?>
							<div class="<?php bc('7','7','7','12'); ?>">
								<p><?php echo $theme_options['footer_copyright'] ?></p>
							</div>
							<?php
						endif;

						if (!empty($theme_options['display_footer_social_icons'])) : ?>
							<div class="<?php bc('5','5','5','12'); ?> clearfix">
								<?php inspiry_social_nav('footer-social-nav', 'display_footer_social_icons'); ?>
							</div>
                        <?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
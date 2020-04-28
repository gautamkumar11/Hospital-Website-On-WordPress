<?php
global $theme_options;
$features_variation_2 = $theme_options['features_variation_2'];
$has_features         = ! empty( $features_variation_2 ) && ! empty( array_filter( $features_variation_2[0] ) );
if ( $has_features ) : ?>
    <div class="home-section home-features">
        <div class="container">
            <div class="row">
				<?php foreach ( $features_variation_2 as $feature ) : ?>
                    <div class="col-md-4">
                        <div class="home-features-item">
                            <div class="home-features-item-image">
								<?php
								if ( ! empty( $feature['url'] ) ) {
									echo '<a href="' . $feature['url'] . '">';
									echo '<img src="' . $feature['image'] . '" alt="' . $feature['title'] . '"/>';
									echo '</a>';
								} else {
									echo '<img src="' . $feature['image'] . '" alt="' . $feature['title'] . '"/>';
								}
								?>
                            </div>
                            <div class="home-features-item-content">
                                <h3 class="home-features-item-title">
									<?php
									if ( ! empty( $feature['url'] ) ) {
										echo '<a href="' . $feature['url'] . '">';
										echo $feature['title'];
										echo '</a>';
									} else {
										echo $feature['title'];
									}
									?>
                                </h3>
                                <p class="home-features-item-description"><?php echo $feature['description']; ?></p>
                            </div>
                        </div>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
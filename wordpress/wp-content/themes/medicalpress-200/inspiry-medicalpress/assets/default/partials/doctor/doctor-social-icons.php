<div class="social-icon clearfix">
    <ul class="doc-social-nav">
        <?php
        global $post;

        $twitter_url = get_post_meta($post->ID, 'twitter_link', true);
        if (!empty($twitter_url)) {
            echo '<li class ="twitter-icon"><a target="_blank" href="' . $twitter_url . '"><i class="fab fa-twitter"></i></a></li>';
        }

        $facebook_url = get_post_meta($post->ID, 'facebook_link', true);
        if (!empty($facebook_url)) {
            echo '<li class ="facebook-icon"><a target="_blank" href="' . $facebook_url . '"><i class="fab fa-facebook-f"></i></a></li>';
        }

        $google_plus_url = get_post_meta($post->ID, 'google_plus_link', true);
        if (!empty($google_plus_url)) {
	        echo '<li class ="google-icon"><a target="_blank" href="' . $google_plus_url . '"><i class="fab fa-google-plus"></i></a></li>';
        }

        $linkedin_url = get_post_meta($post->ID, 'linkedin_link', true);
        if (!empty($linkedin_url)) {
            echo '<li class ="linkedin-icon"><a target="_blank" href="' . $linkedin_url . '"><i class="fab fa-linkedin-in"></i></a></li>';
        }

        $youtube_url = get_post_meta($post->ID, 'youtube_link', true);
        if (!empty($youtube_url)) {
	        echo '<li class ="youtube-icon"><a target="_blank" href="' . $youtube_url . '"><i class="fab fa-youtube"></i></a></li>';
        }

        $skype_username = get_post_meta($post->ID, 'skype_username', true);
        if (!empty($skype_username)) {
            echo '<li class ="skype-icon"><a target="_blank" href="skype:' . $skype_username . '?add"><i class="fab fa-skype"></i></a></li>';
        }
        ?>
    </ul>
</div>
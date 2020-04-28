<div class="social-icon">
    <?php
    global $post;

    $twitter_url = get_post_meta($post->ID, 'twitter_link', true);
    if (!empty($twitter_url)) {
        echo '<a class ="twitter-icon" target="_blank" href="' . $twitter_url . '"><i class="fab fa-twitter"></i></a>';
    }

    $facebook_url = get_post_meta($post->ID, 'facebook_link', true);
    if (!empty($facebook_url)) {
        echo '<a class ="facebook-icon" target="_blank" href="' . $facebook_url . '"><i class="fab fa-facebook"></i></a>';
    }

    $google_plus_url = get_post_meta($post->ID, 'google_plus_link', true);
    if (!empty($google_plus_url)) {
        echo '<a class ="google-icon" target="_blank" href="' . $google_plus_url . '"><i class="fab fa-google-plus"></i></a>';
    }

    $linkedin_url = get_post_meta($post->ID, 'linkedin_link', true);
    if (!empty($linkedin_url)) {
        echo '<a class ="linkedin-icon" target="_blank" href="' . $linkedin_url . '"><i class="fab fa-linkedin"></i></a>';
    }

    $youtube_url = get_post_meta($post->ID, 'youtube_link', true);
    if (!empty($youtube_url)) {
        echo '<a class ="youtube-icon" target="_blank" href="' . $youtube_url . '"><i class="fab fa-youtube"></i></a>';
    }

    $skype_username = get_post_meta($post->ID, 'skype_username', true);
    if (!empty($skype_username)) {
        echo '<a class ="skype-icon" target="_blank" href="skype:' . $skype_username . '?add"><i class="fab fa-skype"></i></a>';
    }
    ?>
</div>
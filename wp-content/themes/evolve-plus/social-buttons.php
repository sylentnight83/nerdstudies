<?php global $evl_options; ?>	
<?php if ($evl_options['evl_header_social_sort'] != "") { ?>									
<ul class="sc_menu">
    <?php
    foreach ($evl_options['evl_header_social_sort'] as $key => $val) {
        if (!empty($evl_options[$key]) && $val == 1) {
            $tipsy = ($key === 'evl_rss_feed') ? 'RSS Feed' : (
                    ($key === 'evl_newsletter') ? 'Newsletter' : (
                            ($key === 'evl_facebook') ? 'Facebook' : (
                                    ($key === 'evl_twitter_id') ? 'Twitter' : (
                                            ($key === 'evl_instagram') ? 'Instagram' : (
                                                    ($key === 'evl_skype') ? 'Skype' : (
                                                            ($key === 'evl_youtube') ? 'YouTube' : (
                                                                    ($key === 'evl_flickr') ? 'Flickr' : (
                                                                            ($key === 'evl_linkedin') ? 'LinkedIn' : (
                                                                                    ($key === 'evl_googleplus') ? 'Google Plus' : (
                                                                                            ($key === 'evl_pinterest') ? 'Pinterest' : (
                                                                                                    ($key === 'evl_tumblr') ? 'Tumblr' : (
                                                                                                            ''
                                                                                                            ))))))))))));
            $social_icon = ($key === 'evl_rss_feed') ? 'rss' : (
                    ($key === 'evl_newsletter') ? 'envelope-o' : (
                            ($key === 'evl_facebook') ? 'facebook' : (
                                    ($key === 'evl_twitter_id') ? 'twitter' : (
                                            ($key === 'evl_instagram') ? 'instagram' : (
                                                    ($key === 'evl_skype') ? 'skype' : (
                                                            ($key === 'evl_youtube') ? 'youtube' : (
                                                                    ($key === 'evl_flickr') ? 'flickr' : (
                                                                            ($key === 'evl_linkedin') ? 'linkedin' : (
                                                                                    ($key === 'evl_googleplus') ? 'google-plus' : (
                                                                                            ($key === 'evl_pinterest') ? 'pinterest' : (
                                                                                                    ($key === 'evl_tumblr') ? 'tumblr' : (
                                                                                                            ''
                                                                                                            ))))))))))));

            echo '<li><a href="' . $evl_options[$key] . '" target="_blank" class="tipsytext" title="' . $tipsy . '"><i class="t4p-icon-social-' . $social_icon . '"></i></a></li>';
        }
    }
    ?>
</ul>	
<?php } ?>
<?php
/**
 * WP Custom Twitter Admin Class
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if (! class_exists('TwitterFeed')) {
    class TwitterFeed
    {
        /**
         * Capture Twitter Feeds
         *
         * This method captures Twitter feeds by connecting to the Twitter API.
         * It requires the Twitter API keys to be set in the WordPress options.
         *
         * @return mixed|array|null returns an array of Twitter feeds if successful, null otherwise
         */
        public function capture_twitter_feeds()
        {
            // Request to Include Twitter Class
            require_once dirname(__FILE__) . '/inc/twitter.class.php';

            // Get Twitter API options from WordPress options
            $twitter_api_options = get_option('twitter_api_keys');

            // Check if Twitter API is enabled
            if (! empty($twitter_api_options['enable'])) {
                // Check if Twitter hash is provided
                if (! empty($twitter_api_options['hash'])) {
                    // Instantiate the Twitter class
                    $tweets = new Twitter();

                    // Call the method to load Twitter feed
                    return $tweets->load_twitter_feed($twitter_api_options);
                }
            }

            // Return null if Twitter API is not enabled or hash is not provided
            return null;
        }
    }
}

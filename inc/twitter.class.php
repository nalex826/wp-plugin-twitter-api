<?php
/**
 * WP Custom Twitter Class
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/* Check if Class Exists. */
if (! class_exists('Twitter')) {
    class Twitter
    {
        /**
         * Load Twitter feed from API.
         *
         * @param array $twitter_api_options twitter API options
         *
         * @return array|bool|array[]|false|string|null twitter feed
         */
        public function load_twitter_feed($twitter_api_options)
        {
            // Set transient key
            $key = 'twitter_api_cache_feed';
            // Check if cached feed exists
            if (false === ($smartCache = get_transient($key))) {
                // Include TwitterAPIExchange class
                require_once 'TwitterAPIExchange.php';
                // Twitter API settings
                $settings = [
                    'oauth_access_token'        => $twitter_api_options['api_token'],
                    'oauth_access_token_secret' => $twitter_api_options['api_token_secret'],
                    'consumer_key'              => $twitter_api_options['api_key'],
                    'consumer_secret'           => $twitter_api_options['api_key_secret'],
                ];
                $url           = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
                $getfield      = '?screen_name=' . $twitter_api_options['hash'] . '&tweet_mode=extended&exclude_replies=true&count=' . $twitter_api_options['limit'];
                $requestMethod = 'GET';
                // Initialize TwitterAPIExchange object
                $twitter       = new TwitterAPIExchange($settings);
                // Perform API request
                $twfeed        = $twitter->setGetfield($getfield)
                    ->buildOauth($url, $requestMethod)
                    ->performRequest();
                // Check if Twitter feed is not empty
                if (! empty($twfeed)) {
                    // Serialize and cache Twitter feed
                    $response = serialize($twfeed);
                    set_transient($key, $response, 60 * 60 * 6);

                    return json_decode($twfeed);
                }
            } else {
                // Retrieve cached Twitter feed
                $twfeed = get_transient($key);

                return json_decode(unserialize($twfeed));
            }
        }
    }
}

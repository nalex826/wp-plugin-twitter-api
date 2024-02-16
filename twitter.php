<?php
/*
Plugin Name: Twitter Api Feeds
Description: Custom Twitter Feed
Version: 1.0
Author: Alex Nguyen
License: GPLv3
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

date_default_timezone_set('America/Los_Angeles');

require_once dirname(__FILE__) . '/inc/twitterfeed.class.php';

// Init Twitter Admin Setting
if (is_admin()) {
    require_once dirname(__FILE__) . '/inc/twitteradmin.class.php';
    $twAdmin = new TwitterAdmin();
}

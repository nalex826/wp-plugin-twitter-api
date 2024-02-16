<?php
/**
 * WP Custom Twitter Admin Class
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (! class_exists('TwitterAdmin')) {
    class TwitterAdmin
    {
        /**
         * Properties for TwitterAdmin class.
         */
        public $name;
        public $prefix;
        public $title;
        public $slug;

        /**
         * Constructor method to initialize properties and set up admin actions.
         */
        public function __construct()
        {
            $this->name   = 'twitter';
            $this->prefix = 'twitter_';
            $this->title  = 'Twitter Feed';
            $this->slug   = str_replace('_', '-', $this->name);

            if (is_admin()) {
                // Register admin actions
                add_action('admin_menu', [$this, 'twitter_add_admin_page']);
                add_action('admin_init', [$this, 'twitter_add_custom_settings']);
            }
        }

        /**
         * Add Twitter admin page.
         */
        public function twitter_add_admin_page()
        {
            add_menu_page(
                __($this->title, 'textdomain'),
                __($this->title, 'textdomain'),
                'manage_options',
                $this->slug,
                [$this, 'twitter_render_settings_page'],
                'dashicons-twitter',
                50
            );
        }

        /**
         * Add custom settings for Twitter admin page.
         */
        public function twitter_add_custom_settings()
        {
            add_settings_section(
                $this->prefix . 'settings',
                '',
                [$this, 'twitter_settings_callback'],
                $this->slug . '-api-settings'
            );
            register_setting(
                $this->prefix . 'twitter_settings',
                $this->prefix . 'api_keys'
            );
        }

        /**
         * Callback function for Twitter settings.
         */
        public function twitter_settings_callback()
        {
            settings_fields($this->prefix . 'twitter_settings');
            $this->twitter_api_settings_callback();
        }

        /**
         * Callback function for Twitter API settings.
         */
        public function twitter_api_settings_callback()
        {
            $twitter_api_options = get_option('twitter_api_keys');
            ?>
<!-- Twitter API Settings Form -->
<div id="wipe-message"></div>
<hr>
<h2>Twitter API Settings</h2>
<div class="form-wrap" style="max-width: 500px;">
  <!-- Enable Twitter -->
  <div class="form-field">
    <label style="display:inline" for="twitter_api_keys[enable]">Enable Twitter </label>
    <input name="twitter_api_keys[enable]" type="checkbox" <?php echo (isset($twitter_api_options['enable']) && $twitter_api_options['enable']) ? 'checked' : ''; ?> />
  </div>
  <!-- Twitter Hash Tag -->
  <div class="form-field">
    <label for="twitter_api_keys[hash]">Twitter Hash Tag</label>
    <input name="twitter_api_keys[hash]" type="text" value="<?php echo $twitter_api_options['hash']; ?>" />
  </div>
  <!-- Twitter API Key -->
  <div class="form-field">
    <label for="twitter_api_keys[api_key]">Twitter API Key</label>
    <input name="twitter_api_keys[api_key]" type="text" value="<?php echo $twitter_api_options['api_key']; ?>" />
  </div>
  <!-- Twitter API Secret -->
  <div class="form-field">
    <label for="twitter_api_keys[api_key_secret]">Twitter API Secret</label>
    <input name="twitter_api_keys[api_key_secret]" type="password" value="<?php echo $twitter_api_options['api_key_secret']; ?>" />
  </div>
  <!-- Twitter API Token -->
  <div class="form-field">
    <label for="twitter_api_keys[api_token]">Twitter API Token</label>
    <input name="twitter_api_keys[api_token]" type="text" value="<?php echo @$twitter_api_options['api_token']; ?>" />
  </div>
  <!-- Twitter API Token Secret -->
  <div class="form-field">
    <label for="twitter_api_keys[api_token_secret]">Twitter API Token Secret</label>
    <input name="twitter_api_keys[api_token_secret]" type="password" value="<?php echo @$twitter_api_options['api_token_secret']; ?>" />
  </div>
  <!-- Twitter Limit -->
  <div class="form-field">
    <label for="twitter_api_keys[limit]">Twitter Limit</label>
    <input name="twitter_api_keys[limit]" type="text" value="<?php echo $twitter_api_options['limit']; ?>" />
  </div>
</div>
<?php
        }

        /**
         * Render settings page for Twitter admin.
         */
        public function twitter_render_settings_page()
        {
            ?>
<div class="wrap">
  <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
  <?php settings_errors(); ?>
  <!-- Twitter Settings Form -->
  <form method="post" action="options.php">
    <?php
                    do_settings_sections($this->slug . '-api-settings');
            submit_button('Save Twitter Settings', 'primary', 'submit');
            ?>
  </form>
  <hr>
</div>
<?php
        }
    }
}

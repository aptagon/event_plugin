<?php
class Events {
    public function activate() {
        flush_rewrite_rules();
    }
    public function deactivate() {

    }
    public function uninstall() {

    }
    public function enqueue() {
        wp_enqueue_script('mypluginstyle', plugins_url('assets/style.css', __FILE__));
        wp_enqueue_script('mypluginjs', plugins_url('assets/script.js', __FILE__));
    }
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_shortcode('event_feeds', array($this, 'event_feed_shortcode'));
        add_shortcode('display_cal_events', array($this, 'display_cal_events_shortcode'));
        add_shortcode('display_term_dates', array($this, 'display_term_dates_shortcode'));
    }
    public function display_cal_events_shortcode() {
        ob_start();
        require_once(EVENT__PLUGIN_DIR.'templates/event-dis-shortcode.php');
        return ob_get_clean();
    }
    public function display_term_dates_shortcode() {
        ob_start();
        require_once(EVENT__PLUGIN_DIR.'templates/display_term_dates-shortcode.php');
        return ob_get_clean();
    }
    public function event_feed_shortcode() {
        ob_start();
        require_once(EVENT__PLUGIN_DIR.'templates/event-shortcode.php');
        return ob_get_clean();
    }
    public function add_admin_pages() {
        add_menu_page('Events Manager', 'Events Manager', 'manage_options', 'event_manager', array($this, 'admin_index'), 'dashicons-store', null);
    }
    public function admin_index() {
        require_once( EVENT__PLUGIN_DIR . 'templates/main.php' );
    }
}

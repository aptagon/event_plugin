<?php
/**
 * @package Events
 */
if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
global $wpdb;
$events = get_posts(array('post_type' => 'event_post', 'numberposts' => -1));
foreach ($events as $event) {
    wp_delete_post($event->ID, true);
}

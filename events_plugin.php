<?php
/**
 * @package Events
 */
/**
* Plugin Name:       Events Manager
* Description:       Manage events through this plugin.
* Version:           1.0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Talal Nazir
*/

define( 'EVENT_VERSION', '1.0.0' );
define( 'EVENT__MINIMUM_WP_VERSION', '5.0' );
define( 'EVENT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'EVENT_DELETE_LIMIT', 10000 );


require_once( EVENT__PLUGIN_DIR . 'class.event_plugin.php' );

if(class_exists('Events')) {
    $eventPlugin = new Events();
    $eventPlugin->register();
}
register_activation_hook(__FILE__, array ($eventPlugin, 'activate'));
register_deactivation_hook(__FILE__, array($eventPlugin, 'deactivate'));
register_uninstall_hook(__FILE__, array($eventPlugin, 'uninstall'));



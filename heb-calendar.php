<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://atarimtr.co.il
 * @since             1.0.0
 * @package           Heb_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       Hebrew Calendar
 * Plugin URI:        https://atarimtr.co.il
 * Description:       This simple ACF calendar plugin is based on Roee Yossef excellent article at
 * https://he.savvy.co.il/blog/%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A8%D7%A1/display-events-on-hebrew-calendar-wordpress/.
 * This plugin is merely porting the code from this article into a plugin. 
 * I may add some feature in the future.
 * Version:           1.0.0
 * Author:            Yehuda Tiram
 * Author URI:        http://atarimtr.co.il
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       heb-calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'HEB_CALENDAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-heb-calendar-activator.php
 */
function activate_heb_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-heb-calendar-activator.php';
	Heb_Calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-heb-calendar-deactivator.php
 */
function deactivate_heb_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-heb-calendar-deactivator.php';
	Heb_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_heb_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_heb_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-heb-calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_heb_calendar() {

	$plugin = new Heb_Calendar();
	$plugin->run();

}
run_heb_calendar();

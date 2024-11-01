<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   TUA
 * @copyright Copyright (c) 2013, Daniel Zilli
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @version   1.0.0
 */

/**
 * If uninstall, not called from WordPress, then exit
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Clean up the database.
 */
delete_option('tua_sample');
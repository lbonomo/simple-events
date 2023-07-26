<?php
/**
 * Plugin Name:     Simple Events
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     simple-events
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Simple_Events
 */

// Your code starts here.

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once 'post-types/events.php';

<?php
/**
 *  Formidable task
 *
 * @package           formidable-task
 * @author            Valerii Vasyliev
 * @license           GPL-2.0-or-later
 * @wordpress-plugin
 *
 * Plugin Name:         Formidable task
 * Description:         Formidable task
 * Version:             1.0.0
 * Requires at least:   5.9
 * Requires PHP:        7.4
 * Author:              Valerii Vasyliev
 * Author URI:          https://valera.codes/
 * License:             GPL-2.0-or-later
 * Text Domain:         formidable-task
 */

namespace FormidableTask;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

add_action( 'plugins_loaded', [ new Plugin( new API(), __FILE__ ), 'init' ] );

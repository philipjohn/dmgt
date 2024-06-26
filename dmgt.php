<?php
/**
 * Plugin Name:       DMGT Read More
 * Description:       Provides a block to show a read more link for a selected post, and a CLI command to find instances of the block in post content.
 * Requires at least: 6.5.0
 * Requires PHP:      8.0
 * Version:           0.1.0
 * Author:            Philip John
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dmgt
 *
 * @package Dmg_Read_More
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_dmgt_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_dmgt_block_init' );

// Include the CLI class. We may want to consider an autoloader if this plugin grows.
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	include_once __DIR__ . '/inc/class.dmg-read-more-cli.php';
}

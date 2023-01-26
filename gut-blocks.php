<?php
/**
 * Plugin Name:       GutBlocks
 * Description:       Useful Gutenberg Blocks
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Humberto Robles
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gut-blocks
 * Domain Path:       gutblocks
 *
 * @package           blocks
 */

 /**
 * Enqueue font-awesome
 */
 function gut_blocks_block_styles() {
	wp_enqueue_script( 'font-awesome', '//kit.fontawesome.com/03d62932bb.js', [], time(), false );

}
add_action( 'enqueue_block_assets', 'gut_blocks_block_styles' );

/**
 * Create a category for include the gut-blocks
 */
function gut_blocks_block_categories( $categories, $post ) {

	$custom_gut_blocks_category = array(
    'slug' => 'gut-blocks',
    'title' => __( 'Gut Blocks', 'gut-blocks'),
    'icon'  => 'block-default',
  );

	//Include the new category on top of the panel
	array_unshift( $categories, $custom_gut_blocks_category );

	return $categories;
}
add_action( 'block_categories_all', 'gut_blocks_block_categories', 10 , 2 );


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function blocks_gut_blocks_block_init() {

	$build_dir = __DIR__ . '/build';

	foreach( scandir( $build_dir ) as $dir ) {

		$block_location = $build_dir . '/' . $dir;

		if( !is_dir( $block_location ) || '.' === $dir || '..' === $dir ) continue;

		register_block_type( $block_location );
	}

}
add_action( 'init', 'blocks_gut_blocks_block_init' );


require_once dirname(__FILE__) . '/src/cpt/gut_blocks_custom_post_types.php'; ?>


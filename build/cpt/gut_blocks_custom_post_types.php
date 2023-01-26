<?php
/**
 * File that handles all of the CPT things.
 *
 * @package blocks
 */

/**
 * Register the custom posts types
 */
function gut_blocks_register_custom_post_types() {

  //Register the team post type
  $menu_icon_teams = file_get_contents( plugin_dir_path( __FILE__ ) . 'assets/images/team.svg' );

  $labels_teams = array (
    'name'                => _x( 'Teams', 'Post type general name', 'gut-blocks' ),
    'singular_name'       => _x( 'Team', 'Post type singular name', 'gut-blocks' ),
    'menu_name'           => _x( 'Teams', 'Admin Menu text', 'gut-blocks' ),
    'name_admin_bar'      => _x( 'Team', 'Add New on Toolbar', 'gut-blocks' ),
    'add_new'             => _x( 'Add New', 'team', 'gut-blocks' ),
    'add_new_item'        => _x( 'Add New Team', 'team', 'gut-blocks' ),
    'new_item'            => __( 'New Team', 'gut-blocks' ),
    'edit_item'           => __( 'Edit Team', 'gut-blocks' ),
    'view_item'           => __( 'View Team', 'gut-blocks' ),
    'all_items'           => __( 'All Team', 'gut-blocks' ),
    'search_items'        => __( 'Search Teams', 'gut-blocks' ),
    'not_found_in_trash'  => __( 'Not found team in trash', 'gut-blocks' ),
    'not_found'           => __( 'Not found team', 'gut-blocks' ),
    'all_items'           => __( 'All teams', 'gut-blocks' ),
    'archives'            => __( 'Team Attributes', 'gut-blocks' )
  );

  $args_teams = array (
    'labels'          => $labels_teams,
    'description'     => __( 'Team Custom Post Type', 'gut-blocks' ),
    'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'teams' ),
    'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'author' ),
    'show_in_rest'       => true,
		'menu_icon'          => 'data:image/svg+xml;base64,' . base64_encode( $menu_icon_teams ),
  );

  register_post_type( 'team', $args_teams );

  register_post_meta( 'team', 'team_role', array(
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
  ) );

}
add_action( 'init', 'gut_blocks_register_custom_post_types' );
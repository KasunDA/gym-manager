<?php
/**
 * Plugin Name:     Gym Manager
 * Plugin URI:      https://pbwebdev.com/gym-manager
 * Description:     Integrated gym membership and workouts and tracking program
 * Author:          Peter Bui
 * Author URI:      https://pbwebdev.com
 * Text Domain:     gym-manager
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package         Gym_Manager
 */

function class_schedule_post() {
	register_post_type( 'class_schedule',
		array(
			'labels'       => array(
				'name'       => __( 'Class Schedule' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'menu_icon'   => 'dashicons-media-spreadsheet',
			'has_archive'  => true,
			'supports'     => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
			),
			'taxonomies'   => array(
				'post_tag',
				'category',
			)
		)
	);
	register_taxonomy_for_object_type( 'category', 'class_schedule' );
	register_taxonomy_for_object_type( 'post_tag', 'class_schedule' );
}


function workout_post_type() {
	register_post_type( 'workout',
		array(
			'labels'       => array(
				'name'       => __( 'Workouts' ),
			),
			'public'       => true,
			'menu_icon'   => 'dashicons-clipboard',
			'hierarchical' => true,
			'has_archive'  => true,
			'supports'     => array(
				'title',
				'editor',
			),
			'taxonomies'   => array(
				'post_tag',
				'category',
			)
		)
	);
	register_taxonomy_for_object_type( 'category', 'workout' );
}

add_action( 'init', 'class_schedule_post' );
add_action( 'init', 'workout_post_type' );



/**
 * Add a new role cloning capabilities from editor and flush rewrite rules
 */
function install_member_plugin() {
	$editor = get_role( 'editor' );
	add_role( 'member', 'member', $editor->capabilities );
	member_plugin_endpoint();
	flush_rewrite_rules();
}

/**
 * Remove the role and flush rewrite rules
 */
function unistall_member_plugin() {
	remove_role( 'member' );
	flush_rewrite_rules();
}

/**
 * Add the endpoint
 */
function member_plugin_endpoint() {
	add_rewrite_endpoint( 'user', EP_PAGES );
}

/**
 * Add custom field to profile page
 */
function member_plugin_profile_fields( $user ) {
	$fields = array(
		'mobile' => __('Mobile'),
		'facebook'  => __('Facebook'),
		'instagram'  => __('instagram')
	);
	echo '<h3>' . __('Member Contact Details') . '</h3>';
	echo '<table class="form-table">';
	foreach ( $fields as $field => $label ) {
		$now = get_user_meta( $user->ID, $field, true ) ? : "";
		printf( '<tr><th><label for="%s">%s</label></th>',
			esc_attr($field), esc_html($label) );
		printf( '<td><input type="text" name="%s" id="%s" value="%s" class="regular-text" /><br /></td></tr>',
			esc_attr($field), esc_attr($field), esc_attr($now) );
	}
	echo '</table>';
}

/**
 * Save the custom fields
 */
function member_plugin_profile_fields_save( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) return;
	$fields = array( 'facebook', 'twitter', 'instagram' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[$field] ) )
			update_user_meta( $user_id, $field, $_POST[$field] );
	}
}

add_action( 'init', 'member_plugin_endpoint' );
add_action( 'show_user_profile', 'member_plugin_profile_fields' );
add_action( 'edit_user_profile', 'member_plugin_profile_fields' );
add_action( 'personal_options_update', 'member_plugin_profile_fields_save' );
add_action( 'edit_user_profile_update', 'member_plugin_profile_fields_save' );

register_activation_hook( __FILE__, 'install_member_plugin' );
register_deactivation_hook( __FILE__, 'unistall_member_plugin' );
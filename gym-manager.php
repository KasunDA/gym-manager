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

// Your code starts here.

function class_schedule_post() {
	register_post_type( 'class_schedule',
		array(
			'labels'       => array(
				'name'       => __( 'Class Schedule' ),
			),
			'public'       => true,
			'hierarchical' => true,
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
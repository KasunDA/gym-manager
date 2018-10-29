<?php

/**
 * Setup custom posts and taxonomies
 *
 * @package gym manager
 * @since 0.1.0
 */


class GymManager_CPT
{


	public function class_schedule_post()
	{
		register_post_type('class_schedule',
			array(
				'labels' => array(
					'name' => __('Class Schedule'),
				),
				'public' => true,
				'hierarchical' => true,
				'has_archive' => true,
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
				'taxonomies' => array(
					'post_tag',
					'category',
				)
			)
		);
		register_taxonomy_for_object_type('category', 'class_schedule');
		register_taxonomy_for_object_type('post_tag', 'class_schedule');
	}


	public function workout_post_type()
	{
		register_post_type('workout',
			array(
				'labels' => array(
					'name' => __('Workouts'),
				),
				'public' => true,
				'hierarchical' => true,
				'has_archive' => true,
				'supports' => array(
					'title',
					'editor',
				),
				'taxonomies' => array(
					'post_tag',
					'category',
				)
			)
		);
		register_taxonomy_for_object_type('category', 'workout');
	}

}
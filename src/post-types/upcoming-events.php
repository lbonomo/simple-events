<?php

/**
 * Registers the `upcoming_events` post type.
 */
function upcoming_events_init() {
	register_post_type(
		'upcoming-events',
		[
			'labels'                => [
				'name'                  => __( 'Upcoming events', 'simple-events' ),
				'singular_name'         => __( 'Upcoming events', 'simple-events' ),
				'all_items'             => __( 'All Upcoming events', 'simple-events' ),
				'archives'              => __( 'Upcoming events Archives', 'simple-events' ),
				'attributes'            => __( 'Upcoming events Attributes', 'simple-events' ),
				'insert_into_item'      => __( 'Insert into upcoming events', 'simple-events' ),
				'uploaded_to_this_item' => __( 'Uploaded to this upcoming events', 'simple-events' ),
				'featured_image'        => _x( 'Featured Image', 'upcoming-events', 'simple-events' ),
				'set_featured_image'    => _x( 'Set featured image', 'upcoming-events', 'simple-events' ),
				'remove_featured_image' => _x( 'Remove featured image', 'upcoming-events', 'simple-events' ),
				'use_featured_image'    => _x( 'Use as featured image', 'upcoming-events', 'simple-events' ),
				'filter_items_list'     => __( 'Filter upcoming events list', 'simple-events' ),
				'items_list_navigation' => __( 'Upcoming events list navigation', 'simple-events' ),
				'items_list'            => __( 'Upcoming events list', 'simple-events' ),
				'new_item'              => __( 'New Upcoming events', 'simple-events' ),
				'add_new'               => __( 'Add New', 'simple-events' ),
				'add_new_item'          => __( 'Add New Upcoming events', 'simple-events' ),
				'edit_item'             => __( 'Edit Upcoming events', 'simple-events' ),
				'view_item'             => __( 'View Upcoming events', 'simple-events' ),
				'view_items'            => __( 'View Upcoming events', 'simple-events' ),
				'search_items'          => __( 'Search upcoming events', 'simple-events' ),
				'not_found'             => __( 'No upcoming events found', 'simple-events' ),
				'not_found_in_trash'    => __( 'No upcoming events found in trash', 'simple-events' ),
				'parent_item_colon'     => __( 'Parent Upcoming events:', 'simple-events' ),
				'menu_name'             => __( 'Upcoming events', 'simple-events' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'upcoming-events',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'upcoming_events_init' );

/**
 * Sets the post updated messages for the `upcoming_events` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `upcoming_events` post type.
 */
function upcoming_events_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['upcoming-events'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Upcoming events updated. <a target="_blank" href="%s">View upcoming events</a>', 'simple-events' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'simple-events' ),
		3  => __( 'Custom field deleted.', 'simple-events' ),
		4  => __( 'Upcoming events updated.', 'simple-events' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Upcoming events restored to revision from %s', 'simple-events' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Upcoming events published. <a href="%s">View upcoming events</a>', 'simple-events' ), esc_url( $permalink ) ),
		7  => __( 'Upcoming events saved.', 'simple-events' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Upcoming events submitted. <a target="_blank" href="%s">Preview upcoming events</a>', 'simple-events' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Upcoming events scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview upcoming events</a>', 'simple-events' ), date_i18n( __( 'M j, Y @ G:i', 'simple-events' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Upcoming events draft updated. <a target="_blank" href="%s">Preview upcoming events</a>', 'simple-events' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'upcoming_events_updated_messages' );

/**
 * Sets the bulk post updated messages for the `upcoming_events` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `upcoming_events` post type.
 */
function upcoming_events_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['upcoming-events'] = [
		/* translators: %s: Number of upcoming events. */
		'updated'   => _n( '%s upcoming events updated.', '%s upcoming events updated.', $bulk_counts['updated'], 'simple-events' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 upcoming events not updated, somebody is editing it.', 'simple-events' ) :
						/* translators: %s: Number of upcoming events. */
						_n( '%s upcoming events not updated, somebody is editing it.', '%s upcoming events not updated, somebody is editing them.', $bulk_counts['locked'], 'simple-events' ),
		/* translators: %s: Number of upcoming events. */
		'deleted'   => _n( '%s upcoming events permanently deleted.', '%s upcoming events permanently deleted.', $bulk_counts['deleted'], 'simple-events' ),
		/* translators: %s: Number of upcoming events. */
		'trashed'   => _n( '%s upcoming events moved to the Trash.', '%s upcoming events moved to the Trash.', $bulk_counts['trashed'], 'simple-events' ),
		/* translators: %s: Number of upcoming events. */
		'untrashed' => _n( '%s upcoming events restored from the Trash.', '%s upcoming events restored from the Trash.', $bulk_counts['untrashed'], 'simple-events' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'upcoming_events_bulk_updated_messages', 10, 2 );

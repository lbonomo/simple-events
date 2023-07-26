<?php 

/**
 * Registers the `events` post type.
 */
function events_init() {
	register_post_type(
		'events',
		[
			'labels'                => [
				'name'                  => __( 'Events', 'simple-events' ),
				'singular_name'         => __( 'Events', 'simple-events' ),
				'all_items'             => __( 'All Events', 'simple-events' ),
				'archives'              => __( 'Events Archives', 'simple-events' ),
				'attributes'            => __( 'Events Attributes', 'simple-events' ),
				'insert_into_item'      => __( 'Insert into Events', 'simple-events' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Events', 'simple-events' ),
				'featured_image'        => _x( 'Featured Image', 'events', 'simple-events' ),
				'set_featured_image'    => _x( 'Set featured image', 'events', 'simple-events' ),
				'remove_featured_image' => _x( 'Remove featured image', 'events', 'simple-events' ),
				'use_featured_image'    => _x( 'Use as featured image', 'events', 'simple-events' ),
				'filter_items_list'     => __( 'Filter Events list', 'simple-events' ),
				'items_list_navigation' => __( 'Events list navigation', 'simple-events' ),
				'items_list'            => __( 'Events list', 'simple-events' ),
				'new_item'              => __( 'New Events', 'simple-events' ),
				'add_new'               => __( 'Add New', 'simple-events' ),
				'add_new_item'          => __( 'Add New Events', 'simple-events' ),
				'edit_item'             => __( 'Edit Events', 'simple-events' ),
				'view_item'             => __( 'View Events', 'simple-events' ),
				'view_items'            => __( 'View Events', 'simple-events' ),
				'search_items'          => __( 'Search Events', 'simple-events' ),
				'not_found'             => __( 'No Events found', 'simple-events' ),
				'not_found_in_trash'    => __( 'No Events found in trash', 'simple-events' ),
				'parent_item_colon'     => __( 'Parent Events:', 'simple-events' ),
				'menu_name'             => __( 'Events', 'simple-events' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-calendar',
			'show_in_rest'          => true,
			'rest_base'             => 'events',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'events_init' );

/**
 * Sets the post updated messages for the `events` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `events` post type.
 */
function events_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['events'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Events updated. <a target="_blank" href="%s">View Events</a>', 'simple-events' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'simple-events' ),
		3  => __( 'Custom field deleted.', 'simple-events' ),
		4  => __( 'Events updated.', 'simple-events' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Events restored to revision from %s', 'simple-events' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Events published. <a href="%s">View Events</a>', 'simple-events' ), esc_url( $permalink ) ),
		7  => __( 'Events saved.', 'simple-events' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Events submitted. <a target="_blank" href="%s">Preview Events</a>', 'simple-events' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Events scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Events</a>', 'simple-events' ), date_i18n( __( 'M j, Y @ G:i', 'simple-events' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Events draft updated. <a target="_blank" href="%s">Preview Events</a>', 'simple-events' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'events_updated_messages' );

/**
 * Sets the bulk post updated messages for the `events` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `events` post type.
 */
function events_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['events'] = [
		/* translators: %s: Number of Events. */
		'updated'   => _n( '%s Events updated.', '%s Events updated.', $bulk_counts['updated'], 'simple-events' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Events not updated, somebody is editing it.', 'simple-events' ) :
						/* translators: %s: Number of Events. */
						_n( '%s Events not updated, somebody is editing it.', '%s Events not updated, somebody is editing them.', $bulk_counts['locked'], 'simple-events' ),
		/* translators: %s: Number of Events. */
		'deleted'   => _n( '%s Events permanently deleted.', '%s Events permanently deleted.', $bulk_counts['deleted'], 'simple-events' ),
		/* translators: %s: Number of Events. */
		'trashed'   => _n( '%s Events moved to the Trash.', '%s Events moved to the Trash.', $bulk_counts['trashed'], 'simple-events' ),
		/* translators: %s: Number of Events. */
		'untrashed' => _n( '%s Events restored from the Trash.', '%s Events restored from the Trash.', $bulk_counts['untrashed'], 'simple-events' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'events_bulk_updated_messages', 10, 2 );


add_action( 'add_meta_boxes', 'register_metabox' );

function register_metabox() { add_meta_box(
	'review-meta-box-id', // ID.
	'Review data', // Title.
	'render_metabox_content', 	// callback.
	'events', // screen - CTP Name.
	'normal', // dónde queremos que se muestre nuestro metabox [side/advanced/normal].
	'low', // priority [default/high/low].
	null, // callback_args.
);
}

/**
 * Metabox callback
 */
function render_metabox_content( $post ) {
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'review_custom_box', 'review_custom_box_nonce' );
	// Use get_post_meta to retrieve an existing value from the database.

	$review_name  = get_post_meta( $post->ID, 'review_name', true );
	$review_link  = get_post_meta( $post->ID, 'review_link', true );
	$review_order = get_post_meta( $post->ID, 'review_order', true );

	include( "metabox.html" );

}
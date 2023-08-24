<?php 

/**
 * Class for registering a new settings page under Settings.
 */
class Event_Options_Page {

	/**
	 * Constructor.
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'evenets_setting' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Registers a new options page under menu Settings -> Events.
	 */
	function admin_menu() {
		add_options_page( 
			'Global events settings',        // page_title
			'Events',                        // menu_title
			'manage_options',                // capability
			'events-settings',               // menu_slug
			array( $this, 'settings_page' ), // callback
			null                             // position
		);
	}

	/**
	 * Event setting page.
	 */
	function evenets_setting() {

		/**** Section ****/
		add_settings_section(
			'events-settings-section',                         // id
			'Events general settings',                         // title
			array( $this, 'event_settings_section_callback' ), // callback
			'events-settings',                                 // page (menu_slug)
			null                                               // args
		);
		
		/**** Settings fields ****/
		$inputs = array(
			'event_address_street'       => 'Street',
			'event_address_locality'     => 'Locality',
			'event_address_postal_code'  => 'ZIP Code',
			'event_address_region'       => 'Region',
			'event_address_country'      => 'Country',
			'event_offers_priceCurrency' => 'Currency',
		);
		
		foreach ($inputs as $id => $title) {

			register_setting( 'events-settings', $id, null );
			
			add_settings_field(
				$id,
				$title,
				array( $this, 'input_callback' ),
				'events-settings',
				'events-settings-section',
				array(
					'label_for'   => $id,
					'class'       => 'regular-text',
					'type'        => 'text',
				)
			);
		}
		

	}

	/*** Callbacks. ***/

	/**
	 * Settings page display callback.
	 */
	public function settings_page() {
		// Verifico permisos.
		if ( current_user_can( 'manage_options' ) ) {
			echo '<form action="options.php" method="post">';
			do_settings_sections( 'events-settings' );
			submit_button( 'Save Changes' );
			echo '</form>';
		}
	}
	
	/**
	 * Section callback.
	 */
	public function event_settings_section_callback() {
		settings_fields( 'events-settings' );
	}

	/**
	 * HTML input.
	 *
	 *  @param array $args Settings values.
	 */
	public function input_callback( $args ) {
		$value       = get_option( $args['label_for'] );
		$value       = isset( $value ) ? esc_attr( $value ) : '';
		$name        = $args['label_for'];
		$type        = $args['type'];
		$description = $args['description'];
		$class       = $args['class'];
		$html        = "<input name='$name' type='$type' value='$value' class='$class'>";
		if ( null !== $description ) {
			$html .= "<p class='description'>$description</p>"; }

		// Just available a textarea.
		$allowed_html = array(
			'input' => array(
				'name'  => array(),
				'value' => array(),
				'type'  => array(),
				'class' => array(),
			),
			'p' => array(
				'class' => array()
			)
		);
		echo wp_kses( $html, $allowed_html );
	}
}

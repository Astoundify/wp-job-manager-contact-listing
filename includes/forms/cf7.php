<?php
/**
 * Contact Form 7 support.
 *
 * @since WP Job Manager - Contact Listing 1.0.0
 *
 * @return void
 */
class Astoundify_Job_Manager_Contact_Listing_Form_CF7 extends Astoundify_Job_Manager_Contact_Listing_Form {

	/**
	 * Load the base form class.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Hook into processing and attach our own things.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function setup_actions() {
		add_filter( 'wpcf7_mail_components', array( $this, 'notification_email' ), 10, 2 );
	}

	/**
	 * Set the notification email when sending an email.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return string The email to notify.
	 */
	public function notification_email( $components, $cf7 ) {
		if ( $cf7->id !== absint( $this->jobs_form_id ) && $cf7->id !== absint( $this->resumes_form_id ) ) {
			return $components;
		}

		$unit = $cf7->posted_data[ '_wpcf7_unit_tag' ];

		if ( ! preg_match( '/^wpcf7-f(\d+)-p(\d+)-o(\d+)$/', $unit, $matches ) )
			return $components;

		$post_id = (int) $matches[2];

		$listing = get_post( $post_id );

		$components[ 'recipient' ] = $cf7->id == $this->jobs_form_id ? $listing->_application : $listing->_candidate_email;

		return $components;
	}

	/**
	 * Get all forms and return in a simple array for output.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function get_forms() {
		$forms  = array( 0 => __( 'Please select a form', 'wp-job-manager-contact-listing' ) );

		$_forms = get_posts(
			array(
				'numberposts' => -1,
				'post_type'   => 'wpcf7_contact_form',
			)
		);

		if ( ! empty( $_forms ) ) {

			foreach ( $_forms as $_form ) {
				$forms[ $_form->ID ] = $_form->post_title;
			}
		}

		return $forms;
	}

}
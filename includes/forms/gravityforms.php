<?php
/**
 * Gravity Forms support.
 *
 * @since WP Job Manager - Contact Listing 1.0.0
 *
 * @return void
 */
class Astoundify_Job_Manager_Contact_Listing_Form_GravityForms extends Astoundify_Job_Manager_Contact_Listing_Form {

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

	public function setup_actions() {
		add_action( 'job_manager_contact_listing_form_gravityforms', array( $this, 'output_form' ) );

		add_filter( 'gform_field_value_application_email', array( $this, 'application_email' ) );

		add_filter( 'gform_notification_' . $this->jobs_form_id, array( $this, 'notification_email' ), 10, 3 );
		add_filter( 'gform_notification_' . $this->resumes_form_id, array( $this, 'notification_email' ), 10, 3 );
	}

	/**
	 * Output the shortcode.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function output_form( $form ) {
		$args = apply_filters( 'job_manager_contact_listing_gravityforms_apply_form_args', 'title="false" description="false" ajax="true"' );

		echo do_shortcode( sprintf( '[gravityform id="%s" %s]', $form, $args ) );
	}

	/**
	 * Dynamically populate the application email field.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return string The email to notify.
	 */
	public function application_email() {
		global $post;

		if ( $post->_application ) {
			return $post->_application;
		} else {
			return $post->_candidate_email;
		}
	}

	/**
	 * Set the notification email when sending an email.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return string The email to notify.
	 */
	public function notification_email( $notification, $form, $entry ) {
		$notification[ 'toType' ] = 'email';

		$field  = null;
		$fields = $form[ 'fields' ];

		if ( 'dummy@dummy.com' != $notification[ 'to' ] ) {
			return $notification;
		}

		foreach ( $fields as $check ) {
			if ( $check[ 'inputName' ] == 'application_email' ) {
				$field = $check[ 'id' ];
			}
		}

		$notification[ 'to' ] = $entry[ $field ];

		return $notification;
	}

	/**
	 * Get all forms and return in a simple array for output.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function get_forms() {
		$forms = array( 0 => __( 'Please select a form', 'wp-job-manager-contact-listing' ) );

		$_forms = RGFormsModel::get_forms( null, 'title' );

		if ( ! empty( $_forms ) ) {
			foreach ( $_forms as $_form ) {
				$forms[ $_form->id ] = $_form->title;
			}
		}

		return $forms;
	}

}
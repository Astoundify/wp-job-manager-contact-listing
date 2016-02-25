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
		add_filter( 'gform_notification', array( $this, 'notification_email' ), 10, 3 );
	}

	/**
	 * Output the shortcode.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function output_form($form) {
		$args = apply_filters( 'job_manager_contact_listing_gravityforms_apply_form_args', 'title="false" description="false" ajax="true"' );

		echo do_shortcode( sprintf( '[gravityform id="%s" %s]', $form, $args ) );
	}

	/**
	 * Set the notification email when sending an email.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return string The email to notify.
	 */
	public function notification_email( $notification, $form, $entry ) {
		if ( 'no-reply@listingowner.com' != $notification[ 'to' ] ) {
			return $notification;
		}

		$notification[ 'toType' ] = 'email';

		$listing_ID = false;
		$fields  = $form[ 'fields' ];

		foreach ( $fields as $check ) {
			if ( $check[ 'label' ] == 'Listing ID' ) {
				if ( isset( $entry[ $check[ 'id' ] ] ) ) {
					$listing_ID = $entry[ $check['id'] ];
				}
			}
		}

		$object = get_post( $listing_ID );

		if ( ! isset( $this->forms[ $object->post_type ] ) ) {
			return;
		}

		if ( ! array_search( $form[ 'id' ], $this->forms[ $object->post_type ] ) ) {
			return;
		}

		$to = $object->_application ? $object->_application : $object->_candidate_email;

		//if we couldn't find the email by now, get it from the listing owner/author
		if ( empty( $to ) ) {

			//just get the email of the listing author
			$owner_ID = $object->post_author;

			//retrieve the owner user data to get the email
			$owner_info = get_userdata( $owner_ID );

			if ( false !== $owner_info ) {
				$to = $owner_info->user_email;
			}
		}

		$notification[ 'to' ] = $to;

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

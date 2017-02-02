<?php
/**
 * Ninja Forms support.
 *
 * @since WP Job Manager - Contact Listing 1.0.0
 *
 * @return void
 */
class Astoundify_Job_Manager_Contact_Listing_Form_NinjaForms extends Astoundify_Job_Manager_Contact_Listing_Form {

	/**
	 * Pre THREE release.
	 * @access protected
	 */
	public $is_pre_three;

	/**
	 * Load the base form class.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->is_pre_three = version_compare( get_option( 'ninja_forms_version', '0.0.0' ), '3', '<' ) || get_option( 'ninja_forms_load_deprecated', false );

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
		add_action( 'job_manager_contact_listing_form_ninjaforms', array( $this, 'output_form' ) );
		add_filter( 'nf_email_notification_process_setting', array( $this, 'notification_email' ), 10, 3 );

		if ( ! $this->is_pre_three ) {
			Ninja_forms()->merge_tags[ 'wp-job-manager' ] = new Astoundify_NF_MergeTags_WPJobManager();
		}
	}

	/**
	 * Output the shortcode.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function output_form($form) {
		$args = apply_filters( 'job_manager_contact_listing_ninjaforms_apply_form_args', '' );

		if ( $this->is_pre_three ) {
			echo do_shortcode( sprintf( '[ninja_forms_display_form id="%s" %s]', $form, $args ) );
		} else {
			echo do_shortcode( sprintf( '[ninja_forms id="%s" %s]', $form, $args ) );
		}
	}

	/**
	 * Set the notification email when sending an email.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return string The email to notify.
	 */
	public function notification_email( $setting, $setting_name, $id ) {
		if ( 'to' != $setting_name ) {
			return $setting;
		}

		$fake = array_search( 'no-reply@listingowner.com', $setting );

		if ( false === $fake ) {
			return $setting;
		}

		global $ninja_forms_processing;

		$form_id = $ninja_forms_processing->get_form_ID();

		$object = $field_id = null;
		$fields = $ninja_forms_processing;

		foreach ( $fields->data[ 'field_data' ] as $field ) {
			if ( 'Listing ID' == $field[ 'data' ][ 'label' ] ) {
				$field_id = $field[ 'id' ];

				break;
			}
		}

		$listing_ID = $ninja_forms_processing->get_field_value( $field_id );

		$object = get_post( $listing_ID );

		if ( ! is_a( $object, 'WP_Post' ) ) {
			return $setting;
		}

		if ( ! array_search( $form_id, $this->forms[ $object->post_type ] ) ) {
			return $setting;
		}

		$setting[ $fake ] = $object->_application ? $object->_application : $object->_candidate_email;

		//if we couldn't find the email by now, get it from the listing owner/author
		if ( empty( $setting[ $fake ] ) ) {

			//just get the email of the listing author
			$owner_ID = $object->post_author;

			//retrieve the owner user data to get the email
			$owner_info = get_userdata( $owner_ID );

			if ( false !== $owner_info ) {
				$setting[ $fake ] = $owner_info->user_email;
			}
		}

		return $setting;
	}

	/**
	 * Get all forms and return in a simple array for output.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function get_forms() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			return;
		}
		$forms  = array( 0 => __( 'Please select a form', 'wp-job-manager-contact-listing' ) );
		$_forms = array();

		if ( $this->is_pre_three ) {
			$f = Ninja_Forms()->forms()->get_all();
			$x = 0;

			foreach ( $f as $form_id ) {
				$_forms[] = array(
					'id' => $form_id,
					'title' => Ninja_Forms()->form( $form_id )->get_setting( 'form_title' )
				);
			}
		} else {
			$f = Ninja_Forms()->form()->get_forms();

			foreach ( $f as $form ) {
				$_forms[] = array(
					'id' => $form->get_id(),
					'title' => $form->get_setting( 'title' )
				);
			}
		}

		if ( ! empty( $_forms ) ) {

			foreach ( $_forms as $_form ) {
				$forms[ $_form[ 'id' ] ] = $_form[ 'title' ];
			}

		}

		return $forms;
	}

}

if ( class_exists( 'NF_Abstracts_MergeTags' ) ) :
/**
 * Custom merge tag for Ninja Forms THREE.
 *
 * Simply create a hidden field with {contact-email} tag and use
 * the value of that field to send the email to.
 *
 * @since 1.3.0
 */
class Astoundify_NF_MergeTags_WPJobManager extends NF_Abstracts_MergeTags {

    protected $id = 'wp-job-manager';

    public function __construct() {
        parent::__construct();

        $this->title = __( 'WP Job Manager', 'wp-job-manager-contact-listing' );

		$this->merge_tags = array(
			'email' => array(
				'id' => 'email',
				'tag' => '{contact-email}',
				'label' => __( 'Contact Email', 'wp-job-manager-contact-listing' ),
				'callback' => 'contact_email'
			)
		);
    }

    protected function contact_email() {
		$post = get_post();

		// try the wp job manager fields
		$contact = $post->_application ? $post->_application : $post->_candidate_email;

		// use listing owner data
		if ( ! $contact ) {
			$owner_info = get_userdata( $post->post_author );

			if ( false !== $owner_info ) {
				$contact = $owner_info->user_email;
			}
		}

        return $contact;
    }
}
endif;
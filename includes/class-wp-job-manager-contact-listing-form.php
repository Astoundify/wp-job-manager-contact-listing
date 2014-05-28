<?php
/**
 * Base form class. Grab the form values, add settings, and
 * output the correct form.
 *
 * @since WP Job Manager - Contact Listing 1.0.0
 *
 * @return void
 */
abstract class Astoundify_Job_Manager_Contact_Listing_Form extends Astoundify_Job_Manager_Contact_Listing {

	/**
	 * @var $jobs_form_id
	 */
	public $jobs_form_id;

	/**
	 * @var $resumes_form_id
	 */
	public $resumes_form_id;

	/**
	 * Form-specific methods
	 */
	abstract protected function setup_actions();
	abstract protected function get_forms();
	abstract protected function output_form( $form );
	abstract protected function notification_email();

	/**
	 * Set the form values, remove the default application template
	 * and attach our own. Call and of the children's special actions.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		global $job_manager;

		$this->jobs_form_id    = get_option( 'job_manager_job_apply', false );
		$this->resumes_form_id = get_option( 'job_manager_resume_apply', false );

		add_filter( 'job_manager_settings', array( $this, 'job_manager_settings' ) );

		if ( ! parent::$active_plugin || ! ( $this->jobs_form_id || $this->resumes_form_id ) ) {
			return;
		}

		$this->setup_actions();

		// Shim for Jobify until 1.8.1
		add_filter( 'jobify_apply_via_form', '__return_false' );

		// Output the shortcode
		remove_action( 'job_manager_application_details_email', array( $job_manager->post_types, 'application_details_email' ) );
		add_action( 'job_manager_application_details_email', array( $this, 'job_manager_application_details_email' ) );
	}

	/**
	 * Add settings fields to select the appropriate form for each listing type.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function job_manager_settings($settings) {
		$settings[ 'job_listings' ][1][] = array(
			'name'    => 'job_manager_job_apply',
			'std'     => null,
			'label'   => __( 'Jobs Contact Form', 'wp-job-manager-gf-apply' ),
			'desc'    => __( 'Choose a form to contact the listing author.', 'wp-job-manager-contact-listing' ),
			'type'    => 'select',
			'options' => $this->get_forms()
		);

		if ( class_exists( 'WP_Resume_Manager' ) ) {
			$settings[ 'job_listings' ][1][] = array(
				'name'    => 'job_manager_resume_apply',
				'std'     => null,
				'label'   => __( 'Resumes Contact Form', 'wp-job-manager-gf-apply' ),
				'desc'    => __( 'Choose a form to contact the listing author.', 'wp-job-manager-gf-apply' ),
				'type'    => 'select',
				'options' => $this->get_forms()
			);
		}

		return $settings;
	}

	/**
	 * Output the necessary form shortocde.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function job_manager_application_details_email( $apply ) {
		$plugin = parent::$active_plugin;
		$post   = get_post();

		if ( 'resume' == $post->post_type ) {
			$form = $this->jobs_form_id;
		} else {
			$form = $this->resumes_form_id;
		}

		do_action( 'job_manager_contact_listing_form_' . $plugin, $form );
	}

}
<?php
/**
 * Base form class. Grab the form values, add settings, and
 * output the correct form.
 *
 * @since WP Job Manager - Contact Listing 1.0.0
 *
 * @return void
 */
class Astoundify_Job_Manager_Contact_Listing_Form extends Astoundify_Job_Manager_Contact_Listing {

	/**
	 * @var $jobs_form_id
	 */
	public $forms;

	/**
	 * Set the form values, remove the default application template
	 * and attach our own. Call and of the children's special actions.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		if ( ! class_exists( 'WP_Job_Manager' ) ) {
			return;
		}

		global $job_manager;

		$this->forms = apply_filters( 'job_manager_contact_listing_forms', array(
			'job_listing' => array(
				'contact' => get_option( 'job_manager_form_contact', false )
			),
			'resume' => array(
				'contact' => get_option( 'resume_manager_form_contact', false )
			)
		) );

		add_filter( 'job_manager_settings', array( $this, 'job_manager_settings' ) );
		add_filter( 'resume_manager_settings', array( $this, 'resume_manager_settings' ) );

		if ( ! parent::$active_plugin ) {
			return;
		}

		$this->setup_actions();

		// Output the shortcode


		if ( ! get_option( 'resume_manager_force_application' ) ) {
			add_action( 'job_manager_application_details_email', array( $this, 'job_manager_application_details_email' ), 5 );
		}

		if ( class_exists( 'WP_Resume_Manager' ) ) {
			global $resume_manager;

			remove_action( 'resume_manager_contact_details', array( $resume_manager->post_types, 'contact_details_email' ) );
			add_action( 'resume_manager_contact_details', array( $this, 'job_manager_application_details_email' ) );
		}
	}

	/**
	 * Add settings fields to select the appropriate form for each listing type.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function job_manager_settings($settings) {
		$args = array(
			'post_type' => 'job_listing',
			'key' => 'job_listings',
			'option' => 'job_manager'
		);

		$settings = $this->add_settings( $args, $settings );

		return $settings;
	}

	/**
	 * Add settings fields to select the appropriate form for each listing type.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function resume_manager_settings($settings) {
		$args = array(
			'post_type' => 'resume',
			'key' => 'resume_listings',
			'option' => 'resume_manager'
		);

		$settings = $this->add_settings( $args, $settings );

		return $settings;
	}

	private function add_settings( $args, $settings ) {
		$post_type = $args[ 'post_type' ];
		$forms = $this->forms[ $post_type ];

		$p_type_obj = get_post_type_object( $post_type );

		/* Bail. */
		if( ! $p_type_obj ){
			return $settings;
		}

		foreach ( $forms as $key => $value ) {
			$settings[ $args[ 'key' ] ][1][] = array(
				'name'    => sprintf( '%s_form_%s', $args[ 'option' ], $key ),
				'std'     => null,
				'label'   => sprintf( __( '%s a %s Form', 'wp-job-manager-contact-listing' ), ucfirst( $key ), $p_type_obj->labels->singular_name ),
				'desc'    => '',
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
		global $job_manager;

		$plugin = parent::$active_plugin;
		$post   = get_post();

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return;
		}

		$form = isset( $this->forms[ $post->post_type ][ 'contact' ] ) ? $this->forms[ $post->post_type ][ 'contact' ] : false;

		if ( ! $form ) {
			return;
		}

		// Only remove the default text when contact form is set.
		remove_action( 'job_manager_application_details_email', array( $job_manager->post_types, 'application_details_email' ) );

		// Add contact form content
		do_action( 'job_manager_contact_listing_form_' . $plugin, $form );
	}

}

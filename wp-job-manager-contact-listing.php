<?php
/**
 * Plugin Name: WP Job Manager - Contact Listing
 * Plugin URI:  http://wordpress.org/plugins/wp-job-manager-contact-listing/
 * Description: Contact job listings or resume listings with your choice of Gravity Forms, Ninja Forms, or Contact Form 7
 * Author:      Astoundify
 * Author URI:  http://astoundify.com
 * Version:     1.0.5
 * Text Domain: wp-job-manager-contact-listing
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Astoundify_Job_Manager_Contact_Listing {

	/**
	 * @var $instance
	 */
	private static $instance;

	/**
	 * @var $active_plugin;
	 */
	public static $active_plugin;

	/**
	 * Make sure only one instance is only running.
	 */
	public static function instance() {
		if ( ! isset ( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Start things up.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 */
	public function __construct() {
		$this->setup_globals();
		$this->load_textdomain();

		$this->find_plugin();
	}

	/**
	 * Set some smart defaults to class variables. Allow some of them to be
	 * filtered to allow for early overriding.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	private function setup_globals() {
		$this->file         = __FILE__;

		$this->basename     = plugin_basename( $this->file );
		$this->plugin_dir   = plugin_dir_path( $this->file );
		$this->plugin_url   = plugin_dir_url ( $this->file );

		$this->lang_dir     = trailingslashit( $this->plugin_dir . 'languages' );
		$this->domain       = 'wp-job-contact-listing';
	}

	/**
	 * Loads the plugin language files
	 *
 	 * @since WP Job Manager - Contact Listing 1.0.0
	 */
	public function load_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), $this->domain );
		$mofile = sprintf( '%1$s-%2$s.mo', $this->domain, $locale );

		$mofile_local = $this->lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/' . $this->domain . '/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			return load_textdomain( $this->domain, $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			return load_textdomain( $this->domain, $mofile_local );
		}

		return false;
	}

	/**
	 * Find the plugin we are using to apply. It simply goes down the list
	 * in order so the first active plugin that meets requirements will
	 * be assumed the correct one.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	private function find_plugin() {
		$supported = $this->supported_plugins();

		foreach ( $supported as $key => $plugin ) {
			if ( $plugin[ 'dependancy' ] ) {
				self::$active_plugin = $key;

				break;
			}
		}

		$this->init_plugin();
	}

	/**
	 * Load the base form class and the necessary form class for the active plugin.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	private function init_plugin() {
		if ( ! isset( self::$active_plugin ) ) {
			return;
		}

		$plugins = $this->supported_plugins();
		$plugin = $plugins[ self::$active_plugin ];

		$plugin_file = sprintf( $this->plugin_dir . 'includes/forms/%s.php', self::$active_plugin );
		$plugin_class = sprintf( 'Astoundify_Job_Manager_Contact_Listing_Form_%s', $plugin[ 'class' ] );

		if ( ! file_exists( $plugin_file ) ) {
			return false;
		}

		include_once( $this->plugin_dir . '/includes/class-wp-job-manager-contact-listing-form.php' );
		include_once( $plugin_file );

		if ( ! class_exists( $plugin_class ) ) {
			return false;
		}

		new $plugin_class;
	}

	/**
	 * Retrieve a list of supported plugins.
	 *
	 * @since WP Job Manager - Contact Listing 1.0.0
	 *
	 * @return void
	 */
	public function supported_plugins() {
		$supported = array(
			'gravityforms' => array(
				'dependancy' => class_exists( 'GFForms' ),
				'class' => 'GravityForms'
			),
			'ninjaforms' => array(
				'dependancy' => defined( 'NINJA_FORMS_DIR' ),
				'class' => 'NinjaForms'
			),
			'cf7' => array(
				'dependancy' => defined( 'WPCF7_VERSION' ),
				'class' => 'CF7'
			)
		);

		return apply_filters( 'job_manager_contact_listing_supported_plugins', $supported );
	}

}
add_action( 'init', array( 'Astoundify_Job_Manager_Contact_Listing', 'instance' ) );

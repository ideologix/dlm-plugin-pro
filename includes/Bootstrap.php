<?php

namespace IdeoLogix\DLMPluginPro;

use IdeoLogix\DigitalLicenseManagerUpdaterWP\Core\Configuration;
use IdeoLogix\DigitalLicenseManagerUpdaterWP\Main;

/**
 * Class Bootstrap
 * @package IdeoLogix\DLMPluginPro
 */
class Bootstrap {

	/**
	 * The updater/activator instance
	 * @var Main
	 */
	protected $updater;

	/**
	 * Bootstrap constructor.
	 */
	public function __construct() {

		/**
		 * Setup the updater
		 */
		$this->setup_updater();

		/**
		 * Setup the admin menu
		 */
		add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );

		/**
		 * Some other functionality.
		 */
		add_shortcode( 'dlm_plugin_pro', array( $this, 'do_plugin_shortcode' ) );
	}

	/**
	 * Set up the activator and plugin updater
	 *   1. Wrap the labels in your plugin text-domain so they become tralsatable
	 *   2. Create instance of the Main class to start running the updater
	 *   3. Optional functionality
	 */
	protected function setup_updater() {
		try {

			$labels = [
				'activator.no_permissions'                   => __( 'Sorry, you dont have enough permissions to manage those settings.', 'dlm-plugin-pro' ),
				'activator.license_removed'                  => __( 'License removed.', 'dlm-plugin-pro' ),
				'activator.invalid_action'                   => __( 'Invalid action.', 'dlm-plugin-pro' ),
				'activator.invalid_license_key'              => __( 'Please provide valid product key.', 'dlm-plugin-pro' ),
				'activator.license_activated'                => __( 'Congrats! Your key is valid and your product will receive future updates', 'dlm-plugin-pro' ),
				'activator.license_deactivated'              => __( 'The license key is now deactivated.', 'dlm-plugin-pro' ),
				'activator.activation_permanent'             => __( 'License :status. Activation permanent.', 'dlm-plugin-pro' ),
				'activator.activation_expires'               => __( 'License :status. Expires on :expires_at (:days_remaining days remaining).', 'dlm-plugin-pro' ),
				'activator.activation_deactivated_permanent' => __( 'License :status. Deactivated on :deactivated_at (Valid permanently)', 'dlm-plugin-pro' ),
				'activator.activation_deactivated_expires'   => __( 'License :status. Deactivated on :deactivated_at (:days_remaining days remaining)', 'dlm-plugin-pro' ),
				'activator.activation_expired_purchase'      => __( 'Your license is :status. To get regular updates and support, please <purchase_link>purchase the product</purchase_link>.', 'dlm-plugin-pro' ),
				'activator.activation_purchase'              => __( 'To get regular updates and support, please <purchase_link>purchase the product</purchase_link>.', 'dlm-plugin-pro' ),
				'activator.word_valid'                       => __( 'valid', 'dlm-plugin-pro' ),
				'activator.word_expired'                     => __( 'expired', 'dlm-plugin-pro' ),
				'activator.word_expired_or_invalid'          => __( 'expired or invalid', 'dlm-plugin-pro' ),
				'activator.word_deactivate'                  => __( 'Deactivate', 'dlm-plugin-pro' ),
				'activator.word_activate'                    => __( 'Activate', 'dlm-plugin-pro' ),
				'activator.word_reactivate'                  => __( 'Reactivate', 'dlm-plugin-pro' ),
				'activator.word_purchase'                    => __( 'Purchase', 'dlm-plugin-pro' ),
				'activator.word_renew'                       => __( 'Renew', 'dlm-plugin-pro' ),
				'activator.word_remove'                      => __( 'Remove', 'dlm-plugin-pro' ),
				'activator.word_product_key'                 => __( 'Product Key', 'dlm-plugin-pro' ),
				'activator.help_remove'                      => __( 'Remove the license key', 'dlm-plugin-pro' ),
				'activator.help_product_key'                 => __( 'Enter your product key', 'dlm-plugin-pro' ),
			];

			$this->updater = new Main( array(
				'id'              => DLM_PLUGIN_PRO_ID,
				'name'            => DLM_PLUGIN_PRO_BASENAME,
				'file'            => DLM_PLUGIN_PRO_FILE,
				'basename'        => DLM_PLUGIN_PRO_BASENAME,
				'version'         => DLM_PLUGIN_PRO_VERSION,
				'url_purchase'    => DLM_PLUGIN_PRO_URL,
				'url_settings'    => admin_url( 'options-general.php?page=dlm-plugin-pro' ),
				'consumer_key'    => DLM_PLUGIN_PRO_ACTIVATOR_CONSUMER_KEY,
				'consumer_secret' => DLM_PLUGIN_PRO_ACTIVATOR_CONSUMER_SECRET,
				'api_url'         => DLM_PLUGIN_PRO_ACTIVATOR_URL,
				'prefix'          => 'cv',
				'labels'          => $labels,
				'mask_key_input'  => true, // Show ***** in license key input?
			) );

		} catch ( \Exception $e ) {
			error_log( 'Error: ' . $e->getMessage() );
		}

		// Optional:
		// add_action( 'dlm_wp_updater_activate_meta', [ $this, 'updater_activate_endpoint_meta' ], 10, 3 );
	}

	/**
	 * Example on how to modify the Activation label
	 *
	 * @param $params
	 * @param $key
	 * @param Configuration $configuration
	 *
	 * @return void
	 */
	public function updater_activate_endpoint_meta( $params, $key, $configuration ) {

		if ( $configuration->getEntity()->getId() != DLM_PLUGIN_PRO_ID ) {
			return $params; // Do not apply to other plugins that use this activator.
		}

		if ( isset( $params['label'] ) ) {
			$params['label'] = str_replace( [ 'https://', 'http://' ], '', $params['label'] );
		}

		return $params;
	}

	/**
	 * Set up the admin menu
	 */
	public function setup_admin_menu() {
		add_submenu_page(
			'options-general.php',
			__( 'DLM Plugin PRO', 'dlm-theme-pro' ),
			__( 'DLM Plugin PRO', 'dlm-theme-pro' ),
			'manage_options',
			'dlm-plugin-pro',
			array( $this, 'render_plugin_settings' )
		);
	}

	/**
	 * Renders the plugin settings
	 */
	public function render_plugin_settings() {

		echo '<div class="wrap">';
		echo '<h2>DLM Plugin Pro</h2>';

		// Renders the activator
		echo '<div class="dlm-form-group">';
		$this->updater->getActivator()->renderActivationForm();
		echo '</div>';

		// Render some other form...
		// ...

		// Do your styling. This is just a plain form.
		echo '<style>.dlm-form-group {background-color: #fff; padding: 10px; max-width: 50%; margin-top: 10px;}';
		echo '</div>';

	}

	/**
	 * The plugin shortcode
	 * @return string
	 */
	public function do_plugin_shortcode() {
		return 'Hello World.';
	}

}

<?php

namespace IdeoLogix\DLMPluginPro;

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
	 * Setup the updater
	 */
	protected function setup_updater() {
		try {
			$this->updater = new Main( array(
				'id'              => DLM_PLUGIN_PRO_ID,
				'name'            => 'digital-license-manager-pro',
				'file'            => DLM_PLUGIN_PRO_FILE,
				'basename'        => DLM_PLUGIN_PRO_BASENAME,
				'version'         => DLM_PLUGIN_PRO_VERSION,
				'url_purchase'    => DLM_PLUGIN_PRO_URL,
				'url_settings'    => '',
				'consumer_key'    => 'ck_af0d08f062474fc78c0a78d141cc28a2e529e315',
				'consumer_secret' => 'cs_3feb428091467bf1761b871d63123556c3b7df01',
				'api_url'         => 'https://dlm.test/wp-json/dlm/v1/',
				'prefix'          => 'cv',
			) );
		} catch ( \Exception $e ) {
			error_log( 'Error: ' . $e->getMessage() );
		}
	}

	/**
	 * Setup the admin menu
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

<?php
/**
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */

namespace EcoTechie\Commenter;

use EcoTechie\Commenter\Assets\AssetsAware;
use EcoTechie\Commenter\Assets\AssetsHandler;

/**
 * Class Plugin.
 *
 * Main plugin controller class that hooks the plugin's functionality into the
 * WordPress request lifecycle.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class Plugin implements Registerable {

	/**
	 * Assets handler instance.
	 *
	 * @since 0.1.0
	 *
	 * @var AssetsHandler
	 */
	private $assets_handler;

	/**
	 * Instantiate a Plugin object.
	 *
	 * @since 0.2.7
	 *
	 * @param AssetsHandler|null $assets_handler Optional. Instance of the
	 *                                           assets handler to use.
	 */
	public function __construct( AssetsHandler $assets_handler = null ) {
		$this->assets_handler = $assets_handler ?: new AssetsHandler();
	}

	/**
	 * Register the plugin with the WordPress system.
	 *
	 * @since 0.1.0
	 *
	 * @throws Exception\InvalidService If a service is not valid.
	 */
	public function register() {
		add_action( 'plugins_loaded', [ $this, 'register_services' ] );
		add_action( 'init', [ $this, 'register_assets_handler' ] );
	}

	/**
	 * Register the individual services of this plugin.
	 *
	 * @since 0.1.0
	 *
	 * @throws Exception\InvalidService If a service is not valid.
	 */
	public function register_services() {
		$services = $this->get_services();
		$services = array_map( [ $this, 'instantiate_service' ], $services );
		array_walk(
			$services,
			function ( Service $service ) {
				$service->register();
			}
		);
	}

	/**
	 * Register the assets handler.
	 *
	 * @since 0.1.0
	 */
	public function register_assets_handler() {
		$this->assets_handler->register();
	}

	/**
	 * Return the instance of the assets handler in use.
	 *
	 * @since 0.2.7
	 *
	 * @return AssetsHandler
	 */
	public function get_assets_handler() {
		return $this->assets_handler;
	}

	/**
	 * Instantiate a single service.
	 *
	 * @since 0.1.0
	 *
	 * @param string $class Service class to instantiate.
	 *
	 * @return Service
	 * @throws Exception\InvalidService If the service is not valid.
	 */
	private function instantiate_service( $class ) {
		if ( ! class_exists( $class ) ) {
			throw Exception\InvalidService::from_service( $class );
		}

		$service = new $class();

		if ( ! $service instanceof Service ) {
			throw Exception\InvalidService::from_service( $service );
		}

		if ( $service instanceof AssetsAware ) {
			$service->with_assets_handler( $this->assets_handler );
		}

		return $service;
	}

	/**
	 * Get the list of services to register.
	 *
	 * @since 0.1.0
	 *
	 * @return array<string> Array of fully qualified class names.
	 */
	private function get_services() {
		return [
			Settings\Settings::class,
			Admin\Admin::class,
			// Shortcode\SpeakingPage::class,
			// CustomPostType\Talk::class,
			// Metabox\Talk::class,
			// Widget\Talks::class,
		];
	}
}

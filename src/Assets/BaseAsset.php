<?php
/**
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */


namespace EcoTechie\Commenter\Assets;

use Closure;

/**
 * Abstract class BaseAsset.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter\Assets
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
abstract class BaseAsset implements Asset {

	const REGISTER_PRIORITY = 1;
	const ENQUEUE_PRIORITY  = 10;
	const DEQUEUE_PRIORITY  = 20;

	/**
	 * Handle of the asset.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	protected $handle;

	/**
	 * Get the handle of the asset.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_handle() {
		return $this->handle;
	}

	/**
	 * Register the current Registerable.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function register() {
		$this->deferred_action(
			$this->get_register_action(),
			$this->get_register_closure(),
			static::REGISTER_PRIORITY
		);
	}

	/**
	 * Enqueue the asset.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function enqueue() {
		$this->deferred_action(
			$this->get_enqueue_action(),
			$this->get_enqueue_closure(),
			static::ENQUEUE_PRIORITY
		);
	}

	/**
	 * Dequeue the asset.
	 *
	 * @since 0.2.7
	 *
	 * @return void
	 */
	public function dequeue() {
		$this->deferred_action(
			$this->get_dequeue_action(),
			$this->get_dequeue_closure(),
			static::DEQUEUE_PRIORITY
		);
	}

	/**
	 * Add a deferred action hook.
	 *
	 * If the action has already passed, the closure will be called directly.
	 *
	 * @since 0.1.0
	 *
	 * @param string  $action   Deferred action to hook to.
	 * @param Closure $closure  Closure to attach to the action.
	 * @param int     $priority Optional. Priority to use. Defaults to 10.
	 */
	protected function deferred_action( $action, $closure, $priority = 10 ) {
		if ( did_action( $action ) ) {
			$closure();

			return;
		}

		add_action(
			$action,
			$closure,
			$priority
		);
	}

	/**
	 * Get the register action to use.
	 *
	 * @since 0.1.0
	 *
	 * @return string Register action to use.
	 */
	protected function get_register_action() {
		return $this->get_enqueue_action();
	}

	/**
	 * Get the enqueue action to use.
	 *
	 * @since 0.1.0
	 *
	 * @return string Enqueue action name.
	 */
	protected function get_enqueue_action() {
		return is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
	}

	/**
	 * Get the enqueue action to use.
	 *
	 * @since 0.1.0
	 *
	 * @return string Enqueue action name.
	 */
	protected function get_dequeue_action() {
		return is_admin() ? 'admin_print_scripts' : 'wp_print_scripts';
	}

	/**
	 * Normalize the source URI.
	 *
	 * @since 0.1.0
	 *
	 * @param string $uri       Source URI to normalize.
	 * @param string $extension Default extension to use.
	 *
	 * @return string Normalized source URI.
	 */
	protected function normalize_source( $uri, $extension ) {
		$uri = $this->check_extension( $uri, $extension );
		$uri = plugins_url( $uri, dirname( __FILE__, 2 ) );

		return $this->check_for_minified_asset( $uri, $extension );
	}

	/**
	 * Return the URI of the minified asset if it is readable and
	 * `SCRIPT_DEBUG` is not set.
	 *
	 * @since 0.1.9
	 *
	 * @param string $uri       Source URI.
	 * @param string $extension Default extension to use.
	 *
	 * @return string URI of the asset to use.
	 */
	protected function check_for_minified_asset( $uri, $extension ) {
		$debug        = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
		$minified_uri = str_replace( $extension, "min.{$extension}", $uri );

		return ! $debug && is_readable( $minified_uri ) ? $minified_uri : $uri;
	}

	/**
	 * Check that the URI has the correct extension.
	 *
	 * Optionally adds the extension if none was detected.
	 *
	 * @since 0.2.5
	 *
	 * @param string $uri       URI to check the extension of.
	 * @param string $extension Extension to use.
	 *
	 * @return string URI with correct extension.
	 */
	public function check_extension( $uri, $extension ) {
		$detected_extension = pathinfo( $uri, PATHINFO_EXTENSION );

		if ( $extension !== $detected_extension ) {
			$uri .= '.' . $extension;
		}

		return $uri;
	}

	/**
	 * Get the enqueue closure to use.
	 *
	 * @since 0.1.0
	 *
	 * @return Closure
	 */
	abstract protected function get_register_closure();

	/**
	 * Get the enqueue closure to use.
	 *
	 * @since 0.1.0
	 *
	 * @return Closure
	 */
	abstract protected function get_enqueue_closure();

	/**
	 * Get the dequeue closure to use.
	 *
	 * @since 0.2.7
	 *
	 * @return Closure
	 */
	abstract protected function get_dequeue_closure();
}

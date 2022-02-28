<?php
/**
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */

namespace EcoTechie\Commenter\Assets;

use EcoTechie\Commenter\Registerable;

/**
 * Interface Asset.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter\Assets
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface Asset extends Registerable {

	/**
	 * Enqueue the asset.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public function enqueue();

	/**
	 * Dequeue the asset.
	 *
	 * @since 0.2.7
	 *
	 * @return void
	 */
	public function dequeue();

	/**
	 * Get the handle of the asset.
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_handle();
}

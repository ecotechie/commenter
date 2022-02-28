<?php
/**
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */

namespace EcoTechie\Commenter\Assets;

/**
 * Interface AssetsAware.
 *
 * @since   0.1.0
 *
 * @package EcoTechie\Commenter
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface AssetsAware {

	/**
	 * Set the assets handler to use within this object.
	 *
	 * @since 0.1.0
	 *
	 * @param AssetsHandler $assets Assets handler to use.
	 */
	public function with_assets_handler( AssetsHandler $assets );
}

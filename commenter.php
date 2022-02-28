<?php
/**
 * Plugin Name:     Commenter
 * Plugin URI:      https//www.ecotechie.io/commenter
 * Description:     Easily disable links for comment author and content.
 * Author:          Sergio Scabuzzo
 * Author URI:      https://www.ecotechie.io
 * Text Domain:     commenter
 * Domain Path:     /languages
 * Version:         0.1.0
 * PHP Version:     8.0
 *
 * @package EcoTechie\Commenter
 * @author  Sergio Scabuzzo <sergio@ecotechie.io>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link    https//www.ecotechie.io/commenter
 * @since   0.1.0
 */

namespace EcoTechie\Commenter;

defined( 'ABSPATH' ) || die( 'These are not the files you are looking for...' );

// Load Autoloader class and register plugin namespace.
require_once __DIR__ . '/src/Autoloader.php';
( new Autoloader() )
	->add_namespace( __NAMESPACE__, __DIR__ . '/src' )
	->register();

// Hook plugin into WordPress request lifecycle;
PluginFactory::create()
	->register();

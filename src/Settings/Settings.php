<?php

namespace EcoTechie\Commenter;

use EcoTechie\Commenter\Assets\AssetsAware;
use EcoTechie\Commenter\Assets\AssetsAwareness;
use EcoTechie\Commenter\Renderable;
use EcoTechie\Commenter\Service;

// defined( 'ABSPATH' ) || die( 'These are not the files you are looking for...' );

/**
 * Settings: plugin settings page class.
 *
 * @since 0.1.0
 *
 * @package Commenter
 */
class Settings {

	/**
	 * Instance of this class.
	 *
	 * @since 0.1.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since 0.1.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function register() {
		add_action( 'init', function() {
			$this->get_instance();
		} );
	}

	/**
	 * Add edit permission setting checkbox.
	 *
	 * @since 0.1.0
	 */
	public static function bypass_users_render() {
		$options = get_option( 'ecotechie_commenter' );

		?>
		<input type='checkbox' id='bypass_users' name='ecotechie_commenter[bypass_users]' <?php checked( isset( $options['bypass_users'] ) ); ?> value='1'>
		<label for='bypass_users'>Bypass for priviledged users</label>
		<p class='description'>If checked, users who can edit posts won't be affected by settings below.</p>
		<?php
	}

	/**
	 * Add comment author URL setting checkbox.
	 *
	 * @since 0.1.0
	 */
	public static function comment_author_url_render() {
		$options = get_option( 'ecotechie_commenter' );

		?>
		<input type='checkbox' id='comment_author_url' name='ecotechie_commenter[comment_author_url]' <?php checked( isset( $options['comment_author_url'] ) ); ?> value='1'>
		<label for='comment_author_url'>Hide comment author's Website on comments</label>
		<p class='description'>If checked, comment author's name won't have a link to their Website.</p>
		<?php
	}


	/**
	 * Add comment links setting radio buttons.
	 *
	 * @since 0.1.0
	 */
	public static function comment_links_render() {
		$options = get_option( 'ecotechie_commenter' );
		if ( ! is_array( $options ) ) {
			$options                  = array();
			$options['comment_links'] = '0';
		}

		?>
		<input type='radio' id='comment_links_default' name='ecotechie_commenter[comment_links]' <?php checked( $options['comment_links'], 0 ); ?> value='0'>
		<label for='comment_links_default'>Default</label>
		<p class='description'>No changes to comment links</p>
		<br>
		<input type='radio' id='comment_links_move' name='ecotechie_commenter[comment_links]' <?php checked( $options['comment_links'], 1 ); ?> value='1'>
		<label for='comment_links_move'>Move</label>
		<p class='description'><a href="https://www.ecotechie.io">EcoTechie</a>, would be changed to EcoTechie (https://www.ecotechie.io)</p>
		<br>
		<input type='radio' id='comment_links_unset' name='ecotechie_commenter[comment_links]' <?php checked( $options['comment_links'], 2 ); ?> value='2'>
		<label for='comment_links_unset'>Unset</label>
		<p class='description'><a href="https://www.ecotechie.io">EcoTechie</a>, would be changed to EcoTechie</p>
		<?php
	}


	/**
	 * Build plugin options page.
	 *
	 * @since 0.1.0
	 */
	public static function options_page() {

		?>
		<form action='options.php' method='post'>
			<h2>Commenter</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php
	}
}

/**
* Init the plugin.
*/
// add_action( 'init', array( 'EcoTechie\Commenter\Settings', 'get_instance' ) );

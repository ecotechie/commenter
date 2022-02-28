<?php
/**
 * Add opions to user profile page
 *
 * @package Commenter
 * @since 1.0
 */

// TODO:
// Use the users.php page to set (even bulk) the proxy commenter.
// https://wordpress.stackexchange.com/questions/121632/add-a-button-to-users-php
//
// Show the proxy users for current user in the user's settings page or plugin options.
//
// Use this info!
// https://awhitepixel.com/blog/wordpress-admin-add-custom-bulk-action/
// https://wordpress.stackexchange.com/questions/160422/add-custom-column-to-users-admin-panel

namespace EcoTechie\Commenter;

defined( 'ABSPATH' ) || die( 'These are not the files you are looking for...' );

/**
 * User profile admin page class.
 *
 * @since 0.1.0
 *
 * @package Commenter
 */
class User {

	/**
	 * Instance of this class.
	 *
	 * @since 0.1.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	private function __construct() {
		add_action( 'show_user_profile', array( $this, 'set_proxy_commenter' ) );
		add_action( 'edit_user_profile', array( $this, 'set_proxy_commenter' ) );
	}

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

	public function set_proxy_commenter( $user ) {

		?>
			<h3><?php _e( 'Extra profile information', 'blank' ); ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="phone"><?php _e( 'Proxy Commenter' ); ?></label></th>
					<td>
						<input type="text" name="phone" id="phone" class="regular-text" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" /><br />
						<span class="description"><?php _e( 'Please enter your phone.' ); ?></span>
					</td>
				</tr>
			</table>
		<?php
	}
}

/**
 * Init the plugin.
 */
add_action( 'init', array( 'EcoTechie\Commenter\User', 'get_instance' ) );

<?php
/**
 * Plugin helper functions
 *
 * @package Commenter
 * @since 0.1.0
 */

namespace EcoTechie\Commenter;

defined( 'ABSPATH' ) || die( 'These are not the files you are looking for...' );

/**
 * Helper function class.
 *
 * @since 0.1.0
 *
 * @package Commenter
 */
class Helpers {

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

	/**
	* Constructor
	*
	* @since 0.1.0
	*/
	private function __construct() {
		$options = get_option( 'settings' );

		if ( isset( $options['comment_author_url'] ) ) {
			add_filter( 'get_comment_author_url', array( $this, 'remove_comment_author_url' ), 20, 3 );
		}

		if ( isset( $options['comment_links'] ) && '1' === $options['comment_links'] ) {
			add_filter( 'comment_text', array( $this, 'comment_text_links_move' ), 20, 3 );
		}

		if ( isset( $options['comment_links'] ) && '2' === $options['comment_links'] ) {
			add_filter( 'comment_text', array( $this, 'comment_text_links_unset' ), 20, 3 );
		}
	}

	/**
	 * Verify user has, at least, edit posts priviledges.
	 *
	 * @since 0.1.0
	 *
	 * @param int The comment ID.
	 *
	 * @return bool
	 */
	private function is_user_priviledged( $id ) {
		if ( user_can( get_user_by( 'login', get_comment_author( $id ) ), 'edit_posts' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Verify priviledged users should be bypassed.
	 *
	 * @since 0.1.0
	 *
	 * @return bool
	 */
	private function bypass_priviledged_users() {
		$options = get_option( 'settings' );
		if ( isset( $options['bypass_users'] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Unsets comment author URL.
	 *
	 * @since 0.1.0
	 *
	 * @param string     $url        The comment author's URL.
	 * @param int        $comment_id The comment ID.
	 * @param WP_Comment $comment    The comment object.
	 *
	 * @return string The comment author's URL.
	 */
	public function remove_comment_author_url( $url, $comment_id, $comment ) {
		if ( ( ! self::bypass_priviledged_users() ) || ( self::bypass_priviledged_users() && ! self::is_user_priviledged( $comment->ID ) ) ) {
			$url = '';
		}
		return $url;
	}

	/**
	 * Filters comment to be displayed by removing links' href tag and moving URL next to it.
	 *
	 * @since 0.1.0
	 *
	 * @param string          $comment_text Text of the current comment.
	 * @param WP_Comment/null $comment      The comment object. Null if not found.
	 * @param array           $args         An array of arguments.
	 *
	 * @return string Text of the current comment.
	 */
	public function comment_text_links_move( $comment_text, $comment, $args ) {
		if ( ( ! self::bypass_priviledged_users() ) || ( self::bypass_priviledged_users() && ! self::is_user_priviledged( $comment->ID ) ) ) {
			$comment_text = preg_replace( '/<a[^>]+href=\"(.*?)\"[^>]*>(.*?)<\/a>/', "\\2 (\\1)", $comment_text );
		}
			return $comment_text;
	}

	/**
	 * Filters comment to be displayed by removing links' href.
	 *
	 * @since 0.1.0
	 *
	 * @param string          $comment_text Text of the current comment.
	 * @param WP_Comment/null $comment      The comment object. Null if not found.
	 * @param array           $args         An array of arguments.
	 *
	 * @return string Text of the current comment.
	 */
	private function comment_text_links_unset( $comment_text, $comment, $args ) {
		if ( ( ! self::bypass_priviledged_users() ) || ( self::bypass_priviledged_users() && ! self::is_user_priviledged( $comment->ID ) ) ) {
			$comment_text = preg_replace( '/<a[^>]+href=\"(.*?)\"[^>]*>(.*?)<\/a>/', "\\2", $comment_text );
		}
			return $comment_text;
	}
}

/**
 * Init the plugin.
 */
add_action( 'init', array( 'EcoTechie\Commenter\Helpers', 'get_instance' ) );

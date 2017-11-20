<?php
/**
 * GitHub Updater
 *
 * @package   GitHub_Updater
 * @author    Andy Fragen
 * @license   GPL-2.0+
 * @link      https://github.com/afragen/github-updater
 */

namespace Fragen\GitHub_Updater;

/*
 * Exit if called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Messages
 *
 * @package Fragen\GitHub_Updater
 */
class Messages extends Base {

	/**
	 * Holds WP_Error message.
	 *
	 * @var string
	 */
	public static $error_message = '';

	/**
	 * Display message when API returns other than 200 or 404.
	 *
	 * @param string
	 *
	 * @return bool
	 */
	public function create_error_message( $type = '' ) {
		global $pagenow;

		$update_pages   = array( 'update-core.php', 'plugins.php', 'themes.php' );
		$settings_pages = array( 'settings.php', 'options-general.php' );

		if (
			( ( ! isset( $_GET['page'] ) || 'github-updater' !== $_GET['page'] ) &&
			  in_array( $pagenow, $settings_pages, true ) ) ||
			! in_array( $pagenow, array_merge( $update_pages, $settings_pages ), true )

		) {
			return false;
		}

		if ( is_admin() && ! static::is_doing_ajax() ) {
			switch ( $type ) {
				case is_wp_error( $type ):
					self::$error_message = $type->get_error_message();
					add_action( 'admin_notices', array( &$this, 'show_wp_error' ) );
					add_action( 'network_admin_notices', array( &$this, 'show_wp_error' ) );
					break;
				case 'gitlab':
					add_action( 'admin_notices', array( &$this, 'gitlab_error' ) );
					add_action( 'network_admin_notices', array( &$this, 'gitlab_error' ) );
				case 'git':
				default:
					add_action( 'admin_notices', array( &$this, 'show_403_error_message' ) );
					add_action( 'network_admin_notices', array( &$this, 'show_403_error_message' ) );
					add_action( 'admin_notices', array( &$this, 'show_401_error_message' ) );
					add_action( 'network_admin_notices', array( &$this, 'show_401_error_message' ) );
			}
		}

		return true;
	}

	/**
	 * Create error message for 403 error.
	 * Usually 403 as API rate limit max out.
	 */
	public function show_403_error_message() {
		$_403       = false;
		$error_code = Singleton::get_instance( 'API_PseudoTrait' )->get_error_codes();
		foreach ( (array) $error_code as $repo ) {
			if ( ! $_403 && 403 === $repo['code'] && 'github' === $repo['git'] ) {
				$_403 = true;
				if ( ! \PAnD::is_admin_notice_active( '403-error-1' ) ) {
					return;
				}
				?>
				<div data-dismissible="403-error-1" class="error notice is-dismissible">
					<p>
						<?php
						esc_html_e( 'GitHub Updater Error Code:', 'github-updater' );
						echo ' ' . $repo['code'];
						?>
						<br>
						<?php
						printf( esc_html__( 'GitHub API\'s rate limit will reset in %s minutes.', 'github-updater' ),
							$repo['wait']
						);
						echo '<br>';
						printf(
							esc_html__( 'It looks like you are running into GitHub API rate limits. Be sure and configure a %sPersonal Access Token%s to avoid this issue.', 'github-updater' ),
							'<a href="https://help.github.com/articles/creating-an-access-token-for-command-line-use/">',
							'</a>'
						);
						?>
					</p>
				</div>
				<?php
			}
		}
	}

	/**
	 * Create error message or 401 (Authentication Error) error.
	 * Usually 401 as private repo with no token set or incorrect user/pass.
	 */
	public function show_401_error_message() {
		$_401       = false;
		$error_code = Singleton::get_instance( 'API_PseudoTrait' )->get_error_codes();
		foreach ( (array) $error_code as $repo ) {
			if ( ! $_401 && 401 === $repo['code'] ) {
				$_401 = true;
				if ( ! \PAnD::is_admin_notice_active( '401-error-1' ) ) {
					return;
				}
				?>
				<div data-dismissible="401-error-1" class="error notice is-dismissible">
					<p>
						<?php
						esc_html_e( 'GitHub Updater Error Code:', 'github-updater' );
						echo ' ' . $repo['code'];
						?>
						<br>
						<?php esc_html_e( 'There is probably an access token or password error on the GitHub Updater Settings page.', 'github-updater' ); ?>
					</p>
				</div>
				<?php
			}
		}
	}

	/**
	 * Generate error message for missing GitLab Private Token.
	 */
	public function gitlab_error() {
		if ( ( empty( static::$options['gitlab_enterprise_token'] ) &&
		       static::$auth_required['gitlab_enterprise'] ) ||
		     ( empty( static::$options['gitlab_access_token'] ) &&
		       static::$auth_required['gitlab'] )
		) {
			if ( ! \PAnD::is_admin_notice_active( 'gitlab-error-1' ) ) {
				return;
			}
			?>
			<div data-dismissible="gitlab-error-1" class="error notice is-dismissible">
				<p>
					<?php esc_html_e( 'You must set a GitLab.com, GitLab CE, or GitLab Enterprise Access Token.', 'github-updater' ); ?>
				</p>
			</div>
			<?php
		}
	}

	/**
	 * Generate error message for WP_Error.
	 */
	public function show_wp_error() {
		if ( ! \PAnD::is_admin_notice_active( 'wp-error-1' ) ) {
			return;
		}
		?>
		<div data-dismissible="wp-error-1" class="error notice is-dismissible">
			<p>
				<?php
				esc_html_e( 'GitHub Updater Error Code:', 'github-updater' );
				echo ' ' . self::$error_message;
				?>
			</p>
		</div>
		<?php
	}

}

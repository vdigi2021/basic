<?php
if ( defined( 'ABSPATH' ) && ! class_exists( 'vnex_login' ) ) {
	class vnex_login {
		private $wp_login_php;
		private function basename() {
			return plugin_basename( __FILE__ );
		}
		private function path() {
			return trailingslashit( dirname( __FILE__ ) );
		}
		private function use_trailing_slashes() {
			return '/' === substr( get_option( 'permalink_structure' ), -1, 1 );
		}
		private function user_trailingslashit( $string ) {
			return $this->use_trailing_slashes() ? trailingslashit( $string ) : untrailingslashit( $string );
		}
		private function wp_template_loader() {
			global $pagenow;
			$pagenow = 'index.php';
			if ( ! defined( 'WP_USE_THEMES' ) ) {
				define( 'WP_USE_THEMES', true );
			}
			wp();
			if ( $_SERVER['REQUEST_URI'] === $this->user_trailingslashit( str_repeat( '-/', 10 ) ) ) {
				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/wp-login-php/' );
			}
			require_once( ABSPATH . WPINC . '/template-loader.php' );
			die;
		}
		private function vnex_new_login_slug() {
			if (
				( $slug = get_option( 'vnex_slug_page' ) ) || (
					is_multisite() &&
					is_plugin_active_for_network( $this->basename() ) &&
					( $slug = get_site_option( 'vnex_slug_page', 'login' ) )
				) ||
				( $slug = 'login' )
			) {
				return $slug;
			}
		}
		public function vnex_new_login_url( $scheme = null ) {
			if ( get_option( 'permalink_structure' ) ) {
				return $this->user_trailingslashit( home_url( '/', $scheme ) . $this->vnex_new_login_slug() );
			} else {
				return home_url( '/', $scheme ) . '?' . $this->vnex_new_login_slug();
			}
		}
		public function __construct() {
			global $wp_version;
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 1 );
			add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );
			add_filter( 'site_url', array( $this, 'site_url' ), 10, 4 );
			add_filter( 'wp_redirect', array( $this, 'wp_redirect' ), 10, 2 );
			remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		}
		public function admin_init() {
			global $pagenow;
			add_settings_section(
				'slug-wp-login-section',
				__( 'Custom wp-login.php & wp-admin', 'vnex' ),
				array( $this, 'vnex_slug_section_desc' ),
				'permalink'
			);
			add_settings_field(
				'vnex_slug-page',
				'<label for="vnex_slug-page">' . __( 'Login URL', 'vnex' ) . '</label>',
				array( $this, 'vnex_slug_page_input' ),
				'permalink',
				'slug-wp-login-section'
			);
			if ( isset( $_POST['vnex_slug_page'] ) && $pagenow === 'options-permalink.php' ) {
				if (
					( $vnex_slug_page = sanitize_title_with_dashes( $_POST['vnex_slug_page'] ) ) &&
					strpos( $vnex_slug_page, 'wp-login' ) === false &&
					! in_array( $vnex_slug_page, $this->forbidden_slugs() )
				) {
					if ( is_multisite() && $vnex_slug_page === get_site_option( 'vnex_slug_page', 'login' ) ) {
						delete_option( 'vnex_slug_page' );
					} else {
						update_option( 'vnex_slug_page', $vnex_slug_page );
					}
				}
			}
			if ( get_option( 'vnex_slug_redirect' ) ) {
				delete_option( 'vnex_slug_redirect' );
				if ( is_multisite() && is_super_admin() && is_plugin_active_for_network( $this->basename() ) ) {
					$redirect = network_admin_url( 'settings.php#vnex_slug-page-input' );
				} else {
					$redirect = admin_url( 'options-permalink.php#vnex_slug-page-input' );
				}
				wp_safe_redirect( $redirect );
				die;
			}
		}
		public function vnex_slug_section_desc() {
			$out = '';
			if ( is_multisite() && is_super_admin() && is_plugin_active_for_network( $this->basename() ) ) {
				$out .= '<p>' . sprintf( __( 'To set a networkwide default, go to %s.', 'vnex' ), '<a href="' . network_admin_url( 'settings.php#vnex_slug-page-input' ) . '">' . __( 'Network Settings', 'vnex' ) . '</a>') . '</p>';
			}
			echo $out;
		}
		public function vnex_slug_page_input() {
			if ( get_option( 'permalink_structure' ) ) {
				echo '<code>' . trailingslashit( home_url() ) . '</code> <input id="vnex_slug-page-input" type="text" name="vnex_slug_page" value="' . $this->vnex_new_login_slug()  . '">' . ( $this->use_trailing_slashes() ? ' <code>/</code>' : '' );
			} else {
				echo '<code>' . trailingslashit( home_url() ) . '?</code> <input id="vnex_slug-page-input" type="text" name="vnex_slug_page" value="' . $this->vnex_new_login_slug()  . '">';
			}
		}
		public function plugins_loaded() {
			global $pagenow;
			load_plugin_textdomain( 'vnex' );
			$request = parse_url( $_SERVER['REQUEST_URI'] );
			if ( (
					strpos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) !== false ||
					untrailingslashit( $request['path'] ) === site_url( 'wp-login', 'relative' )
				) &&
				! is_admin()
			) {
				$this->wp_login_php = true;
				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/' . str_repeat( '-/', 10 ) );
				$pagenow = 'index.php';
			} elseif (
				untrailingslashit( $request['path'] ) === home_url( $this->vnex_new_login_slug(), 'relative' ) || (
					! get_option( 'permalink_structure' ) &&
					isset( $_GET[$this->vnex_new_login_slug()] ) &&
					empty( $_GET[$this->vnex_new_login_slug()] )
			) ) {
				$pagenow = 'wp-login.php';
			}
		}
		public function wp_loaded() {
			global $pagenow;
			if ( is_admin() && ! is_user_logged_in() && ! defined( 'DOING_AJAX' ) ) {
				wp_die( __( 'You must log in to access the admin area.', 'vnex' ) );
			}
			$request = parse_url( $_SERVER['REQUEST_URI'] );
			if (
				$pagenow === 'wp-login.php' &&
				$request['path'] !== $this->user_trailingslashit( $request['path'] ) &&
				get_option( 'permalink_structure' )
			) {
				wp_safe_redirect( $this->user_trailingslashit( $this->vnex_new_login_url() ) . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
				die;
			} elseif ( $this->wp_login_php ) {
				if (
					( $referer = wp_get_referer() ) &&
					strpos( $referer, 'wp-activate.php' ) !== false &&
					( $referer = parse_url( $referer ) ) &&
					! empty( $referer['query'] )
				) {
					parse_str( $referer['query'], $referer );
					if (
						! empty( $referer['key'] ) &&
						( $result = wpmu_activate_signup( $referer['key'] ) ) &&
						is_wp_error( $result ) && (
							$result->get_error_code() === 'already_active' ||
							$result->get_error_code() === 'blog_taken'
					) ) {
						wp_safe_redirect( $this->vnex_new_login_url() . ( ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '' ) );
						die;
					}
				}
				$this->wp_template_loader();
			} elseif ( $pagenow === 'wp-login.php' ) {
				global $error, $interim_login, $action, $user_login;
				@require_once ABSPATH . 'wp-login.php';
				die;
			}
		}
		public function site_url( $url, $path, $scheme, $blog_id ) {
			return $this->filter_wp_login_php( $url, $scheme );
		}
		public function wp_redirect( $location, $status ) {
			return $this->filter_wp_login_php( $location );
		}
		public function filter_wp_login_php( $url, $scheme = null ) {
			if ( strpos( $url, 'wp-login.php' ) !== false ) {
				if ( is_ssl() ) {
					$scheme = 'https';
				}
				$args = explode( '?', $url );
				if ( isset( $args[1] ) ) {
					parse_str( $args[1], $args );
					$url = add_query_arg( $args, $this->vnex_new_login_url( $scheme ) );
				} else {
					$url = $this->vnex_new_login_url( $scheme );
				}
			}
			return $url;
		}
		public function forbidden_slugs() {
			$wp = new WP;
			return array_merge( $wp->public_query_vars, $wp->private_query_vars );
		}
	}
	new vnex_login;
}
?>
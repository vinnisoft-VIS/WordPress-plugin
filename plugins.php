<?php
/**
 * Plugin Name: My Plugins
 * Plugin URI: http://abc/
 * Description: this plugins for testing purpose
 * Version: 1.2.44
 * Author: Abc
 * Author URI: http://abc.com/
 *
 * Text Domain: abc
 * Domain Path: /languages/
 *
 * @package my-plugins
 * @category Plugins
 * @author Abc
 */
if ( ! defined( 'ABSPATH' ) ) {
  	exit;
}

if ( !class_exists("My_Plugins_Pro") ) {
	
	final class My_Plugins_Pro {

		private static $instance;

		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof My_Plugins_Pro ) ) {
				self::$instance = new My_Plugins_Pro;
				self::$instance->setup_constants();

				self::$instance->load_textdomain();		


				add_action( 'activated_plugin', array( self::$instance, 'plugin_order' ) );		
				self::$instance->libraries();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function setup_constants(){
			define( 'My_Plugins_Pro_PLUGIN_VERSION', '1.2.44' );
			define( 'My_Plugins_Pro_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			define( 'My_Plugins_Pro_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		}

		public function includes() {
			global $My_Plugins_Pro_options;
			// Admin Settings
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/admin/class-settings.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/admin/class-permalink-settings.php';

			$My_Plugins_Pro_options = My_Plugins_Pro_get_settings();
			
						
			// custom fields
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/custom-fields/class-fields-manager.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/custom-fields/class-custom-fields-html.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/custom-fields/class-custom-fields.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/custom-fields/class-custom-fields-display.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/custom-fields/class-custom-fields-register.php';



			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/class-ajax.php';

			// social login
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/socials/class-social-facebook.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/socials/class-social-google.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/socials/class-social-linkedin.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'includes/socials/class-social-twitter.php';		

			add_action('init', array( __CLASS__, 'register_post_statuses' ) );
		}


		public static function register_post_statuses() {
			register_post_status(
				'expired',
				array(
					'label'                     => _x( 'Expired', 'post status', 'My_Plugins_Pro' ),
					'public'                    => true,
					'protected'                 => true,
					'exclude_from_search'       => true,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>', 'My_Plugins_Pro' ),
				)
			);
			register_post_status(
				'pending_approve',
				array(
					'label'                     => _x( 'Pending Approve', 'post status', 'My_Plugins_Pro' ),
					'public'                    => false,
					'protected'                 => true,
					'exclude_from_search'       => true,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'label_count'               => _n_noop( 'Pending Approve <span class="count">(%s)</span>', 'Pending Approve <span class="count">(%s)</span>', 'My_Plugins_Pro' ),
				)
			);
			register_post_status(
				'preview',
				array(
					'label'                     => _x( 'Preview', 'post status', 'My_Plugins_Pro' ),
					'public'                    => false,
					'exclude_from_search'       => true,
					'show_in_admin_all_list'    => false,
					'show_in_admin_status_list' => true,
					'label_count'               => _n_noop( 'Preview <span class="count">(%s)</span>', 'Preview <span class="count">(%s)</span>', 'My_Plugins_Pro' ),
				)
			);
			register_post_status(
				'pending_payment',
				array(
					'label'                     => _x( 'Pending Payment', 'post status', 'My_Plugins_Pro' ),
					'public'                    => false,
					'exclude_from_search'       => true,
					'show_in_admin_all_list'    => false,
					'show_in_admin_status_list' => true,
					'label_count'               => _n_noop( 'Pending Payment <span class="count">(%s)</span>', 'Pending Payment <span class="count">(%s)</span>', 'My_Plugins_Pro' ),
				)
			);
			register_post_status(
				'denied',
				array(
					'label'                     => _x( 'Denied', 'post status', 'My_Plugins_Pro' ),
					'public'                    => false,
					'exclude_from_search'       => true,
					'show_in_admin_all_list'    => false,
					'show_in_admin_status_list' => true,
					'label_count'               => _n_noop( 'Denied <span class="count">(%s)</span>', 'Denied <span class="count">(%s)</span>', 'My_Plugins_Pro' ),
				)
			);
		}
		/**
		 * Loads third party libraries
		 *
		 * @access public
		 * @return void
		 */
		public static function libraries() {
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_map/cmb-field-map.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_tags/cmb2-field-type-tags.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_file/cmb2-field-type-file.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_attached_user/cmb2-field-type-attached_user.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_profile_url/cmb2-field-type-profile_url.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_image_select/cmb2-field-type-image-select.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb_field_select2/cmb-field-select2.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb_field_taxonomy_select2/cmb-field-taxonomy-select2.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb_field_taxonomy_select2_search/cmb-field-taxonomy-select2-search.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_ajax_search/cmb2-field-ajax-search.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb_field_taxonomy_location/cmb-field-taxonomy-location.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb_field_taxonomy_location_search/cmb-field-taxonomy-location-search.php';
			
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2-hide-show-password-field/cmb2-hide-show-password.php';
			
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_rate_exchange/cmb2-field-type-rate_exchange.php';

			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_datepicker/cmb2-field-type-datepicker.php';
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2_field_datepicker2/cmb2-field-type-datepicker2.php';
			
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/cmb2/cmb2-tabs/plugin.php';
			
			require_once My_Plugins_Pro_PLUGIN_DIR . 'libraries/class-tgm-plugin-activation.php';
		}

		/**
	     * Loads this plugin first
	     *
	     * @access public
	     * @return void
	     */
	    public static function plugin_order() {
		    $wp_path_to_this_file = preg_replace( '/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR.'/$2', __FILE__ );
		    $this_plugin = plugin_basename( trim( $wp_path_to_this_file ) );
		    $active_plugins = get_option( 'active_plugins' );
		    $this_plugin_key = array_search( $this_plugin, $active_plugins );
			if ( $this_plugin_key ) {
				array_splice( $active_plugins, $this_plugin_key, 1 );
				array_unshift( $active_plugins, $this_plugin );
			    update_option( 'active_plugins', $active_plugins );
		    }
	    }



		/**
		 *
		 */
		public function load_textdomain() {
			// Set filter for My_Plugins_Pro's languages directory
			$lang_dir = My_Plugins_Pro_PLUGIN_DIR . 'languages/';
			$lang_dir = apply_filters( 'My_Plugins_Pro_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'My_Plugins_Pro' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'My_Plugins_Pro', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/My_Plugins_Pro/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/My_Plugins_Pro folder
				load_textdomain( 'My_Plugins_Pro', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/My_Plugins_Pro/languages/ folder
				load_textdomain( 'My_Plugins_Pro', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'My_Plugins_Pro', false, $lang_dir );
			}
		}
	}
}





function My_Plugins_Pro() {
	return My_Plugins_Pro::getInstance();
}

add_action( 'plugins_loaded', 'My_Plugins_Pro' );

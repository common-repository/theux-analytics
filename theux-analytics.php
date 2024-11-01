<?php
/**
 * Plugin Name: TheUx Analytics
 * Description: The right way to insert Google Analytics code on your pages.
 * Plugin URI: http://wordpress.org/plugins/theux-analytics
 * Author: Daniel Zilli
 * Author URI: http://theux.co
 * License: GPL2
 * Version: 1.0.0
 * Text Domain: tua
 * Domain Path: /lang
 *
 * TheUx Analytics is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TheUx Analytics. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   TUA
 * @author    Daniel Zilli
 * @version   1.0.0
 */

/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Starting the class.
 */
if(!class_exists('TheUx_Analytics')) {
	
	class TheUx_Analytics {

		/**
		 * Plugin version, used for cache-busting of style and script file references.
		 */
		protected $version = '1.0.0';


		/**
		 * Unique identifier.
		 *
		 * Used as the text domain when internationalizing strings of text. It should
		 * match the Text Domain file header in the main plugin file.
		 */
		protected $plugin_slug = 'tua';


		/**
		 * Slug of the plugin screen.
		 */
		protected $plugin_screen_hook_suffix = null;


		/**
		 * Initialize the plugin by setting localization, filters, and administration functions.
		 */
		public function __construct() {

			// Load plugin text domain.
			add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

			// Add the settings page and menu item.
			add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

			// Init plugin settings.
			add_action( 'admin_init', array( $this, 'tua_init' ) );

			// Add the snippet on the pages.
			add_action( 'wp_head', array( $this, 'display_public_page' ), 100 );

		} // end of function __construct


		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain() {

			$domain = $this->plugin_slug;
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );

		} // end of load_plugin_textdomain


		/**
		 * Register the administration seeting page for this plugin.
		 */
		public function add_plugin_admin_menu() {

			$this->plugin_screen_hook_suffix = add_options_page(
				__( 'Google Analytics Settings', $this->plugin_slug ),
				__( 'Google Analytics', $this->plugin_slug ),
				'manage_options',
				$this->plugin_slug,
				array( $this, 'display_admin_page' )
			);
		
		} // end of add_plugin_admin_menu


		/**
		 * Render the settings page for this plugin.
		 */
		public function display_admin_page() { ?>
		
			<div class="wrap">
				<?php screen_icon(); ?>
				<h2><?php echo esc_html( get_admin_page_title() ) ?></h2>
				<form method="post" action="options.php">
					<?php settings_fields('tua_options') ?>
					<?php $options = get_option('tua_sample') ?>
					<table class="form-table">
						<p>Please enter your tracking code below:</p>
						<tr valign="top" class="tua_textarea">
							<textarea name="tua_sample[textarea]" rows="10" cols="100"><?php echo $options['textarea'] ?></textarea>
						</tr>
					</table>
					<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', $this->plugin_slug ) ?>">
					</p>
				</form>
			</div> 
		<?php
		} // end of display_admin_page


		/**
		 * Register plugin settings.
		 */
		public function tua_init() {
			register_setting( 'tua_options', 'tua_sample' );
			
		} // end of tua_init


		/**
		 * Render the public page for this plugin.
		 */
		public function display_public_page() {
		
			$analytics_tmp = get_option('tua_sample');

			if (!empty($analytics_tmp['textarea'] )) {
				echo $analytics_tmp['textarea'] ;
			}

		} // end of display_public_page

	} // end of TheUx_Analytics

	/**
	 * Initialize the plugin.
	 */
	new TheUx_Analytics();

} // end of !class_exists

<?php
/**
 * Plugin Name: FaceTab
 * Plugin URI: http://lbideias.com.br
 * Description: This plugin allows you to create a tab on your fan page and display the latest posts from your website or blog. You create filters to define which posts will appear in the facebook tab.
 * Author: leobaiano
 * Author URI: http://lbideias.com.br/
 * Version: 1.0
 * License: GPLv2 or later
 * Text Domain: lb_ps
 */

	// Exit if accessed directly.
	if ( ! defined( 'ABSPATH' ) ) exit;

	// Sets the plugin path.
	define( 'FACETAB_PATH', plugin_dir_path( __FILE__ ) );

	// Sets app facebook
	define( 'APP_FACEBOOK', 'https://apps.facebook.com/wpfacetab' );

	/**
	 * Class FaceTab
	 * @version 1.0
	 * @author Leo Baiano <leobaiano@lbideias.com.br>
	 */
	class FaceTab {
		
		public function __construct() {
			register_activation_hook( __FILE__, array( $this, 'init' ) );

			/**
			* Add option pages in menu settings WordPress
			*/
			add_action( 'admin_menu', array( $this, 'menuFaceTab' ) );
		}

		public function init() {
			$options = array(
								'facebook_page' => ''
							);
			add_option( 'facetab_options', $options );
		}

		public function menuFaceTab() {
				/**
				 * Options Page
				 */
				add_options_page(
						__( 'Face Tab', 'facetab' ),
						__( 'Face Tab', 'facetab' ),
						'manage_options',
						'facetab',
						array( $this, 'facetab_settings' )
				);
		}

		/**
		 * Function that generates the options page of the plugin
		 */
		public function facetab_settings() {
                $current = '';
                if ( isset( $_GET['tab'] ) )
                    $current = $_GET['tab'];
                else
                    $current = 'config';
?>
				<div class="wrap">
					<h2 class="nav-tab-wrapper">
						<a href="admin.php?page=facetab&tab=config" class="nav-tab <?php echo $current == 'config' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Config', 'facetab' ); ?></a>
						<a href="admin.php?page=facetab&tab=options" class="nav-tab <?php echo $current == 'options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Options', 'facetab' ); ?></a>
						<a href="admin.php?page=facetab&tab=layout" class="nav-tab <?php echo $current == 'layout' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Layout', 'facetab' ); ?></a>
					</h2>
					<?php
						if( $current == 'options' )
							$this->displayPage( 'options' );
						else if( $current == 'layout' )
							$this->displayPage( 'layout' );
						else
							$this->displayPage( 'config' );
					?>
				</div>
<?php
		}

		/**
		 * Display the HTML of a page of options according to the selected tab
		 *
		 * @param string $page - Name of the page that will be loaded
		 * @return string $view - Display HTML
		 */
		public function displayPage( $page ) {
			$options = get_option( 'facetab_options' );
			
			if( $page == 'config' ){

				if( empty( $options['facebook_page'] ) ) {

					$facetab_login_url = APP_FACEBOOK . '?action=new&url=' . get_site_url();

					$html = '<h3>' . __( 'Integração com o Facebook', 'facetab' ) . '</h3>';
					$html .= '<p>' . __( 'You are not authorized to access the plugin information in your facebook account or are not logged in, this is necessary because only with these permissions can create a tab on your fan page and display the selected options in this plugin content. Click the button below to connect to facebook and allow the plugin to create the flap on the fan page you choose.', 'facetab' ) . '</p>';
					$html .= '<a class="facebookConnect" href="' . $facetab_login_url . '">' . __( 'Facebook Connect', 'facetab' ) . '</a>';
				}

			}

			echo $html;
		}

	}
	new FaceTab;
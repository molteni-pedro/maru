<?php

/**
 * Plugin Name: Datalentor
 * Description: Datalentor - Advanced DataTable for Elementor is used to insert data table using elementor editor.
 * Plugin URL: https://www.coderkart.com/downloads/datalentor-advanced-datatable-for-elementor/
 * Version: 1.0.1
 * Author: Coderkart Technologies
 * Author URI: https://www.coderkart.com
 *
 * Text Domain: datalentor 
 */


/*
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define Plugin URL and Directory Path
 */
define('DTLE_URL', plugins_url('/', __FILE__));  // Define Plugin URL
define('DTLE_PATH', plugin_dir_path(__FILE__));  // Define Plugin Directory Path
define('DTLE_DOMAIN', 'datalentor'); // Define Text Domain
define('DTLE_SITE', home_url()); // Define Home URL
define('DTLE_NAME', 'Datalentor'); // Define Name

/**
 * Main Plugin Datalentor class.
 * 
 * @access public
 * @since  1.0
 */
if (!class_exists('DTLE_Datalentor')) :
class DTLE_Datalentor {

    /**
     * DTLE constructor.
     * The main plugin actions registered for WordPress
     * 
     * @access public
     * @since  1.0
    */
    public function __construct() {	
		$this->hooks();	
		require_once DTLE_PATH . 'includes/widgets/elementor-helper.php';
		require_once DTLE_PATH . 'includes/widgets/elementor-dependency.php';
    }

    /**
	* Initialize
	*/
	public function hooks() {
        add_action('elementor/widgets/register', array($this, 'dtle_widget_register'));
        add_action('wp_enqueue_scripts', array($this, 'dtle_widget_script_register'));
		add_action('plugins_loaded', array($this, 'dtle_plugin_load'));
	}

    
    /**
	 * Check for Plugin Load Data
	 */
	public function dtle_plugin_load() {
		// Load plugin textdomain
        load_plugin_textdomain(DTLE_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages');

		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'dtle_widget_fail_load'));
			return;
		}
	}

    /**
	 * This notice will appear if Elementor is not installed or activated or both
	 */
	public function dtle_widget_fail_load() {
		$screen = get_current_screen();
		if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
			return;
		}

		$plugin = 'elementor/elementor.php';

		if (dtle_elementor_installed()) {
			if (!current_user_can('activate_plugins')) {
				return;
			}
			$activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

			$message = '<p><strong>' . esc_html__('Datalentor', DTLE_DOMAIN).'</strong>'. esc_html__(' not working because you need to activate the Elementor plugin.', DTLE_DOMAIN) . '</p>';
			$message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__('Activate Elementor Now', DTLE_DOMAIN)) . '</p>';
		} else {
			if (!current_user_can('install_plugins')) {
				return;
			}

			$install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');

			$message = '<p><strong>' . esc_html__('Datalentor', DTLE_DOMAIN).'</strong>'. esc_html__(' not working because you need to install the Elementor plugin', DTLE_DOMAIN) . '</p>';
			$message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__('Install Elementor Now', DTLE_DOMAIN)) . '</p>';
		}

		echo '<div class="error"><p>' . $message . '</p></div>';
	}

    /**
	 * Register the widgets file in elementor widgets.
	 */
	public function dtle_widget_register() {
		require_once DTLE_PATH . 'includes/widgets/datalentor-table.php';
        require_once DTLE_PATH . 'includes/datalentor-functions.php';
	}

	/**
	 * Load scripts and styles
	 */
	public function dtle_widget_script_register() {		
        wp_register_style('dtle-common-style', DTLE_URL . 'assets/css/common-style.css', false);
        wp_enqueue_style('dtle-common-style');
        wp_register_style('dataTables', DTLE_URL . 'assets/css/dataTables.min.css', false);
        wp_enqueue_style('dataTables');
    }

}
endif;

/**
 * Initialize Plugin Class
 *
 * @access public
 * @since  1.0
 */
new DTLE_Datalentor();

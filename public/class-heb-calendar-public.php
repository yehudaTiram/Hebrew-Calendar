<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://atarimtr.co.il
 * @since      1.0.0
 *
 * @package    Heb_Calendar
 * @subpackage Heb_Calendar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Heb_Calendar
 * @subpackage Heb_Calendar/public
 * @author     Yehuda Tiram <yehuda@atarimtr.co.il>
 */
class Heb_Calendar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		global $post;   
		$cal_page_arr_options = $this->get_options('heb_calendar_pages_ids');
		$cal_page_IDs = explode (",", $cal_page_arr_options['heb_calendar_pages_ids']);
		$cal_page =  in_array($post->ID, $cal_page_IDs );		

		if( $cal_page ){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/heb-calendar-public.css', array(), rand( 1, 99999999999 ), 'all' );
		}
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		global $post;   
		$cal_page_arr_options = $this->get_options('heb_calendar_pages_ids');
		$cal_page_IDs = explode (",", $cal_page_arr_options['heb_calendar_pages_ids']);
		$cal_page =  in_array($post->ID, $cal_page_IDs );		

		if( $cal_page ){
			//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/heb-calendar-public.js', array( 'jquery' ), rand( 1, 99999999999 ), false );
			wp_register_script( 'modernizer-js', plugin_dir_url( __FILE__ ) . '/js/modernizr.custom.63321.js', array('jquery'), rand( 1, 99999999999 ), false );
			wp_enqueue_script( 'calendario-js', plugin_dir_url( __FILE__ ) . 'js/jquery.calendario.js', array( 'modernizer-js' ), rand( 1, 99999999999 ), false );

			wp_enqueue_script( 'localize-events', plugin_dir_url( __FILE__ ) . 'js/localize-events.js', array(  ), rand( 1, 99999999999 ), false );
			
			wp_localize_script( 'localize-events', 'acf_vars', array(
					'my_localized_var' => get_field( 'events' ),
				)
			);			
		}



	}

     /**
     * Options getter
     * @return array Options, either saved or default ones.
     */
    public function get_options()
    {
        $options = get_option($this->plugin_name);
        if (!$options && is_array($this->settings)) {
            $options = array();
            foreach ($this->settings as $section => $data) {
                foreach ($data['fields'] as $field) {
                    $options[$field['id']] = $field['default'];
                }
            }

            add_option($this->plugin_name, $options);
        }

        return $options;
    }
}

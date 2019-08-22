<?php

/**
 * The settings of the plugin.
 *
 * @link       http://atarimtr.co.il
 * @since      1.0.0
 *
 * @package    Heb_Calendar
 * @subpackage Heb_Calendar/admin
 * @author     Yehuda Tiram <yehuda@atarimtr.co.il>
 */
class Heb_Calendar_Admin_settings {
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
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $textdomain    The current version of this plugin.
     */
    private $textdomain;
    /*
     * Fired during plugins_loaded (very very early),
     * so don't miss-use this, only actions and filters,
     * current ones speak for themselves.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->textdomain = 'heb-calendar';
        
    }
    /*
     * Loads both the general and advanced settings from
     * the database into their respective arrays. Uses
     * array_merge to merge with default values if they're
     * missing.
     */
    /**
     * Initialise settings
     * @return void
     */
    public function init()
    {
        $this->settings = $this->settings_fields();
        $this->options = $this->get_options();        
        $this->register_settings();
        
    }
    
        /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function settings_fields()
    {
        $options = get_option($this->plugin_name);
        $settings['main'] = array(
            'title' => __('Set the options of the calendar<br />', $this->textdomain),
            'description' => __('', $this->textdomain),
            'fields' => array(
                array(
                    'id' => 'heb_calendar_pages_ids',
                    'label' => __('The pages IDs', $this->textdomain),
                    'description' => __('Write the pages IDs where you want to put the calendar in. Separate with comma ( eg 12,18,25). That will make the plugin load the js and css files only in those pages', $this->textdomain),
                    'type' => 'text',
                    'default' => __('', $this->textdomain),
                    'placeholder' => __('', $this->textdomain),
                ),  

            ),
        );

        $settings = apply_filters('plugin_settings_fields', $settings);

        return $settings;
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

    
    /**
     * Register plugin settings
     * @return void
     */
    public function register_settings()
    {
        if (is_array($this->settings)) {
            register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate_fields'));

            foreach ($this->settings as $section => $data) {
                // Add section to page
                add_settings_section($section, $data['title'], array($this, 'settings_section'), $this->plugin_name);

                foreach ($data['fields'] as $field) {
                    // Add field to page
                    add_settings_field($field['id'], $field['label'], array($this, 'display_field'), $this->plugin_name, $section, array('field' => $field));
                }
            }
        }
    }

    
    /**
     * Add settings link to plugin list table
     * @param  array $links Existing links
     * @return array         Modified links
     */
    public function add_action_links($links)
    {        
        $links[] = '<a href="https://atarimtr.co.il" target="_blank">More plugins by Yehuda Tiram</a>';
        return $links;
    }


    public function add_menu_item()
    {
        $page = add_options_page($this->plugin_name, $this->plugin_name, 'manage_options', $this->plugin_name, array($this, 'settings_page'));

    }
    
    public function settings_section($section)
    {
        $html = '<p> ' . $this->settings[$section['id']]['description'] . '</p>' . "\n";
        echo $html;
    }

    /**
     * Generate HTML for displaying fields
     * @param  array $args Field data
     * @return void
     */
    public function display_field($args)
    {
        

        $field = $args['field'];

        $html = '';

        $option_name = $this->plugin_name . "[" . $field['id'] . "]";

        $data = (isset($this->options[$field['id']])) ? $this->options[$field['id']] : '';

        switch ($field['type']) {

            case 'text':
                $html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="' . $data . '"/>' . "\n";
                break;
            case 'password':
            case 'number':
                $html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="' . $data . '"/>' . "\n";
                break;

            case 'text_secret':
                $html .= '<input id="' . esc_attr($field['id']) . '" type="text" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '" value=""/>' . "\n";
                break;

            case 'textarea':
                $html .= '<textarea id="' . esc_attr($field['id']) . '" rows="5" cols="50" name="' . esc_attr($option_name) . '" placeholder="' . esc_attr($field['placeholder']) . '">' . sanitize_textarea_field($data) . '</textarea><br/>' . "\n";
                break;

            case 'checkbox':
                $checked = '';
                if ($data && 'on' == $data) {
                    $checked = 'checked="checked"';
                }
                $html .= '<input id="' . esc_attr($field['id']) . '" type="' . $field['type'] . '" name="' . esc_attr($option_name) . '" ' . $checked . '/>' . "\n";
                break;

            case 'checkbox_multi':
                foreach ($field['options'] as $k => $v) {
                    $checked = false;
                    if (is_array($data) && in_array($k, $data)) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr($field['id'] . '_' . $k) . '"><input type="checkbox" ' . checked($checked, true, false) . ' name="' . esc_attr($option_name) . '[]" value="' . esc_attr($k) . '" id="' . esc_attr($field['id'] . '_' . $k) . '" /> ' . $v . '</label> ';
                }
                break;

            case 'radio':
                foreach ($field['options'] as $k => $v) {
                    $checked = false;
                    if ($k == $data) {
                        $checked = true;
                    }
                    $html .= '<label for="' . esc_attr($field['id'] . '_' . $k) . '"><input type="radio" ' . checked($checked, true, false) . ' name="' . esc_attr($option_name) . '" value="' . esc_attr($k) . '" id="' . esc_attr($field['id'] . '_' . $k) . '" /> ' . $v . '</label> ';
                }
                break;

            case 'select':
                $html .= '<select name="' . esc_attr($option_name) . '" id="' . esc_attr($field['id']) . '">';
                foreach ($field['options'] as $k => $v) {
                    $selected = false;
                    if ($k == $data) {
                        $selected = true;
                    }
                    $html .= '<option ' . selected($selected, true, false) . ' value="' . esc_attr($k) . '">' . $v . '</option>';
                }
                $html .= '</select> ';

                break;

            case 'select_multi':
                $html .= '<select name="' . esc_attr($option_name) . '[]" id="' . esc_attr($field['id']) . '" multiple="multiple">';
                foreach ($field['options'] as $k => $v) {
                    $selected = false;
                    if ($data) {
                        if (in_array($k, $data)) {
                            $selected = true;
                        }
                    }

                    $html .= '<option ' . selected($selected, true, false) . ' value="' . esc_attr($k) . '" />' . $v . '</label> ';
                }
                $html .= '</select> ';
                break;

        }

        switch ($field['type']) {

            case 'checkbox_multi':
            case 'radio':
            case 'select_multi':
                $html .= '<br/><span class="description">' . $field['description'] . '</span>';
                break;

            default:
                $html .= '<label for="' . esc_attr($field['id']) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
                break;
        }
        
        echo $html;
    }

    /**
     * Validate individual settings field
     * @param  string $data Inputted value
     * @return string       Validated value
     */
    public function validate_fields($data)
    {

        //Sanitize and validate the price options rows
        foreach ($_POST as $key => $val) {
            if ($data['heb_calendar_pages_ids']) {  
                $sanitzeIDs = wp_parse_id_list( $data['heb_calendar_pages_ids']);  
                $data['heb_calendar_pages_ids'] = implode (",", $sanitzeIDs);  
                
            }           
        }
        return $data;
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page()
    {
        // Build page HTML output
        // If you don't need tabbed navigation just strip out everything between the <!-- Tab navigation --> tags.
        ?>
		<div class="wrap <?php echo $this->plugin_name; ?>-wrap" id="<?php echo $this->plugin_name; ?>">
		<h2><?php _e('Hebrew calendar options', $this->textdomain);?></h2>
		<p><?php _e('Settings.', $this->textdomain);?></p>

		<!-- Tab navigation starts -->
		<h2 class="nav-tab-wrapper settings-tabs hide-if-no-js">
		<?php
foreach ($this->settings as $section => $data) {
            echo '<a href="#' . $section . '" class="nav-tab">' . $data['title'] . '</a>';
        }
        ?>
		</h2>
		<?php $this->do_script_for_tabbed_nav();?>
		<!-- Tab navigation ends -->
		<form action="options.php" method="POST">
		<?php settings_fields($this->plugin_name);?>
		<div class="settings-container">
		<?php do_settings_sections($this->plugin_name);?>
		</div>
		<?php submit_button();?>
		</form>
		</div>
		<?php
}

    /**
     * Print jQuery script for tabbed navigation
     * @return void
     */
    private function do_script_for_tabbed_nav()
    {
        // Very simple jQuery logic for the tabbed navigation.
        // Delete this function if you don't need it.
        // If you have other JS assets you may merge this there.
        ?>
		<script>
		jQuery(document).ready(function($) {
			var headings = jQuery('.settings-container > h2, .settings-container > h3');
			var paragraphs  = jQuery('.settings-container > p');
			var tables = jQuery('.settings-container > .section-tab-content');
			var triggers = jQuery('.settings-tabs a');

			triggers.each(function(i){
				triggers.eq(i).on('click', function(e){
					e.preventDefault();
					triggers.removeClass('nav-tab-active');
					headings.hide();
					paragraphs.hide();
					tables.hide();

					triggers.eq(i).addClass('nav-tab-active');
					headings.eq(i).show();
					paragraphs.eq(i).show();
					tables.eq(i).show();
				});
			})

			triggers.eq(0).click();
		});
		</script>
		<?php
}
    public function check_isset_post($field_name)
    {
        if (isset($_POST[$field_name]) && !empty($_POST[$field_name])) {return true;} else {return false;}
    }
}
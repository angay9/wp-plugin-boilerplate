<?php

namespace PluginBoilerplate\Settings;

/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class Settings 
{
	protected $plugin_settings;

    protected $title = 'Plugin Settings';

    public function __construct() 
    {
		add_action('admin_menu', [$this, 'plugin_settings_add_plugin_page']);
        add_action('admin_init', [$this, 'plugin_settings_page_init']);
    }

	public function plugin_settings_add_plugin_page() {
		add_menu_page(
			$this->title, // page_title
			$this->title, // menu_title
			'manage_options', // capability
			'plugin-settings', // menu_slug
			[$this, 'plugin_settings_add_admin_page'], // function
			'dashicons-admin-generic', // icon_url
			81 // position
        );
    }

	public function plugin_settings_add_admin_page() {
		$this->plugin_settings = get_option('plugin_settings'); ?>

		<div class="wrap">
			<h2><?php echo $this->title; ?></h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields('plugin_settings_option_group');
					do_settings_sections('plugin-settings');
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function plugin_settings_page_init() {
		register_setting(
			'plugin_settings_option_group', // option_group
			'plugin_settings', // option_name
			[$this, 'plugin_settings_sanitize']// sanitize_callback
		);

		add_settings_section(
			'plugin_settings_setting_section', // id
			'Settings', // title
			[$this, 'plugin_settings_section_info'], // callback
			'plugin-settings' // page
		);

		add_settings_field(
			'plugin_settings_sample_field', // id
			'Sample Field', // title
			[$this, 'sample_field'], // callback
			'plugin-settings', // page
			'plugin_settings_setting_section' // section
        );
    }

    public function plugin_settings_section_info()
    {
        
    }
    
	public function plugin_settings_sanitize($input) {
        $sanitary_values = [];
        $sanitize_fields = [
            'sample_field',
        ];

        foreach ($sanitize_fields as $field) {
            if (is_array($input[$field])) {
                $sanitary_values[$field] = array_map('esc_attr', $input[$field]);
            }
            else {
                $sanitary_values[$field] = sanitize_text_field($input[$field]);
            }
        }

		return $sanitary_values;
	}

	public function sample_field() {
		printf(
			'<input class="regular-text" type="text" name="plugin_settings[sample_field]" id="sample_field" value="%s">',
			pb_array_get($this->plugin_settings, 'sample_field', '')
		);
    }
}
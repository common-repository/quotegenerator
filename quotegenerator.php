<?php
/*
Plugin Name:Quote Generator
Plugin URL: http://quotegeneratorplus.com
Version: 1.1
Autor: Vitaliy Zakhodylo
Autor URL: http://quotegeneratorplus.com
Description: Quoting and ordering software.
*/

function PHP_Include($params = array()) {
	extract(shortcode_atts(array('file' => 'default'), $params));
	ob_start();
	include(get_theme_root() . '/' . get_template() . "/$file.php");
	return ob_get_clean();
}

// register shortcode
add_shortcode('quotegenerator', 'PHP_Include');

//The following shortcode can now be added to any page or post: [quotegenerator file='qgcode']
//Assuming qgcode.php exists in your theme’s folder, it will be inserted at that point in the content.


if(!class_exists('Quote_Generator')){
	class Quote_Generator	{
              
		public function __construct()		{
			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Quote_Generator_Settings = new Quote_Generator_Settings();

			// Register custom post types
			require_once(sprintf("%s/post-types/post_type_template.php", dirname(__FILE__)));
			$Post_Post_Quote_Generator = new Post_Quote_Generator();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		}

		public static function activate()	{
			// This will run when the plugin is activated, setup the database.
			$arrvalues = array('','100%','#fefefe','1px solid #cccccc','#ffffff','11px','#006BB2','#666666','11px','#dddddd','hide','show','show','hide','show','show','show','USD','$','Tax','0','','','','','#','Item','Price','Quantity','Discount','Amount','Submit an Order','Submit','#4D97C9','#ffffff','Name','Phone','');
			for($xv=1; $xv<=37; $xv++){
			    $oname = 'setting_qg'.$xv;
			    $ovalue = $arrvalues[$xv];
			    $sql = "INSERT INTO `wp_options` (option_name, option_value, autoload) VALUES('$oname','$ovalue','yes')";
   	                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		            dbDelta($sql);
			}

			
		} 

		public static function deactivate()	{
			// Do nothing
		}

		// Add the settings link to the plugins page
		function plugin_settings_link($links)	{
			$settings_link = '<a href="options-general.php?page=quotegenerator">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}

	} 
}

if(class_exists('Quote_Generator')){// instantiate the plugin class
	register_activation_hook(__FILE__, array('Quote_Generator', 'activate'));
	register_deactivation_hook(__FILE__, array('Quote_Generator', 'deactivate'));
	$wp_plugin_template = new Quote_Generator();
}
?>
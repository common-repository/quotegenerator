<?php
if(!class_exists('Quote_Generator_Settings')){
    class Quote_Generator_Settings	{
	public function __construct()	{
		 // register actions
                 add_action('admin_init', array(&$this, 'admin_init'));
        	 add_action('admin_menu', array(&$this, 'add_menu'));
	}
	
         // hook into WP's admin_init action hook
        public function admin_init()   {    // register your plugin's settings

		for($qx=1;$qx<=9;$qx++){
		    register_setting('wp_plugin_template-group', 'setting_qg'.$qx);
		}

		for($qx=10;$qx<=37;$qx++){
		    register_setting('wp_plugin_template-group2', 'setting_qg'.$qx);
		}
		
        	//add_settings_section('wp_plugin_template-section','Quote_Generator_Settings',array(&$this, 'settings_section_qg'),'wp_plugin_template');
        	add_settings_section('wp_plugin_template-section','',array(&$this, 'settings_section_qg'),'quotegenerator');
		add_settings_section('wp_plugin_template-section','',array(&$this, 'settings_section_qg2'),'quotegenerator2');
		
		$arrfields = array('','Form width','Form background','Form border','Header text color','Header font size','Header background','Font color','Font size','Font background','Quantity Discounts','Order Total Discount','Description','Price','Subtotal','Total before tax','Tax','Currency Symbol','Currency Sign','Tax 1 Name','Tax 1 %','Tax 2 Name','Tax 2 %','Tax 3 Name','Tax 3 %','Header Name 1','Header Name 2','Header Name 3','Header Name 4','Header Name 5','Header Name 6','Button 1','Button 2','Buttons background','Buttons text color','Submit field 1','Submit field 2','Submit field 3');
		
                
		for($qx=1; $qx<=9; $qx++){
		    add_settings_field(
                      'wp_plugin_template-setting_qg'.$qx, 
		      $arrfields[$qx],
                      array(&$this, 'settings_field_input_text'), 'quotegenerator', 'wp_plugin_template-section',
                      array('field' => 'setting_qg'.$qx)
                    );	
		}
		for($qx=10; $qx<=37; $qx++){
		    add_settings_field(
                      'wp_plugin_template-setting_qg'.$qx, 
		      $arrfields[$qx],
                      array(&$this, 'settings_field_input_text'), 'quotegenerator2', 'wp_plugin_template-section',
                      array('field' => 'setting_qg'.$qx)
                    );	
		}
		
            // Possibly do additional admin_init tasks
        }
        
        public function settings_section_qg()   {
            echo '<div style="font-family: Arial;font-size: 12px;background:#ff991d;padding:3px;color:#ffffff;text-align:center;">Style</div>';
        }
        public function settings_section_qg2()   {
            echo '<div style="font-family: Arial;font-size: 12px;background:#ff991d;padding:3px;color:#ffffff;text-align:center;">Form</div>';
        }
         // This function provides text inputs for settings fields
	 
	 
        public function settings_field_input_text($args)   {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
	    $colmesg='';
	    $errmesg ='';
	    $arrvalues = array('','100%','#fefefe','1px solid #cccccc','#ffffff','11px','#006BB2','#666666','11px','#dddddd','hide','show','show','hide','show','show','show','USD','$','Tax','0','','','','','#','Item','Price','Quantity','Discount','Amount','Submit an Order',' Submit ','#4D97C9','#ffffff','Name','','');
	    if($value == ''){
		$value0 = filter_var($field, FILTER_SANITIZE_NUMBER_INT);
		$value = $arrvalues[$value0];
		if($value != ''){
		   $colmesg='color:red;';
		   $errmesg = '<span style="font-size: 9px;color:red;"> This field cannot be blank. Please click [Save Changes].</span>';
		}
	    }

            echo sprintf('<input type="text" name="%s" id="%s" value="%s" style="font-family: Arial;font-size: 12px;margin:0px;text-align : left;'.$colmesg.'" />'.$errmesg, $field, $field, $value);
        } 
        
		
        public function add_menu()        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Quote Generator Settings', 
        	    'Quote_Generator', 
        	    'manage_options', 
        	    'quotegenerator', 
        	    array(&$this, 'plugin_settings_page')
        	);
        } 
    
        // Menu Callback
        public function plugin_settings_page()         {
        	if(!current_user_can('manage_options')){
        	    wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));	
        }
	
   }
}
?>
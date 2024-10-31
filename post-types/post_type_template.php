<?php
if(!class_exists('Post_Quote_Generator')) {
	// A Post class that provides additional meta fields
	class Post_Quote_Generator	  {
		const POST_TYPE	= "post-type-template";
                private $_meta = array('meta_qg1','meta_qg2','meta_qg3','meta_qg4','meta_qg5','meta_qg6','meta_qg7','meta_qg8','meta_qg9','meta_qg10','meta_qg11','meta_qg12','meta_qg13','meta_qg14','meta_qg15','meta_qg16','meta_qg17','meta_qg18','meta_qg19','meta_qg20','meta_qg21','meta_qg22','meta_qg23','meta_qg24','meta_qg25','meta_qg26','meta_qg27','meta_qg28','meta_qg29','meta_qg30','meta_qg31','meta_qg32','meta_qg33','meta_qg34','meta_qg35','meta_qg36','meta_qg37');

	
	
    	 // The Constructor
    	public function __construct()  	{
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'admin_init'));
    	}
	
    	// hook into WP's init action hook
    	public function init()    	{	
    		$this->create_post_type();
    		add_action('save_post', array(&$this, 'save_post'));
    	} 

    	 // Create the post type
    	public function create_post_type()    	{
    		register_post_type(self::POST_TYPE,
    			array('labels' => array(
    					'name' => __(sprintf('%ss', ucwords(str_replace("_", " ", self::POST_TYPE)))),
    					'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))),
    				'public' => true,
    				'has_archive' => true,
    				'description' => __("This is a QG post type"),
    				'supports' => array('title', 'editor', 'excerpt'),
    			)
    		);
    	}
	
     // Save the metaboxes for this custom post type
    	public function save_post($post_id)    	{
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id)){
    			foreach($this->_meta as $field_name){	// Update the post's meta field
    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
    			}
    		}else{
    			return;
    		} 
    	}

    	 // hook into WP's admin_init action hook
    	public function admin_init()  	{
    		add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
    	} 
			
    	 // hook into WP's add_meta_boxes action hook
    	public function add_meta_boxes(){	// Add this metabox to every selected post
    		add_meta_box( 
    			sprintf('wp_plugin_template_%s_section', self::POST_TYPE),
    			sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
    			array(&$this, 'add_inner_meta_boxes'),self::POST_TYPE
    	        );					
    	}

		public function add_inner_meta_boxes($post)	{		
			include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));			
		}

	}
}
<?php
/**
* Plugin Name: WP Scholarship Finder
* Plugin URI: https://www.pickascholarship.com/
* Version: 2.1
* Description: This plugin provide you facility to search scholarships provided by universities all around world.
* Author: Pick A Scholarship
* Author URI: https://www.pickascholarship.com/
**/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
 
define('EduScholarship_ROOT', dirname(__FILE__));
define('EduScholarship_URL', plugins_url('/', __FILE__));
define('EduScholarship_NETWORK_ADMIN', admin_url( 'admin.php?page=', 'http' ));
define('EduScholarship_HOME', home_url('/'));
define('EduScholarship_IMAGES_PATH',EduScholarship_URL.'assests/images');
define('EduScholarship_CSS_PATH',EduScholarship_URL.'assests/css');
define('EduScholarship_JS_PATH',EduScholarship_URL.'assests/js');
define('EduScholarship_plugin_dirpath', plugin_dir_path( __FILE__ ) );

class wp_education_scholarship_fn
{
    /** 
     * Initialized in the constructor
     * @access private
     * @var array
     */
	 
    private $sidebar_status = array();	
	
    /**
     * Constructor 
     */
	 
    public function __construct() 
	{
		/*Custom Hooks for style and js files - Admin panel */
		
		add_action( 'wp_enqueue_scripts', array(&$this, 'register_education_scholarship_scripts') );
		
		add_action( 'admin_menu', array( $this, 'register_wp_scholarship_admin_menu' ) );
		
		/* Call Classes  */
		$this->internal_scholarship_features();
		
		$wp_education_internal_cls=new wp_edu_scholarship_search();
    }
	
    /*Include JS and CSS in Front Panel*/
	
	public function register_education_scholarship_scripts($hook)
	{
	    $pluginpath=get_site_url();
		
		$no_of_pages_counter=get_option("no_of_pages_counter");
		if($no_of_pages_counter=='')
		{
			$no_of_pages_counter=10;
		}
		
		if(!wp_script_is('jquery')) 
		{
		    wp_enqueue_script('jquery');
		}
		
		wp_register_style( 'education_scholarship_style', plugins_url( 'assests/css/edu_scholarship_style.css', __FILE__ ));
		
	    wp_enqueue_style( 'education_scholarship_style' );
		
		wp_register_script("education_scholarship_js", plugins_url( 'assests/js/jquery-wp-scholarship.js', __FILE__ ), array("jquery"),time(), true );
		
		$script_arr=array(
            'scholarship_ajaxurl' => admin_url( 'admin-ajax.php' ),
            'page_limit' => $no_of_pages_counter,
        );
		
		wp_localize_script("education_scholarship_js","sch_ajax_obj",$script_arr);
		
		wp_enqueue_script("education_scholarship_js");
		
	}
	
	/*Attach menu in admin panel under Setting menu */
	
	function register_wp_scholarship_admin_menu()
	{
		add_options_page("WP Scholarship Setting", "WP Scholarship Setting", "administrator", "wp_scholarship_setting", array($this, "wp_search_scholarship_fn"));
	}
	
	/*Include Classes*/
	
	public function internal_scholarship_features() 
	{
		include( 'lib/class_scholarship_search.php' );
	} 
	
	/*Include Menu in admin*/
	
	public function wp_search_scholarship_fn()
	{
		global $wpdb;
		
		include("admin/wp_scholarship_admin_setting.php");
		
	}
	
}
global $wp_eductaion_scholarships_info;
$wp_eductaion_scholarships_info = new wp_education_scholarship_fn();
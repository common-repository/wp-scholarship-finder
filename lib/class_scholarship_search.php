<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class wp_edu_scholarship_search
{
    public function __construct() 
	{ 
	    /*****Declaration of action hooks*****/
		add_shortcode("wp_education_scholarship_search",array(&$this, 'register_education_scholarship_shortcode'));
		
		/*Hooks to run ajax*/
		
		add_action("wp_ajax_search_scholarship_info", array(&$this, "wp_search_scholarship_info_fn"));
        
		add_action("wp_ajax_nopriv_search_scholarship_info", array(&$this, "wp_search_scholarship_info_fn"));
		
	}
	
	function register_education_scholarship_shortcode()
	{
        ob_start();
		
		global $wpdb;
		
		include("inc/scholarship_search_form.php");
		
	    $getshortcodeoutput=ob_get_clean();	
		
		return $getshortcodeoutput;
		
	}
	
	function wp_search_scholarship_info_fn()
	{
		include("inc/search_scholarship_info.php");
		
		die();
	}
}	
?>
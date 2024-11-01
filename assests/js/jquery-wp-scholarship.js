/**
 * WP Scholarship listing JS
 */
var ajaxrunpath=sch_ajax_obj.scholarship_ajaxurl;
var posts_per_page=sch_ajax_obj.page_limit;

jQuery(document).ready(function(){
	
	jQuery("#unq_search_scholarship").click(function(){
		
		search_scholarship_data();
		
		return false;
	});
	
});

function search_scholarship_data()
{
	jQuery("#scholarship_ajx_loader").show();
	
	jQuery.ajax({
			url: ajaxrunpath+"?action=search_scholarship_info",
			method: "POST",
			data: jQuery("#scholarship_from_data").serialize()+'&posts_per_page='+posts_per_page,
			success:function(resphtml)
			{
				jQuery("#scholarship_ajx_loader").hide();
				jQuery("#scholarship_listing_module").html(resphtml);
			}
	});	
	return false;
}

function load_pagination_data(pageno)
{
	jQuery(".scholarship_page_loader").show();
	
	jQuery.ajax({
			url: ajaxrunpath+"/?action=search_scholarship_info",
			method: "POST",
			data: jQuery("#scholarship_from_data").serialize()+"&pageno="+pageno+"&posts_per_page="+posts_per_page,
			success:function(resphtml)
			{
				jQuery(".scholarship_page_loader").hide();
				jQuery("#scholarship_listing_module").html(resphtml);
			}
	});	
	return false;
}
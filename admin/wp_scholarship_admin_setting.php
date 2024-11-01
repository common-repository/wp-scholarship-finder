<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( current_user_can('administrator') )  /*This part only access by administrator*/
{
	if(isset($_POST['submit_scholar_setting']))
	{
		$wpadmsch_nonce = sanitize_text_field( $_POST['wp_admin_scholar_nonce'] );
		if(!wp_verify_nonce($wpadmsch_nonce, 'my_admin_scholar_nonce' ) ) 
		{
			die( 'Security check' ); 
		}else{
			$heading_scholarship_form = sanitize_text_field( $_POST['heading_scholarship_form'] );
			$srchbutton_scholarship_form = sanitize_text_field( $_POST['srchbutton_scholarship_form'] );
			$noofpages_scholarship_form = sanitize_text_field( $_POST['noofpages_scholarship_form'] );
			update_option("search_box_heading",$heading_scholarship_form);
			update_option("search_button_name",$srchbutton_scholarship_form);
			update_option("no_of_pages_counter",$noofpages_scholarship_form);
		}
	}

	$search_box_heading=get_option("search_box_heading");
	$search_button_name=get_option("search_button_name");
	$no_of_pages_counter=get_option("no_of_pages_counter");

	if($no_of_pages_counter=='')
	{
		$no_of_pages_counter="10";
	}
	if($search_box_heading=='')
	{
		$search_box_heading="Scholarships and Student Grants Finder";
	}
	if($search_button_name=='')
	{
		$search_button_name="Search";
	}

	$wp_getadmin_nonce = wp_create_nonce( 'my_admin_scholar_nonce' );

	?>

	<div class="wrap scholarship_search_setting">
		<h1>WP Scholarship Search Setting</h1>
		<form method="post" action="" name="scholarship_admin_form">
			<input type="hidden" name="wp_admin_scholar_nonce" value="<?php echo $wp_getadmin_nonce; ?>" />
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="heading_scholarship_form">Heading above search box</label>
						</th>
						<td>
							<input name="heading_scholarship_form" id="heading_scholarship_form" value="<?php echo $search_box_heading; ?>" class="regular-text" type="text" placeholder="default (Scholarships and Student Grants Finder)">
							<p class="description" id="heading-description">This heading will appear above the search box in frontend.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="srchbutton_scholarship_form">Search Button Name</label>
						</th>
						<td>
							<input name="srchbutton_scholarship_form" id="srchbutton_scholarship_form" value="<?php echo $search_button_name; ?>" class="regular-text" type="text" placeholder="default (Search)">
							<p class="description" id="heading-description">Name of search button (default is "Search").</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="noofpages_scholarship_form">No of records per page</label>
						</th>
						<td>
							<input name="noofpages_scholarship_form" id="noofpages_scholarship_form" value="<?php echo $no_of_pages_counter; ?>" class="regular-text" type="number">
							<p class="description" id="heading-description">No of scholarship records to list single time in pagination. Default is 10</p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input name="submit_scholar_setting" id="submit_scholar_setting" class="button button-primary" value="Save Changes" type="submit">
			</p>
		</form>
	</div>
<?php }else{ ?>
<div class="wrap scholarship_search_setting">
	<p>You don't have permissions to review this page.
</diV>
<?php } ?>
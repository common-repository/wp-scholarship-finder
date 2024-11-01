<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
extract($_REQUEST);

if(!wp_verify_nonce($wp_scholar_nonce, 'my_scholarship_search_nonce' ) ) {

    die( 'Security check' ); 

}else{
    /*Run CURL to get fields data*/
	
	if(!isset($pageno))
	{
		$data=json_encode(array('area_of_study'=>trim($area_of_study),'scholarship_country'=>trim($scholarship_country),'scholarship_valid_date'=>trim($scholarship_valid_date),'scholarship_type'=>trim($scholarship_type),'applier_country'=>trim($applier_country),'scholarship_amount'=>trim($scholarship_amount),'scholarship_admin_type'=>trim($scholarship_admin_type),'expense_covered'=>trim($expense_covered),'scholarship_mode'=>trim($scholarship_mode),'posts_per_page'=>$posts_per_page));

	}else{
		
		$data=json_encode(array('area_of_study'=>trim($area_of_study),'scholarship_country'=>trim($scholarship_country),'scholarship_valid_date'=>trim($scholarship_valid_date),'scholarship_type'=>trim($scholarship_type),'applier_country'=>trim($applier_country),'scholarship_amount'=>trim($scholarship_amount),'scholarship_admin_type'=>trim($scholarship_admin_type),'expense_covered'=>trim($expense_covered),'scholarship_mode'=>trim($scholarship_mode),'pageno'=>trim($pageno),'posts_per_page'=>trim($posts_per_page)));
	}

	$postUrl = "http://www.pickascholarship.com/api/scholarship_search_api.php?action=search_scholarship&apikey=53t181Hf3Xe8e472aye7695167V9Q08a4c&secret=TY9p3W2U7bXp";

	$data_attrs = $data;
	$request_args = array(
		'body' => $data_attrs,
		'headers' => array(
			'Content-Type => application/json',
		),
	);
	$get_response = wp_remote_post($postUrl, $request_args);
	if ( is_wp_error( $get_response ) ) 
	{
		//Error in getting response from CURL
	}else{
		$raw_response=$get_response['body'];
		$getrawresponse=json_decode($raw_response);
		$getscholarshiplisting=$getrawresponse->Message->response_data;
		$getscholarshippagination=$getrawresponse->Message->pagination;
		$getscholarshippagelink=$getrawresponse->Message->scholarship_slug;
	}
	/*Run CURL to get fields data*/

	if(!empty($getscholarshiplisting))
	{
		foreach($getscholarshiplisting as $singlescholarship)
		{
			$getsinglescholarship=$singlescholarship->scholarship_details;
			$getscholarshipdata=$singlescholarship->scholarship_post_details;
			
			$scholarid=$getsinglescholarship->scholarship_id;
			$area_of_study=$getsinglescholarship->area_of_study;
			$scholarship_country=$getsinglescholarship->scholarship_country;
			$scholarship_valid_date=$getsinglescholarship->scholarship_valid_date;
			$scholarship_type=$getsinglescholarship->scholarship_type;
			$applier_country=$getsinglescholarship->applier_country;
			$scholarship_amount=$getsinglescholarship->scholarship_amount;
			$scholarship_administrator=$getsinglescholarship->scholarship_administrator;
			$scholarship_expenses=$getsinglescholarship->scholarship_expenses;
			$scholarship_mode=$getsinglescholarship->scholarship_mode;
			$scholarship_ext_link=$getsinglescholarship->scholarship_ext_link;
			$scholarship_contact_details=$getsinglescholarship->scholarship_contact_details;
			
			$getscholarshiptitle=$getscholarshipdata->post_title;
			$getscholarshipslug=$getscholarshipdata->post_name;
			

			$scholarship_short_content=$getscholarshipdata->post_content;
			$trimmed_content = wp_trim_words( $scholarship_short_content, 15, '...' );

		?>
			<div class="scholarship_schools_listing">
				<p>
					<strong>Scholarship Name :</strong> <a href="<?php echo $getscholarshippagelink; ?>/<?php echo $getscholarshipslug; ?>"><?php echo $getscholarshiptitle; ?></a><br>

					<strong>Country :</strong> <?php echo ucwords($scholarship_country); ?><br>
					<strong>Description :</strong> <?php echo ucwords($trimmed_content); ?><br>

					<!--<strong>Apply from :</strong> <?php echo ucwords($applier_country); ?>-->
					
					<a href="<?php echo $getscholarshippagelink; ?>/<?php echo $getscholarshipslug; ?>" title="<?php echo $getscholarshiptitle; ?>" class="btn btn-theme-primary scholarship_viewmore_link" target="_blank">View Details <i aria-hidden="true" class="fa fa-chevron-right"></i></a>
				</p>
			</div>
		<?php
		}
		?>
			<?php if(!empty($getscholarshippagination)){  ?>
			<div id="scholarship_pagination_ct">
				<?php echo $getscholarshippagination; ?>
			</div>
			<?php } ?>
		<?php
	}else{
		?>
		<div class="scholarship_schools_listing">
			<p>
				<strong>No scholarships found.</strong>
			</p>
		</div>
		<?php
	}
}
?>
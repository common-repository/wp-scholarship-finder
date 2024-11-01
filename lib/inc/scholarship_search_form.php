<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/*Run CURL to get fields data*/
global $wpdb;
$postUrl = "http://www.pickascholarship.com/api/scholarship_search_api.php?action=form_fields_data&apikey=53t181Hf3Xe8e472aye7695167V9Q08a4c&secret=TY9p3W2U7bXp";

$data_attrs = array();
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
	$getresult=json_decode($raw_response);
	$country_array=$getresult->Message->scholarship_countries;
	$getareaofstudyarr=$getresult->Message->scholarship_courses;
	$getscholartypesarr=$getresult->Message->scholarship_types;
	$getscholaradminarr=$getresult->Message->scholarship_adminitrators;
	$getscholarexpensearr=$getresult->Message->scholarship_expenses;
	$getscholareamountsarr=$getresult->Message->scholarship_amounts;
}
/*Run CURL to get fields data*/

$searchformid="scholarship_from_data";
$searchsubmitid="unq_search_scholarship";
$searchsubmitname="search_scholarship";
$actionval='';

$search_box_heading=get_option("search_box_heading");
$search_button_name=get_option("search_button_name");
$no_of_pages_counter=get_option("no_of_pages_counter");

if($search_box_heading=='')
{
	$search_box_heading="Scholarships and Student Grants Finder";
}
if($search_button_name=='')
{
	$search_button_name="Search";
}

if($no_of_pages_counter=='')
{
	$no_of_pages_counter=10;
}

$wp_get_nonce = wp_create_nonce( 'my_scholarship_search_nonce' );
?>
<div class="search_sec">

<h2><?php echo $search_box_heading; ?></h2>

<form class="form-inline" name="scholarship_formnm" id="<?php echo $searchformid; ?>" action="<?php echo trim($actionval); ?>" method="post">
<input type="hidden" name="wp_scholar_nonce" value="<?php echo $wp_get_nonce; ?>" />
<div class="col-sm-4">
	<div class="form-group">
		<select class="form-control" name="area_of_study">
			<option value="">Area of study</option>
			<?php
			    if(!empty($getareaofstudyarr))
				{
				    foreach($getareaofstudyarr as $areasofstudy)
					{
						$areasofstudy=trim($areasofstudy);
						?>
						<option value="<?php echo $areasofstudy; ?>" <?php if(isset($_REQUEST['area_of_study']) && stripslashes(trim($_REQUEST['area_of_study']))==$areasofstudy){ echo 'selected="selected"'; } ?> ><?php echo $areasofstudy; ?></option>
						<?php
					}
				}
			?>
		</select>
	</div>
</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="scholarship_country">

			<option value=""> Country of the Scholarship</option>

			<?php
			    if(!empty($country_array))
				{
					foreach($country_array as $countrynm)
					{
						$countrynm=trim($countrynm);
						?>
						<option value="<?php echo $countrynm; ?>" <?php if(isset($_REQUEST['scholarship_country']) && stripslashes(trim($_REQUEST['scholarship_country']))==$countrynm){ echo 'selected="selected"'; } ?> ><?php echo $countrynm; ?></option>
						<?php
					}
					
				}
			?>
			
		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="scholarship_valid_date">

			<option value="">Scholarship Valid Until (Year)</option>
			
            <option value="All">All</option>
			<?php
				$currentyear=date("Y");
				
				$incyear=$currentyear+3;
				
				for($y=$currentyear;$y<$incyear;$y++)
				{
					?>
					<option value="<?php echo $y; ?>" <?php if(isset($_REQUEST['scholarship_valid_date']) && stripslashes(trim($_REQUEST['scholarship_valid_date']))==$y){ echo 'selected="selected"'; } ?> ><?php echo $y; ?></option>
					<?php
				}
			?>

		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">
     
		<select class="form-control" name="scholarship_type">

			<option value="">Type of scholarship</option>
			
			<?php
			    if(!empty($getscholartypesarr))
				{
				    foreach($getscholartypesarr as $scholarshiptype)
					{
						$scholarshiptype=trim($scholarshiptype);
						
						?>
						<option value="<?php echo $scholarshiptype; ?>" <?php if(isset($_REQUEST['scholarship_type']) && stripslashes(trim($_REQUEST['scholarship_type']))==$scholarshiptype){ echo 'selected="selected"'; } ?> ><?php echo $scholarshiptype; ?></option>
						<?php
					}
				}
			?>
 

		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">
	
		<select class="form-control" name="applier_country">
		    <option value="">Applier's country</option>
			<?php
			    if(!empty($country_array))
				{
					foreach($country_array as $countrynm)
					{
						$countrynm=trim($countrynm);
						?>
						<option value="<?php echo $countrynm; ?>" <?php if(isset($_REQUEST['applier_country']) && stripslashes(trim($_REQUEST['applier_country']))==$countrynm){ echo 'selected="selected"'; } ?> ><?php echo $countrynm; ?></option>
						<?php
					}
					
				}
			?>
        </select>
	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="scholarship_amount">

			<option value=""> Scholarship amount given</option>
			
			<?php 
				if(!empty($getscholareamountsarr))
				{ 
					foreach($getscholareamountsarr as $singleamount)
					{
						$singleamount=trim($singleamount);
				?>
					<option value="<?php echo $singleamount; ?>" <?php if(isset($_REQUEST['scholarship_amount']) && stripslashes(trim($_REQUEST['scholarship_amount']))==$singleamount){ echo 'selected="selected"'; } ?> ><?php echo $singleamount; ?></option>
			<?php }
			
			}?>

		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="scholarship_admin_type">

			<option value=""> Type of scholarship administrator</option>
            
			<?php 
				if(!empty($getscholaradminarr))
				{ 
					foreach($getscholaradminarr as $singleadmin)
					{
						$singleadmin=trim($singleadmin);
				?>
					<option value="<?php echo $singleadmin; ?>" <?php if(isset($_REQUEST['scholarship_admin_type']) && stripslashes(trim($_REQUEST['scholarship_admin_type']))==$singleadmin){ echo 'selected="selected"'; } ?> ><?php echo $singleadmin; ?></option>
			<?php }
			
			}?>

		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="expense_covered">

			<option value="">Expenses covered</option>
            
			<?php 
				if(!empty($getscholarexpensearr))
				{ 
					foreach($getscholarexpensearr as $singleexpense)
					{
						$singleexpense=trim($singleexpense);
				?>
					<option value="<?php echo $singleexpense; ?>" <?php if(isset($_REQUEST['expense_covered']) && stripslashes(trim($_REQUEST['expense_covered']))==$scholarshiptype){ echo 'selected="selected"'; } ?> ><?php echo $singleexpense; ?></option>
				<?php }
				
				}
			?>

		</select>

	</div>

</div>

<div class="col-sm-4">

	<div class="form-group">

		<select class="form-control" name="scholarship_mode">

			<option value="">Scholarship Mode</option>
			<option value="All">All</option>
			<option value="online" <?php if(isset($_REQUEST['scholarship_mode']) && stripslashes(trim($_REQUEST['scholarship_mode']))=='online'){ echo 'selected="selected"'; } ?> >Online</option>
			
			<option value="offline" <?php if(isset($_REQUEST['scholarship_mode']) && stripslashes(trim($_REQUEST['scholarship_mode']))=='offline'){ echo 'selected="selected"'; } ?> >Offline</option>

		</select>

	</div>

</div>

<div class="col-sm-5 formsubmitsection_ct">

	<div class="form-group form_submit_section">

	    <input type="submit" name="<?php echo $search_button_name; ?>" id="<?php echo $searchsubmitid; ?>"  value="Search" class="btn btn-default">
		
		<img src="<?php echo EduScholarship_IMAGES_PATH; ?>/scholarship_loader1.gif" class="scholarship_loading_cls" id="scholarship_ajx_loader" style="display:none;" />
       
	</div>

</div>

</form>

<div class="listing_sec">

    <div class="scholarship_page_loader">
	    <div class="overlay-content">
		    <img src="<?php echo EduScholarship_IMAGES_PATH; ?>/scholarship_page_loader.gif" class="schpageloadercls" />
		</div>
	</div>
	
	<div class="inner_scholarship_list" id="scholarship_listing_module">
		<?php
		
		    //echo "<pre>";print_r($_REQUEST);
		    
			//include("reload_scholarship_search.php");
			
		?>
		
	</div>
    
</div>


</div>


<?php

//add button on backend post listing

add_action('manage_posts_extra_tablenav', 'admin_post_list_add_exportButton', 20, 1);

function admin_post_list_add_exportButton($which){
	global $typenow;
	$post_type= "";
	if(!empty($_GET['post_type'])){
	$post_type = $_GET['post_type'];
	}
	if($post_type == 'my_post'){ ?>

	<input type="submit" name="export_csv_post" class="button button-primary Custom_export_button" value="<?php _e("Export All Customs"); ?>"/>
    <?php 	
   }
}

add_action('admin_init', 'export_Customs');
   function export_Customs() {
	if(isset($_GET['export_csv_post'])){
		$args = array(
			'post_type' => 'my_post',
			'post_status' => 'publish',
			'numberposts' => -1
		);




        $current_time = date('d-M-Y-h:i:s');
		global $post;
		$arr_post = get_posts($args);
		if($arr_post){
			header('Content-type: text/csv');
			header('Content-Disposition: attchment; filename="Export Customs_'.$current_time.'.csv"');
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

			$file = fopen("php://output", 'w');
			ob_end_clean();
			fputcsv($file, array('Custom Code', 'Custom Name', 'Custom Type', 'Custom Data 1', 'Custom Data 2', 'Custom Data 3', 'Custom Data 4', 'Custom Data 5', 'Custom Data 6','Custom Data 7', 'Custom Data 8', 'Meta Description', 'Outline Count'),',', '"', '\\');

			foreach($arr_post as $post){
				setup_postdata($post);


                $Custom_id = get_the_ID();
                $Custom_code = get_post_meta( $Custom_id, 'Custom_code', true );
				$Custom_title = get_post_meta( $Custom_id, 'title_cbnw', true );
				$seotitleDefualt="";
				$seotitle="";
			    $seoDescriptions=""; 
				$getOutline=  get_post_meta( $Custom_id, 'Custom_outline_nac', true );
			
				global $wpdb; 

				$fetchData = $wpdb->get_results ( "SELECT * FROM wp_yoast_indexable WHERE object_id = '$Custom_id' "  );	
				
				
				foreach ( $fetchData as $data ) { 
				 $seotitleDefualt= $data->breadcrumb_title;
				 $seotitle= $data->title;
			     $seoDescriptions= $data->description; 
			
				}

				//Custom type
				$terms_format = get_the_terms( $Custom_id, 'Custom_type' );
				$format_box = "";
				$format_slug = "";
				if(!empty($terms_format)){
					foreach($terms_format as $format){
						$format_box = $format->name;
						$format_slug = $format->slug;
					}
				}

				// subject
				$terms_subjects = get_the_terms( $Custom_id, 'Custom_category' );
				$subject_box = array();
				if(!empty($terms_subjects)){
					foreach($terms_subjects as $subject){
						$subject_box[] = $subject->name;
					}
				}

				// venue
				$venue_box = array();
				// if($format_slug == "classroom"){
					$terms_venue = get_the_terms( $Custom_id, 'data5' );
						if(!empty($terms_venue)){
							foreach($terms_venue as $venue){
								$venue_box[] = $venue->name;
							}
						}
				    
					while (have_rows('data6')): the_row(); 
						$start_date = get_sub_field("data6_1");
						$enddate = get_sub_field("data6_2");
						$Custom_length = dateforamts_custom($start_date, $enddate); 
						$shedl_price ="US $". get_sub_field('price__data'); 
						
						$lines =  array($Custom_code, $Custom_title, $format_box, implode(",",$subject_box), $Custom_length, $Customduration." Days",  "Codes", $shedl_price, get_the_permalink(),$seotitle,$seoDescriptions,$getOutline);
					
						fputcsv($file, $lines,',', '"', '\\');
					endwhile;	
				

				
				
			}
			exit;

			


		}
		
	}

   }

   function dateforamts_custom($start_date, $enddate){

	$start_time=strtotime($start_date);
	$end_time=strtotime($enddate);
	
	$start_month=date("F",$start_time);
	$start_month= substr($start_month, 0,3);
	$start_year=date("Y",$start_time);
	$start_day=date("d",$start_time);
	
	
	$end_month=date("F",$end_time);
	$end_month= substr($end_month, 0,3);
	$end_year=date("Y",$end_time);
	$end_day=date("d",$end_time);
	
		if($start_year != $end_year){
	
		  return $start_day." ".$start_month." ".$start_year."-".$end_day." ".$end_month." ".$end_year;
	
		}else if($start_month != $end_month){
			return $start_day." ".$start_month."-".$end_day." ".$end_month." ".$end_year;
		} else{
			return $start_day."-".$end_day." ".$end_month." ".$end_year;
		}
	}
	
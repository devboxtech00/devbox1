<?php
foreach ( $deparments as $deparment ) { 

    $deparment_cat = $deparment ->department_name;
    $deparment_ID = $deparment ->object_id;
    if(strlen($deparment_cat)>3 && $deparment_cat != "Other" ){
        $deparment_menue=[];
        $deparment_menue["id"] = $deparment_ID;
        $deparment_menue["parent"] = $deparment_cat;
        $deparment_menue["childs"] = [];
        $deparment_menue["cat_url"] = home_url('job_category/'.sanitize_title($deparment_cat));
        $deparments_childs = $wpdb->get_results ( "SELECT * FROM $tablename WHERE parenet_id = '$deparment_ID' ");
        foreach ($deparments_childs as $dc ){
            $dept_child['name'] = $dc->department_name;
            $dept_child['url'] = home_url('specialisms/'.sanitize_title($dc->department_name));
            array_push($deparment_menue["childs"],$dept_child);
        }
        array_push($deparment_menue_main,$deparment_menue);
    }
   
}

echo json_encode( $deparment_menue_main);

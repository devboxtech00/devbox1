<?php
global $wpdb; 
$get_entryId = $_GET['entryId'];
$form_submission_table = $wpdb->prefix."wpc_forms_submission";
$get_data = $wpdb->get_var ( "SELECT form_data FROM $form_submission_table WHERE id = '$get_entryId'");  
$form_table = $wpdb->prefix."wpc_forms";
?>
<div class="wpc_admin_page">

<div class="container-fluid">
    <h2 class="pb-3">All Entries</h2>
    <table id="responsive-data-table" class="w-100 wpc_table table_small_width table dt-responsive nowrap table table-striped table-hover table-bordered border-primary" >
        <thead>
            <tr>
            <th>Field Name</th>
            <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($get_data)):
             $get_data = json_decode($get_data, true);
             foreach($get_data as $key => $value){?>
                <tr>
                    <?php if($value['field'] != "Submit"){?>
                 
                    <td><?php  echo $value['field'];  ?></td>
                    <td><?php  echo $value['value']; ?></td>
                <?php } ?>
                </tr>
            
             

            <?php } endif; ?>
            </tbody>
    </table>
 </div>          
</div>
<?php 
  global $wpdb; 
  $form_submission_table = $wpdb->prefix."wpc_forms_submission";
  $get_data = $wpdb->get_results ( "SELECT * FROM $form_submission_table");  
  $form_table = $wpdb->prefix."wpc_forms";
?>
<div class="wpc_admin_page">

<div class="container-fluid">
    <h2 class="pb-3">All Entries</h2>
    <table id="responsive-data-table" class="w-100 wpc_table table_small_width table dt-responsive nowrap table table-striped table-hover table-bordered border-primary" >
        <thead>
            <tr>
            <th>Form Id</th>
            <th>Form Name</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($get_data)):?>
            <?php foreach($get_data as $form){ ?>
            <tr>
            <td><?php  echo $form->form_id;  ?></td>
           <?php $formName = $wpdb->get_var ("SELECT form_name FROM $form_table WHERE id = '$form->form_id' ");  ?>
            <td><?php  echo $formName; ?></td>
            <td style="text-align:right;"> <a class="btn btn-primary" href="<?php  echo home_url('/wp-admin/admin.php?page=form_entries_view&entryId='.$form->id); ?>"> View </a></td>
           <?php if($form->admin_status == "pending"){?>
            
            <td class ="text-right us">
                <form style="text-align:right;" class="us_form">
                    <input class="db_id" type="text" value="<?php echo  $form->id; ?>" hidden>
                    <input type="text" class="tableName" value="wpc_forms_submission" hidden>
                    <input type="text" class="status_entr" value="approve" hidden>
                    <button type="submit" class="btn btn-success" name="delete_row<?php  echo $form->id; ?>">Approve</button>
                </form>
            </td>
            <td class ="text-right us">
                <form style="text-align:right;" class="us_form">
                    <input class="db_id" type="text" value="<?php echo  $form->id; ?>" hidden>
                    <input type="text" class="tableName" value="wpc_forms_submission" hidden>
                    <input type="text" class="status_entr" value="reject" hidden>
                    <button type="submit" class="btn btn-danger" name="delete_row<?php echo  $form->id; ?>">Reject</button>
                </form>
            </td>
          <?php  } else if($form->admin_status == "approve"){?>
            <td style="text-align:right;"colspan="2">  <span class="entry_status btn-success"><?php  echo _e('Approved','wpc'); ?></span></td>
           <?php }else if($form->admin_status == "reject"){ ?>
            <td style="text-align:right;" colspan="2">  <span class="entry_status btn-danger"><?php  echo _e('Rejected','wpc'); ?></span></td>
            <?php } ?>
            <td class ="delete_row">
                <form class="delete_row_form">
                    <input class="db_id" type="text" value="<?php echo $form->id; ?>" hidden>
                    <input type="text" class="tableName" value="wpc_forms_submission" hidden>
                    <button type="submit" class="btn btn-danger" name="delete_row<?php echo $form->id ?>"><i class="fa-solid fa-minus p-0"></i></button>
                </form>
            </td>
            </tr>

            <?php } endif; ?>
            </tbody>
    </table>
 </div>          
</div>
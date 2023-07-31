<?php 
  global $wpdb; 
?>
<div class="wpc_admin_page">

    <div class="container">
    <h2 class="pb-3">Field Types</h2>
    <table id="responsive-data-table" class="table wpc_table dt-responsive nowrap table table-striped table-hover table-bordered border-primary" style="width:450px">
  <thead>
    <tr>
      <th>Field Name</th>
      <th>Field Type</th>
      <th></th>
    </tr>
  </thead>

  <tbody>
    <?php 
    $form_fields_table = $wpdb->prefix."wpc_fieldtype";
    $get_fieldtypes = $wpdb->get_results ( "SELECT * FROM $form_fields_table ");  
    foreach($get_fieldtypes as $fieldtypes){
    ?>
    <tr>
      <td><?php  echo $fieldtypes->field_label;  ?></td>
      <td><?php  echo $fieldtypes->field_type;  ?></td>
      <td class ="delete_row">
					<form class="delete_row_form">
					<input class="db_id" type="text" value="<?php echo $fieldtypes->id; ?>" hidden>
          <input type="text" class="tableName" value="wpc_fieldtype" hidden>
						<button type="submit" class="btn btn-danger" name="delete_row<?php echo $fieldtypes->id ?>"><i class="fa-solid fa-minus"></i></button>
				</form>
		</td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="add_data table_small_width">
            <div colspan="2"><button class="w-100 btn btn-info">Add <i class="fa-solid fa-plus"></i></button></div>
        </div>
        <div class="add_form_data table_small_width">
            <form method="post" name="addform_wpc_feilds">
                    <div>
                        <div><input type="text" name="form_name_wpc" class="w-100" placeholder="Enter Form Name Here.."></div>
                    </div>
                    <div>
                        <div class="buttons_container">
                            <button class="btn btn-success" name="addform_wpc_feilds" type="submit">Add</button>
                            <button class="hide_frm btn btn-dark">Cancel</button>
                        </div>
                    </div> 
                </form>
            </div>
     </div>         
    </div>
</div>

<script>
  //   jQuery(document).ready(function() {
  //   jQuery('#responsive-data-table').DataTable({
  //     "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
  //     "pageLength": 20,
  //     "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
  //   });
  // });
</script>

<script>
	jQuery(document).ready(function ($) {
		
	});
</script>

<?php
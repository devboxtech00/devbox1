<?php 
  global $wpdb; 
$get_formId = $_GET['formId'];
//echo $get_formId;
?>
	<div class="wpc_admin_page p-0 form_edit_page">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-4 forms_feilds">
					<h2 class="pb-3">Field Types</h2>
					<table class="table w-100 wpc_table dt-responsive nowrap table table-striped table-hover table-bordered border-primary" id="responsive-data-table" style="width:450px">
						<thead>
							<tr>
								<th>Field Label</th>
								<th>Field Name</th>
								<th>Field Type</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							    $form_fields_table = $wpdb->prefix."wpc_forms_data";
							    $get_fieldtypes = $wpdb->get_results ( "SELECT * FROM $form_fields_table ");  
							    foreach($get_fieldtypes as $fieldtypes){
							    ?>
							<tr>
								<td><?php  echo $fieldtypes->field_lablel;  ?></td>
								<td><?php  echo $fieldtypes->field_name;  ?></td>
								<td><?php  echo $fieldtypes->field_type;  ?></td>
								<td class="edit_row">
									<form class="edit_row_form">
										<input class="db_id" hidden="" type="text" value="<?php echo $fieldtypes->id; ?>"> <input class="tableName" hidden="" type="text" value="wpc_forms_data"> <button class="btn btn-success" name="edit_row_<?php echo $fieldtypes->id; ?>" type="submit">Edit</button>
									</form>
								</td>
								<td class="delete_row">
									<form class="delete_row_form">
										<input class="db_id" hidden="" type="text" value="<?php echo $fieldtypes->id; ?>"> <input class="tableName" hidden="" type="text" value="wpc_forms_data"> <button class="btn btn-danger" name="delete_row_<?php echo $fieldtypes->id; ?>" type="submit"><i class="fa-solid fa-minus"></i></button>
									</form>
								</td>
							</tr><?php } ?>
						</tbody>
					</table>
				</div>
                <div class="col-md-8 froms_types">
                    <?php require( Custom_Dummy_Forms_PATH . 'views/form_display_type.php' ); ?>
                </div>
			</div>
		</div>
	</div>


<?php
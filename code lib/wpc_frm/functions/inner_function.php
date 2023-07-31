<?php
if ( isset( $_POST['addform_wpc'] ) ){
$formName = $_POST['form_name_wpc'];
global $wpdb;
$form_table = $wpdb->prefix."wpc_forms";
$data=array(
'form_name' => $_POST['form_name_wpc'],
);
$wpdb->insert( $form_table, $data);
}

if ( isset( $_POST['addform_wpc_feilds'] ) ){
    $formName = $_POST['form_name_wpc'];
    global $wpdb;
    $form_table = $wpdb->prefix."wpc_fieldtype";
    $feild_type = $_POST['form_name_wpc'];
    $feild_type = strtolower($feild_type);
    $feild_type = str_replace(" ", "-",$feild_type);
    $data=array(
    'field_type' => $feild_type,
    'field_label' => $_POST['form_name_wpc']

    );
    $wpdb->insert( $form_table, $data);
}

//all delete
add_action( 'wp_ajax_nopriv_del_history', 'del_history_cb' );
add_action( 'wp_ajax_del_history', 'del_history_cb' );

function del_history_cb() {

    $dataId = $_POST['row_id'];
    $get_tableName = $_POST['table_name'];

    global $wpdb; 

    $tablename=$wpdb->prefix.$get_tableName;

    $wpdb->delete($tablename,['id' => $dataId],['%d']);

}

// add row

add_action( 'wp_ajax_nopriv_addFormData', 'add_form_data' );
add_action( 'wp_ajax_addFormData', 'add_form_data' );

function add_form_data() {

    $requestType = $_POST['formId_submissiom_type'];
    $formID = $_POST['formId_fd'];
    $label = $_POST['fd_field_label'] ? $_POST['fd_field_label'] : "";
    $name = strtolower($label);
    $name = str_replace(' ', '-', $name);
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name); 
    $fieldId = $formID."_".$name;
    $placeholder = $_POST['fd_field_placeholder'] ? $_POST['fd_field_placeholder'] : "";
    $fieldType = $_POST['fd_field_type'] ? $_POST['fd_field_type'] : "";
    $isRequired = $_POST['fd_field_isrequired'] ? $_POST['fd_field_isrequired'] : "";
    $islabel = $_POST['fd_field_showlabel'] ? $_POST['fd_field_showlabel'] : "";
    $isplaceholder = $_POST['fd_field_showplaceholder'] ? $_POST['fd_field_showplaceholder'] : "";
    $score = $_POST['fd_field_score'] ? $_POST['fd_field_score'] : "";
    $value = $_POST['fd_field_value'] ? $_POST['fd_field_value'] : "" ;

    global $wpdb;
    $fd_tablename=$wpdb->prefix.'wpc_forms_data';
    if($requestType == "add"){
    $fd_data=array(
    'created_on' => date('Y-m-d H:i:s'),
    'form_id' => $formID,
    'field_id' => $fieldId,
    'field_name' => $name,
    'field_lablel' => $label,
    'field_placeholder' => $placeholder,
    'field_type' => $fieldType,
    'field_value' => $value,
    'field_score' => $score,
    'isrequired' => $isRequired,
    'islabel' => $islabel,
    'isplaceholder' => $isplaceholder
    );
    $wpdb->insert( $fd_tablename, $fd_data);

  } else if($requestType == "update"){
    $fieldId = $_POST['feild_id_fd'];
    $fd_data=array(
        'created_on' => date('Y-m-d H:i:s'),
        'field_name' => $name,
        'field_lablel' => $label,
        'field_placeholder' => $placeholder,
        'field_type' => $fieldType,
        'field_value' => $value,
        'field_score' => $score,
        'isrequired' => $isRequired,
        'islabel' => $islabel,
        'isplaceholder' => $isplaceholder
        );

    $data_where = array('form_id' => $formID, 'field_id' => $fieldId);

    $wpdb->update( $fd_tablename, $fd_data, $data_where );

  }
}

add_action( 'wp_ajax_nopriv_edit_form_field', 'edit_form_data' );
add_action( 'wp_ajax_edit_form_field', 'edit_form_data' );

function edit_form_data() {

    $dataId = $_POST['row_id'];
    $get_tableName = $_POST['table_name'];

    global $wpdb; 

    $tablename=$wpdb->prefix.$get_tableName;

    $formData = $wpdb->get_results( "SELECT * FROM $tablename WHERE id = '$dataId' ");  

    $data=[];

    foreach($formData as $formData){
        $data['fd_field_label'] =$formData->field_lablel;
        $data['fd_field_placeholder'] =$formData->field_placeholder;
        $data['fd_field_type'] =$formData->field_type;
        $data['fd_field_value'] =$formData->field_value;
        $data['fd_field_score'] =$formData->field_score;
        $data['fd_field_isrequired'] =$formData->isrequired;
        $data['fd_field_showlabel'] =$formData->islabel;
        $data['fd_field_showplaceholder'] =$formData->isplaceholder;
        $data['feild_id_fd'] =$formData->field_id;
        
    }

   echo  json_encode($data);
    exit;

}


add_action( 'wp_ajax_nopriv_update_status', 'update_status_cb' );
add_action( 'wp_ajax_update_status', 'update_status_cb' );

function update_status_cb() {
    $get_tableName = $_POST['table_name'];
    $admin_status = $_POST['status'];
    $dataId = $_POST['row_id'];
    global $wpdb; 

    $fd_tablename=$wpdb->prefix.$get_tableName;

    $fd_data=array(
        'admin_status' => $admin_status,
        );

    $data_where = array('id' => $dataId);

    $wpdb->update( $fd_tablename, $fd_data, $data_where );
}
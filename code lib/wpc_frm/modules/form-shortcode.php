<?php
if( !class_exists( 'Custom_Dummy_Forms_formshortcode') ){
    class Custom_Dummy_Forms_formshortcode {
        public function __construct(){
            add_shortcode('wpcforms', array($this,'wpcforms_shortcode_cb')); 
        }
    function wpcforms_shortcode_cb($atts) {
        $default = array(
            'id' => "0"
        );
        $attributes =  shortcode_atts($default, $atts);
        $formId = $attributes['id'];
        global $wpdb; 
        $form_data_table = $wpdb->prefix."wpc_forms_data";
        $form_table = $wpdb->prefix."wpc_forms";
        $formName = $wpdb->get_var ("SELECT form_name FROM $form_table WHERE id = '$formId' ");  
        $formName = strtolower($formName);
        $formName = str_replace(' ', '-', $formName);
        $formName = preg_replace('/[^A-Za-z0-9\-]/', '', $formName); 
        $formData = $wpdb->get_results ( "SELECT * FROM $form_data_table WHERE form_id = '$formId' ");  

        if(!empty($formData)){?>
        <form id="<?php echo $formId;  ?>" name="<?php echo $formName;  ?>" method="post">
        <?php foreach($formData as $formData){

            $field_id = $formData->field_id;
            $field_name = $formData->field_name;
            $field_lablel =$formData->field_lablel;
            $field_placeholder =$formData->field_placeholder;
            $field_type =$formData->field_type;
            $field_value =$formData->field_value;
            $field_score =$formData->field_score;
            $getisrequired =$formData->isrequired;
            $islabel =$formData->islabel;
            $getisplaceholder =$formData->isplaceholder;


            $isrequired = $getisrequired ? 'required' : '';
            $placeholder = $getisplaceholder ? $field_placeholder : '';
            $lablel = $islabel ? $field_lablel : '';
            ?>
         
            
                <?php if($field_type == 'radio' || $field_type == 'other-text'): ?>
                 
                  <?php if($field_type == 'radio') {?>
                <div class="create-radio-list">
                <?php if($field_lablel): ?>
                  <h3><?php echo $lablel; ?></h3>
                <?php endif; ?>
               
                  <?php $fieldOptions = explode(",",$field_value); 
                   foreach($fieldOptions as $fieldOption){
                    $genid = strtolower($fieldOption);
                    $genid = str_replace(' ', '-', $genid);
                    $genid = preg_replace('/[^A-Za-z0-9\-]/', '', $genid);  ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="<?php echo $field_name; ?>" id="<?php echo $genid; ?>" value="<?php echo $fieldOption; ?>" <?php echo $isrequired; ?>>
                    <label class="form-check-label" for="<?php echo $genid; ?>">
                      <?php echo $fieldOption; ?>
                    </label>
                   
                  </div>
                <?php } ?> 
                </div> <?php
                }
                
                ?>
                 <?php if($field_type == 'other-text') {?>
                    <input type="text" class="other-text" id="<?php echo $field_id; ?>" placeholder="<?php echo $placeholder; ?>">
                    <?php } ?>
                 
                <?php endif; ?>
                <?php if($field_type == 'text'): ?>
                <div class="input-box-container mt-70">
                    <?php if($field_lablel): ?>
                        <h3 class="mb-28"><?php echo $field_lablel; ?></h3>
                    <?php endif; ?>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" placeholder="<?php echo $placeholder; ?>">
                    </div>
                  </div>
                <?php endif; ?>
                <?php if($field_type == 'select'): ?>
                <div class="input-box-container">
                  <?php if($field_lablel): ?>
                    <h3><?php echo $lablel; ?></h3>
                  <?php endif; ?>
                    <div class="mb-3">
                      <select class="form-select form-select-sm" name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" aria-label=".form-select-sm example">
                      <?php $fieldOptions = explode(",",$field_value); 
                       foreach($fieldOptions as $fieldOption){?>
                        <option value="<?php echo $fieldOption; ?>"><?php echo $fieldOption; ?></option>
                      <?php } ?>
                      </select>
                    </div>
                  </div> 
                <?php endif; ?>
                <?php if($field_type == 'submit'): ?>
                  <div class="w-100">
                <button  type="submit" name="<?php echo $formName; ?>" class="btn btn-primary modal-submit-btn w-100" style="max-width: 100%!important;"><?php echo $field_value; ?></button>
                </div>
                <?php endif; ?>
             

             

        
       <?php }?>
           
           <input type="hidden" name="form_id" value="<?php echo $formId; ?>">
           <input type="hidden" name="form_name" value="<?php echo $formName;  ?>">

        </form>
     <?php }
      else{ return "Form with id ".$formId." dosen't exit.";}
    }
}
}
<div class="container">
    <div class="form_feild_types">
        <h2><?php _e('Choose Your Fields','wpc'); ?> </h2>
               <form id="add_data_form"  >
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Field Label" type="text" id="fd_field_label" name="fd_field_label" required="required">
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-group">
                            <select id="fd_field_type" class="form-select " aria-label="Default select example" name="fd_field_type">
                            <option value="text">Select Field Type</option>
                            <?php $form_fields_table = $wpdb->prefix."wpc_fieldtype";
                                $get_fieldtypes = $wpdb->get_results ( "SELECT * FROM $form_fields_table ");  
                                foreach($get_fieldtypes as $fieldtypes):
                                    $name = $fieldtypes->field_label; 
                                    $slug = $fieldtypes->field_type;  ?>
                                <option value="<?php echo $slug; ?>"><?php echo $name; ?></option>
                                <?php endforeach;  ?>
                            </select>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                    <input type="checkbox" value="1" class="form-check-input" name="fd_field_isrequired" id="fd_field_isrequired">
                                        <label class="form-check-label" for="fd_field_isrequired">Required</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" class="form-check-input" name="fd_field_showlabel" id="fd_field_showlabel">
                                        <label class="form-check-label" for="fd_field_showlabel">Show Label</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-check">
                                    <input type="checkbox" value="1" class="form-check-input" name="fd_field_showplaceholder" id="fd_field_showplaceholder">
                                        <label class="form-check-label" for="fd_field_showplaceholder">Show Placeholder</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>Scores</label>
                                        <input type="number" class="form-control" id="fd_field_score" name="fd_field_score">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group valuebox d-none">
                                    <div class="checkbox">
                                        <label>Value</label>
                                        <textarea name="fd_field_value" id="fd_field_value" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group d-none  placeholder_box">
                                    <input class="form-control" placeholder="Field Placeholder" type="text"  id="fd_field_placeholder" name="fd_field_placeholder">
                                </div>
                            </div>
                        </div>                               
                        <div class="form-group">
                            <button type="submit"   class="btn btn-primary btn-block submit"><?php _e( 'Add To Form','wpc'); ?></button>
                            <input type="hidden" name="action" value="addFormData">
                            <input type="text" name="formId_fd" value="<?php echo $_GET['formId'] ? $_GET['formId'] : "" ;?>" hidden>
                            <input type="hidden" id="submissiom_type_fd" name="formId_submissiom_type" value="add" >
                            <input type="hidden" id="feild_id_fd" name="feild_id_fd">
                        </div>
                        </form>
                    </div>            
                </div>   
<!-- end of container -->



<?php 



?>






<script>
jQuery(document).ready(function($) {
    // $(document).ready(function(){
    //    $(".accordion").on("click", ".heading", function() {
    //    $(this).toggleClass("active").next().slideToggle();
    //    $(".contents").not($(this).next()).slideUp(300);      
    //    $(this).siblings().removeClass("active");
    //    });
    //   });

    $("#fd_field_type").on('change', function(e){
        var value = $(this).val();
        if(value == 'radio' || value == 'checkbox' || value == 'select' || value == 'submit'){
            $(".valuebox").removeClass("d-none");
            $(".placeholder_box").addClass("d-none");
        }else if(value == 'text' || value == 'textarea' || value == 'number'){
            $(".valuebox").addClass("d-none");
            $(".placeholder_box").removeClass("d-none");
        } else{
            $(".valuebox").addClass("d-none");
            $(".placeholder_box").addClass("d-none");
        }
    })
           
});
</script>
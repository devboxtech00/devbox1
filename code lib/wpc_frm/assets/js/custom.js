jQuery(document).ready(function($) {

    $(".add_data button").on("click", function(e){
        e.preventDefault();
        $(".add_form_data").css("display","block");
    });
    $(".hide_frm").on("click", function(e){
        e.preventDefault();
        $(".add_form_data").css("display","none");
    })


    var siteurl = 'https://localhost/wpc';


		$(".wpc_table tr").each(function(e){
			$($(this).find(".delete_row .delete_row_form")).on('submit', function(e){
				e.preventDefault();
				var dataId = $($(this).find(".db_id")).val();
                var tableName = $($(this).find(".tableName")).val();
				// console.log(dataId);
				$.ajax({
					url: siteurl+'/wp-admin/admin-ajax.php',
					
					data: {'action':'del_history',
							"row_id": dataId,
                            "table_name":tableName,
						},
					type:'post',
					success: function(result){
						 //console.log("s");
						location.reload();
					},
					error:function(result){
						console.warn(result);
		
					}
				})
			})	
		})

		$(".wpc_table tr").each(function(e){
			$($(this).find(".us .us_form")).on('submit', function(e){
				e.preventDefault();
				var dataId = $($(this).find(".db_id")).val();
                var tableName = $($(this).find(".tableName")).val();
				var status_rcv =  $($(this).find(".status_entr")).val();
				// console.log(dataId);
				$.ajax({
					url: siteurl+'/wp-admin/admin-ajax.php',
					
					data: {'action':'update_status',
							"row_id": dataId,
                            "table_name":tableName,
							"status":status_rcv,
						},
					type:'post',
					success: function(result){
						 //console.log("s");
						location.reload();
					},
					error:function(result){
						console.warn(result);
		
					}
				})
			})	
		})



		$(".wpc_table tr").each(function(e){
			$($(this).find(".edit_row .edit_row_form")).on('submit', function(e){
				e.preventDefault();
				var dataId = $($(this).find(".db_id")).val();
                var tableName = $($(this).find(".tableName")).val();
				// console.log(dataId);
				$.ajax({
					url: siteurl+'/wp-admin/admin-ajax.php',
					
					data: {'action':'edit_form_field',
							"row_id": dataId,
                            "table_name":tableName,
						},
					type:'post',
					success: function(result){
						var result = JSON.parse(result);
						$("#submissiom_type_fd").val("update");
						for (let key in result) {
							if (result.hasOwnProperty(key))
							{   value = result[key];
								
								$("#fd_field_type").trigger( "change" );
								$("#add_data_form button").html("Update");
								if((key == 'fd_field_isrequired' && value == "1") || (key == 'fd_field_showlabel' && value == "1") || (key == 'fd_field_showplaceholder' && value == "1")){
									$("#"+key).attr('checked',true);
									$("#"+key).val("0");
								}else if((key == 'fd_field_isrequired' && value == "0") || (key == 'fd_field_showlabel' && value == "0") || (key == 'fd_field_showplaceholder' && value == "0")){
									$("#"+key).attr('checked',false);
									$("#"+key).val("1");
								}else{
									$("#"+key).val(value);
								}
								//console.log(value)
							}
							
						 }
						// console.log(result);

					

			            // var 
						
						//location.reload();
					},
					error:function(result){
						console.warn(result);
		
					}
				})
			})	
		})



		$("#add_data_form").on("submit", function(e){
			e.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				url: siteurl+'/wp-admin/admin-ajax.php',
				data:  formData,
				type:'post',
				success: function(result){
					location.reload();
					//console.log(result);
				},
				error:function(result){
					console.warn(result);
				}
			})
		})


		// const add_data_form = document.getElementById('add_data_form');
		// const formData = new FormData(add_data_form);






	$('.collapse.in').prev('.panel-heading').addClass('active');
	$('#accordion, #bs-collapse')
		.on('show.bs.collapse', function(a) {
		$(a.target).prev('.panel-heading').addClass('active');
		})
		.on('hide.bs.collapse', function(a) {
		$(a.target).prev('.panel-heading').removeClass('active');
		});
	

});
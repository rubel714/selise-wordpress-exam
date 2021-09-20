
var $ = jQuery.noConflict();


function wpgmapAdvancedSettingsAjax() {
	var ufname = $('#ufname').val();
	var ulname = $('#ulname').val();
	var uemail = $('#uemail').val();
	var umessage = $('#umessage').val(); 
	
	if((ufname == "") || (ulname == "") || (uemail == "") || (umessage == "")){
		alert("Please fill-up valid data"); 
		return;
	}
	
	var data = {
		'action': 'onWPContactDataAjax',
		'ufname': ufname,
		'ulname': ulname,
		'uemail': uemail,
		'umessage': umessage
	};
	jQuery.ajax({
		url : wpgmap_ajax_object.wpgmap_ajax_url,
		type : 'POST',
		data : data,
		success : function (response){
			 if (response == 1) {
				alert("Success"); 
				$('#ufname,#ulname,#uemail,#umessage').val("");
			} else {
				
				alert("Failed");
			} 
		}
	}); 
}

jQuery(document).ready(function(){
	
	$('#postcontact').click(function () { 
			wpgmapAdvancedSettingsAjax(); 
	});

});
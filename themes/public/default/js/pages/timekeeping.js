$(function(){	
	init();
	searchList();	
	$("#search").click(function(){
		$(".loading").show();
		searchList();	
	});
	$("#refresh").click(function(){
		$(".loading").show();
		refresh();
	});
	$("#close").click(function(){
		$(".loading").show();
		refresh();
	});
	$('#workday').click(function(){
		workdayForm();
	});
	$('#edit').click(function(){
		var id = $('#id').val();
		loadForm(id);
	});
	$("#delete").click(function(){
		var id = getCheckedId();
		if(id == ''){ return false;}
		confirmDelete(id);
		return false
	});
	$(document).keypress(function(e) {
		 var id = $("#id").val();
		 if (e.which == 13) {
			$(".loading").show();
			searchList();	
		 }
	});
	$('#actionSave').click(function(){
		save();
	});
});
function workdayForm(){
	var month = getCombo('month');
	if(month == ''){
		warning(chon_thang); return false;
	}
	$('.loading').show();
	$.ajax({
		url : controller + 'workday',
		type: 'POST',
		async: false,
		data:{month:month},  
		success:function(datas){
			$('.loading').hide();
			searchList();	
			if(datas == 1){
				success(chot_cong_thanh_cong); 
			}
			else{
				error(chot_cong_khong_thanh_cong);
			}
		}
	});
}
function save(id,func){
	var id = $('#id').val(); 
	var func = 'save';
	if(id != ''){
		func = 'edit';
	}
	var search = getFormInput();
	var obj = $.evalJSON(search); 
	if(obj.departmanet_name == ""){
		warning(chon_phong_ban); 
		$("#departmanet_name").focus();
		return false;		
	}
	$('.loading').show();
	var data = new FormData();
	data.append('search', search);
	data.append('id',id);
	$.ajax({
		url : controller + func,
		type: 'POST',
		async: false,
		data:data,
		enctype: 'multipart/form-data',
		processData: false,  
		contentType: false,   
		success:function(datas){
			var obj = $.evalJSON(datas); 
			$('.loading').hide();
			if(obj.status == 0){
				if(id == ''){
					error(tmktc); return false;	
				}
				else{
					error(sktc); return false;	
				}
			}
			else if(obj.status == -1){
				error(dldtt); return false;		
			}
			else{
				if(id == ''){
					success(tmtc); 
				}
				else{
					success(stc); 
				}
				refresh();
			}
		},
		error : function(){
			$('.loading').hide();
			if(id == ''){
				error(tmktc); return false;	
			}
			else{
				error(sktc); return false;	
			}
		}
	});
}
function init(){
	$('#departmentid').multipleSelect({
		filter: true,
		placeholder:chon_phong_ban,
		single: false
	});
	$('#month').multipleSelect({
		filter: true,
		placeholder:chon_thang,
		single: true,
		onClick: function(view){
			searchList();
		}
	});
}
function funcList(obj){
	$(".edit").each(function(e){
		$(this).click(function(){ 
			var departmanet_name = $(".departmanet_name").eq(e).text().trim();
			var phone = $(".phone").eq(e).text().trim();
			var fax = $(".fax").eq(e).text().trim();
			var heads = $(".heads").eq(e).text().trim();
			var id = $(this).attr('id');
			$("#id").val(id);	
			$("#departmanet_name").val(departmanet_name);	
			$("#phone").val(phone);	
			$("#fax").val(fax);	
			$("#heads").val(heads);	
		});
	});	
	$('.edititem').each(function(e){
		$(this).click(function(){
			var id = $(this).attr('id');
			loadForm(id);
		});
	});
	$('.deleteitem').each(function(e){
		$(this).click(function(){
			var id = $(this).attr('id');
			confirmDelete(id);
			return false
		});
	});
}
function refresh(){
	$(".loading").show();
	$(".searchs").val("");
	csrfHash = $('#token').val();
	search = getSearch();
	getList(cpage,csrfHash);	
}
function searchList(){
	$(".loading").show();
	search = getSearch();
	csrfHash = $('#token').val();
	getList(cpage,csrfHash);	
}
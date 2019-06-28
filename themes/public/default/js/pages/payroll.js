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
	$("#export").click(function(){
		search = getSearch(); 
		window.location = controller+'export?search='+search;
	});
	$('#save').click(function(){
		$('#id').val('');
		loadForm();
	});
	$('#edit').click(function(){
		var id = $('#id').val();
		if(id == ''){
			warning(cldcs);
			return false;
		} 
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
			  if(id == ''){
				  save('','save');
			  }
			  else{
				  save(id,'edit');
			  }
		 }
	});
	$('#actionSave').click(function(){
		save();
	});
	$('#updatepayroll').click(function(){
		updatepayroll();
	});
	$('#copySalary').click(function(){
		copySalary();
	});
	$('#payroll').click(function(){
		formPayroll();
	});
	$('#copy').click(function(){
		copyForm();
	});
});
function copySalary(){
	var frommonth = $('#frommonth').val();
	var tomonth = $('#tomonth').val();
	if(frommonth == ''){
		return;
	}
	if(tomonth == ''){
		return;
	}
	$(".loading").show();
	$.ajax({
		url : controller + 'copySalary',
		type: 'POST',
		async: false,
		data:{frommonth:frommonth, tomonth:tomonth},  
		success:function(datas){
			var obj = $.parseJSON(datas); 
			$(".loading").hide();
			if(obj.status == 1){
				searchList();
				success(obj.msg);
			}
			else{
				error(copyFailed);
			}
		}
	});
}
function updatepayroll(){
	var endoffmonthid = $('#endoffmonthids').val(); 
	if(endoffmonthid == ''){
		return;
	} 
	$(".loading").show();
	$.ajax({
		url : controller + 'updatepayroll',
		type: 'POST',
		async: false,
		data:{endoffmonthid:endoffmonthid},  
		success:function(datas){
			$(".loading").hide();
			var obj = $.parseJSON(datas); 
			if(obj.status == 0){
				error(obj.msg);
			}
			else{
				searchList();
				success(obj.msg);
			}				
		}
	});
}
function loadForm(id){
	$.ajax({
		url : controller + 'form',
		type: 'POST',
		async: false,
		data:{id:id},  
		success:function(datas){
			var obj = $.parseJSON(datas); 
			$('#loadContentFrom').html(obj.content);
			$('#modalTitleFrom').html(obj.title);
			$('#input_reward_content').select();
			$('#id').html(obj.id);
		}
	});
}
function formPayroll(){
	$.ajax({
		url : controller + 'formPayroll',
		type: 'POST',
		async: false,
		data:{},  
		success:function(datas){
			var obj = $.parseJSON(datas); 
			$('#loadContentPayRoll').html(obj.content);
		}
	});
}
function copyForm(){
	$.ajax({
		url : controller + 'copyForm',
		type: 'POST',
		async: false,
		data:{},  
		success:function(datas){
			var obj = $.parseJSON(datas); 
			$('#loadContentCopy').html(obj.content);
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
	var obj = $.parseJSON(search); 
	if(obj.employeeid == ""){
		warning(nhan_vien_khong_duoc_trong); 
		return false;		
	}
	if(obj.salary == ""){
		warning(luong_co_ban_khong_duoc_trong); 
		return false;		
	}
	var allowance = getAllowance();
	$('.loading').show();
	var data = new FormData();
	data.append('search', search);
	data.append('allowance', allowance);
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
			var obj = $.parseJSON(datas); 
			$('.loading').hide();
			if(obj.status == 0){
				if(id == ''){
					$('.loading').hide();  
					error(tmktc); 
					return false;	
				}
				else{
					$('.loading').hide();  
					error(sktc); 
					return false;	
				}
			}
			else if(obj.status == -1){
				$('.loading').hide(); 
				error(dldtt); 				
				return false;		
			}
			else{
				if(id == ''){
					$('.loading').hide();  
					success(tmtc); 
					searchList();
					return false;		
				}
				else{
					$('.loading').hide();  
					success(stc); 
					return false;		
				}
			}
		},
		error : function(){
			$('.loading').hide();
			if(id == ''){
				error(tmktc); 
				$('.loading').hide(); 
				return false;	
			}
			else{
				error(sktc); 
				$('.loading').hide(); 
				return false;	
			}
		}
	});
}
function init(){
	$('#departmentid').multipleSelect({
		filter: true,
		placeholder:cpb,
		single: false
	});
	$('#endoffmonthid').multipleSelect({
		filter: true,
		placeholder:ckl,
		single: true
	});
}
function funcList(obj){
	$(".edit").each(function(e){
		$(this).click(function(){ 
			var reward_content = $(".reward_content").eq(e).text().trim();
			var othercollect_date  = $(".othercollect_date").eq(e).text().trim();
			var id = $(this).attr('id');
			var departmentid = $(this).attr('departmentid');
			$("#id").val(id);	
			$("#reward_content").val(reward_content);
			$("#othercollect_date").val(othercollect_date);
			$('#departmentid').multipleSelect('setSelects', departmentid.split(','));				
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
	$('#departmentid').multipleSelect('uncheckAll');
	csrfHash = $('#token').val();
	search = getSearch();
	getList(cpage,csrfHash);
	$(".loading").hide();	
}
function searchList(){
	$(".loading").show();
	search = getSearch();
	csrfHash = $('#token').val();
	getList(cpage,csrfHash);
	$(".loading").hide();	
}

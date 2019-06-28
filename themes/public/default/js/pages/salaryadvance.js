$(function(){	
	init();
	//refresh();
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
});
function loadForm(id){
	$.ajax({
		url : controller + 'form',
		type: 'POST',
		async: false,
		data:{id:id},  
		success:function(datas){
			var obj = $.evalJSON(datas); 
			$('#loadContentFrom').html(obj.content);
			$('#modalTitleFrom').html(obj.title);
			$('#input_reward_content').select();
			$('#id').html(obj.id);
		}
	});
}
function init(){
	$('#departmentid').multipleSelect({
		filter: true,
		placeholder: chon_phong_ban,
		single: false
	});
}
function funcList(obj){
	$(".edit").each(function(e){
		$(this).click(function(){ 
			var reward_content = $(".reward_content").eq(e).text().trim();
			var salaryadvance_date  = $(".salaryadvance_date").eq(e).text().trim();
			var id = $(this).attr('id');
			var departmentid = $(this).attr('departmentid');
			$("#id").val(id);	
			$("#reward_content").val(reward_content);
			$("#salaryadvance_date").val(salaryadvance_date);
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
}
function searchList(){
	$(".loading").show();
	search = getSearch();
	csrfHash = $('#token').val();
	getList(cpage,csrfHash);	
}
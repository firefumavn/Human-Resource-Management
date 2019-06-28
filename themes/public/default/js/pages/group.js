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
	$("#save").click(function(){
		save('');
	});
	$("#edit").click(function(){
		var id = $('#id').val();
		if(id == ''){
			warning(cldcs);
			return false;
		} 
		save(id);
	});
	$("#delete").click(function(){
		var id = getCheckedId();
		if(id == ''){ return false;}
		confirmDelete(id);
		return false
	});
	$( "#dialog" ).dialog({
		autoOpen: false,
		width: 400,
		height:460,
		modal:false
	});
});
function save(id){
	var search = getSearch();
		var obj = $.evalJSON(search); 
		if(obj.groupname == ""){
			error(nhom_quyen_khong_duoc_trong); 
			$("#groupname").focus();
			return false;		
		}
		var token = $("#token").val();
		$.ajax({
			url : controller + 'save',
			type: 'POST',
			async: false,
			data: {csrf_stock_name:token,search:search , id:id},
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$("#token").val(obj.csrfHash);
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
						refresh();
						return false;
					}
					else{
						success(stc); 
						refresh();
						return false;
					}
					
				}
			},
			error : function(){
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
	$('#grouptype').multipleSelect({
		filter: true,
		placeholder:chon_nhom,
		single: true
	});
	$('#companyid').multipleSelect({
		filter: true,
		placeholder:chon_cong_ty,
		single: true
	});
	$("#companyid").multipleSelect('setSelects', companyid.split(','));
}
function funcList(obj){
	$(".edit").each(function(e){
		$(this).click(function(){ 
			 var groupname = $(".groupname").eq(e).text().trim();
			 var grouptype = $(this).attr('grouptype');
			 var companyid = $(this).attr('companyid');
			 var id = $(this).attr('id');
			 $("#id").val(id);	
			 $("#groupname").val(groupname);	
			 $("#companyid").multipleSelect('setSelects', companyid.split(','));
			 $("#grouptype").multipleSelect('setSelects', grouptype.split(','));
		});
		function getIDChecked(){
			return 1;	
		} 
	});	
	$(".permission").each(function(e){
		$(this).click(function(event){ 
			$( "#dialog" ).dialog( "open" );
			event.preventDefault();
			var id = $(this).attr('id');
			var token = $("#token").val();
			$.ajax({
				url : controller + 'getRight',
				type: 'POST',
				async: false,
				data: {csrf_stock_name:token, id:id},
				success:function(datas){
					var obj = $.evalJSON(datas); 
					$("#token").val(obj.csrfHash); 
					$('#dialog').html(obj.content);
					$("#saveright").click(function(){
						var right = getRight();
						token = $("#token").val();
						$.ajax({
							url : controller + 'setRight',
							type: 'POST',
							async: false,
							data: {csrf_stock_name:token, id:id, right:right},
							success:function(datas){
								var obj2 = $.evalJSON(datas);
								//$("#token").val(obj2.csrfHash);
							}
						});
						success(stc);
						$("#dialog").dialog( "close" );	
						
					});	
				},
				error : function(){
					error(sktc);
				}
			});
			return false;
		});
	});
}
function refresh(){
	$(".loading").show();
	$(".searchs").val("");
	$('#grouptype').multipleSelect('uncheckAll');
	$("#companyid").multipleSelect('setSelects', companyid.split(','));
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
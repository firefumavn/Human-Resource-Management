$(function(){
	formatNumber('fm-number');
	formatNumberKeyUp('fm-number');
	initForm();
});
function initForm(){
	$('.select2mes').select2({
		placeholder: "Select",
		allowClear: true
	});
}
function getAllowance() {
	var objReq = {};
	$(".allowance").each(function(i) {
		var id = $(this).attr('id');
		var val = $(this).val();
		val = val.replace(/['"]/g, '');
		if(id != undefined){ 
			var ids = id.replace('input_','');
			var res = id.substring(0, 4); 
			if(res != 's2id'){
				objReq[ids] = val;
			}
		}
	});
	return JSON.stringify(objReq);
}
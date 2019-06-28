$(function(){
		init();
		$('#imageEnable').change(function(evt) {
            var files = evt.target.files;
            for (var i = 0, f; f = files[i]; i++){
                var size = f.size;
                    if (!f.type.match('image.*'))
                    {
                        continue;
                    }
                    var reader = new FileReader();
                    reader.onload = (function(theFile) {
                        return function(e) { //size e = e.tatal
                            $('#show').html('<img src="' + e.target.result + '" style="width:144px; height:170px" />');
                            //$("#avatar").val(e.target.result);
                        };
                    })(f);
                    reader.readAsDataURL(f);
            }
        });
		$('#save2').click(function(){
			save('save','');
		});
		$('#edit2').click(function(){
			var employeeid = $("#employeeid").val();
			if(employeeid == ''){
				error('Vui lòng chọn nhân viên cần sửa.'); return false;	
			}
			save('edit',employeeid);
		});
	});
	function save(func,id){
		var search = getSearch();  
		var obj = $.parseJSON(search);
		var ht_time = '';
		$("input[id^='ht_time']").each(function(index) {
			vals = $(this).val();
			ht_time+= ',"'+index+'":'+'"'+vals+'"';
		});
		var ht_school = ''; 
		$("input[id^='ht_school']").each(function(index) {
			vals = $(this).val();
			ht_school+= ',"'+index+'":'+'"'+vals+'"';
		});
		var ht_adress = '';
		$("input[id^='ht_adress']").each(function(index) {
			vals = $(this).val();
			ht_adress+= ',"'+index+'":'+'"'+vals+'"';
		});
		var work_time = '';
		$("input[id^='work_time']").each(function(index) {
			vals = $(this).val();
			work_time+= ',"'+index+'":'+'"'+vals+'"';
		});
		var work_company = '';
		$("input[id^='work_company']").each(function(index) {
			vals = $(this).val();
			work_company+= ',"'+index+'":'+'"'+vals+'"';
		});
		var work_address = ''; 
		$("input[id^='work_address']").each(function(index) {
			vals = $(this).val();
			work_address+= ',"'+index+'":'+'"'+vals+'"';
		});
		if(obj.fullname == ''){
			warning(ho_ten_khong_duoc_trong); 
			$('#fullname').focus();
			return false;	
		}
		if(obj.sex == ''){
			warning(gioi_tinh_khong_duoc_trong); 
			$('#sex').focus();
			return false;	
		}
		if(obj.birthday == ''){
			warning(ngay_sinh_khong_duoc_trong); 
			$('#birthday').focus();
			return false;	
		}
		if(obj.place_of_birth == ''){
			warning(noi_sinh_khong_duoc_trong);
			$('#place_of_birth').focus();
			return false;	
		}
		if(obj.marriage == ''){
			warning(chon_tinh_trang_hon_nhan); 
			$('#marriage').focus();
			return false;	
		}
		if(obj.ethnicid == ''){
			warning(chon_dan_toc); 
			$('#marriage').focus();
			return false;	
		}
		if(obj.identity == ''){
			warning(cmnd_khong_duoc_trong); 
			$('#identity').focus();
			return false;	
		}
		if(obj.identity_date == ''){
			warning(ngay_cap_khong_duoc_trong); 
			$('#identity_date').focus();
			return false;	
		}
		if(obj.identity_from == ''){
			warning(noi_cap_khong_duoc_trong);
			$('#identity_from').focus(); return false;	
		}
		if(obj.academic_level == ''){
			warning(chon_trinh_do); 
			$('#academic_level').focus();
			return false;	
		}
		if(obj.permanent_address == ''){
			warning(dia_chi_thuong_tru_khong_duoc_trong); 
			$('#permanent_address').focus();
			return false;	
		}
		if(obj.permanent_province == ''){
			warning(chon_tinh_thanh_pho); 
			$('#permanent_province').focus();
			return false;	
		}
		if(obj.permanent_dictric == ''){
			warning(chon_quan_huyen); 
			$('#permanent_dictric').focus();
			return false;	
		}
		if(obj.tempery_address == ''){
			warning(dia_chi_tam_tru_khong_duoc_trong); 
			$('#tempery_address').focus();
			return false;	
		}
		if(obj.tempery_province == ''){
			warning(chon_tinh_thanh_pho); 
			$('#tempery_province').focus();
			return false;	
		}
		if(obj.tempery_distric == ''){
			warning(chon_quan_huyen); 
			$('#tempery_distric').focus();
			return false;	
		}
		if(obj.phone == ''){
			warning(dien_thoai_khong_duoc_trong); 
			$('#phone').focus();
			return false;	
		}
		if(obj.code == ''){
			warning(ma_nhan_vien_khong_duoc_trong); 
			$('#code').focus();
			return false;	
		}
		if(obj.departmentid == ''){
			warning(chon_phong_ban); 
			$('#department').focus();
			return false;	
		}
		if(obj.positionid == ''){
			warning(chon_chuc_vu); 
			$('#position').focus();
			return false;	
		}
		if(obj.jobstatusid == ''){
			warning(chon_tinh_trang_cong_viec); 
			$('#jobstatus').focus();
			return false;	
		}
		if(obj.date_start == ''){
			warning(chon_ngay_bat_dau); 
			$('#date_start').focus();
			return false;	
		}
		if(obj.shiftid == ''){
			warning(chon_ca_lam_viec); 
			$('#date_start').focus();
			return false;	
		}
		var islogin = 0;
		if($('#islogin').is(':checked')){
			islogin = 1;
		}
		var token = $('#token').val();
		var datas = new FormData();
		var objectfile = document.getElementById('imageEnable').files;
		datas.append('avatarfile', objectfile[0]);
		datas.append('search', search);
		datas.append('id',id);
		datas.append('ht_time', ht_time);
		datas.append('ht_school', ht_school);
		datas.append('ht_adress', ht_adress);
		datas.append('work_time', work_time);
		datas.append('work_company', work_company);
		datas.append('work_address', work_address);
		datas.append('islogin', islogin);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data:datas,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			/*data: {csrf_stock_name:token,search:search , id:id, ht_time:ht_time,ht_school:ht_school,ht_adress:ht_adress,work_time:work_time,work_company:work_company,work_address:work_address,islogin:islogin},*/
			success:function(datas){
				var obj = $.parseJSON(datas); 
				$("#token").val(obj.csrfHash);
				if(id == ''){
					if(obj.status == 0){
						error(tmktc); return false;	
					}
					else if(obj.status == -1){
						error(ma_nhan_vien_da_ton_tai); return false;		
					}
					else{
						success(tmtc); return false;	
					}
				}
				else{
					if(obj.status == 0){
						error(sktc); return false;	
					}
					else if(obj.status == -1){
						error(ma_nhan_vien_da_ton_tai); return false;		
					}
					else{
						success(stc); return false;	
					}
				}
			},
			error : function(){
				error(tmktc); return false;	
			}
		});
	}
	function init(){
		handleSelect2();	
		$("#permanent_province").change(function() {
			var provinceid = $(this).val();
			var links = controller+'getDistric';
			$.ajax({					
				url: links,	
				type: 'POST',
				data: {provinceid:provinceid},	
				success: function(data) {
					$('#loadDistricPermanent').html(data);
					$('#permanent_dictric').select2({
						placeholder: chon_quan_huyen,
						allowClear: true
					});
				}
			});
		});
		$("#tempery_province").change(function() {
			var provinceid = $(this).val();
			var links = controller+'getDistric2';
			$.ajax({					
				url: links,	
				type: 'POST',
				data: {provinceid:provinceid},	
				success: function(data) {
					$('#loadDistricEmpery').html(data);
					$('#tempery_distric').select2({
						placeholder: chon_quan_huyen,
						allowClear: true
					});
				}
			});
		});
		$("#departmentid").change(function() {
			var departmentid = $(this).val();
			$.ajax({					
				url: controller+'getgetDepartmentGroup',	
				type: 'POST',
				data: {departmentid:departmentid},	
				success: function(data) {
					$('#loadgroupwork').html(data);
					$('#group_work_id').select2({
						placeholder:chon_to_nhom,
						allowClear: true
					});
				}
			});
		});
	}
	function getCheckedId(){
		var strId = '';
		$('#'+routes).find('input:checked').each(function(){
			var id = $(this).attr('id');
			if(id != 'checkAll'){
				strId += ',' + $(this).attr('id') ;
			}
		});
		return strId.substring(1);
	}
	var html = '<div class="row mtop10"><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4" style="padding-right:0;">Thời gian </label><div class="col-md-8"><input type="text" name="work_time[]" id="work_time" placeholder="" class="search2 form-control" required /></div></div></div><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4">Nơi làm việc</label><div class="col-md-8"><input type="text" name="work_company[]" id="work_company" placeholder="" class="search2 form-control" required /></div></div></div><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4">Địa chỉ</label><div class="col-md-7"><input type="text" name="work_address[]" id="work_address" placeholder="" class="search2 form-control" required /></div><div class="col-md-1"><i class="fa fa-times cursor delete_noilamviec mright5 fright mtop5 red"></i></div></div></div></div>';
	event_click = function(){
		$('#qtlamviec').click(function(){
			$('#quatrinhlamviec').append(html);
			delete_row();
		});	
	};
	delete_row = function(){
		$('.delete_noilamviec').each(function(i){
			$(this).bind("click",function(){
				$(this).parent().parent().parent().parent().remove();
				delete_row();	   
			})
		});
	};	
	$(function(){
		event_click();
	});	
	/**Hoc tap*/
	var html2 = '<div class="row mtop10"><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4" style="padding-right:0;">Thời gian </label><div class="col-md-8"><input type="text" name="ht_time[]" id="ht_time" placeholder="" class="search2 form-control" required /></div></div></div><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4">Trường theo học</label><div class="col-md-8"><input type="text" name="ht_school[]" id="ht_school" placeholder="" class="search2 form-control" required /></div></div></div><div class="col-md-4"><div class="form-group"><label class="control-label col-md-4">Địa chỉ</label><div class="col-md-7"><input type="text" name="ht_adress[]" id="ht_adress" placeholder="" class="search2 form-control" required /></div><div class="col-md-1"><i class="fa fa-times cursor delete_hoctap mright5 fright mtop5 red"></i></div></div></div></div>';
	event_click2 = function(){
		$('#qthoctap').click(function(){
			$('#quatrinhhoctap').append(html2);
			delete_row2();
		});	
	};
	delete_row2 = function(){
		$('.delete_hoctap').each(function(i){
			$(this).bind("click",function(){
				$(this).parent().parent().parent().parent().remove();
				delete_row2();	   
			})
		});
	};	
	$(function(){
		event_click2();
	});	
	
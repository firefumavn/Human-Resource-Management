<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-info-circle"></i> <?=getLanguage('thong-tin-ca-nhan')?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <!--S content-->
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ho-ten')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input maxlength="100" type="text" name="fullname" id="fullname" placeholder="" class="searchs form-control" value="<?=$datas->fullname;?>" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('gioi-tinh')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select  id="sex" name="sex" class="select2me form-control " data-placeholder="<?=getLanguage('chon-gioi-tinh')?>">
							<option value=""></option>
							<option <?php if($datas->sex == 1){?> selected <?php }?>  value="1"><?=getLanguage('nam');?></option>
							<option <?php if($datas->sex == 2){?> selected <?php }?>  value="2"><?=getLanguage('nu');?></option>
							<option <?php if($datas->sex == -1){?> selected <?php }?>  value="-1"><?=getLanguage('gioi-tinh-khac');?></option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div onclick ="javascript:document.getElementById('imageEnable').click();" style="width:150px; height:175px; border:1px solid #ccc; text-align:center;  margin-bottom:-155px; padding:2px;">
					<div style="width:100%;">
					<span id="show">
					<?php if(!empty($datas->avatar)){?>
						<img src="<?=base_url();?>files/user/<?=$datas->avatar;?>" style="width:145px; height:170px" />
					<?php }else{?>
						<div style="margin-top:70px;"><?=getLanguage('hinh-dai-dien')?></div>
					<?php }?>
					</span>
					</div>
					
				</div>
				<input type="hidden" id="avatar" class="searchs">
				<input style='display:none;' accept="image/*" id ="imageEnable" type="file" name="userfile">
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<?php 
						$birthday = '';
						if(!empty($datas->birthday)){
							$birthday = date(configs('cfdate'),strtotime($datas->birthday));
						}
					?>
                    <label class="control-label col-md-4"><?=getLanguage('ngay-sinh')?> (<span class="red">*</span>)</label>
                    <div class="col-md-8">
						<div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
							<input value="<?=$birthday;?>" id="birthday" name="birthday" type="text" class="searchs form-control tab-event" placeholder="dd/mm/yyyy">
							<div class="input-group-addon">
								<i class="fa fa-calendar "></i>
							</div>
						</div>
                    </div>
                </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-sinh')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input maxlength="150" type="text" name="place_of_birth" id="place_of_birth" placeholder="" class="searchs form-control" required value="<?=$datas->place_of_birth;?>" placeholder="dd/mm/yyyy" />
						
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('hon-nhan')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="marriage" name="marriage" class="select2me form-control " data-placeholder="<?=getLanguage('chon-tinh-trang-hon-nhan')?>">
							<option value=""></option>
							<option <?php if($datas->marriage == 1){?> selected <?php }?> value="1">Đã có gia đình</option>
							<option <?php if($datas->marriage == 2){?> selected <?php }?> value="2">Độc thân</option>
							<option <?php if($datas->marriage == -1){?> selected <?php }?> value="-1">Khác</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('quoc-tich')?></label>
					<div class="col-md-8">
						<select id="nationality" name="nationality" class="select2me form-control " data-placeholder="<?=getLanguage('chon-quoc-tich')?>">
							<option <?php if($datas->marriage == 1){?> selected <?php }?> value="1">Việt Nam</option>
							<option <?php if($datas->marriage == -1){?> selected <?php }?> value="-1">Quốc tịch khác</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('dan-toc')?> (<span class="red">*</span>)</label>
					<div class="col-md-8"> 
						<select id="ethnicid" name="ethnicid" class="select2me form-control " data-placeholder="<?=getLanguage('chon-dan-toc')?>">
							<option value=""></option>
							<?php foreach($ethnics as $item){?>
								<option <?php if($datas->ethnicid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->ethnic_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ton-giao')?></label>
					<div class="col-md-8">
						<select id="religionid" name="religionid" class="select2me form-control " data-placeholder="<?=getLanguage('chon-ton-giao')?>">
							<option value=""></option>
							<?php foreach($religions as $item){?>
								<option <?php if($datas->religionid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->religion_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('cmnd')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<input maxlength="12" type="text" name="identity" id="identity" placeholder="" class="searchs form-control" required value="<?=$datas->identity;?>" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngay-cap')?> (<span class="red">*</span>)</label>
					 <div class="col-md-8">
						<?php 
							$identity_date = '';
							if(!empty($datas->identity_date)){
								$identity_date = date(configs('cfdate'),strtotime($datas->identity_date));
							}
						?>
						<div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
							<input value="<?=$identity_date;?>" id="identity_date" name="identity_date" type="text" class="searchs form-control tab-event" placeholder="dd/mm/yyyy">
							<div class="input-group-addon">
								<i class="fa fa-calendar "></i>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('noi-cap')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="identity_from" name="identity_from" class="select2me form-control " data-placeholder="<?=getLanguage('chon-noi-cap')?>">
							<option value=""></option>
							<?php foreach($provinces as $item){?>
								<option <?php if($datas->identity_from == $item->id){?> selected <?php }?>  value="<?=$item->id;?>"><?=$item->province_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="islogin" class="control-label col-md-4"><?=getLanguage('dang-nhap-he-thong')?></label>
					<div class="col-md-8">
						<input type="checkbox" <?php if($datas->islogin == 1){?> checked <?php }?> id="islogin" name="islogin" />
					</div>
				</div>
			</div>
		</div>
		<!--E Content-->
		<div class="row mtop10"></div>
	</div>
</div>
<!--End Box-->
<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-graduation-cap"></i> Thông tin trình độ & Quá trình học tập, làm việc
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <!--S content-->
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('trinh-do-hoc-van')?> (<span class="red">*</span>)</label>
					<div class="col-md-8">
						<select id="academic_level" name="academic_level" class="select2me form-control " data-placeholder="<?=getLanguage('chon-trinh-do-hoc-van')?>">
							<option value=""></option>
							<?php foreach($academics as $item){?>
								<option <?php if($datas->academic_level == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->academic_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('trinh-do-chuyen-mon')?></label>
					<div class="col-md-8">
						<input maxlength="100" type="text" name="academic_skills" id="academic_skills" placeholder="" class="searchs form-control" required value="<?=$datas->academic_skills;?>" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ngoai-ngu')?></label>
					<div class="col-md-8">
						<input maxlength="100" type="text" name="english_level" id="english_level" placeholder="" class="searchs form-control" required value="<?=$datas->english_level;?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ngoai-ngu-khac')?></label>
					<div class="col-md-8">
						<input maxlength="100"  type="text" name="foreign_language_other" id="foreign_language_other" placeholder="" class="searchs form-control" required value="<?=$datas->foreign_language_other;?>" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('tin-hoc')?></label>
					<div class="col-md-8">
						<input maxlength="100" type="text" name="computer_level" id="computer_level" placeholder="" class="searchs form-control" required value="<?=$datas->computer_level;?>"  />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ky-nang-khac')?></label>
					<div class="col-md-8">
						<input  maxlength="100" type="text" name="other_skills" id="other_skills" placeholder="" class="searchs form-control" required  value="<?=$datas->other_skills;?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 mtop10">
			 <div class="mtop10" style='border-bottom:1px dotted #0288b4; color:#0288b4; display:flex; margin-bottom:10px; cursor:pointer;'><b><?=getLanguage('qua-trinh-hoc-tap')?></b>
			 <div class="fright cursor" id="qthoctap" style="padding-left:20px;"><i class="fa fa-plus cursor"></i></div>
			 </div>
		</div>
		<!--E Content-->
		<!--S Qua trinh hoc tap-->
		<span id="quatrinhhoctap">
			 <?php
			
			 if(!empty($datas->study_process) && $datas->study_process != '[]'){?>
				<?php 
				$study_process = json_decode($datas->study_process);
				$i = 0;
				foreach($study_process[0] as $item){
					
				?>
				<div class="row mtop10">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('thoi-gian')?> </label>
							<div class="col-md-8">
								<input  maxlength="150" type="text" name="ht_time[]" id="ht_time" placeholder="" class="search2 form-control" required value="<?=$study_process[0][$i];?>" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('truong-theo-hoc')?></label>
							<div class="col-md-8">
								<input  maxlength="150" type="text" name="ht_school[]" id="ht_school" placeholder="" class="search2 form-control" required value="<?=$study_process[1][$i];?>" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi')?></label>
							<div class="col-md-7">
								<input maxlength="150" type="text" name="ht_adress[]" id="ht_adress" placeholder="" class="search2 form-control" required value="<?=$study_process[2][$i];?>" />
							</div>
							<div class="col-md-1">
								<i class="fa fa-times cursor delete_hoctap mright5 fright mtop5 red"></i> 
							</div>
						</div>
					</div>
			 </div>
				<?php $i++;}?>
			 <?php }else{?>
			 <div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('thoi-gian')?> </label>
						<div class="col-md-8">
							<input  maxlength="150" type="text" name="ht_time[]" id="ht_time" placeholder="" class="search2 form-control" required />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('truong-theo-hoc')?></label>
						<div class="col-md-8">
							<input  maxlength="150" type="text" name="ht_school[]" id="ht_school" placeholder="" class="search2 form-control" required />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('dia-chi')?></label>
						<div class="col-md-7">
							<input maxlength="150" type="text" name="ht_adress[]" id="ht_adress" placeholder="" class="search2 form-control" required />
						</div>
						<div class="col-md-1">
							<i class="fa fa-times cursor delete_hoctap mright5 fright mtop5 red"></i> 
						</div>
					</div>
				</div>
			</div>
			 <?php }?>
		</span>
		<!--E Qua trinh hoc tap-->
		<!--S qua trinh lam viec-->
		<div class="box-body">
			 <div class="col-md-12 mtop10">
				 <div class="mtop10" style='border-bottom:1px dotted #0288b4; color:#0288b4; display:flex; margin-bottom:10px; cursor:pointer;'><b><?=getLanguage('qua-trinh-lam-viec')?></b>
				 <div class="fright cursor" id="qtlamviec" style="padding-left:20px;"><i class="fa fa-plus cursor"></i></div>
				 </div>
			</div>
			 <span id="quatrinhlamviec">
			 <?php
			
			 if(!empty($datas->working_process) && $datas->working_process != '[]'){?>
				<?php 
				$working_process = json_decode($datas->working_process);
				$j = 0;
				foreach($working_process[0] as $item){
					
				?>
				 <div class="row mtop10">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('thoi-gian')?> </label>
							<div class="col-md-8">
								<input maxlength="150" type="text" name="work_time[]" id="work_time" placeholder="" class="search2 form-control" required value="<?=$working_process[0][$j];?>" />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('noi-lam-viec')?></label>
							<div class="col-md-8">
								<input maxlength="150" type="text" name="work_company[]" id="work_company" placeholder="" class="search2 form-control" required  value="<?=$working_process[1][$j];?>"/>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi')?></label>
							<div class="col-md-7">
								<input maxlength="150" type="text" name="work_address[]" id="work_address" placeholder="" class="search2 form-control" required value="<?=$working_process[2][$j];?>" />
							</div>
							<div class="col-md-1">
								<i class="fa fa-times cursor delete_noilamviec mright5 fright mtop5 red"></i> 
							</div>
						</div>
					</div>
				</div>
				<?php $j++;}?>
			 <?php }else{?>
				<div class="row mtop10">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('thoi-gian')?> </label>
							<div class="col-md-8">
								<input maxlength="150" type="text" name="work_time[]" id="work_time" placeholder="" class="search2 form-control" required />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('noi-lam-viec')?></label>
							<div class="col-md-8">
								<input maxlength="150" type="text" name="work_company[]" id="work_company" placeholder="" class="search2 form-control" required />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label col-md-4"><?=getLanguage('dia-chi')?></label>
							<div class="col-md-7">
								<input maxlength="150" type="text" name="work_address[]" id="work_address" placeholder="" class="search2 form-control" required />
							</div>
							<div class="col-md-1">
								<i class="fa fa-times cursor delete_noilamviec mright5 fright mtop5 red"></i> 
							</div>
						</div>
					</div>
				</div>
			 <?php }?>
			</span>
		</div>
		<!--E qua trinh lam viec-->
		<div class="row mtop10"></div>
	</div>
</div>
<!--S dia chi lien lac-->
<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-location-arrow"></i> <?=getLanguage('dia-chi-lien-lac');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    		 <div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('dc-thuong-tru')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<input maxlength="150" type="text" name="permanent_address" id="permanent_address" placeholder="" class="searchs form-control" required value="<?=$datas->permanent_address;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('tinh-thanh-pho')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id="permanent_province" name="permanent_province" class="select2me form-control " data-placeholder="<?=getLanguage('chon-tinh-thanh-pho')?>">
								<option value=""></option>
								<?php foreach($provinces as $item){?>
									<option <?php if($datas->permanent_province == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->province_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('quan-huyen')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<?php if(empty($datas->permanent_dictric)){?>
							<span id="loadDistricPermanent">
								<select id="permanent_dictric" name="permanent_dictric" class="form-control select2me" data-placeholder="<?=getLanguage('chon-quan-huyen')?>">
									<option value=""></option>
								</select>
							</span>
							<?php }else{?>
							<span id="loadDistricPermanent">
								<select id="permanent_dictric" name="permanent_dictric" class="form-control select2me" data-placeholder="<?=getLanguage('chon-quan-huyen')?>">
									<option value=""></option>
									<?php foreach($districs as $item){?>
										<option <?php if($datas->permanent_dictric == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->distric_name;?></option>
									<?php }?>
								</select>
							</span>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('dc-tam-tru')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<input maxlength="150" type="text" name="tempery_address" id="tempery_address" placeholder="" class="searchs form-control" required value="<?=$datas->tempery_address;?>"/>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('tinh-thanh-pho')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id="tempery_province" name="tempery_province" class="select2me form-control " data-placeholder="<?=getLanguage('chon-tinh-thanh-pho')?>">
								<option value=""></option>
								<?php foreach($provinces as $item){?>
									<option <?php if($datas->tempery_province == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->province_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('quan-huyen')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<?php if(empty($datas->tempery_distric)){?>
							<span id="loadDistricEmpery"> 
								<select id="tempery_distric" name="tempery_distric" class="form-control select2me" data-placeholder="<?=getLanguage('chon-quan-huyen')?>">
									<option value=""></option>
									
								</select>
							</span>
							<?php }else{?>
							<span id="loadDistricPermanent">
								<select id="tempery_distric" name="tempery_distric" class="form-control select2me" data-placeholder="<?=getLanguage('chon-quan-huyen')?>">
									<option value=""></option>
									<?php foreach($districs2 as $item){?>
										<option <?php if($datas->tempery_distric == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->distric_name;?></option>
									<?php }?>
								</select>
							</span>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage( 'dien-thoai')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<input maxlength="30" type="text" name="phone" id="phone" placeholder="" class="searchs form-control" required value="<?=$datas->phone;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('email')?></label>
						<div class="col-md-8">
							<input maxlength="70" type="text" name="email" id="email" placeholder="" class="searchs form-control" required value="<?=$datas->email;?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10"></div>
	</div>
</div>
<!--E Dia chi lien lac-->
<!--S Thong tin cong viec-->
<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-folder-open-o"></i> <?=getLanguage('thong-tin-cong-viec');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <!--S content-->
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<?php 
						$code = $datas->code;
						if(empty($datas->code)){
							$code = $maxcode;
						}
						?>
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ma-nhan-vien')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<input maxlength="30" type="text" name="code" id="code" placeholder="" class="searchs form-control" required value="<?=$code;?>" <?php if(!empty($datas->code)){?> readonly <?php }?> />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('phong-ban')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id="departmentid" name="departmentid" class="select2me form-control " data-placeholder="<?=getLanguage('chon-phong-ban')?>">
								<option value=""></option> 
								<?php foreach($departments as $item){?>
								<option <?php if($datas->departmentid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('chuc-vu')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id="positionid" name="positionid" class="select2me form-control " data-placeholder="<?=getLanguage('chon-chuc-vu')?>">
								<option value=""></option> 
								<?php foreach($positions as $item){?>
									<option <?php if($datas->positionid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->position_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('to-nhom')?> </label>
						<div class="col-md-8" id="loadgroupwork">
							<select id='group_work_id' name='group_work_id' class="form-control select2me" data-placeholder="<?=getLanguage('chon-to-nhom')?>">
								<option value=""></option>
								<?php foreach($departmentGroups as $item){?>
									<option value="<?=$item->id;?>"><?=$item->departmentgroup_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ngay-bat-dau')?> (<span class="red">*</span>)</label>
						<div class="col-md-8 " >
							<?php 
								$date_start = '';
								if(!empty($datas->date_start)){
									$date_start = date(configs('cfdate'),strtotime($datas->date_start));
								}
							?>
							<div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
								<input value="<?=$date_start;?>" id="date_start" name="date_start" type="text" class="searchs form-control tab-event">
								<div class="input-group-addon">
									<i class="fa fa-calendar "></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('thoi-gian-thu-viec')?></label>
						<div class="col-md-8">
							<input maxlength="100" type="text" name="date_trial_work" id="date_trial_work" placeholder="" class="searchs form-control" required value="<?=$datas->date_trial_work;?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ma-hop-dong')?></label>
						<div class="col-md-8">
							<input  maxlength="30"  type="text" name="contrac_code" id="contrac_code" placeholder="" class="searchs form-control" required value="<?=$datas->contrac_code;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ngay-ky-hop-dong')?></label>
						<div class="col-md-8 " >
							<?php 
								$contrac_date = '';
								if(!empty($datas->contrac_date)){
									$contrac_date = date(configs('cfdate'),strtotime($datas->contrac_date));
								}
							?>
							<div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
								<input value="<?=$contrac_date;?>" id="contrac_date" name="contrac_date" type="text" class="searchs form-control tab-event">
								<div class="input-group-addon">
									<i class="fa fa-calendar "></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ngay-het-han')?></label>
						<div class="col-md-8">
							<?php 
								$contac_expired_date = '';
								if(!empty($datas->contac_expired_date)){
									$contac_expired_date = date(configs('cfdate'),strtotime($datas->contac_expired_date));
								}
							?>
							<div class="input-group date" data-provide="datepicker"  data-date-format="dd/mm/yyyy">
								<input value="<?=$contac_expired_date;?>" id="contac_expired_date" name="contac_expired_date" type="text" class="searchs form-control tab-event">
								<div class="input-group-addon">
									<i class="fa fa-calendar "></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ma-so-bao-hiem')?></label>
						<div class="col-md-8">
							<input  maxlength="30" type="text" name="insurance_code" id="insurance_code" placeholder="" class="searchs form-control" required value="<?=$datas->insurance_code;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('benh-vien-dang-ky')?></label>
						<div class="col-md-8">
							<input  maxlength="100" type="text" name="insurance_hospital" id="insurance_hospital" placeholder="" class="searchs form-control" required value="<?=$datas->insurance_hospital;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('ma-so-thue')?></label>
						<div class="col-md-8">
							<input maxlength="25" type="text" name="tax_code" id="tax_code" placeholder="" class="searchs form-control" required value="<?=$datas->tax_code;?>" />
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('tk-ngan-hang')?></label>
						<div class="col-md-8">
							<input  maxlength="30" type="text" name="bank_accout" id="bank_accout" placeholder="" class="searchs form-control" required value="<?=$datas->bank_accout;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ngan-hang')?></label>
						<div class="col-md-8">
							<input  maxlength="30" type="text" name="bank_name" id="bank_name" placeholder="" class="searchs form-control" required value="<?=$datas->bank_name;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('tinh-trang-cong-viec')?>(<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id='jobstatusid' name='jobstatusid' class="select2me form-control " data-placeholder="<?=getLanguage('chon-tinh-trang-cong-viec')?>">
								<option value=""></option>
								<?php foreach($jobstatus as $item){?>
									<option <?php if($datas->jobstatusid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->status_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ca-lam-viec')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id='shiftid' name='shiftid' class="select2me form-control " data-placeholder="<?=getLanguage('chon-ca-lam-viec')?>">
								<!--<option value=""></option>-->
								<?php foreach($shifts as $item){?>
									<option <?php if($datas->shiftid == $item->id){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->shift_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('nhan-luong')?> (<span class="red">*</span>)</label>
						<div class="col-md-8">
							<select id='salary_accept' name='salary_accept' class="select2me form-control">
								<option <?php if($datas->salary_accept == 1){?> selected <?php }?> value="1"><?=getLanguage('nhan-luong-thang')?></option>
								<option <?php if($datas->salary_accept == 2){?> selected <?php }?> value="2"><?=getLanguage('nhan-luong-gio')?></option>
							</select>
						</div>
					</div>
				</div>
			</div>		
		<!--E content-->
		<div class="row mtop10"></div>
	</div>
</div>
<!--E Thong tin nguoi phu thuoc-->
<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-users"></i> <?=getLanguage('thong-tin-nguoi-phu-thuoc');?> 
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool">
			<a href="#"><div class="fright cursor" id="addnguoiphuthuoc" style="padding-left:20px;"><i class="fa fa-plus cursor"></i></div></a>
		 
		 </button>
	  </div>
	</div>
	<div class="box-body">
	    <div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ho-ten')?> </label>
					<div class="col-md-8">
						<input maxlength="150" type="text" placeholder="" class="form-control" required value="" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('nam-sinh')?></label>
					<div class="col-md-8">
						<input maxlength="150" type="text" placeholder="" class="form-control" required  value=""/>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('quan-he')?></label>
					<div class="col-md-7">
						<input maxlength="150" type="text" placeholder="" class="form-control" required  value=""/>
					</div>
					<div class="col-md-1">
						<i class="fa fa-times cursor delete_noilamviec mright5 fright mtop5 red"></i> 
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10"></div>
	</div>
</div>
<!--E Thong tin cong viec-->
<div class="box">
	<div class="box-header with-border">
	  <i class="fa fa-phone"></i> <?=getLanguage('thong-tin-nguoi-lien-he-khan-cap');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4" style="padding-right:0;"><?=getLanguage('ten-nguoi-than')?></label>
						<div class="col-md-8">
							<input maxlength="70" type="text" name="family_name" id="family_name" placeholder="" class="searchs form-control" required value="<?=$datas->family_name;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage( 'dien-thoai')?></label>
						<div class="col-md-8">
							<input maxlength="30" type="text" name="family_phone" id="family_phone" placeholder="" class="searchs form-control" required value="<?=$datas->family_phone;?>" />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('quan-he')?></label>
						<div class="col-md-8">
							<input maxlength="50" type="text" name="family_relation" id="family_relation" placeholder="" class="searchs form-control" required value="<?=$datas->family_relation;?>" />
						</div>
					</div>
				</div>
			</div>
		<div class="row mtop10"></div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">
		<div class="mright10" >
			<ul class="button-group pull-right">
				<input type="hidden" name="employeeid" id="employeeid" value="<?=$datas->id;?>"/>
				<li id="refresh2" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi')?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save2">
					<button class="button">
						<i class="fa fa-plus"></i>
						<?=getLanguage('them-moi')?>
					</button>
				</li>
				<?php } ?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit2">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua')?>
					</button>
				</li>
				<?php } ?>
			
			</ul>
		</div>		
	</div>
</div>
<!-- END PORTLET-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/preloader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<script type="text/javascript">
	var controller = '<?=base_url().$routes;?>/';
	var csrfHash = '<?=$csrfHash;?>';
	var cpage = 0;
	var search;
</script>
<script src="<?=url_tmpl();?>js/pages/<?=$routes;?>.js" type="text/javascript"></script>


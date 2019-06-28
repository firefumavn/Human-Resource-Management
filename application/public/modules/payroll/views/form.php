<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nhan-vien');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="input_employeeid" name="input_employeeid" class="select2me select2mes form-input form-control " data-placeholder="<?=getLanguage('chon-nhan-vien')?>">
					<option value=""></option>
					<?php foreach($employees as $item){?>
						<option <?php if($item->id == $finds->employeeid){ echo 'selected';}?> value="<?=$item->id;?>"><?=$item->code;?> - <?=$item->fullname;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ky-luong')?></label>
			<div class="col-md-8">
				<select id="input_endoffmonthid" name="input_endoffmonthid" class="select2me select2mes form-input form-control " data-placeholder="<?=getLanguage('chon-ky-luong')?>">
					<?php foreach($endoffmonths as $item){
						?>
					<option <?php if($item->id == $finds->endoffmonthid){ echo 'selected';}?> value="<?=$item->id;?>"><?=$item->monthyear;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-6 ">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('luong-co-ban');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_salary"  id="input_salary" class="form-input form-control fm-number" 
				value="<?=$finds->salary;?>"/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dong-bao-hiem');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="input_isinsurance" name="input_isinsurance" class="select2me select2mes form-input form-control " data-placeholder="<?=getLanguage('chon-loai-luong')?>">
					<option <?php if($finds->isinsurance == 1){?> selected <?php }?> value="1"><?=getLanguage('co-dong');?></option>
					<option <?php if($finds->isinsurance == 0){?> selected <?php }?> value="0"><?=getLanguage('khong-dong');?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="row mtop10">
	<div class="col-md-12 ">
		<div class="col-md-12"><div style="border-top:1px dashed #999; height:1px; width:100%;"></div></div>
	</div>
	<div class="col-md-12 ">
		<div class="form-group">
			<label class="control-label col-md-2"><b><?=getLanguage('phu-cap');?></b></label>
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-3" style="padding-left:10px; margin-top:3px;">
						<b><?=getLanguage('so-tien');?></b>
					</div>
					<!--<div class="col-md-3" style="padding-left:0px;">
						<b><?=getLanguage('cach-tinh');?></b>
					</div>
					<div class="col-md-3" style="padding-left:0px;">
						<b><?=getLanguage('dong-bao-hiem')?></b>
					</div>-->
					<!--<div class="col-md-3" style="padding-left:0px;">
						<b><?=getLanguage('tinh-thue-thu-nhap')?></b>
					</div>-->
				</div>
			</div>
		</div>
	</div>
	<?php foreach($allowances as $item){
		$allowanceS = 0;
		$typeid = 1;
		$isinsurance = 1;
		if(!empty($allowanceSalarys[$finds->employeeid][$item->id])){
			$allowanceS = $allowanceSalarys[$finds->employeeid][$item->id]->salary;
			$typeid = $allowanceSalarys[$finds->employeeid][$item->id]->typeid;
			$isinsurance = $allowanceSalarys[$finds->employeeid][$item->id]->isinsurance;
		}
		?>
		<div class="col-md-12 mtop10">
			<div class="form-group">
				<label class="control-label col-md-2"><?=$item->allowance_name;?></label>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-3" style="padding-left:10px;">
							<input type="text" name="input_<?=$item->id;?>"  id="input_<?=$item->id;?>" class="form-input form-control allowance fm-number" 
							value="<?=$allowanceS;?>"
							/>
						</div>
						<div class="col-md-3" style="padding-left:0; display:none;">
							<select id="input_typeid_<?=$item->id;?>" name="input_typeid_<?=$item->id;?>" class="select2me select2mes allowance form-control " data-placeholder="<?=getLanguage('chon-trang-thai')?>">
								 <option <?php if($typeid == 1){?> selected <?php }?> value="1"><?=getLanguage('cong')?></option>
							</select>
						</div>
						<div class="col-md-3" style="padding-left:0; display:none;">
							<select id="input_isinsurance_<?=$item->id;?>" name="input_isinsurance_<?=$item->id;?>" class="select2me select2mes allowance form-control " data-placeholder="<?=getLanguage('dong-bao-hiem');?>">
								 <option <?php if($isinsurance == 1){?> selected <?php }?> value="1"><?=getLanguage('co-dong')?></option>
								 <option <?php if($isinsurance == 0){?> selected <?php }?> value="0"><?=getLanguage('khong-dong')?></option>
							</select>
						</div>
					 </div>
				</div>
			</div>
		</div>
	<?php }?>
	<div class="col-md-12 mtop10">
		<div class="col-md-12"><div style="border-top:1px dashed #999; height:1px; width:100%;"></div></div>
		<select id="endoffmonthids" name="endoffmonthids" class="select2me select2mes form-control" style="display:none;" ></select>
	</div>
</div>
<script src="<?=url_tmpl();?>js/pages/<?=$routes;?>_form.js" type="text/javascript"></script>
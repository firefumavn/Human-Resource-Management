<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ten');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_insurance_name"  id="input_insurance_name" class="form-input form-control tab-event" 
				value="<?=$finds->insurance_name;?>"  placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('doanh-nghiep-dong');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_company"  id="input_company" class="form-input form-control fm-number" 
				value="<?=number_format($finds->company);?>"
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('nguoi-lao-dong-dong');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_workers"  id="input_workers" class="form-input form-control fm-number" 
				value="<?=number_format($finds->workers);?>" />
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai');?> </label>
			<div class="col-md-8">
				<select id="input_insurance_type" name="input_insurance_type" class="form-input form-control select2me" >
						<?php foreach($types as $key=>$val){?>
							<option <?php if($key == $finds->insurance_type){ echo 'selected';}?>  value="<?=$key;?>"><?=$val;?></option>
						<?php }?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ghi-chu');?></label>
			<div class="col-md-8">
				<input type="text" name="input_description"  id="input_description" class="form-input form-control fm-number" 
				value="<?=$finds->description;?>" />
			</div>
		</div>
	</div>

</div>
<script>
	$(function(){
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
		initForm();
		handleSelect2();
	});
	function initForm(){
		$('#input_insurance_name').select();
	}
</script>

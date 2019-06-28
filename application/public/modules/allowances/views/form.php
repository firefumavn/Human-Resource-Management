<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phu-cap');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_allowance_name"  id="input_allowance_name" class="form-input form-control tab-event" 
				value="<?=$finds->allowance_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<!--<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tien-phu-cap');?></label>
			<div class="col-md-8">
				<input type="text" name="input_allowance_money"  id="input_allowance_money" class="form-input form-control fm-number" 
				value="<?=fmNumber($finds->allowance_money);?>" placeholder="" 
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('loai-phu-cap');?> </label>
			<div class="col-md-8">
				<select id="input_allowance_type" name="input_allowance_type" class="select2me form-input form-control" data-placeholder="<?=getLanguage('chon-loai')?>">
					<option value=""></option>
						<?php foreach($types as $key=>$val){?>
							<option <?php if($key == $finds->allowance_type){ echo 'selected';}?>  value="<?=$key;?>"><?=$val;?></option>
						<?php }?>
				</select>
			</div>
		</div>
	</div>-->
</div>
<?php
	//print_r($finds);
?>
<script>
	$(function(){
		formatNumber('fm-number');
		formatNumberKeyUp('fm-number');
		initForm();
		handleSelect2();
	});
	function initForm(){
		$('#input_allowance_name').select();
	}
</script>

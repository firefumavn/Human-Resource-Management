<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('to-nhom');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_departmentgroup_name"  id="input_departmentgroup_name" class="form-input form-control" 
				value="<?=$finds->departmentgroup_name;?>" placeholder="" 
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phong-ban');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="input_departmentid" name="input_departmentid" class="select2me form-input form-control" data-placeholder="<?=getLanguage('chon-phong-ban')?>">
					<option value=""></option>
					<?php foreach($departments as $item){?>
						<option <?php if($item->id == $finds->departmentid){ echo 'selected';}?> value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
					<?php }?>
				</select>
			</div>
		</div>
	</div>
</div>
<?php
	//print_r($finds);
?>
<script>
	$(function(){
		initForm();
		handleSelect2();
	});
	function initForm(){
		$('#input_departmentgroup_name').select();
	}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('trinh-do-hoc-van');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_academic_name"  id="input_academic_name" class="form-input form-control tab-event" 
				value="<?=$finds->academic_name;?>" placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('thu-tu');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_ordering"  id="input_ordering" class="form-input form-control tab-event" value="<?=$finds->ordering;?>" placeholder=""/>
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
	});
	function initForm(){
		$('#input_academic_name').select();
	}
</script>

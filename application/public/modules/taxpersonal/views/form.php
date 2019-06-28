<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('thu-nhap-tu');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_from_salary"  id="input_from_salary" class="form-input form-control fm-number" 
				value="<?=$finds->from_salary;?>"  placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('thu-nhap-den');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_to_salary"  id="input_to_salary" class="form-input form-control fm-number" 
				value="<?=($finds->to_salary);?>"
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('thue-suat');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_tax"  id="input_tax" class="form-input form-control fm-number" 
				value="<?=($finds->tax);?>" />
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
		$('#input_from_salary').select();
	}
</script>

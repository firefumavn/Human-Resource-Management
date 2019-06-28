<div class="row">
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ky-luong')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="endoffmonthids" name="endoffmonthids" class="select2me form-control" >
					<option value=""></option>
					<?php $i=1; foreach($endoffmonths as $item){?>
					<option <?php if($i==1){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->monthyear;?></option>
					<?php $i++;}?>
				</select>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$("#endoffmonthids").select2({
			placeholder: "",
			allowClear: true
		});
	});
</script>
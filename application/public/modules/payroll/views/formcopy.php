<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('tu-ky-luong')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="frommonth" name="frommonth" class="select2me form-control" >
					<option value=""></option>
					<?php $i=1; foreach($endoffmonths as $item){?>
					<option <?php if($i==2){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->monthyear;?></option>
					<?php $i++;}?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('toi-ky-luong')?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<select id="tomonth" name="tomonth" class="select2me form-control" >
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
		$("#frommonth").select2({
			placeholder: "",
			allowClear: true
		});
		$("#tomonth").select2({
			placeholder: "",
			allowClear: true
		});
	});
</script>
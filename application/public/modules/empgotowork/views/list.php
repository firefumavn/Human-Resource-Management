
<?php 	$i = $start; 
foreach ($datas as $key => $item) { 
	$id = $item->id;
	$shift_time_star = $item->shift_time_star;
	$shift_time_end = $item->shift_time_end;
	//
	$time_start = $item->time_start;
	$time_end = $item->time_end;
	
	$start_shift = date('Y-m-d',strtotime($item->time_start)).' '.$shift_time_star;
	$end_shift = date('Y-m-d',strtotime($item->time_end)).' '.$shift_time_end;
	$ditre = ''; $style="";
	if(strtotime($item->time_start) > strtotime($start_shift)){//Co đo trể
		$ditre = $this->base_model->timeStamp($start_shift, $time_start);
		$style="style='color:red'";
	}
	$vesom = '';
	if(strtotime($item->time_end) < strtotime($end_shift)){//Về sớm
		$vesom = $this->base_model->timeStamp($item->time_end, $end_shift);
		$style="style='color:red'";
	}
	
	?>
	<tr <?=$style;?> class="edit" id="<?=$item->id;?>" group_work_id="<?=$item->group_work_id;?>" departmentid = "<?=$item->departmentid;?>" identity = "<?=$item->identity;?>">
		
		<td style="text-align: center;">
			<input id="<?=$item->id;?>" class="check noClick" type="checkbox" value="<?=$item->id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="departmanet_name "><?=$item->departmanet_name;?></td>
		<td class="code"><?=$item->code;?></td>
		<td class="fullname"><?=$item->fullname;?></td>
		<td class="time_start text-center"><?=date(configs('cfdate').' H:i:s',strtotime($item->time_start));?></td>
		<td class="time_end text-center"><?=date(configs('cfdate').' H:i:s',strtotime($item->time_end));?></td>
		<td class=""><?=$ditre;?></td>
		<td class=""><?=$vesom;?></td>
		<td><?=$item->position_name;?></td>
		<td><?=$item->departmentgroup_name;?></td>
		<td></td>
	</tr>

<?php $i++;}?>

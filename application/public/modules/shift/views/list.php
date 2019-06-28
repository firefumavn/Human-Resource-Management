
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;	
	?>
	<tr class="content edit" id="<?=$id;?>" >
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="shift_name"><?=$item->shift_name;?></td>
		<td class="time_star text-center"><?=$item->time_star;?></td>
		<td class="time_end_am text-center"><?=$item->time_end_am;?></td>
		<td class="time_star_pm text-center"><?=$item->time_star_pm;?></td>
		<td class="time_end text-center"><?=$item->time_end;?></td>
		<td class="time_end text-center"><?=($item->hours_1) + ($item->hours_2);?>h</td>
		<td class="text-center"><input value="<?=$item->isdefault;?>" class="isdefault" id="<?=$item->id;?>" <?php if($item->isdefault == 1){?> checked <?php }?> type="checkbox" /></td>
		<td class="text-center">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem mleft10" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>

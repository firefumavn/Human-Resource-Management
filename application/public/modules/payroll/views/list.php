
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;	
	$salary_status = '';
	$ngaycongNhanvien = 0;
	$salary_accept = getLanguage('ngay');
	if(isset($ngaycong[$item->employeeid])){
		$objectItem = $ngaycong[$item->employeeid];
		$ngaycongNhanvien = $objectItem->workday;
		if($objectItem->salary_accept == 2){
			$ngaycongNhanvien = $objectItem->workday_hours; 
			$salary_accept = getLanguage('gio');
		}
	}
	$pubSalary = 0;
	if(!empty($salaryPublic[$item->employeeid])){
		$pubSalary = $salaryPublic[$item->employeeid];
	}
	?>
	<tr class="content edit" id="<?=$id;?>" 
	departmentid = "<?=$item->departmentid;?>" 
	employeeid = "<?=$item->employeeid;?>"
	endoffmonthid = "<?=$item->endoffmonthid;?>"
	>
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="departmanet_name"><?=$item->departmanet_name;?></td>
		<td class="code"><?=$item->code;?></td>
		<td class="fullname"><?=$item->fullname;?></td>
		<td class="monthyear text-center">
			<a style="padding:0 3px;" id="<?=$id;?>" class="btn btn-success cskh" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
 <?=$item->monthyear;?>
			</a>
		</td>
		<td class="text-right"><?=number_format($item->salary);?></td>
		<?php 
		foreach($allowances as $items){
			$allowanceS = 0;
			if(!empty($allowanceSalarys[$item->employeeid][$items->id])){
				$allowanceS = $allowanceSalarys[$item->employeeid][$items->id];
			}
			?>
			<td class="text-right"><?=number_format($allowanceS);?></td>
		<?php }?>
		<?php 
		$tt = $item->salary;
		foreach($allowances as $items){
			$allowanceS = 0;
			if(!empty($allowanceSalarys[$item->employeeid][$items->id])){
				$allowanceS = $allowanceSalarys[$item->employeeid][$items->id];
			}
			$tt+= $allowanceS;
			?>
		<?php }?>
		<td class="text-right">
				<b><?=number_format($tt);?></b>
		</td>
		<td class="text-center"><?=$ngaycongNhanvien;?> <?=$salary_accept;?></td>
		<td class="text-right"><?=fmNumber($pubSalary);?></td>
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

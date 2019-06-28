
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;	
	$salary_real = $item->salary_real;
	$khen_thuong = $item->khen_thuong;
	$bao_hiem = $item->bao_hiem;
	$tong_cong = $salary_real + $khen_thuong + $bao_hiem;
	?>
	<tr class="content edit" id="<?=$id;?>">
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="departmanet_name"><?=$item->departmanet_name;?></td>
		<td class="code"><?=$item->code;?></td>
		<td class="fullname"><?=$item->fullname;?></td>
		<td class="monthyear text-center"><?=$item->monthyear;?></td>
		<td class="text-right"><?=number_format($tong_cong);?></td>
		<td class="text-right"><?=number_format($salary_real);?></td>
		<td class="text-right"><?=number_format($bao_hiem);?></td>
		<td class="text-right"><?=number_format($khen_thuong);?></td>
		<td></td>
	</tr>
<?php $i++;}?>

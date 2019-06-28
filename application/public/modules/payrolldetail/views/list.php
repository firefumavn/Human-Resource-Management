

	<!--body-->
	<div id="data" style="padding-left:15px; height:auto" class="row">
		<div class="col-md-6" style="padding-right:0;">
			<table width="100%" cellspacing="0" border="1">
				<tr>
					<td>Lương cơ bản:</td>
					<td class="text-right"><?=fmNumber($salarys);?></td>
				</tr>
				<?php foreach($allowances as $item){
					$tienPC = 0;
					if(isset($allowanceSalarys[$item->id])){
						$tienPC = $allowanceSalarys[$item->id];
					}
					?>
				<tr>
					<td><?=$item->allowance_name;?>:</td>
					<td class="text-right"><?=fmNumber($tienPC);?></td>
				</tr>
				<?php }?>
				<tr>
					<td>Các khoản thu khác:</td>
					<td class="text-right"></td>
				</tr>
				<tr>
					<td>Các khoản nợ khác:</td>
					<td></td>
				</tr>
				<tr>
					<td>Lương:</td>
					<td class="text-right">
						<?php
							if(!empty($salaryPublic->salary)){
								echo fmNumber($salaryPublic->salary);
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Thực lãnh:</td>
					<td class="text-right">
						<?php 
							if(!empty($salaryPublic->salary_real)){
								echo fmNumber($salaryPublic->salary_real);
							}
						?>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-6">
			<table width="100%" cellspacing="0" border="1">
				<?php 
					foreach($insurance as $item){
					$value = '';
					if(isset($insuranceValue[$item->id])){
						$value = number_format($insuranceValue[$item->id]).'('.$item->workers .'%)';
					}
					?>
				<tr>
					<td><?=$item->insurance_name;?>:</td>
					<td><?=$value;?></td>
				</tr>
				<?php }?>
				<tr>
					<td>Thuế thu nhập cá nhân:</td>
					<td></td>
				</tr>
				<tr>
					<td>Tổng ngày phép:</td>
					<td></td>
				</tr>
				<tr>
					<td>Số ngày phép đã sử dụng:</td>
					<td></td>
				</tr>
				<tr>
					<td>Số ngày phép còn lại:</td>
					<td></td>
				</tr>
				<tr>
					<td>Số lần đi trễ:</td>
					<td></td>
				</tr>
				<tr>
					<td>Số lần về sớm:</td>
					<td></td>
				</tr>
			</table>
		</div>	
	</div>
	<!--end body-->

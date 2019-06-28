<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 45px; }
	table col.c3 { width: 120px; }
	table col.c4 { width: 100px; }
	table col.c5 { width: 150px; }
	table col.c6 { width: 100px; }
	table col.c7 { width: 110px; }
	table col.c8 { width: 110px; }
	table col.ccallowances { width: 100px; }
	table col.caction { width: 100px; }
	table col.nc { width: 100px; }
	table col.ltl { width: 100px; }
	table col.cauto { width: auto;}
</style>

<div class="box">
	<div class="box-header with-border">
	  <?=$this->load->inc('breadcrumb');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
		<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
		  <i class="fa fa-times"></i></button>-->
	  </div>
	</div>
	<div class="box-body">
	    <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('ma-nhan-vien');?></label>
					<div class="col-md-8">
						<input type="text" name="code" id="code" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('ho-ten')?></label>
					<div class="col-md-8">
						<input type="text" name="fullname" id="fullname" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('cmnd')?></label>
					<div class="col-md-8">
						<input type="text" name="identity" id="identity" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('phong-ban')?></label>
					<div class="col-md-8">
						<select class="combos" id="departmentid" name="departmentid">
							<?php foreach($departments as $item){?>
							<option value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ky-luong')?></label>
					<div class="col-md-8">
						<select id="endoffmonthid" name="endoffmonthid" class="combos" >
							<option value=""></option>
							<?php $i=1; foreach($endoffmonths as $item){?>
							<option <?php if($i==1){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->monthyear;?></option>
							<?php $i++;}?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10"></div>
	</div>
</div>
<div class="box">
	<div class="box-header with-border">
	  <div class="brc"><?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('nhan-vien');?></div>

	  <div class="box-tools pull-right">
		   <ul class="button-group pull-right btnpermission">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('tim-kiem');?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi');?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save" data-toggle="modal" data-target="#myModalFrom">
					<button class="button" >
					<i class="fa fa-plus"></i>
					<?=getLanguage('them-moi');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['copy'])){?>
				<li id="copy" data-toggle="modal" data-target="#myModalCopy">
					<button class="button" >
					<i class="fa fa-files-o"></i>
					<?=getLanguage('copy');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['add'])){?> 
				<li id="payroll" data-toggle="modal" data-target="#myModalPayRoll">
					<button class="button" >
					<i class="fa fa-files-o"></i>
					<?=getLanguage('chot-luong');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['delete'])){?>
				<li id="delete">
					<button type="button" class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa');?>
					</button>
				</li>
				<?php }?>
				
			</ul>	
	  </div>
	</div>
	<div class="box-body">
	     <div id="gridview" >
		 <!--header-->
		 <div id="cHeader">
			<div id="tHeader">    	
				<table width="100%" cellspacing="0" border="1" class="table ">
					<?php 
					for($i=1; $i< 9; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<?php foreach($allowances as $item){?>
						<col class="ccallowances">
					<?php }?>
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="cauto">
					<tr>
						<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
						<th><?=getLanguage('stt');?></th>
						<th id="ord_d.departmanet_name"><?=getLanguage('phong-ban');?></th>
						<th id="ord_e.code"><?=getLanguage('ma-nhan-vien');?></th>
						<th id="ord_e.fullname"><?=getLanguage('ho-ten');?></th>
						<th id="ord_s.endoffmonthid"><?=getLanguage('ky-luong');?></th>
						<th id="ord_s.salary"><?=getLanguage('luong-co-ban');?></th>
						<?php foreach($allowances as $item){?>
						<th id=""><?=$item->allowance_name;?></th>
						<?php }?>
						<th id=""><?=getLanguage('tong-cong');?></th>
						<th><?=getLanguage('ngay-cong');?></th>
						<th><?=getLanguage('thuc-lanh');?></th>
						<th></th>
						<th></th>
					</tr>
				</table>
			</div>
		</div>
		<!--end header-->
		<!--body-->
		<div id="data">
			<div id="gridView">
				<table id="group"  width="100%" cellspacing="0" border="1">
					<?php 
					for($i=1; $i< 9; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<?php foreach($allowances as $item){?>
						<col class="ccallowances">
					<?php }?>
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="cauto">
					<tbody id="grid-rows"></tbody>
				</table>
			</div>
		</div>
		<!--end body-->
	 </div>
	 <div class="">
		<div class="fleft" id="paging"></div>
	 </div>
	</div>
</div>
<!-- END grid-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/preloader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<!-- ui-dialog -->
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:850px;">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=getLanguage('bang-luong-chi-tiet');?></h4>
		</div>
		<div id="loadContent" class="modal-body">
		</div>
		<div class="modal-footer">
			<button id="printSalary" type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-print"></i> <?=getLanguage('in');?></button>			
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?=getLanguage('dong');?></button>
		</div>
    </div>
  </div>
</div>
<!--E Modal -->
<!--Copy Modal -->
<div id="myModalCopy" class="modal fade" role="dialog">
  <div class="modal-dialog w600">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=getLanguage('copy-luong');?></h4>
		</div>
		<div id="loadContentCopy" class="modal-body"></div>
		<div class="modal-footer">
			<button id="copySalary" type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-copy"></i> <?=getLanguage('save');?></button>			
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?=getLanguage('dong');?></button>
		</div>
    </div>
  </div>
</div>
<!--E Copy Modal -->
<!--Copy Modal -->
<div id="myModalPayRoll" class="modal fade" role="dialog">
  <div class="modal-dialog w500">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=getLanguage('chot-luong');?></h4>
		</div>
		<div id="loadContentPayRoll" class="modal-body"></div>
		<div class="modal-footer">
			<button id="updatepayroll" type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-copy"></i> <?=getLanguage('save');?></button>			
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?=getLanguage('dong');?></button>
		</div>
    </div>
  </div>
</div>
<!--E Copy Modal -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
</script>
<script src="<?=url_tmpl();?>js/pages/<?=$routes;?>.js" type="text/javascript"></script>

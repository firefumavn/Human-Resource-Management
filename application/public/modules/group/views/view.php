<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 60px; }
	table col.c3 { width: 250px; }
	table col.c4 { width: 180px; }
	table col.c5 { width: 180px; }
	table col.c6 { width: 100px; }
	table col.c7 { width: auto;}
</style>
<link href="<?=url_tmpl();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<div class="box">
	<div class="box-header with-border">
	  <?=$this->load->inc('breadcrumb');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
	  </div>
	</div>
	<div class="box-body">
	    <div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('nhom-quyen');?></label>
						<div class="col-md-8">
							<input type="text" name="groupname" placeholder="Nhóm quyền" id="groupname" class="searchs form-control tab-event" required />
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('loai-nhom');?></label>
						<div class="col-md-8">
							<select name="grouptype" id="grouptype" class="combos tab-event">
								<option value=""> </option>
								<?php if($grouptype == -1){?>
								<option value="-1">Root</option>
								<?php }?>
								<option value="0"><?=getLanguage('admin');?></option>
								<option value="1"><?=getLanguage('truong-phong-nhan-su');?></option>
								<option value="2"><?=getLanguage('truong-phong-ban');?></option>
								<option value="3"><?=getLanguage('to-truong-truong-nhom');?></option>
								<option value="4"><?=getLanguage('nhan-vien');?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label col-md-4"><?=getLanguage('cong-ty');?></label>
						<div class="col-md-8">
							<select name="companyid" id="companyid" class="combos tab-event">
								<option value=""> </option>
								<?php foreach($companys as $item){?>
								<option value="<?=$item->id;?>"><?=$item->company_name;?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row mtop10">
				<div class="col-md-12">
						
				</div>
			</div>
	</div>
</div>
<div class="box">
	<div class="box-header with-border">
	  <div class="brc"><?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('ket-qua');?></div>

	  <div class="box-tools pull-right">
			<ul class="button-group pull-right">
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
						<li id="save"><button class="button">
							<i class="fa fa-plus"></i>
							<?=getLanguage('them-moi');?>
							</button>
						</li>
						<?php }?>
						<?php if(isset($permission['edit'])){?>
						<li id="edit">
							<button class="button">
								<i class="fa fa-save"></i>
								<?=getLanguage('sua');?>
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
		 <table class="resultset" id="grid"></table>
		 <!--header-->
		 <div id="cHeader">
			<div id="tHeader">    	
				<table width="100%" cellspacing="0" border="1" class="table ">
					<?php for($i=1; $i< 8; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<tr>
						<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
						<th><?=getLanguage('stt');?></th>
						<th><?=getLanguage('nhom-quyen');?></th>
						<th><?=getLanguage('loai-nhom');?></th>
						<th><?=getLanguage('cong-ty');?></th>
						<th><?=getLanguage('phan-quen');?></th>
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
					<?php for($i=1; $i< 8; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
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
<div id="dialog" title="<?=getLanguage('nhom-quyen');?>"></div>
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	var companyid = '<?=$companyid;?>';
</script>
<script src="<?=url_tmpl();?>js/pages/group.js" type="text/javascript"></script>
<script src="<?=url_tmpl();?>js/pages/right.js" type="text/javascript"></script>
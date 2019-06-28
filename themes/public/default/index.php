<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=url_tmpl();?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=url_tmpl();?>font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=url_tmpl();?>theme/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=url_tmpl();?>theme/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <!--<link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/iCheck/flat/blue.css">-->
  <!-- Morris chart -->
  <!--<link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/morris/morris.css">-->
  <!-- jvectormap -->
  <!--<link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css">-->
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <!---->
  <!-- bootstrap wysihtml5 - text editor -->
  <!--<link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">-->
  <link rel="stylesheet" href="<?=url_tmpl();?>template.css">
  <link href="<?=url_tmpl();?>toast/toastr.min.css" rel="stylesheet" type="text/css"/>
  <link href="<?=url_tmpl();?>scrollTable/scrollTable.css" rel="stylesheet" type="text/css"/>
  <link href="<?=url_tmpl();?>multipleselect/multiple-select.css" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="<?=url_tmpl();?>theme/plugins/select2/select2.css"/>
  <link rel="stylesheet" type="text/css" href="<?=url_tmpl();?>theme/plugins/select2/select2-metronic.css"/>
  
  <!-- jQuery 2.2.3 -->
  <script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script type='text/javascript' src="<?=url_tmpl();?>theme/bootstrap/js/bootstrap.min.js"></script>
  
  <script type='text/javascript' src="<?=url_tmpl();?>js/number.js" ></script>
  <script type='text/javascript' src="<?=url_tmpl();?>js/jquery.json.js" ></script>
  <script type='text/javascript' src="<?=url_tmpl();?>js/colResizable-1.5.min.js" ></script>
 
  <script type='text/javascript' src="<?=url_tmpl();?>toast/toastr.min.js"></script>  
  <script type='text/javascript' src="<?=url_tmpl();?>toast/notifications.js"></script>  

  <script type='text/javascript' src="<?=url_tmpl();?>scrollTable/scrollTable.js" ></script>
  <script type='text/javascript' src="<?=url_tmpl();?>scrollTable/jquery.scrollTo.js" ></script>
  <script type='text/javascript' src="<?=url_tmpl();?>js/moment.min.js"></script>
  <!--<script type='text/javascript' src="<?=url_tmpl();?>js/shortcut.js"></script>
  <script type='text/javascript' src="<?=url_tmpl();?>js/tabControl.js"></script>-->
  <script type="text/javascript" src="<?=url_tmpl();?>theme/plugins/select2/select2.min.js"></script>
  <script type='text/javascript' src="<?=url_tmpl();?>js/main.js" ></script>
  <script type='text/javascript'>
	  var order = '';
	  var index = 'DESC';
	  var mgsError = '<?=getLanguage('loi');?>';
	  var mgs_Msg = '<?=getLanguage('thong-bao');?>';
	  var cfDelete = '<?=getLanguage('xac-nhan-xoa');?>';
	  var cancel = '<?=getLanguage('huy');?>';
	  var deletes = '<?=getLanguage('xoa');?>';
	  var selectAll = '<?=getLanguage('chon-tat-ca');?>';
	  var tmtc = '<?=getLanguage('them-moi-thanh-cong');?>';
	  var tmktc = '<?=getLanguage('them-khong-moi-thanh-cong');?>';
	  var stc = '<?=getLanguage('sua-thanh-cong');?>';
	  var sktc = '<?=getLanguage('sua-khong-thanh-cong');?>';
	  var dldtt = '<?=getLanguage('du-lieu-da-ton-tai');?>';
	  var cldcs = '<?=getLanguage('chon-du-lieu-can-sua');?>';
	  var chon_nhom = '<?=getLanguage('chon-nhom');?>';
	  var chon_cong_ty = '<?=getLanguage('chon-cong-ty');?>';
	  var nhom_quyen_khong_duoc_trong = '<?=getLanguage('nhom-quyen-khong-duoc-trong');?>';
	  
	  var ho_ten_khong_duoc_trong = "<?=getLanguage('ho-ten-khong-duoc-trong')?>";
	  var gioi_tinh_khong_duoc_trong = "<?=getLanguage('gioi-tinh-khong-duoc-trong')?>";
	  var ngay_sinh_khong_duoc_trong = "<?=getLanguage('ngay-sinh-khong-duoc-trong')?>";
	  var noi_sinh_khong_duoc_trong = "<?=getLanguage('noi-sinh-khong-duoc-trong')?>";
	  var chon_tinh_trang_hon_nhan = "<?=getLanguage('chon-hon-nhan')?>";
	  var chon_dan_toc = "<?=getLanguage('chon-dan-toc')?>";
	  var cmnd_khong_duoc_trong = "<?=getLanguage('cmnd-khong-duoc-trong')?>";
	  var ngay_cap_khong_duoc_trong = "<?=getLanguage('ngay-cap-khong-duoc-trong')?>";
	  var noi_cap_khong_duoc_trong = "<?=getLanguage('chon-noi-cap')?>";
	  var chon_trinh_do = "<?=getLanguage('chon-trinh-do-hoc-van')?>";
	  var dia_chi_thuong_tru_khong_duoc_trong = "<?=getLanguage('dia-chi-thuong-tru-khong-duoc-trong')?>";
	  var chon_tinh_thanh_pho = "<?=getLanguage('chon-tinh-thanh-pho')?>";
	  var chon_quan_huyen = "<?=getLanguage('chon-quan-huyen')?>";
	  var dia_chi_tam_tru_khong_duoc_trong = "<?=getLanguage('dia-chi-tam-tru-khong-duoc-trong')?>";
	  var dien_thoai_khong_duoc_trong = "<?=getLanguage('dien-thoai-khong-duoc-trong')?>";
	  var ma_nhan_vien_khong_duoc_trong = "<?=getLanguage('ma-nhan-vien-khong-duoc-trong')?>";
	  var chon_phong_ban = "<?=getLanguage('chon-phong-ban')?>";
	  var chon_chuc_vu = "<?=getLanguage('chon-chuc-vu')?>";
	  var chon_tinh_trang_cong_viec  = "<?=getLanguage('chon-tinh-trang-cong-viec')?>";
	  var chon_ngay_bat_dau = "<?=getLanguage('chon-ngay-bat-dau')?>";
	  var chon_ca_lam_viec = "<?=getLanguage('chon-ca-lam-viec')?>";
	  var ma_nhan_vien_da_ton_tai = "<?=getLanguage('ma-nhan-vien-da-ton-tai')?>";
	  var chon_to_nhom = "<?=getLanguage('chon-to-nhom')?>";
	  var chon_thang = "<?=getLanguage('chon-thang')?>";
	  var chot_cong_thanh_cong = "<?=getLanguage('chot-cong-thanh-cong');?>";
	  var chot_cong_khong_thanh_cong = "<?=getLanguage('chot-cong-khong-thanh-cong');?>";
	  var nhan_vien_khong_duoc_trong = "<?=getLanguage('nhan-vien-khong-duoc-trong')?>";
	  var luong_co_ban_khong_duoc_trong = "<?=getLanguage('luong-co-ban-khong-duoc-trong');?>";
	  
	  var copyFailed = "<?=getLanguage('copy-khong-thanh-cong');?>";
	  var cpb = "<?=getLanguage('chon-phong-ban');?>";
	  var ckl = "<?=getLanguage('chon-ky-luong');?>";
	 
  </script>
  <script type='text/javascript' src="<?=url_tmpl();?>multipleselect/jquery.multiple.select.js" ></script>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
	  <img class="logo-img" src="<?=url_tmpl();?>img/logo.png" />
      <!--<span class="logo-lg"><b>Fuma </b>Shop floor</span>-->
    </a>
	
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
         <?=$this->load->inc('menuright');?>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
		<?=$this->load->inc('menu');?>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
          <?=$content;?>
      </div>
      <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
      <?=$this->load->inc('footer');?>
  </footer>
  <!--<div class="control-sidebar-bg"></div>-->
</div>
<!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script type='text/javascript' src="<?=url_tmpl();?>js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script type='text/javascript'>
  $.widget.bridge('uibutton', $.ui.button);
</script>


<!-- datepicker -->
<script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<!--<script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>-->
<!-- Slimscroll -->
<script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script type='text/javascript' src="<?=url_tmpl();?>theme/dist/js/app.js"></script>
<script>
jQuery(document).ready(function() {    
   $.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
   $.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard =  false;
});
</script>
</body>
</html>

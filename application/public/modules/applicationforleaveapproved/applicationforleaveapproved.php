 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Applicationforleaveapproved extends CI_Controller {
	var $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model','excel_model'));
		$this->login = $this->site->getSession('glogin');
		$this->route = $this->router->class;
    }
    function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
    function _view() {
		$data = new stdClass();
        $login = $this->login;
        if (!isset($login['id'])){
			redirect(base_url());
		}
		$permission = $this->base_model->getPermission($this->login, $this->route);
        if(!isset($permission['view'])) {
            redirect('authorize');
        }
		$data->permission = $permission;
        $data->routes = $this->route; 
        $data->groupid = $login['groupid'];
		$data->departments = $this->base_model->getDepartment('');
		$data->employees = '';

		$todate =  gmdate('Y-m-d', time() + 7 * 3600); 
		$fromdate = date(configs('cfdate'),strtotime(date("Y-m-d", strtotime($todate))." -7 day"));		
		$data->fromdate = $fromdate;
		$data->todate = date(configs('cfdate'),strtotime(date("Y-m-d", strtotime($todate))." +7 day"));		
		$data->datenow = $todate;
		#gegion add log
		$ctrol = getLanguage('nhan-vien-nghi-phep');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
		$data->login = $login;
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$approved = $this->input->post('approved');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hre_applicationforleave']);
		}
		$employeeid = $find->employeeid;
		$items = $this->model->table($tb['hre_employee'])->select('id,code,fullname')
								 ->where('id',$employeeid)
								 ->find();
		$data = new stdClass();
        $result = new stdClass();
		$find->code = $login['username'];
		$find->fullname =  $login['fullname'];
		$data->finds = $find;  
		$data->items = $items;  
		$data->approved = $approved;  
		if(!empty($items->id)){
			$data->code = $items->code;  
			$data->fullname = $items->fullname;  
		}
		else{
			$data->code ='';  
			$data->fullname = '';  
		}
		$result->title = getLanguage('duyet-nghi-phep');
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->branchid = $login['branchid'];
		$data->login = $login;
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
    function getList() {
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            //redirect('authorize');
        }
        $rows = 20; //$this->site->config['row'];
        $page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
        $start = empty($page) ? 1 : $page + 1;
		$searchs = json_decode($this->input->post('search'), true);
		$index = $this->input->post('index');
        $order = $this->input->post('order');
		if(!empty($order)) {
            $order = str_replace('ord_', '', $order);
        }
		$searchs['index'] = $index;
        $searchs['order'] = $order;
	    
        $data = new stdClass();
        $result = new stdClass();
        $query = $this->model->getList($searchs, $page, $rows);
        $count = $this->model->getTotal($searchs);
        $data->datas = $query;
        $data->start = $start;
        $data->permission = $this->base_model->getPermission($this->login, $this->route);
        $page_view = $this->site->pagination($count, $rows, 5, $this->route, $page);
		if($count <= $rows){
			$page_view = '';
		}
		
        $result->paging = $page_view;
        $result->csrfHash = $this->security->get_csrf_hash();
        $result->viewtotal = $count;
        $result->content = $this->load->view('list', $data, true);
        echo json_encode($result);
    }
	function export(){
		$search = '{}';
		if(isset($_GET['search'])){
			$search = $_GET['search'];
		}
		$searchs = json_decode($search,true);
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
		
		$versionExcel = 'Excel2007';
		$objPHPExcel = new PHPExcel();
		$sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
		$sheetIndex->setTitle('nha vien di lam');
		
		$sheetIndex->setCellValueByColumnAndRow(0, 1, getLanguage('stt'));
		$sheetIndex->setCellValueByColumnAndRow(1, 1, getLanguage('ma-nhan-vien'));
		$sheetIndex->setCellValueByColumnAndRow(2, 1, getLanguage('ho-ten'));
		$sheetIndex->setCellValueByColumnAndRow(3, 1, getLanguage('thoi-bat-dau'));
		$sheetIndex->setCellValueByColumnAndRow(4, 1, getLanguage('den-ngay'));
		$sheetIndex->setCellValueByColumnAndRow(5, 1, getLanguage('phong-ban'));
		$sheetIndex->setCellValueByColumnAndRow(6, 1, getLanguage('chu-vu'));
		$sheetIndex->setCellValueByColumnAndRow(7, 1, getLanguage('to-nhom'));
		$query = $this->model->getList($searchs, 0, 0);

		$i=2;
		foreach($query as $item){
			
			
			$sheetIndex->setCellValueByColumnAndRow(0, $i, ($i-1));
			$sheetIndex->setCellValueByColumnAndRow(1, $i, $item->code);
			$sheetIndex->setCellValueByColumnAndRow(2, $i, $item->fullname);
			$sheetIndex->setCellValueByColumnAndRow(3, $i, date(configs('cfdate').' H:i:s',strtotime($item->time_start)));
			$sheetIndex->setCellValueByColumnAndRow(4, $i, date(configs('cfdate').' H:i:s',strtotime($item->time_end)));
			$sheetIndex->setCellValueByColumnAndRow(5, $i, $item->departmanet_name);
			$sheetIndex->setCellValueByColumnAndRow(6, $i, $item->position_name);
			$sheetIndex->setCellValueByColumnAndRow(7, $i, $item->departmentgroup_name);

			$i++;
		}
		$today = gmdate("ymdHis", time() + 7 * 3600);;
        $name = "NV_Dilam_".$today.".xlsx";
        $boderthin = "A1:H" .($i-1);
        $sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, $name);
	}
	function save() {
        $token = $this->security->get_csrf_hash();
		$login = $this->login;
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
		if(empty($login['id'])){
			$result['status'] = -10;
            $result['msg'] = getLanguage('khong-co-quyen');
            echo json_encode($result);
            exit;
		}
        if (!isset($permission['add'])) {
            $result['status'] = 0;
            $result['msg'] = getLanguage('khong-co-quyen-them');
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['usercreate'] = $login['userlogin'];
		
        $status = $this->model->saves($array,$id);
		#region logfile
		$ctrol = getLanguage('nhan-vien-nghi-phep');
		$func =  getLanguage('cham-nghi-phep').': '.$array['code'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
		$result['status'] = $status;
		if($status == -1){
			 $result['msg'] = getLanguage('du-lieu-da-ton-tai');
		}
		elseif($status == -2){
			 $result['msg'] = getLanguage('nhan-vien-khong-ton-tai');
		}
		elseif($status == -3){
			 $result['msg'] = getLanguage('ngay-khong-hop-le');
		}
		elseif($status == 1){
			 $result['msg'] = getLanguage('them-moi-thanh-cong');
		}
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }
	function edit() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
		if(empty($login['id'])){
			$result['status'] = -10;
            $result['msg'] = getLanguage('khong-co-quyen');
            echo json_encode($result);
            exit;
		}
        if (!isset($permission['edit'])) {
            $result['status'] = 0;
            $result['msg'] = getLanguage('khong-co-quyen-sua');
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
		$findID = $this->model->findID($id);
        $result['status'] = $this->model->edits($array,$id);
		$findIDEnd = $this->model->findID($id);
		#region logfile
		$ctrol = getLanguage('cham-nghi-phep');
		$func =  getLanguage('sua').': '.$array['code'];
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),json_encode($findIDEnd));	
		#end
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }
	function saveApproved(){
		$token = $this->security->get_csrf_hash();
		$login = $this->login;
        $permission = $this->base_model->getPermission($login, $this->route);
		$tb = $this->base_model->loadTable();
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
		$result = array();
		if(empty($login['id'])){
			$result['status'] = -10;
            $result['msg'] = getLanguage('khong-co-quyen');
            echo json_encode($result);
            exit;
		}
        if (!isset($permission['approved'])) {
            $result['status'] = 0;
            $result['msg'] = getLanguage('khong-co-quyen-duyet');
            echo json_encode($result);
            exit;
        }
		$this->db->trans_start();
        $array = json_decode($this->input->post('search'), true);
        $login = $this->login;
		$update = array();
        $update['approved_date'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $update['approved_userid'] = $login['id'];
		$update['approved'] = $array['approved'];
		$update['approved_description'] = $array['approved_description'];
		$date_time_start = fmDateSave($array['time_start']);
		
		#cham vào bang nghi-phep
		if($array['approved'] == 1){//Nếu cho nghỉ phép chấm vào bảng nghỉ phép
			$items = $this->model->table($tb['hre_employee'])
							 ->select('id,sex,departmentid,branchid,contrac_date,shiftid,bonus_holiday')
							 ->where('code', $array['code'])
							 ->where('isdelete',0)
							 ->find();
			$arrInsert = array();
			
			$arrInsert['employeeid'] = $items->id;
			$arrInsert['departmentid'] =  $items->departmentid;
			$arrInsert['branchid'] =  $items->branchid;
			$arrInsert['time_start'] = fmDateTimeSave($array['time_start']); 
			$arrInsert['time_end'] = fmDateTimeSave($array['time_end']);  
			$arrInsert['datecheck'] = fmDateSave($array['time_start']);
			$arrInsert['statusid'] = 1; 
			$arrInsert['holidays_count_date'] = $array['date_count'];
			//$arrInsert['rest_day'] = $rest_day;
			$checkExit =  $this->model->table($tb['hre_empleaveshow'])
							   ->select('id')
							   ->where('employeeid',$items->id)
							   ->where('time_start',fmDateTimeSave($array['time_start']))
							   ->where('time_end',fmDateTimeSave($array['time_end']))
							   ->find();
			if(empty($checkExit->id)){
				$arrInsert['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				$arrInsert['usercreate'] = $login['userlogin'];
				$empleaveshowid = $this->model->table($tb['hre_empleaveshow'])->save('',$arrInsert);
			}
			else{
				$empleaveshowid = $checkExit->id;
				$arrInsert['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
				$arrInsert['userupdate'] = $login['userlogin'];
				$this->model->table($tb['hre_empleaveshow'])->where('id',$empleaveshowid)->update($arrInsert);
			}
			#region Chi tiết ngày nghỉ để lư vào bảng chi tiết ngày nghỉ
			$listDate =  $this->base_model->getListDay(fmDateTimeSave($array['time_start']),fmDateTimeSave($array['time_end']));
			//Lấy ca làm việc
			$sqlShift = "
				SELECT e.shiftid, s.time_star, s.time_end_am, s.time_star_pm, s.time_end, s.hours_1, s.hours_2, s.between_shift
					FROM `".$tb['hre_employee']."` e
					left join `".$tb['hre_shift']."`  s on e.shiftid = s.id
					where e.id = '".$items->id ."'
					;
			";
			$queryShift = $this->model->query($sqlShift)->execute();
			#region tính số ngày nghỉ
			$time_star = $queryShift[0]->time_star; //Đầu giờ sáng
			$time_end_am = $queryShift[0]->time_end_am; //Cuối buổi sáng
			$time_star_pm = $queryShift[0]->time_star_pm; //Đầu giờ chiếu
			$time_end = $queryShift[0]->time_end; //Cuối ngày
			$between_shift = $queryShift[0]->between_shift; //Giua ca
			
			$time_off_start = fmDateTimeSave($array['time_start']); //Bắt đầu nghỉ
			$time_off_end = fmDateTimeSave($array['time_end']); //Kết thúc ngày nghỉ
			$tongthoigianlamviec = $queryShift[0]->hours_1 + $queryShift[0]->hours_2; 
			$songaynghi = 0;
			 $this->model->table($tb['hre_empleaveshow_detail'])->where('empleaveshowid',$empleaveshowid)->delete();
			if(count($listDate) == 1){//nếu nghỉ 1 ngày
				$insertDetail = array();
				$insertDetail['empleaveshowid'] = $empleaveshowid; 
				$insertDetail['employeeid'] = $items->id;
				$insertDetail['datecheck'] = date('Y-m-d',strtotime($time_off_start));
				$insertDetail['time_start'] = $time_off_start;
				$insertDetail['time_end'] = $time_off_end;
				$insertDetail['departmentid'] = $items->departmentid;
				$insertDetail['branchid'] = $items->branchid;
				$insertDetail['statusid'] = 1;
				$this->model->table($tb['hre_empleaveshow_detail'])->insert($insertDetail);
			}
			else{//Nghỉ nhiều hơn 1 ngày
				$i = 1; $j = count($listDate);
				$songaynghi = 0;
				foreach($listDate as $key => $val){
					if($i==1){
						$ngaydautine_end = fmDateSave($time_off_start).' '.$time_end;
						$insertDetail = array();
						$insertDetail['empleaveshowid'] = $empleaveshowid; 
						$insertDetail['employeeid'] = $items->id;
						$insertDetail['datecheck'] = date('Y-m-d',strtotime($ngaydautine_end));
						$insertDetail['time_start'] = $time_off_start;
						$insertDetail['time_end'] = $ngaydautine_end;
						$insertDetail['departmentid'] = $items->departmentid;
						$insertDetail['branchid'] = $items->branchid;
						$insertDetail['statusid'] = 1;
						$this->model->table($tb['hre_empleaveshow_detail'])->insert($insertDetail);
					}
					elseif($i==$j){//Ngày cuối cùng
						$ngaycuoicung_start = fmDateSave($time_off_end).' '.$time_star;
						$insertDetail = array();
						$insertDetail['empleaveshowid'] = $empleaveshowid; 
						$insertDetail['employeeid'] = $items->id;
						$insertDetail['datecheck'] = date('Y-m-d',strtotime($ngaycuoicung_start));
						$insertDetail['time_start'] = $ngaycuoicung_start;
						$insertDetail['time_end'] = $time_off_end;
						$insertDetail['departmentid'] = $items->departmentid;
						$insertDetail['branchid'] = $items->branchid;
						$insertDetail['statusid'] = 1;
						$this->model->table($tb['hre_empleaveshow_detail'])->insert($insertDetail);
					}
					else{
						$time_start_s =  fmDateSave($val).' '.$time_star.':00';
						$time_end_s =  fmDateSave($val).' '.$time_end.':00';
						$insertDetail = array();
						$insertDetail['empleaveshowid'] = $empleaveshowid; 
						$insertDetail['employeeid'] = $items->id;
						$insertDetail['datecheck'] = date('Y-m-d',strtotime($time_start_s));
						$insertDetail['time_start'] = $time_start_s;
						$insertDetail['time_end'] = $time_end_s;
						$insertDetail['departmentid'] = $items->departmentid;
						$insertDetail['branchid'] = $items->branchid;
						$insertDetail['statusid'] = 1;
						$this->model->table($tb['hre_empleaveshow_detail'])->insert($insertDetail);
					}
					$i++;
				}
			}
			#end
		}
		//$update['rest_day'] = $rest_day; 
		$this->model->table($tb['hre_applicationforleave'])
							   ->where('id',$id)
							   ->update($update);
		#end
		#region logfile
		$ctrol = getLanguage('duyet-nghi-phep');
		$func =  getLanguage('sua').': '.$array['code'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$result['status'] = 0;
			$result['msg'] = getLanguage('duyet-khong-thanh-cong');
			echo json_encode($result);
		}
		else{
			$result['status'] = 1;
			$result['msg'] = getLanguage('duyet-thanh-cong');
			echo json_encode($result);
		}
		
	}
    function deletes() {
        $token = $this->security->get_csrf_hash();
        $id = $this->input->post('id');
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['delete'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
		
        $login = $this->login;
        $this->model->table('hre_applicationforleave')->where("id in ($id)")->where('approved',-1)->delete();
        $result['status'] = 1;
        $result['csrfHash'] = $token;
		#region logfile
		$ctrol = getLanguage('xoa-nghi-phep');
		$func =  getLanguage('xoa');
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
        echo json_encode($result);
    }
}
 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Payroll extends CI_Controller {
	public $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model','excel_model'));
        $this->phonedetail = 'hre_processdetail';
		$this->login = $this->site->getSession('glogin');
		$this->route = $this->router->class;
		$this->load->library('upload');
    }
    function _remap($method, $params = array()) {
        $id = $this->uri->segment(2);
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
		//$data->employees = $this->model->getEmployee(); timeSheet
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->allowances = $this->model->getAllowance();
		$data->endoffmonths = $this->model->getEndoffmonth();
		#gegion add log
		$data->datenow = gmdate(configs('cfdate'), time() + 7 * 3600);
		$ctrol = getLanguage('bang-tinh-luong');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hre_salary']);
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		if(empty($id)){
			$result->title = getLanguage('them-moi');
		}
		else{
			$result->title = getLanguage('sua');
		}
		$data->dates = gmdate("d/m/Y", time() + 7 * 3600);
		$data->employees = $this->model->getEmployee($login['departmentid']);
		$data->endoffmonths = $this->model->getEndoffmonth();
		$data->allowances = $this->model->getAllowance();
		$data->branchid = $login['branchid'];
		$allowanceSalarys = $this->model->getAllowanceSalary($find->endoffmonthid);
		$arrays = array();
		foreach($allowanceSalarys as $item){
			$arrays[$item->employeeid][$item->allowanceid] = $item;
		}
		$data->routes = $this->route; 
		$data->allowanceSalarys = $arrays; 
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function formPayroll(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hre_salary']);
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		$data->endoffmonths = $this->model->getEndoffmonth();
		$data->routes = $this->route; 
        $result->content = $this->load->view('formpayroll', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function copyForm(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hre_salary']);
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		$data->endoffmonths = $this->model->getEndoffmonth();
		$data->routes = $this->route; 
        $result->content = $this->load->view('formcopy', $data, true);
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
		$data->allowances = $this->model->getAllowance();
		$allowanceSalarys = $this->model->getAllowanceSalary($searchs['endoffmonthid']);
		$arrays = array();
		foreach($allowanceSalarys as $item){
			$arrays[$item->employeeid][$item->allowanceid] = $item->salary;
		}
		$data->ngaycong = $this->model->getTimesheetsMonth($searchs['endoffmonthid']);
		//Public Salary
		$arr_Public = array();
		$publicSalarys = $this->model->getPublicSalary($searchs['endoffmonthid']);
		foreach($publicSalarys as $item){
			$arr_Public[$item->employeeid] = $item->salary_real;
		}
		$data->salaryPublic = $arr_Public;
		$data->allowanceSalarys = $arrays;
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
    function save() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['add'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		$allowance = $this->input->post('allowance');
		
        $login = $this->login;
        $array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['usercreate'] = $login['userlogin'];
        //$array['ipcreate'] = $this->base_model->getMacAddress();
		
        $result['status'] = $this->model->saves($array,$allowance,$id);
		#region logfile
		$ctrol = getLanguage('bang-tinh-luong');
		$func =  getLanguage('them-moi').': '.$array['employeeid'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
		
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
        if (!isset($permission['edit'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		$allowance = $this->input->post('allowance');
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
		$findID = $this->model->findID($id);
        $result['status'] = $this->model->edits($array,$allowance,$id);
		$findIDEnd = $this->model->findID($id);
		#region logfile
		$ctrol = getLanguage('bang-tinh-luong');
		$func =  getLanguage('sua').': '.$array['employeeid'];
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),json_encode($findIDEnd));	
		#end
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }
	function updatepayroll(){
		set_time_limit(30);
		$this->db->trans_start();
		$endoffmonthid = $this->input->post('endoffmonthid');
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		$branchid = $login['branchid'];
		$username = $login['username'];
		$date = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		//Chot cong
		$timesheets = $this->model->table($tb['hre_timesheets_month_total'])
						   ->select('id,employeeid,workday,workday_hours,salary_accept')
					       ->where('branchid',$branchid)
					       ->where('monthid',$endoffmonthid)
					       ->find_all(); 
		$return = new stdClass(); 
		if(count($timesheets) == 0){
			$return->status = 0;
			$return->msg = getLanguage('chua-chot-cong');
			echo json_encode($return); exit;
		}
		$arrTimeSheet = array();
		foreach($timesheets as $item){
			$arrTimeSheet[$item->employeeid] = $item;
		}
		//Kỳ lương
		$kyLuong = $this->model->table($tb['hre_endoffmonth'])
						   ->select('id,date_start,date_end,number_days')
					       ->where('id',$endoffmonthid)
					       ->find();
		if(empty($kyLuong->id)){
			$return->status = 0;
			$return->msg = getLanguage('chua-tao-ky-luong');
			echo json_encode($return); exit;
		}
		$date_start = $kyLuong->date_start;	  
		$date_end = $kyLuong->date_end;		
		$number_days = $kyLuong->number_days;
		#region Xoa du lieu cu - Tien luong
		$this->model->table($tb['hre_salary_public'])->where('endoffmonthid',$endoffmonthid)->delete();
		$this->model->table($tb['hre_salary_insurance'])->where('endoffmonthid',$endoffmonthid)->delete();
		#end
		//Lấy lương cơ bản
		$luongCoBan = $this->model->table($tb['hre_salary'])
						   ->select('employeeid,salary, isinsurance,statusid')
						   ->where('endoffmonthid',$endoffmonthid)
						   ->where('branchid',$branchid)
						   ->where('isdelete',0)
						   ->find_all();
		//Các khoản phụ cấp
		$cacKhoanPhuCap = $this->model->table($tb['hre_salary_allowance'])
						   ->select('id,allowanceid,employeeid,endoffmonthid,salary,typeid,isinsurance,istax')
						   ->where('endoffmonthid',$endoffmonthid)
						   ->where('branchid',$branchid)
						   ->where('salary <>',0)
						   ->where('isdelete',0)
						   ->find_all();
		$arrPhuCap = array(); 
		foreach($cacKhoanPhuCap as $item){
			$arrPhuCap[$item->employeeid][$item->id] = $item;
		}
		//Các khoản đóng bảo hiểm
		$cacKhoanBaoHiem = $this->model->table($tb['hre_insurance'])
						   ->select('insurance_name,company,workers,insurance_type,id')
						   ->where('isdelete',0)
						   ->find_all();
		//Các khoản cộng trong tháng
		$congTrongThang = $this->model->table($tb['hre_salary_othercollect'])
						   ->select('sum(othercollect_money) as othercollect_money, employeeid')
						   ->where('isdelete',0)
						   ->where('othercollect_date >= ',$date_start)
						   ->where('othercollect_date <=',$date_end)
						   ->group_by('employeeid')
						   ->find_all();
		$arrCongTrongThang = array();
		foreach($congTrongThang as $item){
			$arrCongTrongThang[$item->employeeid] = $item->othercollect_money;
		}
		//Các khỏan trừ trong tháng
		$truTrongThang = $this->model->table($tb['hre_salary_otherdebt'])
						   ->select('sum(otherdebt_money) as otherdebt_money, employeeid')
						   ->where('isdelete',0)
						   ->where('otherdebt_date >= ',$date_start)
						   ->where('otherdebt_date <=',$date_end)
						   ->group_by('employeeid')
						   ->find_all();
		$arrTruTrongThang = array();
		foreach($truTrongThang as $item){
			$arrTruTrongThang[$item->employeeid] = $item->otherdebt_money;
		}
		//Tính tổng tiền lương
		foreach($luongCoBan as $item){
			$luong_co_ban = $item->salary;
			$employeeid = $item->employeeid;
			$isinsurance = $item->isinsurance;
			//Các Khoản phu cấp
			$tongTienPhuCap = 0;
			if(isset($arrPhuCap[$employeeid])){
				$arrCacKhoanBaoHiem = array();
				foreach($arrPhuCap[$employeeid] as $items){
					$tienPhuCap = $items->salary;
					$tongTienPhuCap+= $tienPhuCap;
					/*if($items->isinsurance == 1){ //Có tính bảo hiểm
						foreach($cacKhoanBaoHiem as $item2){
							$company = $item2->company;
							$workers = $item2->workers;
							$t_company = ($tienLuongSauKhiCong * $company)/ 100;
							$t_workers = ($tienLuongSauKhiCong * $workers)/ 100;
							//Người lao động đóng
							if(isset($arrCacKhoanBaoHiem[$item2->id]['t_workers'])){
								$arrCacKhoanBaoHiem[$item2->id]['t_workers'] += $t_workers;
							}
							else{
								$arrCacKhoanBaoHiem[$item2->id]['t_workers'] = $t_workers;
							}
							//Công ty đóng
							if(isset($arrCacKhoanBaoHiem[$item2->id]['t_company'])){
								$arrCacKhoanBaoHiem[$item2->id]['t_company'] += $t_company;
							}
							else{
								$arrCacKhoanBaoHiem[$item2->id]['t_company'] = $t_company;
							}
						}
					}*/
				}
			} 
			//Ngay cong
			$salary_accept = 1;
			$ngayCongNhanVien = 0;
			if(isset($arrTimeSheet[$employeeid])){
				$itemWorkdat = $arrTimeSheet[$employeeid];
				if($itemWorkdat->salary_accept == 1){//Lãnh lương theo tháng
					$ngayCongNhanVien = $itemWorkdat->workday;
				}else{//Lãnh lương theo giờ
					$salary_accept = 2;
					$ngayCongNhanVien = $itemWorkdat->workday_hours; //Giờ công nhân viên
				}
			}
			
			//Tổng tiền lương
			if(empty($ngayCongNhanVien)){
				$tongTienLuong = 0;
			}
			else{
				//Lãnh lương theo tháng
				$tongTienLuong = ($tongTienPhuCap + $luong_co_ban);
				if($salary_accept == 1){
					if($number_days > $ngayCongNhanVien){//Làm thiếu công
						$tienLuongMotNgay = $tongTienLuong/$number_days;
						$tongTienLuong = round($tienLuongMotNgay * $ngayCongNhanVien);
					}
				}else{	
					$tongTienLuong = $tongTienLuong * $ngayCongNhanVien;
				}
			}
			
			//Các khoản cộng trong tháng
			$tienCongTrongThang = 0;
			if(isset($arrCongTrongThang[$employeeid])){
				$tienCongTrongThang = $arrCongTrongThang[$employeeid];
			}
			//Tiền lương sau khi cộng
			$tienLuongSauKhiCong = $tongTienLuong + $tienCongTrongThang;
			//
			//Tính các khoản bảo hiểm kinh phí công đoàn
			$tt_workers = 0;
			if($isinsurance == 1){
				foreach($cacKhoanBaoHiem as $item2){
					$company = $item2->company;
					$workers = $item2->workers;
					$t_company = ($tienLuongSauKhiCong * $company)/ 100;
					$t_workers = ($tienLuongSauKhiCong * $workers)/ 100;
					$tt_workers+= $t_workers;
					//Inser Bao bien cong doang
					$insertLuongBaoHiem = array();
					$insertLuongBaoHiem['endoffmonthid'] = $endoffmonthid;
					$insertLuongBaoHiem['employeeid'] = $item->employeeid;
					$insertLuongBaoHiem['branchid'] = $branchid;
					$insertLuongBaoHiem['company'] = round($t_company);
					$insertLuongBaoHiem['worker'] = round($t_workers);
					$insertLuongBaoHiem['insuranceid'] = $item2->id;
					$insertLuongBaoHiem['datecreate'] = $date;
					$insertLuongBaoHiem['usercreate'] = $username;
					$this->model->table($tb['hre_salary_insurance'])->insert($insertLuongBaoHiem);
				}
			}
			$insertLuong = array();
			$insertLuong['endoffmonthid'] = $endoffmonthid;
			$insertLuong['employeeid'] = $item->employeeid;
			$insertLuong['branchid'] = $branchid;
			$insertLuong['salary'] = $tienLuongSauKhiCong;
			$insertLuong['salary_real'] = $tienLuongSauKhiCong - round($tt_workers);
			$insertLuong['datecreate'] = $date;
			$insertLuong['usercreate'] = $username;
			$this->model->table($tb['hre_salary_public'])->insert($insertLuong);
			
		}	
		$this->db->trans_complete(); 
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$return->status = 0;
			$return->msg = getLanguage('chot-luong-khong-thanh-cong');
			echo json_encode($return); exit;
		} 
		else {
			$this->db->trans_commit();
			$return->status = 1;
			$return->msg = getLanguage('chot-luong-thanh-cong');
			echo json_encode($return); exit;
		}	
	}
	function copySalary(){
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		$branchid = $login['branchid'];
		$frommonth = $this->input->post('frommonth');
		$tomonth = $this->input->post('tomonth');
		$date = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		
		$luongCoBan = $this->model->table($tb['hre_salary'])
						   ->select('employeeid,salary, isinsurance')
						   ->where('endoffmonthid',$frommonth)
						   ->where('branchid',$branchid)
						   ->where('isdelete',0)
						   ->find_all();
		$cacKhoanPhuCap = $this->model->table($tb['hre_salary_allowance'])
						   ->select('allowanceid,employeeid,endoffmonthid,salary,typeid,isinsurance,istax')
						   ->where('endoffmonthid',$frommonth)
						   ->where('branchid',$branchid)
						   ->where('isdelete',0)
						   ->find_all();
		
		$this->model->table($tb['hre_salary'])->where('endoffmonthid',$tomonth)->delete();
		$this->model->table($tb['hre_salary_allowance'])->where('endoffmonthid',$tomonth)->delete();
		$return = new stdClass();
		if(count($luongCoBan) == 0){
			$return->status = 0;
			$return->msg = '';
			echo json_encode($return); exit;
		}
		foreach($luongCoBan as $item){
			$insert = array();
			$insert['endoffmonthid'] = $tomonth; 
			$insert['employeeid'] = $item->employeeid;
			$insert['branchid'] = $branchid;
			$insert['salary'] = $item->salary;
			$insert['isinsurance'] = $item->isinsurance;
			$insert['datecreate'] = $date;
			$insert['usercreate'] = $login['username'];
			$this->model->table($tb['hre_salary'])->insert($insert);
		}
		foreach($cacKhoanPhuCap as $item){
			$insert = array();
			$insert['allowanceid'] = $item->allowanceid;
			$insert['endoffmonthid'] = $tomonth; 
			$insert['employeeid'] = $item->employeeid;
			$insert['branchid'] = $branchid;
			$insert['salary'] = $item->salary;
			$insert['isinsurance'] = $item->isinsurance;
			$insert['typeid'] = $item->typeid;
			$insert['istax'] = $item->istax;
			$insert['datecreate'] = $date;
			$insert['usercreate'] = $login['username'];
			$this->model->table($tb['hre_salary_allowance'])->insert($insert);
		}
		$return->status = 1;
		$return->msg = getLanguage('copy-thanh-cong');;
		echo json_encode($return); exit;
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
		$findID = $this->model->findID($id);
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
        $array['isdelete'] = 1;
        $this->model->deletes($id,$findID);
        $result['status'] = 1;
        $result['csrfHash'] = $token;
		#region logfile
		$ctrol = getLanguage('bang-tinh-luong');
		$func =  getLanguage('xoa').': '.$findID->employeeid;
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),'');	
		#end
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
		$sheetIndex->setTitle('danh sach nhan vien');
		
		$sheetIndex->setCellValueByColumnAndRow(0, 1, getLanguage('stt'));
		$sheetIndex->setCellValueByColumnAndRow(1, 1, getLanguage('phong-ban'));
		$sheetIndex->setCellValueByColumnAndRow(2, 1, getLanguage('ma-nhan-vien'));
		$sheetIndex->setCellValueByColumnAndRow(3, 1, getLanguage('ho-ten'));
		$sheetIndex->setCellValueByColumnAndRow(4, 1, getLanguage('so-tien'));
		$sheetIndex->setCellValueByColumnAndRow(5, 1, getLanguage('ngay-bang-tinh-luong'));
		$sheetIndex->setCellValueByColumnAndRow(6, 1, getLanguage('ghi-chu'));
		
		$query = $this->model->getList($searchs, 0, 0);
		$i=2;
		foreach($query as $item){
			$sheetIndex->setCellValueByColumnAndRow(0, $i, ($i-1));
			$sheetIndex->setCellValueByColumnAndRow(1, $i, $item->departmanet_name);
			$sheetIndex->setCellValueByColumnAndRow(2, $i, $item->code);
			$sheetIndex->setCellValueByColumnAndRow(3, $i, $item->fullname);
			$sheetIndex->setCellValueByColumnAndRow(4, $i, $item->salaryadvance_money);
			$sheetIndex->setCellValueByColumnAndRow(5, $i, date(configs('cfdate'),strtotime($item->salaryadvance_date)));
			$sheetIndex->setCellValueByColumnAndRow(6, $i, $item->employeeid);
			$i++;
		}
		$today = gmdate("ymdHis", time() + 7 * 3600);;
        $name = "Tamung_".$today.".xlsx";
        $boderthin = "A1:G" .($i-1);
        $sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, $name);
	}
}
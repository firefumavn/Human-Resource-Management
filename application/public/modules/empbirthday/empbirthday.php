﻿ <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Empbirthday extends CI_Controller {
    var $phonedetail;
	var $login;
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
        
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->positions = $this->base_model->getPosition('');
		$data->jobstatus = $this->base_model->getJobStatus('');
		$data->month = $this->base_model->getMonth('');
		
		$montNow = gmdate("m", time() + 7 * 3600);
		$data->montNow = (int)$montNow;		
		#gegion add log
		$ctrol = getLanguage('sinh-nhat');
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
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hre_ethnic');
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
		$data->branchid = $login['branchid'];
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
		$sheetIndex->setTitle('receiving');
		
		$sheetIndex->setCellValueByColumnAndRow(0, 1, getLanguage('stt'));
		$sheetIndex->setCellValueByColumnAndRow(1, 1, getLanguage('ho-ten'));
		$sheetIndex->setCellValueByColumnAndRow(2, 1, getLanguage('ma-nhan-vien'));
		$sheetIndex->setCellValueByColumnAndRow(3, 1, getLanguage('gioi-tinh'));
		$sheetIndex->setCellValueByColumnAndRow(4, 1, getLanguage('dien-thoai'));
		$sheetIndex->setCellValueByColumnAndRow(5, 1, getLanguage('ngay-sinh'));
		$sheetIndex->setCellValueByColumnAndRow(6, 1, getLanguage('sinh-nhat'));
		$sheetIndex->setCellValueByColumnAndRow(7, 1, getLanguage('phong-ban'));
		$sheetIndex->setCellValueByColumnAndRow(8, 1, getLanguage('chu-vu'));

		$query = $this->model->getList($searchs, 0, 0, true);
		$i=2;
		foreach($query as $item){
			if($item->sex == 1){
				$sex = 'Nam';
			}
			else if($item->sex == 2){
				$sex = 'Nữ';
			}
			else if($item->sex == -1){
				$sex = 'Giới tính khác';
			}
			else{
				$sex = '';
			}
			$birthday = (int)date('d',strtotime($item->birthday));
			$timenow = (int)gmdate("d", time() + 7 * 3600);
			if($timenow > $birthday){
				$sn = 'Đã qua '.($timenow - $birthday).' ngày';
			}
			else if($timenow == $birthday){
				$sn = 'Hôm nay';
			}
			else{
				$sn = 'Còn '.($birthday - $timenow).' ngày';
			}
			$sheetIndex->setCellValueByColumnAndRow(0, $i, $i - 1);
			$sheetIndex->setCellValueByColumnAndRow(1, $i, $item->fullname);
			$sheetIndex->setCellValueByColumnAndRow(2, $i, $item->code);
			$sheetIndex->setCellValueByColumnAndRow(3, $i, $sex);
			$sheetIndex->setCellValueByColumnAndRow(4, $i, $item->phone);
			$sheetIndex->setCellValueByColumnAndRow(5, $i, date(configs('cfdate'),strtotime($item->birthday)));
			$sheetIndex->setCellValueByColumnAndRow(6, $i, $sn);
			$sheetIndex->setCellValueByColumnAndRow(7, $i, $item->departmanet_name);
			$sheetIndex->setCellValueByColumnAndRow(8, $i, $item->position_name);
			$i++;
		}
		$today = gmdate("ymdHis", time() + 7 * 3600);;
        $name = "Birthday_".$today.".xlsx";
        $boderthin = "A1:I" .($i-1);
        $sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, $name);
	}
}
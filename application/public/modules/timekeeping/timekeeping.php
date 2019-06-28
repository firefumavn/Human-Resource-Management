 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Timekeeping extends CI_Controller {
    var $phonedetail;
	var $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model'));
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
        $data->groupid = $login['groupid'];
		#gegion add log
		$ctrol = getLanguage('phong-ban');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
		$data->montNow = $year = gmdate("m/Y", time() + 7 * 3600);
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->months = $this->model->getMonth();
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hre_department');
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
	function getList(){
		$rows = 20; //$this->site->config['row'];
		$page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
		$start = empty($page) ? 1 : $page+1;
		$searchs = json_decode($this->input->post('search'),true);
		$searchs['order'] = substr($this->input->post('order'),4);
		$searchs['index'] = $this->input->post('index');
		$data = new stdClass();
		$result = new stdClass();
		$datas = $this->model->getList($searchs,$page,$rows);
		$count = $this->model->getTotal($searchs);
		$data->datas = $datas;
		$data->start = $start;
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		$searchmonth = $searchs['month'];
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$findMonth = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear,date_start,date_end')
					  ->where('id',$searchmonth)
					  ->find();
		$fromdate = $findMonth->date_start;
		$todate = $findMonth->date_end;
		//Nay cong nhan vien
		$ngaycong = $this->model->table($tb['hre_timesheets_month_total'])
						 ->select('employeeid,workday,workday_hours,salary_accept')
						 ->where('monthid',$searchmonth)
						 ->where('branchid',$login['branchid'])
						 ->find_all();
		$arrNgaycong = array();
		foreach($ngaycong as $item){
			$arrNgaycong[$item->employeeid] = $item;
		}
		$data->ngaycong = $arrNgaycong;
		
		$arrayDate = array(); 
		$arrayDateList = array(); 
		for($i=0;$i<32;$i++){
			$dateNext = date("Y-m-d", strtotime("$fromdate + $i day"));
			$arrayDate[$i] = $dateNext;
			$arrayDateList[$i] = "'".$dateNext."'";
			if($todate == $dateNext){
				break;
			}
		}
		$listDate = implode(',',$arrayDateList);
		//List employee
		$arrEmployee = array(); 
		$arrEmployeeList = array(); 
		foreach($datas as $item){
			$arrEmployee[$item->id]['time_start'] = $item->time_star;
			$arrEmployee[$item->id]['time_end'] = $item->time_end;
			$arrEmployeeList[] = $item->id;
		}
		$listEmployeeID = implode(',',$arrEmployeeList);
		$getCheckIN = $this->model->getCheckIN($listDate,$listEmployeeID,$arrEmployee);
		//Check Vân tay
		$data->timesheets = $this->model->geTimesheets($fromdate,$todate);
		//Nghỉ phép
		$data->nghiphep = $this->model->getNghiPhep($fromdate,$todate);
		//Đi công tác
		$data->dicongtac = $this->model->getDiCongTac($fromdate,$todate);
		//Nghi thai san
		$data->nghithaisan = $this->model->getNghiThaiSan($fromdate,$todate);
		
		$arr_thu = array();
		$arr_thu['monday'] = getLanguage('monday');
		$arr_thu['tuesday'] = getLanguage('tuesday');
		$arr_thu['wednesday'] = getLanguage('wednesday');
		$arr_thu['thursday'] = getLanguage('thursday');
		$arr_thu['friday'] = getLanguage('friday');
		$arr_thu['saturday'] = getLanguage('saturday');
		$arr_thu['sunday'] = getLanguage('sunday');
		
		$data->arr_thu = $arr_thu;
		$data->arrayDate = $arrayDate;
		$page_view=$this->site->pagination($count,$rows,5,$this->route,$page);
		$result->paging = $page_view;
		$result->csrfHash = $this->security->get_csrf_hash();
		$result->viewtotal = number_format($count); 
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function workday(){
		$tb = $this->base_model->loadTable();
		$month = $this->input->post('month');
		$login = $this->login;
		$branchid  = $login['branchid'];
		$datecreate =  gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		//Danh sach bang cham cong
		$findMonth = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear,date_start,date_end,number_days')
					  ->where('id',$month)
					  ->find();
		$fromdate = $findMonth->date_start;
		$todate = $findMonth->date_end;
		//Danh sac ngay cong
		$sqltimeset = "
			SELECT ts.time_start, ts.time_end, s.id, s.time_star as shift_time_star, s.time_end as shift_time_end, s.time_end_am, s.time_star_pm, s.between_shift,
			s.hours_1, s.hours_2,  e.branchid, e.departmentid, e.salary_accept , ts.employeeid
			FROM `".$tb['hre_timesheets']."` ts
			left join `".$tb['hre_shift']."` s on s.id = ts.shiftid
			left join `".$tb['hre_employee']."` e on e.id = ts.employeeid
			where ts.isdelete = 0
			and ts.branchid = '$branchid'
			and ts.time_start >= '".$fromdate." 00:00:00'
			and ts.time_start <= '".$todate." 23:59:59'
			and ts.time_end >= '".$fromdate." 00:00:00'
			and ts.time_end <= '".$todate." 23:59:59'
			and ts.time_end is not null
			;
		";
		$query = $this->model->query($sqltimeset)->execute();
		$number_days = $findMonth->number_days;
		$arrayTimeSheet = array();
		foreach($query as $item){
			#region Thời gian bắt 
			$time_start = $item->time_start;
			$s_ngaytheoca = date('Y-m-d',strtotime($time_start)).' '.$item->shift_time_star;
			if(strtotime($time_start) < strtotime($s_ngaytheoca)){//Chấm vân tay lúc vào trước giờ làm
				$time_start = $s_ngaytheoca;
			}
			#end
			#region Cuối giờ làm 
			$time_end = $item->time_end;   
			$e_theoca = date('Y-m-d',strtotime($time_end)).' '.$item->shift_time_end;
			if(strtotime($time_end) > strtotime($e_theoca)){//Chấm vân tay lúc ra sau giờ làm
				$time_end = $e_theoca;
			}
			#end
			$dataStart = date('ymd', strtotime($time_start));
			if($item->salary_accept == 2){ //Lãnh lương theo giờ
				$thoigianlamviec = (strtotime($time_end) - strtotime($time_start))/3600;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_date_start'] = $time_start;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_date_end'] = $time_end;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday'] = 0;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_hours'] = $thoigianlamviec;
				$arrayTimeSheet[$item->employeeid][$dataStart]['salary_accept'] = 2;
			}else{
				$between_shift = $item->between_shift; //Nghỉ giữa buổi
				$thoigianlamviecCangay = $item->hours_1 + $item->hours_2; //Thoi gian duoc thiet lap - Tổng 2 buổi 8 tiếng
				$daucacgieu = date('Y-m-d',strtotime($item->time_start)).' '.$item->time_star_pm;
				//Nếu check vân tay vào buổi chiều
				if(strtotime($time_start) > strtotime($daucacgieu)){
					$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
				}
				elseif(strtotime($time_end) <= strtotime($daucacgieu)){//Chỉ làm buổi sáng
					$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
				}
				else{//Làm cả ngày trừ thời gian nghỉ
					$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600)-$between_shift;
				}
				if($thoigianlamviec == $thoigianlamviecCangay){
					$thoigian = 1;
				}
				else{
					$thoigian = round(($thoigianlamviec/$thoigianlamviecCangay),2);
				}
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_date_start'] = $time_start;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_date_end'] = $time_end;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday'] = $thoigian;
				$arrayTimeSheet[$item->employeeid][$dataStart]['workday_hours'] = $thoigianlamviec;
				$arrayTimeSheet[$item->employeeid][$dataStart]['salary_accept'] = 1;
			}
		}
		//Tính nghỉ phép và đi công tac
		$sqlEmpleaveshow = "
			SELECT ts.time_start, ts.time_end, s.id, s.time_star as shift_time_star, s.time_end as shift_time_end, s.time_end_am, s.time_star_pm, s.between_shift,
			s.hours_1, s.hours_2,  e.branchid, e.departmentid, ts.employeeid
			FROM `".$tb['hre_empleaveshow_detail']."` ts
			left join `".$tb['hre_shift']."` s on s.id = ts.shiftid
			left join `".$tb['hre_employee']."` e on e.id = ts.employeeid
			where (ts.statusid = 1 or ts.statusid = 2)
			and ts.branchid = '$branchid'
			and ts.time_start >= '".$fromdate." 00:00:00'
			and ts.time_start <= '".$todate." 23:59:59'
			and ts.time_end >= '".$fromdate." 00:00:00'
			and ts.time_end <= '".$todate." 23:59:59'
			and ts.time_end is not null
			;
		"; 
		$query2 = $this->model->query($sqlEmpleaveshow)->execute();
		$array2 = array(); 
		$arrayTimeSheetOff = array(); 
		foreach($query2 as $item){
			$time_start = $item->time_start;
			$s_ngaytheoca = date('Y-m-d',strtotime($time_start)).' '.$item->shift_time_star;
			if(strtotime($time_start) < strtotime($s_ngaytheoca)){//Chấm vân tay lúc vào trước giờ làm
				$time_start = $s_ngaytheoca;
			}
			$time_end = $item->time_end;   
			$e_theoca = date('Y-m-d',strtotime($time_end)).' '.$item->shift_time_end;
			if(strtotime($time_end) > strtotime($e_theoca)){//Chấm vân tay lúc ra sau giờ làm
				$time_end = $e_theoca;
			}
			$between_shift = $item->between_shift;
			$thoigianlamviecCangay = $item->hours_1 + $item->hours_2; //Thoi gian duoc thiet lap
			
			$daucacgieu = date('Y-m-d',strtotime($item->time_start)).' '.$item->time_star_pm;
			//Nếu check vân tay vào buổi chiều
			if(strtotime($time_start) > strtotime($daucacgieu)){
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
			}
			elseif(strtotime($time_end) <= strtotime($daucacgieu)){//Chỉ làm buổi sáng
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
			}
			else{//Làm cả ngày trừ thời gian nghi
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600)-$between_shift;
			}
			if($thoigianlamviec == $thoigianlamviecCangay){
				$thoigian = 1;
			}
			else{
				$thoigian = round(($thoigianlamviec/$thoigianlamviecCangay),2);
			}
			if($thoigian < 0){
				$thoigian = 0;
			}
			$arrayTimeSheetOff[$item->employeeid] = $thoigian;
		}
		//danh sacnh nhan vien
		$listEmployee = $this->model->table($tb['hre_employee'])
								->select('id,departmentid,branchid')
								->where('branchid',$branchid)
								->find_all(); 
		//Xóa dữ liệu chi tiết
		$this->model->table($tb['hre_timesheets_month'])
			 ->where('monthid',$month)
			 ->where('branchid',$branchid)
			 ->delete();
		//Xóa dữ liệu tổng
		$this->model->table($tb['hre_timesheets_month_total'])
			 ->where('monthid',$month)
			 ->where('branchid',$branchid)
			 ->delete();
		$strSql = '';
		$arrTotal = array();
		foreach($listEmployee as $item){
			//Insert Ngày công
			if(isset($arrayTimeSheet[$item->id])){
				foreach($arrayTimeSheet[$item->id] as $key => $timeSheet){
					$employeeid = $item->id;
					$departmentid = $item->departmentid;
					$strSql.= "('$month', '$branchid', '$departmentid', '$employeeid', '".$timeSheet['workday_date_start']."', '".$timeSheet['workday_date_end']."', '".$timeSheet['workday']."', '".$timeSheet['workday_hours']."', '".$timeSheet['salary_accept']."', '$datecreate', '".$login['userlogin']."'),";
					//Tính tổng
					$arrTotal[$employeeid]['salary_accept'] = $timeSheet['salary_accept'];
					if(isset($arrTotal[$employeeid]['workday'])){
						$arrTotal[$employeeid]['workday'] += $timeSheet['workday'];
						$arrTotal[$employeeid]['workday_hours'] += $timeSheet['workday_hours'];
					}else{
						$arrTotal[$employeeid]['workday'] = $timeSheet['workday'];
						$arrTotal[$employeeid]['workday_hours'] = $timeSheet['workday_hours'];
					}
				}
			}
		}
		if(!empty($strSql)){
			$sqlInsert = "INSERT INTO `".$tb['hre_timesheets_month']."` (`monthid`, `branchid`, `departmentid`, `employeeid`, `workday_date_start`, `workday_date_end`, `workday`, `workday_hours`, `salary_accept`, `datecreate`, `usercreate`) VALUES ".substr($strSql,0,-1);
			$this->model->executeQuery($sqlInsert);
		}
		//Thêm tổng cộng ngày công 
		$strSqlTotal = "";
		foreach($listEmployee as $item){
			if(isset($arrTotal[$item->id])){
				$employeeid = $item->id;
				$departmentid = $item->departmentid;
				$timeSheetTotal = $arrTotal[$item->id];
				$ngayCongNghiPhep = 0;
				if(isset($arrayTimeSheetOff[$employeeid])){
					$ngayCongNghiPhep = $arrayTimeSheetOff[$employeeid];
				}
				$tongNgayCong = $ngayCongNghiPhep + $timeSheetTotal['workday'];
				$strSqlTotal.= "('$month', '$branchid', '$departmentid', '$employeeid', '".$tongNgayCong."', '".$timeSheetTotal['workday_hours']."', '".$timeSheetTotal['salary_accept']."', '$datecreate', '".$login['userlogin']."'),";
			}
		}
		if(!empty($strSqlTotal)){
			$sqlInsertTotal = "INSERT INTO `".$tb['hre_timesheets_month_total']."` (`monthid`, `branchid`, `departmentid`, `employeeid`, `workday`, `workday_hours`, `salary_accept` ,`datecreate`, `usercreate`) VALUES ".substr($strSqlTotal,0,-1);
			$this->model->executeQuery($sqlInsertTotal);
		}
		echo 1;
	}
}
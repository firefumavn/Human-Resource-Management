<?php
/**
 * @author 
 * @copyright 2017
 */
class base_model extends CI_Model {
    function __construct() {
        parent::__construct('');
        $this->load->model();
        $this->route = $this->router->class;
		$this->login = $this->site->getSession('glogin');
    }
	function loadTable(){
		$login = $this->login;
		$companyid = $login['companyid'];
		$arrTable = array();
		$arrTable['hre_absent'] = 'hre_absent_'.$companyid;
		$arrTable['hre_academic_level'] = 'hre_academic_level_'.$companyid;
		$arrTable['hre_action'] = 'hre_action_'.$companyid;
		$arrTable['hre_allowance'] = 'hre_allowance_'.$companyid;
		$arrTable['hre_applicationforleave'] = 'hre_applicationforleave_'.$companyid;
		$arrTable['hre_branch'] = 'hre_branch_'.$companyid;
		$arrTable['hre_coefficient'] = 'hre_coefficient_'.$companyid;
		$arrTable['hre_config'] = 'hre_config_'.$companyid;
		$arrTable['hre_criteriakpi'] = 'hre_criteriakpi_'.$companyid;
		$arrTable['hre_criteriakpi_department'] = 'hre_criteriakpi_department_'.$companyid;
		$arrTable['hre_criteriaprobationary'] = 'hre_criteriaprobationary_'.$companyid;
		$arrTable['hre_department'] = 'hre_department_'.$companyid;
		$arrTable['hre_departmentgroup'] = 'hre_departmentgroup_'.$companyid;
		$arrTable['hre_departmentkpi'] = 'hre_departmentkpi_'.$companyid;
		$arrTable['hre_emp_timmaternityleave'] = 'hre_emp_timmaternityleave_'.$companyid;
		$arrTable['hre_empevaluationprobationary'] = 'hre_empevaluationprobationary_'.$companyid;
		$arrTable['hre_empleaveshow'] = 'hre_empleaveshow_'.$companyid;
		$arrTable['hre_empleaveshow_detail'] = 'hre_empleaveshow_detail_'.$companyid;
		$arrTable['hre_employee'] = 'hre_employee_'.$companyid;
		$arrTable['hre_employee_history'] = 'hre_employee_history_'.$companyid;
		$arrTable['hre_employeekpi'] = 'hre_employeekpi_'.$companyid;
		$arrTable['hre_endoffmonth'] = 'hre_endoffmonth_'.$companyid;
		$arrTable['hre_district'] = 'hre_district_'.$companyid;
		$arrTable['hre_ethnic'] = 'hre_ethnic_'.$companyid;
		$arrTable['hre_family_relation'] = 'hre_family_relation_'.$companyid;
		$arrTable['hre_familyallowances'] = 'hre_familyallowances_'.$companyid;
		$arrTable['hre_holidays'] = 'hre_holidays_'.$companyid;
		$arrTable['hre_holidays_year'] = 'hre_holidays_year_'.$companyid;
		$arrTable['hre_insurance'] = 'hre_insurance_'.$companyid;
		$arrTable['hre_job_status'] = 'hre_job_status_'.$companyid;
		$arrTable['hre_kpiemployee'] = 'hre_kpiemployee_'.$companyid;
		$arrTable['hre_language'] = 'hre_language_'.$companyid;
		$arrTable['hre_log'] = 'hre_log_'.$companyid;
		$arrTable['hre_machine'] = 'hre_machine_'.$companyid;
		$arrTable['hre_machine_fingerprint'] = 'hre_machine_fingerprint_'.$companyid;
		$arrTable['hre_maternityleave'] = 'hre_maternityleave_'.$companyid;
		$arrTable['hre_mission'] = 'hre_mission_'.$companyid;
		$arrTable['hre_salary_othercollect'] = 'hre_salary_othercollect_'.$companyid;
		$arrTable['hre_salary_otherdebt'] = 'hre_salary_otherdebt_'.$companyid;
		$arrTable['hre_overtime_pay'] = 'hre_overtime_pay_'.$companyid;
		$arrTable['hre_position'] = 'hre_position_'.$companyid;
		$arrTable['hre_province'] = 'hre_province_'.$companyid;
		$arrTable['hre_recruitmentrequest'] = 'hre_recruitmentrequest_'.$companyid;
		$arrTable['hre_regovertime'] = 'hre_regovertime_'.$companyid;
		$arrTable['hre_relation_catalog'] = 'hre_relation_catalog_'.$companyid;
		$arrTable['hre_religion'] = 'hre_religion_'.$companyid;
		$arrTable['hre_reward'] = 'hre_reward_'.$companyid;
		$arrTable['hre_salary'] = 'hre_salary_'.$companyid;
		$arrTable['hre_salary_allowance'] = 'hre_salary_allowance_'.$companyid;
		$arrTable['hre_salaryadvance'] = 'hre_salaryadvance_'.$companyid;
		$arrTable['hre_shif'] = 'hre_shif_'.$companyid;
		$arrTable['hre_time_login'] = 'hre_time_login_'.$companyid;
		$arrTable['hre_timemission'] = 'hre_timemission_'.$companyid;
		$arrTable['hre_timemission_other'] = 'hre_timemission_other_'.$companyid;
		$arrTable['hre_timesheets'] = 'hre_timesheets_'.$companyid;
		$arrTable['hre_trainingcourse'] = 'hre_trainingcourse_'.$companyid;
		$arrTable['hre_trainingresults'] = 'hre_trainingresults_'.$companyid;
		$arrTable['hre_type_contrac'] = 'hre_type_contrac_'.$companyid;
		$arrTable['hre_shift'] = 'hre_shift_'.$companyid;
		$arrTable['hre_interviewschedule'] = 'hre_interviewschedule_'.$companyid;
		$arrTable['hre_discipline'] = 'hre_discipline_'.$companyid;
		$arrTable['hre_timesheets_month'] = 'hre_timesheets_month_'.$companyid;
		$arrTable['hre_timesheets_month_total'] = 'hre_timesheets_month_total_'.$companyid;
		
		$arrTable['hre_taxpersonal'] = 'hre_taxpersonal_'.$companyid;
		$arrTable['hre_salary_public'] = 'hre_salary_public_'.$companyid;
		$arrTable['hre_salary_insurance'] = 'hre_salary_insurance_'.$companyid;
		return $arrTable;
	}
	function getListTable($fromdate,$todate){
		$arrMonth = array();
		$start = strtotime(date('Y-m-d', strtotime($fromdate))); 
		$end = strtotime(date('Y-m-d', strtotime($todate)));
		while($start <= $end){
			$d = date('d', $start);
			$m = date('m', $start);
			$y = date('Y', $start);
			
			$yearmonth = $y.'-'.$m.'-'.$d;
			$arrMonth[] = $yearmonth;
			$start = strtotime("+1 day", $start);
		}
		return $arrMonth;
	}
	public function getMacAddress() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $mac = shell_exec("arp -a $ip");
        $arr = explode(" ", $mac);
        if (isset($arr[3])) {
            $macAddress = $arr[3];
        } else {
            $macAddress = $ip;
        }
        if ($macAddress != 'entries') {
            return $ip . ' ' . $macAddress;
        } else {
            return $ip;
        }
    }
	public function getKPIDepartment(){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_criteriakpi_department'])
							 ->select('id,kpi_code,kpi_name,kpi_point_max')
							 ->order_by('kpi_name')
							 ->where('isdelete',0)->find_all();
		return $query;
	}
	public function getCriteriaProbationary(){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_criteriaprobationary'])
							 ->select('id,aprobationary_name')
							 ->order_by('aprobationary_name')
							 ->where('isdelete',0)->find_all();
		return $query;
	}
	function getProvice() {
		$tb = $this->loadTable();
        $query = $this->model->table($tb['hre_province'])
					  ->select('id,province_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
    }
	public function getListDay($fromdate, $todate){
		$arrMonth = array();
		$start = strtotime(date('Y-m-d', strtotime($fromdate)));
		$end = strtotime(date('Y-m-d', strtotime($todate)));
		while($start <= $end){
			$d = date('d', $start);
			$m = date('m', $start);
			$y = date('Y', $start);
			$yearmonth = $y.'-'.$m.'-'.$d;
			$arrMonth[] = $yearmonth;
			$start = strtotime("+1 day", $start);
		}
		return $arrMonth;
	}
	public function getCountHolidays($item){
		$contrac_date = $item->contrac_date;
		$bonus_holiday = $item->bonus_holiday;
		$datecreate = gmdate("Y-m-d", time() + 7 * 3600);
		if(empty($bonus_holiday)){
			$bonus_holiday = 0;
		}
		$holidays = $this->getHolidayYear();
		//Nam ky HD
		$timeYears = 0;
		if(!empty($item->contrac_date) && $item->contrac_date != '1970-01-01' && $item->contrac_date !='0000-00-00'){
			$contrac_date = date(configs('cfdate'),strtotime($item->contrac_date));
			$times = (int)((strtotime($datecreate) - strtotime($item->contrac_date))/86400);
			$yearss = ($times/365);
			$timeYears = round($yearss,1);
		}
		$holidays_date = 0;
		if(!empty($timeYears)){
			foreach($holidays as $items){
				//Tim so ngay nghi dua vao nam hop dong
				if($timeYears >= $items->holidays_year_from && $timeYears < $items->holidays_year_to){
					$holidays_date = $items->holidays_date;
				}
			}
		}
		$total = $holidays_date + $bonus_holiday;
		return $total;
	}
	function getHolidayYear(){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_holidays_year'])
					  ->select('id,holidays_year_from,holidays_year_to,holidays_date')
					  ->where('isdelete',0)
					  ->find_all();
		return $query;
	}
	public function getProvince(){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_province'])
							 ->select('id,province_name')
							 ->where('isdelete',0);				
		$query = $query->find_all();
		return $query;
	}
	public function getKPI(){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_criteriakpi'])
							 ->select('id,kpi_code,kpi_name,kpi_point_max')
							 ->where('isdelete',0)
							 ->order_by('kpi_name');				
		$query = $query->find_all();
		return $query;
	}
	
	public function getShift($branchid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_shift'])
							 ->select('id,shift_name')
							 ->where('isdelete',0);		
		if(!empty($branchid)){
		   $query = $query->where('branchid',$branchid);
		}							 
		$query = $query->find_all();
		return $query;
	}
	public function getDepartmentGroup($departmentid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_departmentgroup'])
							 ->select('id,departmentgroup_name')
							 ->where('isdelete',0);	
		if(!empty($departmentid)){
		   $query = $query->where('departmentid',$departmentid);
		}
		$query = $query->find_all();
		return $query;
	}
	public function getEmployee($departmentid=''){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_employee'])
							 ->select("id,concat(code,'-',fullname) as fullname")
							 ->where('isdelete',0);		
		if(!empty($departmentid)){
		   $query = $query->where('departmentid',$departmentid);
		}
		$query = $query->find_all();
		return $query;
	}	
	public function getEmployeeTemp($departmentid=''){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_employee'])
							 ->select("id,concat(code,'-',fullname) as fullname")
							 ->where('isdelete',0)
							 ->where('jobstatusid',3);		
		if(!empty($departmentid)){
		   $query = $query->where('departmentid',$departmentid);
		}
		$query = $query->find_all();
		return $query;
	}
	function getEmployees($login,$departmentid='') {
		$tb = $this->loadTable();
		if(empty($departmentid)){
			$departmentid = $login['departmentid'];
		}
		$grouptype = $login['grouptype'];
        $query = $this->model->table($tb['hre_employee'])
					  ->select('id,code,fullname')
					  ->where('isdelete',0);
		if(!empty($departmentid)){
			$query = $query->where('departmentid',$departmentid);
		}
		if($grouptype == 4){
			$query = $query->where('code',$login['username']);
		}
		$query = $query->find_all();
        return $query;
    }
	public function getDistric($provinceid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_district'])
						 ->select('id,distric_name')
						 ->where('isdelete',0);
						 
		if(!empty($provinceid)){
		   $query = $query->where('provinceid',$provinceid);
		}					
		$query = $query->find_all();
		return $query;
	}
	public function getEthnic($ethnicid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_ethnic'])
						 ->select('id,ethnic_name')
						 ->where('isdelete',0);
						 
		if(!empty($ethnicid)){
		   $query = $query->where('id',$ethnicid);
		}	
		$query = $query->order_by('ethnic_name','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getReligion($religionid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_religion'])
						 ->select('id,religion_name')
						 ->where('isdelete',0);
						 
		if(!empty($religionid)){
		   $query = $query->where('id',$religionid);
		}	
		$query = $query->order_by('religion_name','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getAcademic($academicid=''){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_academic_level'])
						 ->select('id,academic_name')
						 ->where('isdelete',0);
						 
		if(!empty($academicid)){
		   $query = $query->where('id',$academicid);
		}	
		$query = $query->order_by('ordering','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getDepartment($deparmentid){
		$login = $this->login;
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_department'])
						 ->select('id,departmanet_name')
						 ->where('isdelete',0);
						 
		if(!empty($deparmentid) && $login['grouptype'] > 1){
		   $query = $query->where('id',$deparmentid);
		}	
		$query = $query->order_by('departmanet_name','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getPosition($positionid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_position'])
						 ->select('id,position_name')
						 ->where('isdelete',0);
						 
		if(!empty($positionid)){
		   $query = $query->where('id',$positionid);
		}	
		$query = $query->order_by('ordering','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getCoefficient($coefficientid=""){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_coefficient'])
						 ->select('id,groupt_name,public_name,coefficient,coefficient_rank')
						 ->where('isdelete',0);
						 
		if(!empty($positionid)){
		   $query = $query->where('id',$positionid);
		}	
		$query = $query->order_by('ordering','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function getJobStatus($jobstatusid){
		$tb = $this->loadTable();
		$query = $this->model->table($tb['hre_job_status'])
						 ->select('id,status_name')
						 ->where('isdelete',0);
						 
		if(!empty($jobstatusid)){
		   $query = $query->where('id',$jobstatusid);
		}	
		$query = $query->order_by('status_name','ASC');
		$query = $query->find_all();
		return $query;
	}
	public function addAcction($ctrol,$func,$acction_before='',$action_after=''){
		$tb = $this->loadTable();
		$login =  $this->site->getSession("glogin");
		$array['ctrl'] = $ctrol;
		$array['gaction'] = $func;
		$array['before'] = $acction_before;
		$array['after'] = $action_after;
		$array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600); 
		$array['usercreate'] =  $login['userlogin'];
		$array['ipcreate'] = $this->getMacAddress();
		$this->model->table($tb['hre_action'])->insert($array);
	}
	function getMonth(){
		$arr = array(); 
		$arr[1] = 'Tháng 1';
		$arr[2] = 'Tháng 2';
		$arr[3] = 'Tháng 3';
		$arr[4] = 'Tháng 4';
		$arr[5] = 'Tháng 5';
		$arr[6] = 'Tháng 6';
		$arr[7] = 'Tháng 7';
		$arr[8] = 'Tháng 8';
		$arr[9] = 'Tháng 9';
		$arr[10] = 'Tháng 10';
		$arr[11] = 'Tháng 11';
		$arr[12] = 'Tháng 12';
		return $arr;
	}
	function getColumns($table){
		//$tbs = $this->loadTable();
        $sql = "
			SELECT column_name
			FROM information_schema.columns
			WHERE table_name='$table'; 
		";
        $query = $this->model->query($sql)->execute();
        $obj = new stdClass();
        foreach ($query as $item) {
            $clm = $item->column_name;
            $obj->$clm = null;
        }
        return $obj;
    }
    public function getPermission($login, $route,$processid = '') {
        $right = array();
        if (isset($login['params'][$route])) {
            $right = $login['params'][$route];
        }
		if($route == 'process'){
			$query = $this->model->table('hre_menus')
						  ->select('id,params')
						  ->where('route',$route)
						  ->where('processid',$processid)
						  ->where('isdelete',0)
						  ->find();
			if(empty($query->id)){
				return array();
			}
			else{
				$arr = explode(',',$query->params); 
				$right = array();
				foreach($arr as $key=>$val){
					$right[$val] = '';
				}
			}
		}	
        return $right;
    }
    public function getGroup($schoolid) {
        $query = $this->model->table('phone_groups')
                ->select('id,groupname')
                ->where('isdelete', 0);

        if (!empty($schoolid)) {
            $query = $query->where('id', $schoolid);
        }
        $query = $query->find_all();
        return $query;
    }
	public function getBranch($branchid) {
        $tb = $this->loadTable();
		$query = $this->model->table($tb['hre_branch'])
                ->select('id,branch_name')
                ->where('isdelete', 0);

        if (!empty($branchid)) {
            $query = $query->where('id', $branchid);
        }
		$query = $query->order_by('branch_name');
        $query = $query->find_all();
        return $query;
    }
	public function getNetBranch($branchid) {
        $tb = $this->loadTable();
		$query = $this->model->table($tb['hre_branch'])
                ->select('id,branch_name')
                ->where('isdelete', 0);

        if (!empty($branchid)) {
            $query = $query->where('id <>', $branchid);
        }
		$query = $query->order_by('branch_name');
        $query = $query->find_all();
        return $query;
    }
	public function doc1so($so){
			$arr_chuhangdonvi=array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
			$resualt='';
				$resualt=$arr_chuhangdonvi[$so];
			return $resualt;
		}
	public function doc2so($so){
			$arr_chubinhthuong=array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
			$arr_chuhangdonvi=array('mươi','mốt','hai','ba','bốn','lăm','sáu','bảy','tám','chín');
			$arr_chuhangchuc=array('','mười','hai mươi','ba mươi','bốn mươi','năm mươi','sáu mươi','bảy mươi','tám mươi','chín mươi');
			$resualt='';
			$sohangchuc=substr($so,0,1);
			$sohangdonvi=substr($so,1,1);
			$resualt.=$arr_chuhangchuc[$sohangchuc];
			if($sohangchuc==1&&$sohangdonvi==1)
				$resualt.=' '.$arr_chubinhthuong[$sohangdonvi];
			elseif($sohangchuc==1&&$sohangdonvi>1)
				$resualt.=' '.$arr_chuhangdonvi[$sohangdonvi];
			elseif($sohangchuc>1&&$sohangdonvi>0)
				$resualt.=' '.$arr_chuhangdonvi[$sohangdonvi];
			
			return $resualt;
		}
	public function doc3so($so){
		$resualt='';
		$arr_chubinhthuong=array('không','một','hai','ba','bốn','năm','sáu','bảy','tám','chín');
		$sohangtram=substr($so,0,1);
		$sohangchuc=substr($so,1,1);
		$sohangdonvi=substr($so,2,1);
		$resualt=$arr_chubinhthuong[$sohangtram].' trăm';
		if($sohangchuc==0&&$sohangdonvi!=0)
			$resualt.=' linh '.$arr_chubinhthuong[$sohangdonvi];
		elseif($sohangchuc!=0)
			$resualt.=' '.$this->doc2so($sohangchuc.$sohangdonvi);
		return $resualt;
	}
	public function docso($so){
			$arrSo = explode('.',$so);
			if(isset($arrSo[0])){
				$so = $arrSo[0];
			}
			$sole = 0;
			if(isset($arrSo[1])){
				$sole = $arrSo[1];
			}
			$result='';
			$arr_So=array('ty'=>'',
						  'trieu'=>'',
						  'nghin'=>'',
						  'tram'=>'');
			$sochuso=strlen($so);
			for($i=$sochuso-1;$i>=0;$i--)
			{
				
				if($sochuso-$i<=3)
				{
				   $arr_So['tram']=substr($so,$i,1).$arr_So['tram'];
				}
				elseif($sochuso-$i>3&&$sochuso-$i<=6)
				{
					$arr_So['nghin']=substr($so,$i,1).$arr_So['nghin'];
				}
				elseif($sochuso-$i>6&&$sochuso-$i<=9)
				{
					$arr_So['trieu']=substr($so,$i,1).$arr_So['trieu'];
				}
				else
				{
					$arr_So['ty']=substr($so,$i,1).$arr_So['ty'];
				}
			}
			if($arr_So['ty']>0)
				$result.=$this->doc($arr_So['ty']).' tỷ';
			if($arr_So['trieu']>0)
			{
				if($arr_So['trieu']>=100||$arr_So['ty']>0)
					$result.=' '.$this->doc3so($arr_So['trieu']).' triệu';
				elseif($arr_So['trieu']>=10)
					$result.=' '.$this->doc2so($arr_So['trieu']).' triệu';
				else $result.=' '.$this->doc1so($arr_So['trieu']).' triệu';
			}
			if($arr_So['nghin']>0)
			{
				if($arr_So['nghin']>=100||$arr_So['trieu']>0)
					$result.=' '.$this->doc3so($arr_So['nghin']).' nghìn';
				elseif($arr_So['nghin']>=10)
					$result.=' '.$this->doc2so($arr_So['nghin']).' nghìn';
				else $result.=' '.$this->doc1so($arr_So['nghin']).' nghìn';
			}
			if($arr_So['tram']>0)
			{
			   if($arr_So['tram']>=100||$arr_So['nghin']>0)
					$result.=' '.$this->doc3so($arr_So['tram']);
			   elseif($arr_So['tram']>=10)
					$result.=' '.$this->doc2so($arr_So['tram']);
			   else $result.=' '.$this->doc1so($arr_So['tram']);
			}
			$number = trim($result);
			$sub = 	strtoupper(substr($number,0,1));
			if(!empty($sole)){
				return $sub.substr($number,1).' lẻ '.$this->doc2so($sole).' đồng';
			}
			else{
				return $sub.substr($number,1).' đồng';
			}
	}
	function timeStamp($timeStart, $timeEnd){
        //$cur_time=time();
        $time_elapsed = strtotime($timeEnd) - strtotime($timeStart);
        $seconds = $time_elapsed ;
        $minutes = (int)($time_elapsed / 60 );
        $hours = (int)($time_elapsed / 3600);
        $days = (int)($time_elapsed / 86400 );
        $weeks = (int)($time_elapsed / 604800);
        $months = (int)($time_elapsed / 2600640 );
        $years = (int)($time_elapsed / 31207680 );
        // Seconds
		$str = '';
		if($days >= 1){
			$str = $days.' '.getLanguage('ngay');
			$giole = (($time_elapsed % 86400)/86400)*24;
			$gio = (int)$giole;
			$str.= ' '.$gio."h";
			$phutle = (($time_elapsed % 86400)/86400)*24;
			$sophut = ($phutle - $gio)*60;
			$str.= ':'.(int)$sophut."'";
		}
		else{
			if($hours >= 1){
				$str = $hours.'h';
				$sophut = ($time_elapsed % 3600)/60;
				$str.= ':'.$sophut."'";
			}
			else{
				$str = $minutes."'";
			}
		}
		return $str;
    }
}

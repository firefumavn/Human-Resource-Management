<?php
/**
 * @author sonnk
 * @copyright 2018
 */
class PayrolldetailModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($code,$identity){
		if(empty($code)){
			$code = -1;
		}
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_employee'])->select('id')
					  ->where('isdelete',0);
		$query =  $query->where('code',$code);
		if(!empty($identity)){
			$query =  $query->where('identity',$identity);
		}
		$query =  $query->find();
		$employee = 0;
		if(!empty($query->id)){
			$employee = $query->id;
		}
        return $employee;
    }
	function getAllowance(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_allowance'])
					  ->select('id,allowance_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
	}
	function getInsurance(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_insurance'])
					  ->select('id,insurance_name,workers,company')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
	}
	function getInsuranceValue($endoffmonthid,$employeeid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_salary_insurance'])
					  ->select('id,worker,company,insuranceid')
					  ->where('endoffmonthid',$endoffmonthid)
					  ->where('employeeid',$employeeid)
					  ->where('isdelete',0)
					  ->find_all();
        $arr = array();
		foreach($query as $item){
			$arr[$item->insuranceid] = $item->worker;
		}
		return $arr;
	}
	
	function getTimesheetsMonth($monthid){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_timesheets_month'])
					  ->select('id,employeeid,workday')
					  ->where('branchid',$login['branchid'])
					  ->where('monthid',$monthid)
					  ->find_combo('employeeid','workday');
        return $query;
	}
	function getAllowanceSalary($endoffmonthid,$employeeid){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_salary_allowance'])
					  ->select('id,allowanceid,salary,employeeid,typeid')
					  ->where('isdelete',0)
					  ->where('endoffmonthid',$endoffmonthid)
					  ->where('employeeid',$employeeid)
					  ->find_all();
        return $query;
	}
	function getSalary($endoffmonthid,$employeeid){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_salary'])
					  ->select('id,salary')
					  ->where('isdelete',0)
					  ->where('endoffmonthid',$endoffmonthid)
					  ->where('employeeid',$employeeid)
					  ->find();
        $salary = 0;
		if(!empty($query->salary)){
			$salary = $query->salary;
		}
        return $salary;
	}
	function getEndoffmonth(){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear')
					  ->where('isdelete',0)
					  ->order_by('monthyear','desc')
					  ->find_all();
        return $query;
	}
	function getEmployee($departmentid) {
		$tb = $this->base_model->loadTable();
		$login = $this->login;
        $query = $this->model->table($tb['hre_employee'])
					  ->select('id,code,fullname')
					  ->where('isdelete',0);
		if(!empty($departmentid)){
			if($login['grouptype'] > 1){
				$query = $query->where('departmentid',$departmentid);
			}
		}
		$query = $query->find_all();
        return $query;
    }
	function findDepartment($employeeid){
		$tb = $this->base_model->loadTable();
		$find = $this->model->table($tb['hre_employee'])
							->select('id,departmentid')
							->where('id',$employeeid)
							->find();
		$departmentid = 0;
		if(!empty($find->departmentid)){
			$departmentid = $find->departmentid;
		}
		return $departmentid;
	}
	function getPublicSalary($endoffmonthid,$employeeid){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_salary_public'])
					  ->select('id,salary_real,salary')
					  ->where('isdelete',0)
					  ->where('endoffmonthid',$endoffmonthid)
					  ->where('employeeid',$employeeid)
					  ->find();
        return $query;
	}
}
<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class SalarymonthModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_salary'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getAllowance(){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_allowance'])
					  ->select('id,allowance_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
	}
	function getAllowanceSalary($endoffmonthid){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_salary_allowance'])
					  ->select('id,allowanceid,salary,employeeid,typeid')
					  ->where('isdelete',0)
					  ->where('endoffmonthid',$endoffmonthid)
					  ->find_all();
        return $query;
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
        $query = $this->model->table($tb['hre_employee'])
					  ->select('id,code,fullname')
					  ->where('isdelete',0);
		if(!empty($departmentid)){
			$query = $query->where('departmentid',$departmentid);
		}
		$query = $query->find_all();
        return $query;
    }
	function getSearch($search){
		//departmentid
		$sql = "";
		if(!empty($login['branchid'])){
			$sql.= " and s.branchid in (".$login['branchid'].")";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and s.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($login['departmentid'])){
			$sql.= " and e.departmentid in (".$login['departmentid'].")";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and e.departmentid in (".$search['departmentid'].") ";	
			}
		}
		if(!empty($search['fullname'])){
			$sql.= " and e.fullname like '%".$search['fullname']."%' ";	
		}
		if(!empty($search['identity'])){
			$sql.= " and e.identity like '%".$search['identity']."%' ";	
		}
		if(!empty($search['code'])){
			$sql.= " and e.code like '%".$search['code']."%' ";	
		}
		if(!empty($search['endoffmonthid'])){
			$sql.= " and s.endoffmonthid in (".$search['endoffmonthid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT s.*, e.departmentid, e.fullname, e.code, d.departmanet_name, ef.monthyear,
				(
					select sum(r.money)
					from `".$tb['hre_reward']."` r
					where r.endoffmonthid = ef.id
					and r.employeeid = e.id
					and r.isdelete = 0
				) khen_thuong,
				(
					select sum(ins.company + ins.worker)
					from `".$tb['hre_salary_insurance']."` ins
					where ins.endoffmonthid = ef.id
					and ins.employeeid = e.id
					and ins.isdelete = 0
				) bao_hiem
				FROM `".$tb['hre_salary_public']."` AS s
				LEFT JOIN `".$tb['hre_employee']."` e on e.id = s.employeeid
				left join `".$tb['hre_department']."` d on d.id = e.departmentid
				left join `".$tb['hre_endoffmonth']."` ef on ef.id = s.endoffmonthid 
				WHERE s.isdelete = 0 
				$searchs
				and e.isdelete = 0
				and d.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY e.fullname asc  ";
		}
		else{
			$sql.= " ORDER BY ".$search['order']." ".$search['index']." ";
		}
		if(!empty($rows)){
			$sql.= ' limit '.$page.','.$rows;
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['hre_salary']."` AS s
			LEFT JOIN `".$tb['hre_employee']."` e on e.id = s.employeeid
			left join `".$tb['hre_department']."` d on d.id = e.departmentid
			WHERE s.isdelete = 0
			$searchs	
			AND e.isdelete = 0
			and d.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
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
}
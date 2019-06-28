<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class OthercollectModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_salary_othercollect'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
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
			$sql.= " and r.branchid in (".$login['branchid'].")";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and r.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($this->login['departmentid']) && $this->login['grouptype'] > 1){// > 1 Các phòng ban khác
			$sql.= " and e.departmentid = '".$this->login['departmentid']."' ";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and e.departmentid in (".$search['departmentid'].") ";	
			}
		}
		if(!empty($search['datecreate'])){
			$arrayDate = explode('-',$search['datecreate']);
			$fromdate = 0;
			if(!empty($arrayDate[0])){
				$fromdate = fmDateSave(trim($arrayDate[0]));
			}
			$todate = 0;
			if(!empty($arrayDate[1])){
				$todate = fmDateSave(trim($arrayDate[1]));
			}
			$sql.= " and r.othercollect_date >= '".fmDateSave($fromdate)." 00:00:00' ";	
			$sql.= " and r.othercollect_date <= '".fmDateSave($todate)." 23:59:59' ";	
		}
		if(!empty($search['fullname'])){
			$sql.= " and e.fullname like '%".$search['fullname']."%' ";	
		}
		if(!empty($search['code'])){
			$sql.= " and e.code like '%".$search['code']."%' ";	
		}
		if(!empty($search['othercollect_content'])){
			$sql.= " and r.othercollect_content like '%".$search['othercollect_content']."%' ";	
		}
		if(!empty($search['othercollect_money'])){
			$sql.= " and r.othercollect_money like '%".$search['othercollect_money']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT r.*, e.fullname, e.code, d.departmanet_name
				FROM `".$tb['hre_salary_othercollect']."` AS r
				LEFT JOIN `".$tb['hre_employee']."` e on e.id = r.employeeid
				left join `".$tb['hre_department']."` d on d.id = r.departmentid
				WHERE r.isdelete = 0 
				$searchs
				and e.isdelete = 0
				and d.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY r.othercollect_date desc  ";
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
			FROM `".$tb['hre_salary_othercollect']."` AS r
			LEFT JOIN `".$tb['hre_employee']."` e on e.id = r.employeeid
			left join `".$tb['hre_department']."` d on d.id = r.departmentid
			WHERE r.isdelete = 0
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
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		 if(empty($array['othercollect_date'])){
			 $array['othercollect_date'] = gmdate("Y-m-d", time() + 7 * 3600);
		 }
		 else{
			  $array['othercollect_date'] =  fmDateSave($array['othercollect_date']);
		 }
		 $array['departmentid'] =  $this->findDepartment($array['employeeid']);
		 $array['branchid'] = $login['branchid'];
		 $array['othercollect_money'] =  fmNumberSave($array['othercollect_money']);
		 $result = $this->model->table($tb['hre_salary_othercollect'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		if(empty($array['othercollect_date'])){
			$array['othercollect_date'] = gmdate("Y-m-d", time() + 7 * 3600);
		}
		else{
			$array['othercollect_date'] =  fmDateSave($array['othercollect_date']);
		}
		$array['departmentid'] =  $this->findDepartment($array['employeeid']);
		$array['branchid'] = $login['branchid'];
		$array['othercollect_money'] =  fmNumberSave($array['othercollect_money']);
		$this->model->table($tb['hre_salary_othercollect'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_salary_othercollect'])
					->where("id in ($id)")
					->where('ispay',0)
					->delete();
		return 1;
	}
}
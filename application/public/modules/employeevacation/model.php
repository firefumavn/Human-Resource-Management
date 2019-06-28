<?php
/**
 * @author sonnk
 * @copyright 2018
 */
class EmployeevacationModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_timesheets'])
					  ->where('isdelete',0)
					  ->where("id in ($id)")
					  ->find();
        return $query;
    }
	function getEmployee(){

	}
	function getSearch($search){
		$sql = "";
		if(!empty($search['code'])){
			$sql.= " and e.code like '%".$search['code']."%' ";	
		}
		if(!empty($search['fullname'])){
			$sql.= " and e.fullname like '%".$search['fullname']."%' ";	
		}
		if(!empty($search['identity'])){
			$sql.= " and e.identity like '%".$search['identity']."%' ";	
		}
		if(!empty($login['branchid'])){
			$sql.= " and e.branchid in (".$login['branchid'].")";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and e.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($this->login['departmentid']) && $this->login['grouptype'] > 1){// > 1 Các phòng ban khác
			$sql.= " and s.departmentid = '".$this->login['departmentid']."' ";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and s.departmentid in (".$search['departmentid'].") ";	
			}
		}
		$from = fmDateSave($search['fromdate']).' 00:00:00';
		$to = fmDateSave($search['fromdate']).' 23:59:59';
		$sql.= " and esd.time_start >= '$from'";
		$sql.= " and esd.time_start <= '$to'";
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		
		$sql = "SELECT e.id, e.code,e.identity , e.fullname, d.departmanet_name, e.departmentid, p.position_name, dg.departmentgroup_name, e.group_work_id, e.positionid, es.description, esd.time_start, esd.time_end, es.description
				from `".$tb['hre_empleaveshow']."` es 
				left join `".$tb['hre_empleaveshow_detail']."` esd on es.id = esd.empleaveshowid
				left join `".$tb['hre_employee']."` e on e.id = es.employeeid
				left join `".$tb['hre_department']."` d on d.id = e.departmentid
				left join `".$tb['hre_position']."`  p on p.id = e.positionid and p.isdelete = 0
				left join `".$tb['hre_departmentgroup']."` dg on dg.id = e.group_work_id
				WHERE es.isdelete = 0 
				and esd.statusid = 1
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY e.code DESC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
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
		$from = fmDateSave($search['fromdate']).' 00:00:00';
		$to = fmDateSave($search['fromdate']).' 23:59:59';
		$sql = "SELECT count(1) total
				from `".$tb['hre_empleaveshow']."` es 
				left join `".$tb['hre_empleaveshow_detail']."` esd on es.id = esd.empleaveshowid
				left join `".$tb['hre_employee']."` e on e.id = es.employeeid
				left join `".$tb['hre_department']."` d on d.id = e.departmentid
				
				WHERE es.isdelete = 0 
				and esd.statusid = 1
				$searchs
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
}
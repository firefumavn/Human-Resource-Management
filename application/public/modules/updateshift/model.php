<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class UpdateshiftModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_employee'])
					  ->where('isdelete',0)
					  ->where("id",$id)
					  ->find();
        return $query;
    }
	function getEmployee(){

	}
	function getSearch($search){
		$sql = "";
		$login = $this->login;
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
		if(!empty($login['departmentid'])){
			$sql.= " and e.departmentid in (".$login['departmentid'].")";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and e.departmentid in (".$search['departmentid'].") ";	
			}
		}
		if(!empty($search['group_work_id'])){
			$sql.= " and e.group_work_id in (".$search['group_work_id'].") ";	
		}
		if(!empty($search['positionid'])){
			$sql.= " and e.positionid in (".$search['positionid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$searchs = $this->getSearch($search);
		$tb = $this->base_model->loadTable();
		$sql = "SELECT e.id, e.code,e.identity , e.fullname, d.departmanet_name, e.departmentid, p.position_name, dg.departmentgroup_name, e.group_work_id, e.positionid, s.shift_name
				from `".$tb['hre_employee']."` e
				left join `".$tb['hre_department']."` d on d.id = e.departmentid
				left join `".$tb['hre_shift']."` s on s.id = e.shiftid
				left join `".$tb['hre_position']."`  p on p.id = e.positionid and p.isdelete = 0
				left join `".$tb['hre_departmentgroup']."` dg on dg.id = e.group_work_id
				WHERE e.isdelete = 0 
				$searchs
				and d.isdelete = 0
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
		$sql = "SELECT count(1) total
				from `".$tb['hre_employee']."` e
				left join `".$tb['hre_department']."` d on d.id = e.departmentid
				left join `".$tb['hre_position']."` p on p.id = e.positionid  and p.isdelete = 0
				WHERE e.isdelete = 0 
				$searchs
				and d.isdelete = 0
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function edits($search,$id){
		$tb = $this->base_model->loadTable();
		if(!empty($search['code'])){
			$arrCode = explode(',',$search['code']);
			$array = array();
			foreach($arrCode as $key=>$code){
				$array['shiftid'] = $search['shiftid'];
				$result = $this->model->table($tb['hre_employee'])->where('code',$code)->update($array);	
			}
		}
		return $id;
	 }
}
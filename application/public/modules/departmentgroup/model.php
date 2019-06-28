<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class DepartmentgroupModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_departmentgroup'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getDepartment() {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_department'])
					  ->select('id,departmanet_name')
					  ->where('isdelete',0)
					  ->order_by('departmanet_name')
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['departmentgroup_name'])){
			$sql.= " and dp.departmentgroup_name like '%".$search['departmentgroup_name']."%' ";	
		}
		if(!empty($search['departmentid'])){
			$sql.= " and dp.departmentid in (".$search['departmentid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT dp.*, d.departmanet_name
				FROM `".$tb['hre_departmentgroup']."` AS dp
				LEFT JOIN `".$tb['hre_department']."` d on d.id = dp.departmentid
				WHERE dp.isdelete = 0 
				$searchs
				and d.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY dp.departmentgroup_name ASC  ";
		}
		else{
			$sql.= " ORDER BY ".$search['order']." ".$search['index']." ";
		}
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['hre_departmentgroup']."` AS dp
			LEFT JOIN `".$tb['hre_department']."` d on d.id = dp.departmentid
			WHERE dp.isdelete = 0
			$searchs	
			AND d.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_departmentgroup'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('departmentgroup_name',$array['departmentgroup_name'])
					  ->where('departmentid',$array['departmentid'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $result = $this->model->table($tb['hre_departmentgroup'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_departmentgroup'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('departmentgroup_name',$array['departmentgroup_name'])
				  ->where('departmentid',$array['departmentid'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$this->model->table($tb['hre_departmentgroup'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_departmentgroup'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
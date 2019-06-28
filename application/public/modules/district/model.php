<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class DistrictModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_district'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getProvice() {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_province'])
					  ->select('id,province_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['distric_name'])){
			$sql.= " and d.distric_name like '%".$search['distric_name']."%' ";	
		}
		if(!empty($search['provinceid'])){
			$sql.= " and d.provinceid in (".$search['provinceid'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT d.*, p.province_name
				FROM `".$tb['hre_district']."` AS d
				LEFT JOIN `".$tb['hre_province']."` p on p.id = d.provinceid
				WHERE d.isdelete = 0 
				$searchs
				and p.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY d.distric_name ASC  ";
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
			FROM `".$tb['hre_district']."` AS d
			LEFT JOIN `".$tb['hre_province']."` p on p.id = d.provinceid
			WHERE d.isdelete = 0
			$searchs	
			AND p.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_district'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('distric_name',$array['distric_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $result = $this->model->table($tb['hre_district'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_district'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('distric_name',$array['distric_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$this->model->table($tb['hre_district'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_district'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
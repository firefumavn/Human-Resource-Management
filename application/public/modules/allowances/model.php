<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class AllowancesModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_allowance'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getAllowance() {
        $query = array();
		$query[1] = '% so với lương cơ bản';
		$query[2] = 'Cộng tiền trực tiếp';
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['allowance_name'])){
			$sql.= " and al.allowance_name like '%".$search['allowance_name']."%' ";	
		}
		/*if(!empty($search['allowance_money'])){
			$sql.= " and al.allowance_money like '%".$search['allowance_money']."%' ";	
		}
		if(!empty($search['allowance_type'])){
			$sql.= " and al.allowance_type in (".$search['allowance_type'].") ";	
		}*/
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT al.*
				FROM `".$tb['hre_allowance']."` AS al
				WHERE al.isdelete = 0 
				$searchs
				ORDER BY al.allowance_name ASC 
				";
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['hre_allowance']."` AS al
			WHERE al.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_allowance'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('allowance_name',$array['allowance_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 //$array['allowance_money'] = fmNumberSave($array['allowance_money']);
		 $result = $this->model->table($tb['hre_allowance'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_allowance'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('allowance_name',$array['allowance_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		//$array['allowance_money'] = fmNumberSave($array['allowance_money']);
		$this->model->table($tb['hre_allowance'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_allowance'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
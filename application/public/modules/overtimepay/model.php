<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class OvertimepayModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_overtime_pay'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['overtime_name'])){
			$sql.= " and e.overtime_name like '%".$search['overtime_name']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT e.*
				FROM `".$tb['hre_overtime_pay']."` AS e
				WHERE e.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY e.overtime_name ASC  ";
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
			FROM `".$tb['hre_overtime_pay']."` AS e
			WHERE e.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_overtime_pay'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('overtime_name',$array['overtime_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $array['overtime_pay'] = fmNumberSave($array['overtime_pay']);
		 $result = $this->model->table($tb['hre_overtime_pay'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_overtime_pay'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('overtime_name',$array['overtime_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['overtime_pay'] = fmNumberSave($array['overtime_pay']);
		$this->model->table($tb['hre_overtime_pay'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_overtime_pay'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
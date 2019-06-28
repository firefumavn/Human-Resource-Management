<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class InsuranceModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_insurance'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getTypes() {
        $query = array();
		$query[1] = '%';
		//$query[2] = 'Tiền';
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['insurance_name'])){
			$sql.= " and i.insurance_name like '%".$search['insurance_name']."%' ";	
		}
		if(!empty($search['company'])){
			$sql.= " and i.company like '%".$search['company']."%' ";	
		}
		if(!empty($search['workers'])){
			$sql.= " and i.workers like '%".$search['workers']."%' ";	
		}
		if(!empty($search['description'])){
			$sql.= " and i.description like '%".$search['description']."%' ";	
		}
		if(!empty($search['insurance_type'])){
			$sql.= " and i.insurance_type in (".$search['insurance_type'].") ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT i.*
				FROM `".$tb['hre_insurance']."` AS i
				WHERE i.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY i.insurance_name desc  ";
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
			FROM `".$tb['hre_insurance']."` AS i
			WHERE i.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_insurance'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('insurance_name',$array['insurance_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $array['company'] = fmNumberSave($array['company']);
		 $array['workers'] = fmNumberSave($array['workers']);
		 $result = $this->model->table($tb['hre_insurance'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_insurance'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('insurance_name',$array['insurance_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['company'] = fmNumberSave($array['company']);
		$array['workers'] = fmNumberSave($array['workers']);
		$this->model->table($tb['hre_insurance'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_insurance'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
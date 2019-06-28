<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class MachineModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_machine'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['machine_sn'])){
			$sql.= " and m.machine_sn like '%".$search['machine_sn']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT m.*
				FROM `".$tb['hre_machine']."` AS m
				WHERE m.isdelete = 0 
				$searchs
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY m.machine_sn ASC";
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
			FROM `".$tb['hre_machine']."` AS m
			WHERE m.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_machine'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('machine_sn',$array['machine_sn'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $array['fingerprint_date_from'] = fmDateSave($array['fingerprint_date_from']);
		 $array['fingerprint_date_to'] = fmDateSave($array['fingerprint_date_to']);
		 $result = $this->model->table($tb['hre_machine'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$check = $this->model->table($tb['hre_machine'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('machine_sn',$array['machine_sn'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$array['fingerprint_date_from'] = fmDateSave($array['fingerprint_date_from']);
		$array['fingerprint_date_to'] = fmDateSave($array['fingerprint_date_to']);
		$this->model->table($tb['hre_machine'])
					->where('id',$id)
					->update($array);	
		
		if($array['downloademployee'] == 1){//Xóa sync nhân vien sync lại
			$this->model->table($tb['hre_employee_sync'])->where('machine_id',$id)->delete();
		}
		
		return $id;		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table('hre_machine')
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
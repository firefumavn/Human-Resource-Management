<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class ShiftModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_shift'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['shift_name'])){
			$sql.= " and u.shift_name like '%".$search['shift_name']."%' ";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT u.*
				FROM `".$tb['hre_shift']."` AS u
				WHERE u.isdelete = 0 
				$searchs
				ORDER BY u.shift_name ASC 
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
			FROM `".$tb['hre_shift']."` AS u
			WHERE u.isdelete = 0
			$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		//Tính thời gian làm việc
		$s1 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_star'];
		$s11 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_end_am'];
		$hours_1 = (strtotime($s11) - strtotime($s1))/3600;
		$s2 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_star_pm'];
		$s22 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_end'];
		$hours_2 = (strtotime($s22) - strtotime($s2))/3600;
		$between_shift = (strtotime($s2) - strtotime($s11))/3600;
		
		$array['hours_1'] = $hours_1;
		$array['hours_2'] = $hours_2;
		$array['between_shift'] = $between_shift;
		
		$check = $this->model->table($tb['hre_shift'])
					  ->select('id')
					  ->where('isdelete',0)
					  ->where('shift_name',$array['shift_name'])
					  ->find();
		 if(!empty($check->id)){
			return -1;	
		 }
		 $result = $this->model->table($tb['hre_shift'])->insert($array);	
		 return $result;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		//Tính thời gian làm việc
		$s1 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_star'];
		$s11 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_end_am'];
		$hours_1 = (strtotime($s11) - strtotime($s1))/3600;
		$s2 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_star_pm'];
		$s22 = gmdate("Y-m-d", time() + 7 * 3600).' '.$array['time_end'];
		$hours_2 = (strtotime($s22) - strtotime($s2))/3600;
		
		$between_shift = (strtotime($s2) - strtotime($s11))/3600;
		$array['hours_1'] = $hours_1;
		$array['hours_2'] = $hours_2;
		$array['between_shift'] = $between_shift;
		$check = $this->model->table($tb['hre_shift'])
				  ->select('id')
				  ->where('isdelete',0)
				  ->where('shift_name',$array['shift_name'])
				  ->where('id <>',$id)
				  ->find();
		if(!empty($check->id)){
			return -1;	
		}
		$this->model->table($tb['hre_shift'])
					->where('id',$id)
					->update($array);	
		return $id;
		
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_shift'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
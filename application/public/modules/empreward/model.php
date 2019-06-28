<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class EmprewardModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_reward'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getEmployee() {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_employee'])
					  ->select('id,fullname')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
    }
	function getSearch($search){
		$sql = "";
		if(!empty($search['reward_content'])){
			$sql.= " and r.reward_content like '%".$search['reward_content']."%' ";	
		}
		if(!empty($search['date_reward'])){
			$sql.= " and r.date_reward = '".$search['date_reward']."' ";	
		}
		if(!empty($login['departmentid'])){
			$sql.= " and e.departmentid in (".$login['departmentid'].")";	
		}
		if(!empty($login['branchid'])){
			$sql.= " and e.branchid in (".$login['branchid'].")";	
		}
		if(!empty($search['identity'])){
			$sql.= " and e.identity like '%".$search['identity']."%' ";	
		}
		if(!empty($search['code'])){
			$sql.= " and e.code like '%".$search['code']."%' ";	
		}
		if(!empty($search['fullname'])){
			$sql.= " and e.fullname like '%".$search['fullname']."%' ";	
		}
		if(!empty($this->login['departmentid']) && $this->login['grouptype'] > 1){// > 1 Các phòng ban khác
			$sql.= " and e.departmentid = '".$this->login['departmentid']."' ";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and e.departmentid in (".$search['departmentid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " SELECT r.*, e.code ,e.fullname, dp.departmanet_name
				FROM `".$tb['hre_reward']."` AS r
				LEFT JOIN `".$tb['hre_employee']."` e on e.id = r.employeeid
				LEFT JOIN `".$tb['hre_department']."` dp on dp.id = e.departmentid
				WHERE r.isdelete = 0 
				$searchs
				and e.isdelete = 0
				and dp.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY r.date_reward desc  ";
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
			FROM `".$tb['hre_reward']."` AS r
			LEFT JOIN `".$tb['hre_employee']."` e on e.id = r.employeeid
			LEFT JOIN `".$tb['hre_department']."` dp on dp.id = e.departmentid
			WHERE r.isdelete = 0
			$searchs	
			AND e.isdelete = 0
			and dp.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($array,$id){
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		if(empty($array['date_reward'])){
			$array['date_reward'] = gmdate("Y-m-d", time() + 7 * 3600);
		}
		else{
			$array['date_reward'] =  fmDateSave($array['date_reward']);
		}
		if(!empty($login['branchid'])){
			$array['branchid'] = $login['branchid'];
		}
		//date_reward
		//Kỳ lương hre_endoffmonth_1
		$endoffmonth = $this->model->table($tb['hre_endoffmonth'])
			->select('id')
			->where('date_start <',$array['date_reward'])
			->where('date_start >',$array['date_reward'])
			->where('isdelete',0)
			->find();
		$endoffmonthid = 0;
		if(!empty($endoffmonth->id)){
			$endoffmonthid = $endoffmonth->id;
		}
		$array['endoffmonthid'] = $endoffmonthid;
		
		$employeeid = $array['employeeid'];
		$array['money'] =  fmNumberSave($array['money']);
		$this->model->table($tb['hre_reward'])->insert($array);
		return 1;
	}
	function edits($array,$id){
		$tb = $this->base_model->loadTable();
		$login = $this->login;
		if(empty($array['date_reward'])){
			$array['date_reward'] = gmdate("Y-m-d", time() + 7 * 3600);
		}
		else{
			$array['date_reward'] =  fmDateSave($array['date_reward']);
		}
		if(!empty($login['branchid'])){
			$array['branchid'] = $login['branchid'];
		}
		//Kỳ lương hre_endoffmonth_1
		$endoffmonth = $this->model->table($tb['hre_endoffmonth'])
			->select('id')
			->where('date_start <=',$array['date_reward'])
			->where('date_end >=',$array['date_reward'])
			->where('isdelete',0)
			->find();
		$endoffmonthid = 0;
		if(!empty($endoffmonth->id)){
			$endoffmonthid = $endoffmonth->id;
		}
		$array['endoffmonthid'] = $endoffmonthid;
		
		$array['money'] =  fmNumberSave($array['money']);
		$this->model->table($tb['hre_reward'])
					->where('id',$id)
					->update($array);	
		return $id;
	}
	function deletes($id,$array){
		$tb = $this->base_model->loadTable();
		$this->model->table($tb['hre_reward'])
					->where("id in ($id)")
					->update($array);
		return 1;
	}
}
<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class ApplicationforleaveapprovedModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		if(empty($id)){
			$id = 0;
		}
        $query = $this->model->table($tb['hre_applicationforleave'])
					  ->where('isdelete',0)
					  ->where("id in ($id)")
					  ->find();
        return $query;
    }
	function getEmployee(){

	}
	function getSearch($search){
		$login = $this->login;
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
			$sql.= " and al.branchid in (".$login['branchid'].")";	
		}
		else{
			if(!empty($search['branchid'])){
				$sql.= " and al.branchid in (".$search['branchid'].") ";	
			}
		}
		if(!empty($login['departmentid'])){
			$sql.= " and al.departmentid in (".$login['departmentid'].")";	
		}
		
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and al.departmentid in (".$search['departmentid'].") ";	
			}
		}
		if(!empty($search['datecreate'])){
			$arrayDate = explode('-',$search['datecreate']);
			$fromdate = 0;
			if(!empty($arrayDate[0])){
				$fromdate = fmDateSave(trim($arrayDate[0]));
			}
			$todate = 0;
			if(!empty($arrayDate[1])){
				$todate = fmDateSave(trim($arrayDate[1]));
			}
			$sql.= " and al.datecreate >= '".fmDateSave($fromdate)." 00:00:00' ";	
			$sql.= " and al.datecreate <= '".fmDateSave($todate)." 23:59:59' ";	
		}
		if($login['grouptype'] > 2){//Group nhan vien
			$sql.= " and al.departmentid in (".$search['departmentid'].") ";
		}
		if(!empty($search['approved'])){
			$sql.= " and al.approved in (".$search['approved'].")";	
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$year = 0;//date('Y',strtotime(fmDateSave($search['fromdate'])));
		$sql = "SELECT al.id, e.code,e.identity , e.fullname, d.departmanet_name, e.departmentid, al.time_start, al.time_end, dg.departmentgroup_name, e.group_work_id, e.positionid, al.description, al.approved, al.approved_description, al.approved_date,
		(
			SELECT e.rest_day as total
				FROM `".$tb['hre_empleaveshow']."` e
				where e.employeeid = al.employeeid
				and e.time_start like '$year%'
				order by e.datecreate desc
				limit 1
				
		) total, us.fullname as fullnameapproved
				from `".$tb['hre_applicationforleave']."` al
				left join `".$tb['hre_employee']."`  e on e.id = al.employeeid
				left join  hre_users us on us.id = al.approved_userid
				left join `".$tb['hre_department']."` d on d.id = al.departmentid
				left join `".$tb['hre_departmentgroup']."` dg on dg.id = e.group_work_id
				WHERE al.isdelete = 0 
				$searchs
				and d.isdelete = 0
				and e.isdelete = 0
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY e.datecreate DESC ';
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
				from `".$tb['hre_applicationforleave']."` al
				left join `".$tb['hre_employee']."`  e on e.id = al.employeeid
				left join `".$tb['hre_department']."` d on d.id = al.departmentid
				WHERE al.isdelete = 0 
				$searchs
				and d.isdelete = 0
				and e.isdelete = 0
				";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function saves($search){
		$tb = $this->base_model->loadTable();
		$array = array();
		$code = $search['code'];
		$login = $this->login;
		$departmentid = $login['departmentid'];
		if(strtotime(fmDateTimeSave($search['time_start'])) > strtotime(fmDateTimeSave($search['time_end']))){
			return -3;
		}
		$items = $this->model->table($tb['hre_employee'])->select('id,sex,departmentid,branchid')
							 ->where('code',$code)
							 ->where('isdelete',0)
							 ->find();
		if(empty($items->id)){
			return -2;
		}
		else{
			//Chekc duplicate
			$check = $this->model->table($tb['hre_applicationforleave'])
								 ->select('id')
								 ->where('employeeid',$items->id)
								 ->where('time_start',fmDateTimeSave($search['time_start']))
								 ->find();
			if(!empty($check->id)){
				return -1;
			}			
			$arrInsert = array();
			$arrInsert['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
			$arrInsert['usercreate'] = $search['usercreate'];
			$arrInsert['employeeid'] = $items->id;
			$arrInsert['approved'] = -1;
			$arrInsert['departmentid'] =  $items->departmentid;
			$arrInsert['branchid'] =  $items->branchid;
			$arrInsert['time_start'] = fmDateTimeSave($search['time_start']); 
			$arrInsert['time_end'] = fmDateTimeSave($search['time_end']); 
			$arrInsert['description'] = $search['description'];
			//datecheck
			$this->model->table($tb['hre_applicationforleave'])->insert($arrInsert);
			return 1;
		}
	}
	function edits($search,$id){	
		$tb = $this->base_model->loadTable();
		 $array = array();
		 $array['datecreate_approved'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		 $array['usercreate_approved'] = $search['userupdate'];
		 $array['description'] = $search['description'];
		 $result = $this->model->table($tb['hre_applicationforleave'])
							   ->where('id',$id)
							   ->where('approved',-1)
							   ->update($array);	
		 //Duyệt nghỉ phép cập nhật dữ liệu qua bảng nghỉ phép
		 return $id;
	 }
}
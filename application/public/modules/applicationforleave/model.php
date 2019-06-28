<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class ApplicationforleaveModel extends CI_Model
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
		if($login['grouptype'] == 4){//Group nhan vien
			$sql.= " and al.employeeid in (".$login['employee']['employeeid'].") ";
		} 
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$year = 0; // date('Y',strtotime(fmDateSave($search['fromdate'])));
		$sql = "SELECT al.id, al.numberof , e.code,e.identity , e.fullname, d.departmanet_name, e.departmentid, al.time_start, al.time_end, dg.departmentgroup_name, e.group_work_id, e.positionid, al.description, al.approved, al.approved_description, al.approved_date,
		(
			SELECT e.rest_day as total
				FROM `".$tb['hre_empleaveshow']."` e
				where e.employeeid = al.employeeid
				and e.time_start like '$year%'
				order by e.datecreate desc
				limit 1
				
		) total, us.fullname as fullnameapproved
				from `".$tb['hre_applicationforleave']."` al
				left join  `".$tb['hre_employee']."` e on e.id = al.employeeid
				left join  hre_users us on us.id = al.approved_userid
				left join `".$tb['hre_department']."`  d on d.id = al.departmentid
				left join `".$tb['hre_departmentgroup']."`  dg on dg.id = e.group_work_id
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
				left join  `".$tb['hre_employee']."` e on e.id = al.employeeid
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
			//Lấy danh sách ngày nghỉ
			$listDate =  $this->base_model->getListDay(fmDateTimeSave($search['time_start']),fmDateTimeSave($search['time_end']));
			//Lấy ca làm việc
			$sqlShift = "
				SELECT e.shiftid, s.time_star, s.time_end_am, s.time_star_pm, s.time_end, s.hours_1, s.hours_2, s.between_shift
					FROM `".$tb['hre_employee']."` e
					left join `".$tb['hre_shift']."`  s on e.shiftid = s.id
					where e.id = '".$items->id ."'
					;
			";
			$queryShift = $this->model->query($sqlShift)->execute();
			#region tính số ngày nghỉ
			if(empty($queryShift[0]->shiftid)){
				return -5;
			}
			$time_star = $queryShift[0]->time_star; //Đầu giờ sáng
			$time_end_am = $queryShift[0]->time_end_am; //Cuối buổi sáng
			$time_star_pm = $queryShift[0]->time_star_pm; //Đầu giờ chiếu
			$time_end = $queryShift[0]->time_end; //Cuối ngày
			$between_shift = $queryShift[0]->between_shift; //Giua ca
			
			$time_off_start = fmDateTimeSave($search['time_start']); //Bắt đầu nghỉ
			$time_off_end = fmDateTimeSave($search['time_end']); //Kết thúc ngày nghỉ
			$tongthoigianlamviec = $queryShift[0]->hours_1 + $queryShift[0]->hours_2; 
			$songaynghi = 0;
			if(count($listDate) == 1){//nếu nghỉ 1 ngày
				$dateOff = $listDate[0];
				$cuoiCa = fmDateSave($dateOff).' '.$time_end;
				if(strtotime($time_off_end) >= strtotime($cuoiCa)){//Nghỉ cả ngày
					$time_off_end = $cuoiCa;
					$songaynghi = 1;
				}
				else{//Nghỉ ít hơn 1 ngày
					//Thòi gian nghi giu ca 
					$songaynghis = ((strtotime($time_off_end) - strtotime($time_off_start))/3600) - $between_shift;
					if($tongthoigianlamviec == $songaynghis){
						$songaynghi = 1;
					}
					else{
						$songaynghi = round(($songaynghis/$tongthoigianlamviec),2);
					}
				}
				//Tính thời gian nghỉ
			}
			else{//Nghỉ nhiều hơn 1 ngày
				$i = 1; $j = count($listDate);
				$songaynghi = 0;
				foreach($listDate as $key => $val){
					if($i==1){
						$ngaydautien = fmDateSave($time_off_start).' '.$time_end;
						$songaynghis = ((strtotime($ngaydautien) - strtotime($time_off_start))/3600) - $between_shift;
						if($tongthoigianlamviec == $songaynghis){
							$songaynghi+= 1;
						}
						else{
							$songaynghi+= round(($songaynghis/$tongthoigianlamviec),2);
						}
					}
					elseif($i==$j){//Ngày cuối cùng
						$ngaycuoicung = fmDateSave($time_off_end).' '.$time_star;
						$songaynghis = ((strtotime($time_off_end) - strtotime($ngaycuoicung))/3600) - $between_shift;
						if($tongthoigianlamviec == $songaynghis){
							$songaynghi+= 1;
						}
						else{
							$songaynghi+= round(($songaynghis/$tongthoigianlamviec),2);
						}
					}
					else{
						$songaynghi+=1;
					}
					$i++;
				}
			}
			#end
			$arrInsert = array();
			$arrInsert['date_count']  = $songaynghi;
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
		 if(strtotime(fmDateTimeSave($search['time_start'])) > strtotime(fmDateTimeSave($search['time_end']))){
			return -3;
		 }
		 $items = $this->findID($id);
		 $check = $this->model->table($tb['hre_applicationforleave'])
							 ->select('id')
							 ->where('employeeid',$items->id)
							 ->where('id <>',$id)
							 ->where('time_start',fmDateTimeSave($search['time_start']))
							 ->find();
		if(!empty($check->id)){
		 	return -1;
		}		
		//Lấy ca làm việc
		$sqlShift = "
			SELECT e.shiftid, s.time_star, s.time_end_am, s.time_star_pm, s.time_end, s.hours_1, s.hours_2, s.between_shift
				FROM `".$tb['hre_employee']."` e
				left join `".$tb['hre_shift']."`  s on e.shiftid = s.id
				where e.id = '".$items->id ."'
				;
		";
		$queryShift = $this->model->query($sqlShift)->execute();
		//Kiểm tra hợp hệ ngày numberof
		$listDate =  $this->base_model->getListDay(fmDateTimeSave($search['time_start']),fmDateTimeSave($search['time_end']));
		#region tính số ngày nghỉ
			if(empty($queryShift[0]->shiftid)){
				return -5;
			}
			$time_star = $queryShift[0]->time_star; //Đầu giờ sáng
			$time_end_am = $queryShift[0]->time_end_am; //Cuối buổi sáng
			$time_star_pm = $queryShift[0]->time_star_pm; //Đầu giờ chiếu
			$time_end = $queryShift[0]->time_end; //Cuối ngày
			$between_shift = $queryShift[0]->between_shift; //Giua ca
			
			$time_off_start = fmDateTimeSave($search['time_start']); //Bắt đầu nghỉ
			$time_off_end = fmDateTimeSave($search['time_end']); //Kết thúc ngày nghỉ
			$tongthoigianlamviec = $queryShift[0]->hours_1 + $queryShift[0]->hours_2; 
			$songaynghi = 0;
			if(count($listDate) == 1){//nếu nghỉ 1 ngày
				$dateOff = $listDate[0];
				$cuoiCa = fmDateSave($dateOff).' '.$time_end;
				if(strtotime($time_off_end) >= strtotime($cuoiCa)){//Nghỉ cả ngày
					$time_off_end = $cuoiCa;
					$songaynghi = 1;
				}
				else{//Nghỉ ít hơn 1 ngày
					//Thòi gian nghi giu ca 
					$songaynghis = ((strtotime($time_off_end) - strtotime($time_off_start))/3600) - $between_shift;
					if($tongthoigianlamviec == $songaynghis){
						$songaynghi = 1;
					}
					else{
						$songaynghi = round(($songaynghis/$tongthoigianlamviec),2);
					}
				}
				//Tính thời gian nghỉ
			}
			else{//Nghỉ nhiều hơn 1 ngày
				$i = 1; $j = count($listDate);
				$songaynghi = 0;
				foreach($listDate as $key => $val){
					if($i==1){
						$ngaydautien = fmDateSave($time_off_start).' '.$time_end;
						$songaynghis = ((strtotime($ngaydautien) - strtotime($time_off_start))/3600) - $between_shift;
						if($tongthoigianlamviec == $songaynghis){
							$songaynghi+= 1;
						}
						else{
							$songaynghi+= round(($songaynghis/$tongthoigianlamviec),2);
						}
					}
					elseif($i==$j){//Ngày cuối cùng
						$ngaycuoicung = fmDateSave($time_off_end).' '.$time_star;
						$songaynghis = ((strtotime($time_off_end) - strtotime($ngaycuoicung))/3600) - $between_shift;
						if($tongthoigianlamviec == $songaynghis){
							$songaynghi+= 1;
						}
						else{
							$songaynghi+= round(($songaynghis/$tongthoigianlamviec),2);
						}
					}
					else{
						$songaynghi+=1;
					}
					$i++;
				}
			}
		#end
		$array = array();
		$array['date_count'] = $songaynghi;
		$array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
		$array['userupdate'] = $search['userupdate'];
		$array['time_start'] = fmDateTimeSave($search['time_start']); 
		$array['time_end'] = fmDateTimeSave($search['time_end']); 	
		$array['description'] = $search['description'];
		$result = $this->model->table($tb['hre_applicationforleave'])
							   ->where('id',$id)
							   ->where('approved',-1)
							   ->update($array);	
		 return $id;
	 }
}
 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Payrolldetail extends CI_Controller {
	public $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model','excel_model'));
        $this->phonedetail = 'hre_processdetail';
		$this->login = $this->site->getSession('glogin');
		$this->route = $this->router->class;
		$this->load->library('upload');
    }
    function _remap($method, $params = array()) {
        $id = $this->uri->segment(2);
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
    function _view() {
		$data = new stdClass();
        $login = $this->login;
        if (!isset($login['id'])){
			redirect(base_url());
		}
		$permission = $this->base_model->getPermission($this->login, $this->route);
        if(!isset($permission['view'])) {
            redirect('authorize');
        }
		$data->permission = $permission;
        $data->routes = $this->route; 
		$data->insurance = $this->model->getInsurance();
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->allowances = $this->model->getAllowance();
		$data->endoffmonths = $this->model->getEndoffmonth();
		#gegion add log
		$data->datenow = gmdate(configs('cfdate'), time() + 7 * 3600);
		$ctrol = getLanguage('bang-tinh-luong');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function getPriceDetail() {
        $endoffmonthid = $this->input->post('endoffmonthid');
		$code = $this->input->post('code');
		$identity = $this->input->post('cmnd');
		$employeeid = $this->model->findID($code,$identity);
        $data = new stdClass();
        $result = new stdClass();
		$data->allowances = $this->model->getAllowance();
		$allowanceSalarys = $this->model->getAllowanceSalary($endoffmonthid,$employeeid);
		$data->salarys = $this->model->getSalary($endoffmonthid,$employeeid);
		$data->insurance = $this->model->getInsurance();
		$data->insuranceValue = $this->model->getInsuranceValue($endoffmonthid,$employeeid);
		$arrays = array();
		foreach($allowanceSalarys as $item){
			$arrays[$item->allowanceid] = $item->salary;
		}
		$data->timeSheet = $this->model->getTimesheetsMonth($endoffmonthid);
		//Public Salary
		$arr_Public = array();
		$data->salaryPublic = $this->model->getPublicSalary($endoffmonthid, $employeeid);
		$data->allowanceSalarys = $arrays;

        $result->content = $this->load->view('list', $data, true);
        echo json_encode($result);
    }
}
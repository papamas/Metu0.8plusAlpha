<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Administration extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('Mediatutorialauth', 'Administrationmenu', 'Administrationcontent', 'Mediatutorialheader'));
            $this->load->helper(array('html','form', 'url'));
	}
        
        function index(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		$sub_data_1 = array(
			'header' => 'Administration',
			'content' => $this->Administrationcontent->content_home()
		);
		
		$sub_data_2 = array(
			'header' => 'Mediatutorial Update',
			'content' => $this->Administrationcontent->content_mediatutorial()
		);
		
		$data = array(
			'title' => 'Home Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data_1, true).$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data_2, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
			
        }
	
	function site(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		//
		$sub_data = array(
			'header' => 'Site Management',
			'content' => $this->Administrationcontent->content_site()
		);
		$data = array(
			'title' => 'Site Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
	}
	
	function user(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		//
		$sub_data = array(
			'header' => 'User Management',
			'content' => $this->Administrationcontent->content_user()
		);
		$data = array(
			'title' => 'User Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
	}
	
	function modules(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		//
		$sub_data = array(
			'header' => 'Modules Management',
			'content' => $this->Administrationcontent->content_modules()
		);
		$data = array(
			'title' => 'Modules Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
	}
	
	function builder(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		//
		$sub_data = array(
			'header' => 'Builder Management',
			'content' => $this->Administrationcontent->content_builder()
		);
		$data = array(
			'title' => 'Builder Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
	}
	
	function support(){
		if($this->Mediatutorialauth->check_logged()!='admin')
		    redirect(base_url().'login/');
		//
		//
		$sub_data = array(
			'header' => 'Support Management',
			'content' => $this->Administrationcontent->content_support()
		);
		$data = array(
			'title' => 'Support Administration',
			'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_admin_designbox', $sub_data, true)
		);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_admin_output_html', $data);
	}
	
}
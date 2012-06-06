<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Login extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('Mediatutorialheader', 'Mediatutorialmenu'));
            $this->load->helper(array('html','form', 'url'));
	    
	}
        
        function index(){
		if($this->Mediatutorialauth->check_logged()!= false)
			redirect(base_url().'member_area/');
			
		$sub_data['header'] ='Login form';
		$sub_data_form['login_failed'] ='';
		$sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_login_form',$sub_data_form, true);
		
		if($this->input->post('submit_login')) {
			$this->form_validation->set_rules('email', 'email', 'trim|required|min_length[3]|max_length[50]|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[35]|xss_clean');
			$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
			
			if ($this->form_validation->run() == FALSE){
				$sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_login_form',$sub_data_form , true);
			}
			else{
				$login_array = array($this->input->post('email'), $this->input->post('password'));
				if($this->Mediatutorialauth->process_login($login_array)==true)
				{
					//login successfull
					redirect(base_url().'member_area/');
				}
				elseif($this->Mediatutorialauth->process_login($login_array)=='not_activated'){
					$sub_data_form['login_failed'] = "Account not activated yet, please open your email";
					$sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_login_form',$sub_data_form , true);
				}
				else{
					$sub_data_form['login_failed'] = "Invalid email or password";
					$sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_login_form',$sub_data_form , true);
				}
			}
			
		}
		$data = array(
				'title' => 'Login',
				'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox', $sub_data, true)
			);
		$this->load->view($this->Mediatutorialheader->get_site_template().'_output_html', $data);
        }
        function logout(){
            $this->session->sess_destroy();
	    redirect(base_url().'login/');
        }
}
?>
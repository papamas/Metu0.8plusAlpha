<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Register extends CI_Controller {
    function __construct()
    {
            parent::__construct();	
            $this->load->library(array('form_validation'));
            $this->load->model(array('Mediatutorialheader', 'Mediatutorialcaptcha', 'Mediatutorialmenu', 'Mediatutorialutils'));
            $this->load->helper(array('form', 'url'));
            $this->load->database();
    }

    function index(){
	@include(CACHEPATH.'sys_metu_db.php');
	
        if($this->Mediatutorialauth->check_logged()!= false)
            redirect(base_url().'member_area/');
            
        $sub_data['header'] = 'Join';
        $sub_data_form['captcha_return'] ='';
        $sub_data_form['cap_img'] = $this ->Mediatutorialcaptcha->make_captcha();
        $sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_join_form',$sub_data_form, true);
	//
        if($this->input->post('submit')) {
            $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[3]|max_length[50]|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'atches[password_2]|trim|required|min_length[3]|max_length[20]|xss_clean');
	    $this->form_validation->set_rules('password_2', 'Retype Password', 'matches[password]|trim|required| min_length[3]|max_length[20]|xss_clean');
            $this->form_validation->set_rules('email', 'Email',  'trim|required|min_length[3]|max_length[50]|valid_email');
	    $this->form_validation->set_rules('sex', 'Sex', 'trim|required');
	    $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[3]|max_length[500]|xss_clean');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required');
            if ($this->form_validation->run() == FALSE){
                $sub_data['content']  = $this->load->view($this->Mediatutorialheader->get_site_template().'_join_form', $sub_data_form, true);
            }
            else{
                if($this->Mediatutorialcaptcha->check_captcha()==TRUE){
                    $fullname = ucwords($this->input->post('fullname'));
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
		    $sex = $this->input->post('sex');
		    $description = $this->input->post('description');
                    $check_query = "SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `email`='$email'";
                    $query = $this->db->query($check_query);
                    if ($query->num_rows() > 0){
                        $sub_data_form['captcha_return'] = 'Maap, email yang anda masukan telah digunakan pihak lain, silahkan ganti<br/>';
                        $sub_data['content']  = $this->load->view($this->Mediatutorialheader->get_site_template().'_join_form', $sub_data_form, true);
                    }
                    else{
                        $rand_salt = $this->Mediatutorialutils->genRndSalt();
                        $encrypt_pass = $this->Mediatutorialutils->encryptUserPwd( $this->input->post('password'),$rand_salt);
			$code_activation = $this->Mediatutorialutils->genRndSalt(8,false);
                        $input_data = array(
                            'fullname' => $fullname,
                            'password' => $encrypt_pass,
                            'email' => $email,
			    'sex' => $sex,
			    'description' => $description,
                            'salt' => $rand_salt,
			    'activation' => 0,
			    'code_activation' => $code_activation
                        );
                        if($this->db->insert("{$metu_db['dbprefix']}user", $input_data)){
			    $this->load->model('Mediatutorialheader');
			    $site_details = $this->Mediatutorialheader->site_details();
    
			    //
			    $sender_email = $site_details['site_email'];
			    $sender_name = $site_details['site_title'];
			    $link = base_url()."register/activate/".$code_activation;
			    $subject = 'Registration Activation';
			    $body = "Silahkan click link di bawah ini untuk confirmasi pendaftaran<br/><a href=\"".$link."\" target=\"_blank\">".$link."</a><br/><br/>Regards,";
			    $this->Mediatutorialutils->sendMail($sender_email, $sender_name, $email, $subject, $body);
			    //
                            $sub_data['content']  = "join success, silahkan check email anda di ".$email."<br/>";
                        }
                        else 
                            $sub_data['content']  = "error on query";
                    }
                }
                else{
                        $sub_data_form['captcha_return'] = 'Maap captcha salah<br/>';
                        $sub_data['content']  = $this->load->view($this->Mediatutorialheader->get_site_template().'_join_form', $sub_data_form, true);
                }
          }

        }
        $data = array(
                'title' => 'Join',
                'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox', $sub_data, true)
        );
	$this->load->view($this->Mediatutorialheader->get_site_template().'_output_html', $data); 
    }
    
    function activate($code){
	@include(CACHEPATH.'sys_metu_db.php');
	
	$content = '';
	$check_query ="SELECT COUNT(ID) FROM `{$metu_db['dbprefix']}user` WHERE `code_activation` = '{$code}'";
	$update_query ="UPDATE `{$metu_db['dbprefix']}user` SET `activation` = '1' WHERE `code_activation` = '{$code}'";
	//
	$query = $this->db->query($check_query);
	if ($query->num_rows() > 0){
	    if($this->db->query($update_query))
		$content = 'User telah active, silahkan login';
	    else
		$content = 'Maap, error saat update activation';
	}
	else $content = 'Maap, user tidak terdaftar';
	
	$sub_data_notification['notification'] = $content;
	$sub_data['header'] = 'Activation';
        $sub_data['content'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_notification',$sub_data_notification, true);
	
	$data = array(
                'title' => 'Join Activation',
                'body' => $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox', $sub_data, true)
        );
	$this->load->view($this->Mediatutorialheader->get_site_template().'_output_html', $data); 
    }
}
?>
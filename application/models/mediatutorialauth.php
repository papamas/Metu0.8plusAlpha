<?php
/***************************************************************************
* Mediatutorial.web.id
*
* di sini untuk passwordnya tidak kita encrypsi
***************************************************************************/

class Mediatutorialauth extends CI_Model {

    function __construct()
    {
        parent::__construct();
            $this->load->library('session');
	    $this->load->database();
            $this->load->helper('url');
	    $this->load->model(array('Mediatutorialutils'));
    }

	/***************
	* fungsi untuk process dari form login
	* 
	***************/
	function process_login($login_array_input = NULL){
	    @include(CACHEPATH.'sys_metu_db.php');
	    
            if(!isset($login_array_input) OR count($login_array_input) != 2)
                return false;
            //set variable nya
            $email = $login_array_input[0];
            $password = $login_array_input[1];
            //ambil dari database percobaan
            $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `email`= '{$email}' LIMIT 1");
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                $user_id = $row->ID;
                $user_pass = $row->password;
		$user_access = $row->access;
		$user_salt = $row->salt;
                if($this->Mediatutorialutils->encryptUserPwd( $password,$user_salt) === $user_pass){
		    if($row->activation == 0){
			return 'not_activated';
		    }
		    else{
			if($user_access == 1)
			    $this->session->set_userdata('admin_logged_user', $user_id);
			else
			    $this->session->set_userdata('logged_user', $user_id);
			return true;
		    }
                }
                return false;
            }
            return false;
	}
	
	/***************
	* fungsi untuk apakah user telah logged atau belum
	* Juga digunakan apakah yang login betul betul admin terutama di halaman administration
	***************/
	function check_logged(){
	    if ($this->session->userdata('admin_logged_user'))
		return 'admin';
	    elseif ($this->session->userdata('logged_user'))
		return 'user';
	    else
		return false;
	}
	
	/***************
	* fungsi untuk mereturn id user yang sedang login
	* 
	***************/
	function logged_id(){
	    if ($this->session->userdata('admin_logged_user'))
		return $this->session->userdata('admin_logged_user');
	    elseif ($this->session->userdata('logged_user'))
		return $this->session->userdata('logged_user');
	    else
		return '';
	}
}
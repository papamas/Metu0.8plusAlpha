<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Profile extends CI_Controller {
    function __construct()
    {
        parent::__construct();	
        $this->load->library(array('session', 'form_validation'));
        $this->load->model(array('Mediatutorialheader', 'Mediatutorialmenu', 'Mediatutorialprofile'));
        $this->load->helper(array('html','form', 'url'));
    }
    
    /*
     Fungsi ini akan menampilkan profile kita
     bila ID = '' maka akan menampilkan profile kita yang login
     bila ID = 13 maka akan menampilkan profile dari user dengan ID 13
    */
    function index($ID = ''){
        
    }
    
    /*
     Fungsi ini diexecute di ajax
     $edit = untuk mode edit
     $change_email_pass = untuk edit email dan password
    */
    function show_details($edit = '', $change_email_pass = ''){
        @include(CACHEPATH.'sys_metu_db.php');
        
        if($this->Mediatutorialauth->check_logged() == false){
            $data['error_message'] = 'Maap, silahkan login terlebih dahulu';
            $error = $this->load->view($this->Mediatutorialheader->get_site_template().'_error_alert', $data, true);
            echo $error;
            exit;
        }
        $logged_id = $this->Mediatutorialauth->logged_id();
        $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `ID`='".$logged_id."'");
        
        $ret = '';
        if($edit == 'edit'){
            
            if($_POST){ //sama dengan //if($this->input->post('submit')) 
                $ret = '';
                $input_data_key = array();
                $input_data_value = array();
                //
                foreach($_POST as $key =>$value){
                    if($key == 'edit' || $key == 'access')//kita gak punya row edit, nih cuman trick ajach
                        continue;
                    else if($key == 'email')
                        $this->form_validation->set_rules('email', 'Email',  'trim|required|min_length[3]|max_length[50]|valid_email');
                    else if($key == 'password'){
                        $row_db = $query->row_array();
                        $this->form_validation->set_rules('password', 'Password', 'matches[password]|trim|required| min_length[3]|max_length[20]|xss_clean');
                        $rand_salt = $row_db['salt'];
                        $value = $this->Mediatutorialutils->encryptUserPwd( $value,$rand_salt);
                    }
                    else if($key == 'fullname'){
                        $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|min_length[3]|max_length[50]|xss_clean');
                        $value = ucwords($value);
                    }
                    else
                        $this->form_validation->set_rules($key, ucfirst($key), 'trim|required|min_length[3]|max_length[500]|xss_clean');
                    //
                    if ($this->form_validation->run() == FALSE){
                        echo '<div class="error">'.validation_errors().'</div>'; //jangan pakai $ret .=
                        exit;
                    }
                    array_push($input_data_key, $key);
                    array_push($input_data_value, $value);
                }
                //
                $input_data = array_combine($input_data_key, $input_data_value);
                //print_r ($input_data);
                
                $this->db->where('ID', $logged_id);
                if($this->db->update("{$metu_db['dbprefix']}user", $input_data)){
                    //mari update cache
                    $this->Mediatutorialprofile->updateUserCache();
                    $ret .= '<script type="text/javascript">$(".error").remove();</script> <div class="done">Saved</div>';
                }
                else 
                    $ret .= 'Error on query, try again later<br/>';
               
                echo $ret;
            }
            else{
                $form = '';
                $onclick = "cancel_edit_detail();";
                $form .= $this->Mediatutorialmenu->create_icon_link('#','cancel_edit.gif' ,$onclick, 'Cancel edit', 'Cancel edit' );
                foreach ($query->result_array() as $row){
                    foreach($row as $key => $value){
                        if($change_email_pass != ''){
                            if($key != 'email' && $key != 'password')
                                continue;
                        }
                        else if($change_email_pass == ''){
                            if($key == 'ID' || $key == 'email' || $key == 'password' || $key == 'salt' || $key == 'edit' || $key == 'access' || $key == 'activation' || $key == 'code_activation' || $key == 'profile_pic')
                            continue;
                        }
                        
                        //
                        if($key == 'password'){
                            $data_password = array(
                                'name' => $key,
                                'value' => '********',
                                'id' => $key
                            );
                            $value = form_input($data_password);
                        }
                        else if($key == 'sex'){
                            $options = array(
                                    'male' => 'male',
                                    'female' => 'female'
                                );
                            $selected = $value;
                            $id = 'id="'.$key.'"';
                            $value = form_dropdown('sex', $options, $selected, $id);
                        }
                        else if($key == 'description'){
                            $data_textarea = array(
                                'name' => $key,
                                'value' => $value,
                                'rows' => 6,
                                'cols' => 20,
                                'id' => $key
                            );
                            $value = form_textarea($data_textarea);
                        }
                        else{
                            $data_input = array(
                                'name' => $key,
                                'value' => $value,
                                'id' => $key
                            );
                            $value = form_input($data_input);
                        }
                            
                        //
                        $form .= '<tr><td>'.ucfirst($key).'</td><td>'.$value.'</td></tr>';
                    }
                }
                $what = ($change_email_pass == '')?'common':'pass';
                $data_submit = array(
                    'name' => 'submit',
                    'value' => 'Edit',
                    'onclick' => 'submit_edit(\''.$what.'\');return false;'
                );
                $form .= '<tr><td></td><td>'.form_submit($data_submit).'<span id="submit_loading"></span></td></tr>';
                //
                $data_table = array(
                    'tr_td' => $form
                );
                $data = array(
                    'action_url' => base_url().'profile/show_details/edit/',
                    'table_form' => $this->load->view($this->Mediatutorialheader->get_site_template().'_simple_table', $data_table, true)
                );
                $this->load->view($this->Mediatutorialheader->get_site_template().'_simple_form', $data);
            }
        }
        else{
            $ret .= $this->Mediatutorialmenu->create_icon_link('#','edit.png' ,'edit_detail();', 'Edit', 'Edit Profile details' );
            $ret .= '&nbsp;&nbsp;&nbsp;'. $this->Mediatutorialmenu->create_icon_link('#','edit_pass.png' ,'edit_detail_pass();', 'Edit', 'Edit password dan email' );
            foreach ($query->result_array() as $row){
                foreach($row as $key => $value){
                    if($key == 'ID' ||$key == 'email' || $key == 'password' || $key == 'salt' || $key == 'edit' || $key == 'access' || $key == 'activation' || $key == 'code_activation' || $key == 'profile_pic')
                        continue;
                    $ret .= '<tr><td>'.ucfirst($key).'</td><td>"'.$value.'"</td></tr>';
                }
               
               /*
                //atau pakai ini
               while (list($key, $value) = each($row)) {
                    if($key == 'ID' || $key == 'password' || $key == 'salt')
                        continue;
                    $ret .= '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
               }
               */
    
            }
            $data['tr_td'] = $ret;
            $this->load->view($this->Mediatutorialheader->get_site_template().'_simple_table', $data);
            
        }
    }
}
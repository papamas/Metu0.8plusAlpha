<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Member_area extends CI_Controller {
    function __construct()
    {
        parent::__construct();	
        $this->load->library(array('session'));
        $this->load->model(array('Mediatutorialheader', 'Mediatutorialmenu', 'Mediatutorialaccount'));
        $this->load->helper(array('html','url'));
    }
    
    function index(){
        global $metu_db;
        
        if($this->Mediatutorialauth->check_logged()=== FALSE)
            redirect(base_url().'login/');
        else{
            $data['title'] = 'Member only';
            $sub_data = array(
                'extra_script' => $this->Mediatutorialaccount->extra_script(),
                'box_shadowed_content' => $this->load->view($this->Mediatutorialheader->get_site_template().'_account_cropping','',true),
                'column_1'  => $this->Mediatutorialaccount->update_status(),
                'column_2'  => $this->Mediatutorialaccount->profile_detail()
            );
            $data['body'] = $this->load->view($this->Mediatutorialheader->get_site_template().'_member_area', $sub_data, true);
            $this->load->view($this->Mediatutorialheader->get_site_template().'_output_html', $data);
        }
    }
    
}
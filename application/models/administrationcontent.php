<?php
/***************************************************************************
* Mediatutorial.web.id
*
* di sini untuk passwordnya tidak kita encrypsi
***************************************************************************/

class Administrationcontent extends CI_Model {
    function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->helper(array('url','html'));
            $this->load->model(array('Mediatutorialauth', 'Mediatutorialheader'));
    }
    
    function content_home(){
        @include(CACHEPATH.'sys_metu_db.php');
        $ret = '';
        $ret_metu = '';
        //MeTu+ options
        $metu_options = $this->Mediatutorialheader->structure_core();
        $check_update = anchor('http://sourceforge.net/projects/metu/', 'Check Update', 'target="_blank"');
        
        //Mediatutorial options
        $mediatutorial_options = array(
            'fb'    => 'https://facebook.com/mediatutorial',
            'tw'   => 'http://twitter.com/media_tutorial',
            'g+'     => 'https://plus.google.com/113742631977844792525'
        );
        
        //users options
        $query_members = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user`");
        $query_notactive = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `activation`!= '1'");
        $all_members = $query_members->num_rows();
        $not_activate = $query_notactive->num_rows();
        $users_array = array(
            'All Members' => $all_members,
            'Unactivated' => $not_activate
        );
        
        //contents metu
        $ret_metu .= '<b>MeTu+ Engine</b><br/>';
        $ret_metu .='<table>';
        foreach($metu_options as $key => $value){
            $ret_metu .= '<tr><td>'.ucfirst($key).'</td><td>: '.$value.'</td></tr>';
        }
         $ret_metu .= '</table>';
         $ret_metu .= $check_update;
         $data = array(
            'content'   => $ret_metu
         );
         $ret_metu = $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox_2', $data, true);
         
         //contents mediatutorial
         $ret_mediatutorial = '<b>Mediatutorial Network</b>';
         $ret_mediatutorial .='<table>';
         
        foreach($mediatutorial_options as $key => $value){
            $ret_mediatutorial .= '<tr><td>'.ucfirst($key).'</td><td>: '.anchor($value, $value, 'target="_blank"').'</td></tr>';
        }
        $ret_mediatutorial .='</table>';
        $data = array(
            'content'   => $ret_mediatutorial
         );
         $ret_mediatutorial = $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox_2', $data, true);
         
         //contents users
         $ret_user = '';
         $ret_user .='<b>Users</b>';
         $ret_user .='<table>';
         foreach($users_array as $key => $value){
            $ret_user .= '<tr><td>'.ucfirst($key).'</td><td>: '.$value.'</td></tr>';
        }
         $ret_user .= '</table>';
         $data = array(
            'content'   => $ret_user
         );
         $ret_user = $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox_2', $data, true);
         
        return $ret_metu.$ret_mediatutorial.$ret_user;
    }
    
    function content_site(){
        return 'content site';
    }
    
    function content_user(){
        return 'content user';
    }
    
    function content_modules(){
        return 'content modules';
    }
    
    function content_builder(){
        return 'content builder';
    }
    
    function content_support(){
        return 'content support';
    }
    
    function content_mediatutorial(){
        $website = 'http://www.mediatutorial.web.id/';
        $total = 20;
        $vendor_and_module_name= 'mediatutorial/toc_mediatutorial_web_id';

        $data = array(
            'website' => $website,
            'total_news' => $total
        );
        return $this->load->view($this->Mediatutorialheader->get_module_template($vendor_and_module_name).'_template', $data, true);
    }
}

<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Mediatutorialprofile extends CI_Model {
    function __construct()
    {
        parent::__construct();	
        $this->load->library(array('session'));
        $this->load->model(array('Mediatutorialauth'));
        $this->load->helper(array('html','url'));
    }
    
    /*fungsi untuk menampilkan link profile
     contoh:
     http://structurecore/templates/images/male.jpg
     http://structurecore/media/photo_profile/1.jpg
     
     $mode = '', 'icon'
    */
    function getProfilePic($ID='', $mode=''){
       
        $photo_profile_url = base_url().'media/photo_profile/';
        $templates_image = base_url().'templates/'.$this->Mediatutorialheader->get_site_template("short").'images/'; 
        //
        $user_info = $this->getProfileInfo();
        $user_profile_pic = ($mode =='icon')?$photo_profile_url.'icon_'.$user_info['profile_pic']:$photo_profile_url.$user_info['profile_pic'];
        $user_default_pic = $templates_image.$user_info['sex'].'_thumb.jpg';
        //
        if($user_info['profile_pic'] == '' || $user_info['profile_pic'] == 0)
            return $user_default_pic;
        else
            return $user_profile_pic;
        
    }
    
    /*
     fungsi untuk men-generate profile thumb dan profile icon
     $ID = ID dari pengguna
     $mode = '', 'icon', 'with_status'
    */
    function genProfileThumb($ID='', $mode=''){
         if($ID == '')
            $ID = $this->Mediatutorialauth->logged_id();
        
        $user_info = $this->getProfileInfo($ID);
        //
        switch ($mode){
            case 'icon':
            $tmpl = '_thumbnail_icon';
            $recent_status = '';
            $recent_profilepic = $this->getProfilePic($ID, 'icon');
            break;
        
            case 'with_status':
            $tmpl = '_thumbnail_with_status';
            $recent_status = '';
            $recent_profilepic = $this->getProfilePic($ID);
            break;
        
            default:
            $tmpl = '_thumbnail';
            $recent_status = '';
            $recent_profilepic = $this->getProfilePic($ID);
            break;
        
        }
        //
        $data = array(
            'recent_status' => $recent_status,
            'recent_profilepic' => img($recent_profilepic)
        );
        return $this->load->view($this->Mediatutorialheader->get_site_template().$tmpl, $data, true);
        
    }
    
    /*fungsi untuk menampilkan info dari user
    contoh:
    $infoku = $this->Mediatutorialprofile->getProfileInfo(1);
    $email = $infoku->email;
    $profile_pic = $infoku->profile_pic;
    $sex = $infoku->sex;
    
    */
    function getProfileInfo($ID=''){
        if($ID == '')
            $ID = (int)$this->Mediatutorialauth->logged_id();
        //
         if(file_exists(CACHEPATH.'user'.$ID.'.php')){
            @include(CACHEPATH.'user'.$ID.'.php');
            return $user;
        }
        else{
            @include(CACHEPATH.'sys_metu_db.php');
            $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `ID`= '{$ID}' LIMIT 1");
            if ($query->num_rows() > 0)
            {
                $row = $query->row_array();
                $this->Mediatutorialutils->create_cache_file('user'.$ID.'.php', $row, 'user');
                return $row;
            }
        }
    }
    
    /*
     fungsi ini digunakan untuk meng-update cache user dalam folder cache/
    */
    function updateUserCache($ID=''){
        if($ID == '')
            $ID = (int)$this->Mediatutorialauth->logged_id();

        @include(CACHEPATH.'sys_metu_db.php');
        $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user` WHERE `ID`= '{$ID}' LIMIT 1");
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $this->Mediatutorialutils->create_cache_file('user'.$ID.'.php', $row, 'user');
            return true;
        }
        return false;
    }
}
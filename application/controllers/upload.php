<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Upload extends CI_Controller {
    function __construct()
    {
        parent::__construct();	
        $this->load->library(array('session'));
        $this->load->model(array('Mediatutorialheader', 'Mediatutorialmenu', 'Mediatutorialaccount', 'Mediatutorialupload', 'Mediatutorialutils', 'Mediatutorialprofile'));
        $this->load->helper(array('html','url', 'form'));
        $this->load->database();
        //
        if($this->Mediatutorialauth->check_logged()=== FALSE)
            redirect(base_url().'login/');
    }
    
    function index(){
        
    }
    
    /*
     fungsi untuk upload image
     $mode= 'simple', 'multiple'
    */
    function upload_form($mode='simple' ,$ajax=true){
        $data = array(
            'action' => base_url().'upload/upload_profile_pic/'
        );
        $this->load->view($this->Mediatutorialheader->get_site_template().'_upload_'.$mode.'_form', $data);
    }
    
    function upload_profile_pic()
    {
        $ID = $this->Mediatutorialauth->logged_id();
        $user_info = $this->Mediatutorialprofile->getProfileInfo();
        //
        $file = 'userfile';
        $photo_profile_path = './media/photo_profile/';
        //
        $config['upload_path'] = $photo_profile_path.'temp/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '800';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $this->Mediatutorialauth->logged_id();

        $result = $this->Mediatutorialupload->upload_process($config, $file);
        if($result['status']=='error'){
            $ret = '
                            <script type="text/javascript">
                            alert(\'Upload error: '.$result['msg'].'\');
                            </script>
                        ';
                        echo $ret;
        }
        else{
            $file_uploaded_name = $result['msg']['file_name'];
            //
            $explode = explode('.', $file_uploaded_name); // kita cari extentionnya '.jpg'
            //
            $file_uploaded_newname =  $ID.'_'.$this->Mediatutorialutils->genRndDgt(5, false).'.'.$explode[1]; //buat random
            //
            $config['image_library'] = 'gd2';
            $config['source_image'] = $photo_profile_path.'temp/'.$file_uploaded_name;
            $config['new_image'] = $photo_profile_path.'temp/'.$file_uploaded_newname;
            $config['maintain_ratio'] = true;
            $config['width'] = 300;
            $config['height'] = 300;
            //
            $new_image_url = base_url().'media/photo_profile/temp/'.$file_uploaded_newname;
            //
            $result = $this->Mediatutorialupload->resize_process($config);
            if($result['status']=='error'){
                $ret = '
                            <script type="text/javascript">
                            alert(\'Resize to 300 x 300 error: '.$result['msg'].'\');
                            </script>
                        ';
                        echo $ret;
            }
            else{
                @unlink($config['source_image']);
                $ret = '
                    <script type="text/javascript">
                    parent.$(\'#btn_change\').fadeIn();
                    parent.$(\'#upload_form_pic\').fadeOut();
                    //
                    parent.$(\'#crop_photo\').attr(\'alt\',\''.$file_uploaded_newname.'\');
                    parent.$(\'#crop_photo\').attr(\'src\',\''.$new_image_url.'\');
                    parent.$(\'#crop_photo_preview\').attr(\'src\',\''.$new_image_url.'\');
                    parent.$(\'#box_shadowed_member_area\').fadeIn();
                    parent.window.generate_selection();
                    </script>
                ';
                echo $ret;
            }
        }
    }
        
    /*
     Fungsi untuk resize profile pic
     $filename = namafile
    */
    function crop_resize($filename, $x1, $y1, $w, $h){
        @include(CACHEPATH.'sys_metu_db.php');
        
        $ID = $this->Mediatutorialauth->logged_id();
        $user_info = $this->Mediatutorialprofile->getProfileInfo();
        //
        $photo_profile_path = './media/photo_profile/';  
        $photo_temp = './media/photo_profile/temp/';  
        $file_uploaded_name = $filename;
        //
        //Mari kita cropping terlebih dahulu
        $config['image_library'] = 'gd2';
        $config['source_image'] = $photo_profile_path.'temp/'.$file_uploaded_name;
        $config['maintain_ratio'] = FALSE;
        $config['x_axis'] = $x1;
        $config['y_axis'] = $y1;
        $config['width'] = $w;
        $config['height'] = $h;
        //
        $ret = $this->Mediatutorialupload->crop_process($config);
        if($ret['status']=='error'){
            $ret = '
                        <script type="text/javascript">
                        alert(\'Cropping error: '.$ret['msg'].'\');
                        </script>
                    ';
                    echo $ret;
        }
        else{
             //Mari kita resize ke 100 x 100 terlebih dahulu
             unset($config);
            $this->image_lib->clear();
            //
            $config['image_library'] = 'gd2';
            $config['source_image'] = $photo_profile_path.'temp/'.$file_uploaded_name;
            $config['new_image'] = $photo_profile_path.$file_uploaded_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 100;
            $config['height'] = 100;
            //
            $ret = $this->Mediatutorialupload->resize_process($config);
            
            if($ret['status']=='error'){
                $ret = '
                        <script type="text/javascript">
                        alert(\'Resize to 100 x 100 error: '.$ret['msg'].'\');
                        </script>
                    ';
                    echo $ret;
            }
            else{
                @unlink($config['source_image']);
                unset($config);
                $this->image_lib->clear();
                //
                //Nah, baru kita resize ke 50 x 50
                $config['image_library'] = 'gd2';
                $config['source_image'] = $photo_profile_path.$file_uploaded_name;
                $config['new_image'] = $photo_profile_path.'icon_'.$file_uploaded_name;
                $config['width'] = 50;
                $config['height'] = 50;
                //
                $ret = $this->Mediatutorialupload->resize_process($config);
                if($ret['status']=='error'){
                    $ret = '
                            <script type="text/javascript">
                            alert(\'Resize to 50 x 50 error: '.$ret['msg'].'\');
                            </script>
                        ';
                        echo $ret;
                }
                else{
                    //mari kita delete file lama
                    if($user_info['profile_pic'] !=0){
                        @unlink($photo_profile_path.$user_info['profile_pic']);
                        @unlink($photo_profile_path.'icon_'.$user_info['profile_pic']);
                    }
                    $data_update = array(
                        'profile_pic' => $file_uploaded_name
                    );
                    $this->db->where('ID', $ID);
                    if($this->db->update("{$metu_db['dbprefix']}user", $data_update)){
                        //mari updatecache
                        $this->Mediatutorialprofile->updateUserCache();
                        $image_properties = array(
                            'src' => base_url().'media/photo_profile/'.$file_uploaded_name,
                          );
                        $updated_image = img($image_properties);
                        
                        $new_img_url = base_url().'media/photo_profile/'.$file_uploaded_name;
                        $ret = '
                            <script type="text/javascript">
                            $(\'.pic_thumb\').html(\''.img($new_img_url).'\');
                            $(\'#btn_change\').fadeIn();
                            $(\'#upload_form_pic\').fadeOut();
                            //
                            </script>
                        ';
                        echo $ret;
                    }
                    //fungsi update database
                }
            }
        }
    }
    
    /*
     fungsi untuk action
     bila ingin save maka $x, $y, $w, $h harus diisi
     bila cancel maka tidak perlu diisi kecuali $action dan $object
    */
    function action_pic($action, $object, $x1='', $y1='', $w='', $h=''){
        $photo_temp = './media/photo_profile/temp/';
        //
        if($action == 'cancel')
            @unlink($photo_temp.$object);
        elseif($action == 'save'){
            $this->crop_resize($object, $x1, $y1, $w, $h);
        }
    }
    
    
}
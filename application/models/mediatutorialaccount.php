<?
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Mediatutorialaccount extends CI_Model {
    function __construct()
    {
        parent::__construct();	
        $this->load->library(array('session'));
        $this->load->model(array('Mediatutorialauth', 'Mediatutorialprofile'));
        $this->load->helper(array('html','url'));
    }
    
    function extra_script(){
        @include(CACHEPATH.'sys_metu_db.php');
        
        $i = 0;
        $separator = '';
        $divider = 2;
        $datapost = 'var datapost =\''; //var datapost = '?fullname='+fullname+'&description='+description+'&sex='+sex;
        $ret = '
            function submit_edit(what){
            if(what == \'pass\'){
                var email = $("#email").val();
                var password = $("#password").val();
                var url = base_url+\'profile/show_details/edit/pass/\';
                var datapost = \'email=\'+email+\'&password=\'+password;
            }
            if(what == \'common\'){
        ';
        //
        $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}user`");
        $arr_exception = array(
            'ID',
            'email',
            'password',
            'salt',
            'edit',
            'activation',
            'code_activation',
            'access',
            'profile_pic'
        );
        
        foreach ($query->result_array() as $row){
            foreach($row as $key => $value){
                $i++;
                if($i%$divider == 0)
                    $separator = '&';
                
                if(in_array($key, $arr_exception))
                    continue;
                $ret .= 'var '.$key.' = $("#'.$key.'").val();';
                $datapost .= $key.'=\'+'.$key.'+\''.$separator;
            }
        }
        //
        $ret .='
                    var url = base_url+\'profile/show_details/edit/\';
                    '.$datapost.'edit=profile_edit\';
                    }
                var div_loading = \'submit_loading\';
                var div_result = \'profile_detail\';
                post_html_data(url, datapost, div_loading, div_result, \'append\');
            }
        ';
        
        return $ret;
    }
    
    function update_status(){
        $recent_profilepic = $this->Mediatutorialprofile->genProfileThumb('','with_status');
        $style_cropping = $this->Mediatutorialutils->gen_link_css(base_url().'plugins/imageareaselect/imgareaselect-animated.css');
        $script_cropping = $this->Mediatutorialutils->gen_link_js(base_url().'plugins/imageareaselect/jquery.imgareaselect.pack.js').
        "
            <script type=\"text/javascript\">
            function preview(img, selection) {
                if (!selection.width || !selection.height)
                    return;
                
                var scaleX = 100 / selection.width;
                var scaleY = 100 / selection.height;
            
                $('#preview img').css({
                    width: Math.round(scaleX * img.width),
                    height: Math.round(scaleY * img.height),
                    marginLeft: -Math.round(scaleX * selection.x1),
                    marginTop: -Math.round(scaleY * selection.y1)
                });
            
                $('#x1').val(selection.x1);
                $('#y1').val(selection.y1);
                $('#x2').val(selection.x2);
                $('#y2').val(selection.y2);
                $('#w').val(selection.width);
                $('#h').val(selection.height);    
            }
            
            function generate_selection(){
                $('#crop_photo').imgAreaSelect({
                    /*x1: 10,
                    x2: 110,
                    y1: 10,
                    y2: 110,*/
                    aspectRatio: '1:1',
                    handles: true,
                    fadeSpeed: 200,
                    onInit: preview,
                    onSelectChange: preview
                });
            }
            
            /*
            fungsi untuk save dan cancel
            image profile pic kita
            */
            function action_pic(action){
                pic = $('.frame').find('img').attr('alt');
                x1 = $('#x1').val();
                y1 = $('#y1').val();
                w = $('#w').val();
                h = $('#h').val();
                //
                extra = (action == 'save')?x1+'/'+y1+'/'+w+'/'+h:'';
                url_page = base_url+'upload/action_pic/'+action+'/'+pic+'/'+extra;
                //
                loading('action_pic_loading',true);
                setTimeout(function(){
                    $.ajax({
                        type: 'GET',
                        url: url_page,
                        data: '', 
                        cache: false,
                        dataType: 'html',
                        success: function(html){
                            if(action == 'save'){
                                $('#action_pic_result').html(html);
                            }
                            $('#crop_photo').imgAreaSelect({hide:true});
                            $('#box_shadowed_member_area').fadeOut(); 
                            loading('action_pic_loading',false);
                            //$('div.imgareaselect-outer').remove();
                        }
                    });
                }, 500);
            }
            </script>
        ";
        //
        $sub_data = array(
            'user_thumb' => $recent_profilepic,
            'script_cropping' => $script_cropping,
            'style_cropping' => $style_cropping
        );
        $content = $this->load->view($this->Mediatutorialheader->get_site_template().'_account_profilepic_and_status', $sub_data, true);
        //
        $data = array(
            'header'    => 'Status text',
            'content'   => $content
        );
        return $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox', $data, true);
    }
    
    function profile_detail(){
        $data = array(
            'header'    => 'Profile detail',
            'content'   => '<div id="profile_detail_loading"></div><div id="profile_detail"></div>'
        );
        return $this->load->view($this->Mediatutorialheader->get_site_template().'_designbox', $data, true);
    }
    
}
<?php
/***************************************************************************
* Mediatutorial.web.id
*
* di sini untuk passwordnya tidak kita encrypsi
***************************************************************************/

class Administrationmenu extends CI_Model {
    function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->helper(array('url','html'));
            $this->load->model(array('Mediatutorialauth', 'Mediatutorialheader'));
    }
    
    function create_menu($array_menu, $separator ='|'){
        $data = array(
            'menu' => $array_menu,
            'separator' => $separator
        );
        return $this->load->view($this->Mediatutorialheader->get_site_template().'_links',$data, true);
    }
    
    function menu_top(){
        
        if(file_exists(CACHEPATH.'sys_menu_admin_common.php'))
            @include(CACHEPATH.'sys_menu_admin_common.php');
        else{
            if($this->create_cache_menu('menu_admin_common', 'sys_menu_admin_common.php', 'menu_admin_common'))
                @include(CACHEPATH.'sys_menu_admin_common.php');
        }
        
        
        $structure_core = $this->Mediatutorialheader->structure_core();
        /*
         $structure_core['domain'] menghasilkan http://localhost
         $_SERVER['PHP_SELF'] menghasilkan :
         structure_core_codeigniter/index.php
         structure_core_codeigniter/index.php/login/
        */
        
        $current_php_self = str_replace('index.php/', '', $_SERVER['PHP_SELF']);
        $current_php_self = str_replace('index.php', '', $current_php_self);
        $current_page = $structure_core['domain'].$current_php_self;
        
        //
        $ret ='<ul>';
        foreach($menu_admin_common as $link_text => $link_options){
                if( $current_page == $link_options['url'])
                    $ret .='<li class="link_active">'.$link_text.'</li>';
                else{
                    $link_url = $link_options['url'];
                    $link_target = ($link_options['target'] != '')?"target=_blank":"";
                    $ret .='<li><a href="'.$link_url.'" target="'.$link_target.'">'.$link_text.'</a></li>';
            }
        }
        $ret .='</ul>';
        return $ret;
    }
    
    function menu_bottom(){
        
    }
    
    function menu_topest(){
        if($this->Mediatutorialauth->check_logged() == false)
            return;
        
        if(file_exists(CACHEPATH.'sys_menu_admin_top.php'))
            @include(CACHEPATH.'sys_menu_admin_top.php');
        else{
            if($this->create_cache_menu('menu_admin_top', 'sys_menu_admin_top.php', 'menu_admin_top'))
                @include(CACHEPATH.'sys_menu_admin_top.php');
        }
        
        
        $templates_icons = base_url().'templates/'.$this->Mediatutorialheader->get_site_template("short").'images/icons/';
        $ret = '';
        foreach($menu_admin_top as $menu_text => $menu_options){
            $target= ($menu_options['target']!='')?'target="'.$menu_options['target'].'"':'';
            $ret .= '<td>&nbsp;'. img($templates_icons.$menu_options['icon']).'</td><td>'.anchor($menu_options['url'], $menu_text, $target).'</td> ';
        }
        return $ret;
    }
    
    //$url adalah link yang sudah pakai base_url()
    function create_icon_link($url='', $icon, $onclick='', $alt='', $title=''){
        $icons_folder = base_url().'templates/'.$this->Mediatutorialheader->get_site_template("short").'images/icons/';
        $icon_properties = array(
            'src' => $icons_folder.$icon,
            'alt' => $alt,
            'title' => $title
            
        );

        $icon = img($icon_properties);
        //
        $onclick = ($onclick !='')?'onclick="'.$onclick.'return false;"':'';
        //
        $url = ($url !='')?$url:'#';
        $link = anchor($url, $icon, $onclick);
        return $link;
    }
    
}
<?php
/***************************************************************************
* Mediatutorial.web.id
*
* 
***************************************************************************/

class Mediatutorialmenu extends CI_Model {
    function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->helper(array('url','html'));
            $this->load->model(array('Mediatutorialauth', 'Mediatutorialheader', 'Mediatutorialutils'));
    }
    
    function create_menu($array_menu, $separator ='|'){
        $data = array(
            'menu' => $array_menu,
            'separator' => $separator
        );
        return $this->load->view($this->Mediatutorialheader->get_site_template().'_links',$data, true);
    }
    
    /*
     by Okie Eko Wardoyo
     MediaTutorial.web.id
     fungsi untuk compile menu, membuat cache menu
     
     - $what_position => menu_common, menu_top, menu_top_admin, menu_admin,
     dan lain lain sesuai dengan yang ada pada table menu
     - $what_file_tobe_created = file yang ingin dibuat, sys_menu_apagitu.php
     - $what_name_of_array_tobe_created = array yang ingin dibuat dalam file, contoh, menu_common
    */
    function create_cache_menu($what_position, $what_file_tobe_created, $what_name_of_array_tobe_created){
        @include(CACHEPATH.'sys_metu_db.php');
        $query = $this->db->query("SELECT * FROM `{$metu_db['dbprefix']}menu` WHERE `position`= '{$what_position}' ORDER BY `ID`");
        $menus = array();//untuk semua kumpulan menu
        $a = array();
        $parent_array = array();
        $child_array = array('url', 'icon', 'onclick', 'position', 'target');
     
        foreach ($query->result_array() as $row)
        {
            array_push($parent_array, $row['text']);
            $i = array($row['url'], $row['icon'], $row['onclick'], $row['position'], $row['target']);
            $i = array_combine($child_array, $i);
            array_push($a, $i);//nah kita udah dapet child array complit
            
        }
        $menus = array_combine($parent_array, $a);
        if($this->Mediatutorialutils->create_cache_file($what_file_tobe_created, $menus, $what_name_of_array_tobe_created))
            return true;
        else
            return false;
    }
    
    function menu_top(){
     
        if(file_exists(CACHEPATH.'sys_menu_common.php'))
            @include(CACHEPATH.'sys_menu_common.php');
        else{
            if($this->create_cache_menu('menu_common', 'sys_menu_common.php', 'menu_common'))
                @include(CACHEPATH.'sys_menu_common.php');
        }
        
        //menu unlogged
        if(file_exists(CACHEPATH.'sys_menu_unlogged.php'))
            @include(CACHEPATH.'sys_menu_unlogged.php');
        else{
            if($this->create_cache_menu('menu_unlogged', 'sys_menu_unlogged.php', 'menu_unlogged'))
                @include(CACHEPATH.'sys_menu_unlogged.php');
        }
        
        //menu logged
        if(file_exists(CACHEPATH.'sys_menu_logged.php'))
            @include(CACHEPATH.'sys_menu_logged.php');
        else{
            if($this->create_cache_menu('menu_logged', 'sys_menu_logged.php', 'menu_logged'))
                @include(CACHEPATH.'sys_menu_logged.php');
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
        $menu = array_merge($menu_common,($this->Mediatutorialauth->check_logged() == true)?$menu_logged:$menu_unlogged);
        $ret ='<ul>';
        foreach($menu as $link_text => $link_options){
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
        
        if(file_exists(CACHEPATH.'sys_menu_top.php'))
            @include(CACHEPATH.'sys_menu_top.php');
        else{
            if($this->create_cache_menu('menu_top', 'sys_menu_top.php', 'menu_top'))
                @include(CACHEPATH.'sys_menu_top.php');
        }
        
        if(file_exists(CACHEPATH.'sys_menu_top_admin.php'))
            @include(CACHEPATH.'sys_menu_top_admin.php');
        else{
            if($this->create_cache_menu('menu_top_admin', 'sys_menu_top_admin.php', 'menu_top_admin'))
                @include(CACHEPATH.'sys_menu_top_admin.php');
        }
    
    
        //
        if($this->Mediatutorialauth->check_logged() == 'admin')
            $menu = array_merge($menu_top, $menu_top_admin);
        //
        $templates_icons = base_url().'templates/'.$this->Mediatutorialheader->get_site_template("short").'images/icons/';
        $ret = '';
        foreach($menu as $menu_text => $menu_options){
            
            $ret .= '<td>&nbsp;'. img($templates_icons.$menu_options['icon']).'</td><td>'.anchor(base_url().$menu_options['url'], $menu_text).'</td> ';
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
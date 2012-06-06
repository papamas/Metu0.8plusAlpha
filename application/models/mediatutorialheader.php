<?php
/***************************************************************************
* Mediatutorial.web.id
*
* di sini merupakan pengaturan utama
***************************************************************************/

class Mediatutorialheader extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mediatutorialauth','Mediatutorialutils'));
        @include(CACHEPATH.'sys_metu_db.php');
    }
    
    function structure_core(){
        //mari kita loading dari cache file
        //anda dapat langsung menggunakan @include(namafile.php)
        //pada 'FUNCTION' file controller/model anda
        @include(CACHEPATH.'sys_metu_options.php');
        
        return $structure_core;
    }
    
    function site_details(){
        //first, mari kita check apakah cache file ditemukan
        //bila ditemukan mari kita meloading dari cache file saja
        //bila tidak ditemukan mari kita buat cache file nya
        //anda dapat langsung menggunakan @include(namafile.php)
        //pada 'FUNCTION' file controller/model anda
        if(file_exists(CACHEPATH.'sys_site_options.php')){
            @include(CACHEPATH.'sys_site_options.php');
            return $site_options;
        }
        else{
            $table_name = array();
            $table_content = array();
            
            $this->load->database();
            $query = $this->db->query("SELECT * FROM `options`");
            $row = $query->row_array();
            foreach ($query->result_array() as $row)
            {
               array_push($table_name, $row['name']);
               array_push($table_content, stripslashes($row['content']));
            }
            $array_combine = array_combine($table_name, $table_content);
            
            $this->Mediatutorialutils->create_cache_file(CACHEPATH.'sys_site_options.php', $array_combine, 'site_options');
            return $array_combine;
        }
        
    }
    
    function get_site_template($mode='full'){
        //Untuk views, kita memakai relative path saja
        if(isset($_GET['tmpl']) && $_GET['tmpl'] !='')
            $tmpl = $_GET['tmpl'];
        else{
            @include(CACHEPATH.'sys_site_options.php');
            $tmpl = $site_options['site_template'];
        }
        
        return ($mode == 'full')?'../../templates/'.$tmpl.'/':$tmpl.'/';
    }
    
    function get_module_template($vendor_and_name_module){
        //untuk module
        //$vendor_and_name_module adalah contoh mediatutorial/toc_mediatutorial_web_id
        return '../../modules/'.$vendor_and_name_module.'/';

    }
    
    //copyright
    function copyRight($year) {
        $current = date('Y');
        if($year == $current) { $eyear = $year; }
        else { $eyear = "$year - $current"; }
        return "All content &copy; $eyear";
    }
}
?>
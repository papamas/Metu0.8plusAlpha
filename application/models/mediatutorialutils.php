<?php
/***************************************************************************
*                            MediaTutorial ( Codeigniter )
*                              -------------------
*     begin                 : Wednesday Jun 15 2011
*     copyright             : (C) 2011 Okie Wardoyo
*     facebook              : http://facebook.com/okiewardoyo
*     email                 : okie_eko_wardoyo@yahoo.com
*     website		    : http://www.mediatutorial.web.id
* 
* this software is TUTORIAL
***************************************************************************/

class Mediatutorialutils extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('email'));
    }

    // Generate Random Digit
    function genRndDgt($length = 8, $specialCharacters = true) {
        $digits = '';	
        $chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";

        if($specialCharacters === true)
                $chars .= "!?=/&+,.";


        for($i = 0; $i < $length; $i++) {
                $x = mt_rand(0, strlen($chars) -1);
                $digits .= $chars{$x};
        }

        return $digits;
    }

    // Generate Random Salt for Password encryption
    function genRndSalt() {
            return $this->genRndDgt(8, true);
    }

    // Encrypt User Password
    function encryptUserPwd($pwd, $salt) {
            return sha1(md5($pwd) . $salt);
    }
    
    function sendMail($sender_email, $sender_name, $recipient_email, $subject, $body){
        //
        $config['protocol'] = 'mail';
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'text or html';
        $config['wordwrap'] = TRUE;
        //
        $this->email->from($sender_email, $sender_name);
        $this->email->to($recipient_email);
        
        $this->email->subject($subject);
        $this->email->message($body);
        
        $this->email->send();
    }
    
    function gen_link_css($filename, $from_template = false){
        if($from_template == true){
            $tmpl = $this->Mediatutorialheader->get_site_template("short");
            $templates_css = base_url().'templates/'.$tmpl.'css/'; 
            $ret = '<link href="'.$templates_css.$filename.'" type="text/css" rel="stylesheet">';
        }
        else
            $ret = $ret = '<link href="'.$filename.'" type="text/css" rel="stylesheet">';
        return $ret;
    }
    
     function gen_link_js($filename, $from_template = false){
        if($from_template == true){
            $tmpl = $this->Mediatutorialheader->get_site_template("short");
            $templates_js = base_url().'templates/'.$tmpl.'js/'; 
            $ret = '<script src="'.$templates_js.$filename.'" type="text/javascript"></script>';
        }
        else
            $ret = '<script src="'.$filename.'" type="text/javascript"></script>';
        return $ret;
    }
    
    /*
    fungsi untuk membuat cache file
    cache file akan disimpan pada folder cache
    $cache_filename : nama file yang akan dibuat, gunakan relative/absolute path
    $cache_array = array yang akan dimasukkan kedalam filename
    $name_array = nama array pada file yang dibuat
    */
    
    function create_cache_file($cache_filename, $cache_array, $name_array){
        $cache_filename = CACHEPATH.$cache_filename;
        
        $ret = '';
        $ret .='<?';
        $ret .="\r\n$".$name_array." = array(";
        //
        foreach($cache_array as $cache_key => $cache_value){
            if(is_array($cache_value)){
                $ret.= "\r\n\t'".$cache_key."' =>array(";
                foreach($cache_value as $cache_value_key => $cache_value_value){
                    $ret .="\r\n\t\t'".$cache_value_key."'=> '".$cache_value_value."',";
                }
                $ret.="\r\n\t),";
            }
            else
                $ret .="\r\n\t'".$cache_key."'=> '".$cache_value."',";
        }
        //
        $ret .="\r\n);\r\n";
        $ret .='?>';
        
        //mari kita buat filenya
        $fp = fopen($cache_filename, 'w+');
        if ($fp) {
                fputs($fp, $ret);
                fclose($fp);
                chmod($cache_filename, 0666);
                //$innerCode .='Config file telah berhasil ditulis di <strong>' . $aConf['header_file'] . '</strong><br />';
        }
    }
    
    function delete_cache_file($cache_filename){
        $cache_filename = CACHEPATH.$cache_filename;
        //
        if( file_exists($cache_filename) ) {
		unlink($cache_filename);
	}
    }
}
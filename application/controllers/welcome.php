<?php
/***************************************************************************
* Mediatutorial.web.id
***************************************************************************/
class Welcome extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
		//
		$this->load->model(array('Mediatutorialheader', 'Mediatutorialmenu'));
		
	}
	
	function index()
	{
		
		if ( !file_exists( CACHEPATH."sys_site_options.php" ) )
		{
			//dynamic page -  send headers to do not cache this page
			$now = gmdate('D, d M Y H:i:s') . ' GMT';
			header("Expires: $now");
			header("Last-Modified: $now");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
		
			echo "Maap, StructureCore anda <b>belum terinstall</b>\n";
			if ( file_exists( "install/index.php" ) ) {
				echo "Mohon tunggu kami akan mendirect ke halaman installasi<br />\n";
				echo "<script language=\"Javascript\">location.href = 'install/index.php';</script>\n";
			}
			exit;
		}
		
		elseif ( file_exists(CACHEPATH."sys_site_options.php") &&  file_exists( "install/index.php" ))
		{
			//baru diinstall mungkin
			//mari compile menu
			
			$this->Mediatutorialmenu->create_cache_menu('menu_common', 'sys_menu_common.php', 'menu_common');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_logged', 'sys_menu_logged.php', 'menu_logged');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_unlogged', 'sys_menu_unlogged.php', 'menu_unlogged');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_top', 'sys_menu_top.php', 'menu_top');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_top_admin', 'sys_menu_top_admin.php', 'menu_top_admin');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_admin_top', 'sys_menu_admin_top.php', 'menu_admin_top');
			
			$this->Mediatutorialmenu->create_cache_menu('menu_admin_common', 'sys_menu_admin_common.php', 'menu_admin_common');
			
			
			$data['structure_core'] = $this->Mediatutorialheader->structure_core();
			$this->load->view($this->Mediatutorialheader->get_site_template().'_installed', $data);
			
		}
		else{
			$site_details = $this->Mediatutorialheader->site_details();
			$data = array(
				'title' => $site_details['site_title'],
				'body' => $this->promo()
			);
			$this->load->view($this->Mediatutorialheader->get_site_template().'_output_html', $data);
		};
	}
	
	function promo(){
		global $site_options;
		
		$site_details = $this->Mediatutorialheader->site_details();
		/*$data = array( //nah, ini fungsi asli
			'title' => $site_details['site_title'],
			'description' => $site_details['site_description']
		);
		*/
		
		$data = array( //KALO INI CUMAN COBA COBA
			'title' => 'Selamat datang di MeTu+ !',
			'description' => 'Ini merupakan Social Network yang 100% free and opensource, ajax and jquery, chat, wall, profile, notifications, forum, module, administration and many more',
			'container' => $this->load->view($this->Mediatutorialheader->get_site_template().'_1_coba_profile_pic', '',true)
		);
		
		return $this->load->view($this->Mediatutorialheader->get_site_template().'_promo', $data, true);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
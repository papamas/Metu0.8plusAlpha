<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
		<head>
			<title><?=$structure_core['name']?> :: Mediatutorial.web.id</title>
			<link href="install/css/general.css" rel="stylesheet" type="text/css" />
                        <link href='install/images/favicon.ico' rel='icon' type='image/x-icon'/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		</head>
		<body>
			<div id="main">
                            <div id="header">
                                    <img src="install/images/Logo.png" alt="<?=$structure_core['name']?> <?=$structure_core['ver']?>" />
                            </div>
                            <div id="content">
                                <div class="install_text"><?=$structure_core['name']?> <?=$structure_core['ver']?> release <?=$structure_core['release']?></div>
                                <div class="installed_pic">
                                    <img alt="<?=$structure_core['name']?> <?=$structure_core['ver']?>" src="install/images/structurecore_installed.png" />
                                </div>
                            </div>

                            <div class="installed_text">
                                    Anda telah berhasil menginstall <?=$structure_core['name']?> <?=$structure_core['ver']?> silahkan remove 'install' directory
                            </div>
			    <div class="install_text">
				<?=anchor(base_url().'install/index.php','Reinstall this StructureCore')?>
				<br/>
				<br/>
				<br/>
			    </div>
				
                        </div>
		</body>
	</html>
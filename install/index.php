<?php

/***************************************************************************
*                      www.mediatutorial.web.id
***************************************************************************/
//MEDIATUTORIAL INSTALLATION FOR STRUCTURE CORE
//BASED ON DOLPHIN CMS (http://boonex.com/)

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);
  
/*------------------------------*/
/*----------Vars----------------*/
$confStructure_core = array();
$confStructure_core['name']= 'MeTu+';
$confStructure_core['ver'] 	= '0.8 Alpha'; //Alpha Edition
$confStructure_core['build'] 	= '2'; 
$confStructure_core['release'] 	= '26 Mei 2012';
$confStructure_core['coding']   = 'Codeigniter 2.1.0';
$confStructure_core['year']     = date('Y');
$confStructure_core['domain'] = "http://{\$_SERVER['SERVER_NAME']}";

//
//Metu core options
//ditambahkan sejak versi 0.5 alpha (2 Mei 2012)

$site_options_1 = array(
    'site_template' => 'tmpl_metu'
);

//
$aConf = array();
$aConf['header_file'] 	= '../application/models/mediatutorialheader.php';
$aConf['db_file'] 	= '../application/config/database.php';
//$aConf['dir_inc'] 	= '../inc/';	

$aConf['dbTempl'] 	= <<<EOS
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'default';
\$active_record = TRUE;

\$db['default']['hostname'] = '%db_host%';
\$db['default']['username'] = '%db_user%';
\$db['default']['password'] = '%db_password%';
\$db['default']['database'] = '%db_name%';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '%table_prefix%';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */
EOS;
//
	$confFirst = array();
	$confFirst['site_url'] = array(
		'name' => "Site URL",
		'ex' => "http://www.mydomain.com/path/",
		'desc' => "Url situs anda (Ingat, beri backslash dibelakang url '/')",
		'def' => "http://",
	    'def_exp' => '
			$str = "http://".$_SERVER[\'HTTP_HOST\'].$_SERVER[\'PHP_SELF\'];
		    return preg_replace("/install\/(index\.php$)/","",$str);',
		'check' => 'return strlen($arg0) >= 10 ? true : false;'
	);
	$confFirst['dir_root'] = array(
		'name' => "Directory root",
		'ex' => "/path/to/your/script/files/",
		'desc' => "Directory dimana MeTu+ anda diletakan.",
	    'def_exp' => '
			$str = rtrim($_SERVER[\'DOCUMENT_ROOT\'], \'/\').$_SERVER[\'PHP_SELF\'];
		    return preg_replace("/install\/(index\.php$)/","",$str);',
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	

	$confDB = array();
	$confDB['sql_file'] = array(
	    'name' => "SQL file",
	    'ex' => "/home/situsanda/public_html/install/sql/vXX.sql",
	    'desc' => "SQL file location",
		'def' => "sql/vXX.sql",
		'def_exp' => '
			if ( !( $dir = opendir( "sql/" ) ) )
		        return "";
			while (false !== ($file = readdir($dir)))
		        {
			    if ( substr($file,-3) != \'sql\' ) continue;
				closedir( $dir );
				return "sql/$file";
			}
			closedir( $dir );
			return "";',
		'check' => 'return strlen($arg0) >= 4 ? true : false;'
	);
	 $confDB['db_host'] = array(
		'name' => "Database host name",
		'ex' => "localhost",
		'desc' => "Your MySQL database host name here.",
		'def' => "localhost",
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	$confDB['db_name'] = array(
	    'name' => "Database name",
	    'ex' => "YourDatabaseName",
	    'desc' => "Your MySQL database name here.",
	    'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	$confDB['db_user'] = array(
		'name' => "Database user",
		'ex' => "YourName",
		'desc' => "Your MySQL database read/write user name here.",
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	$confDB['db_password'] = array(
		'name' => "Database password",
		'ex' => "YourPassword",
		'desc' => "Your MySQL database password here.",
		'check' => 'return strlen($arg0) >= 0 ? true : false;'
	);
        $confDB['table_prefix'] = array(
		'name' => "Table prefix",
		'ex' => "metu_",
		'desc' => "Your MySQL table prefix here.",
		'def' => "metu_",
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);

	$confGeneral = array();
	$confGeneral['site_title'] = array(
		'name' => "Site Title",
		'ex' => "The Best Community",
		'desc' => "The name of your site",
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	$confGeneral['site_desc'] = array(
		'name' => "Site Description",
		'ex' => "The place to find new friends, communicate and have fun.",
		'desc' => "Meta description of your site",
		'check' => 'return strlen($arg0) >= 1 ? true : false;'
	);
	$confGeneral['site_email'] = array(
		'name' => "Admin Site e-mail",
		'ex' => "admin@email.here",
		'desc' => "Your admin site e-mail.",
		'check' => 'return strlen($arg0) > 0 AND strstr($arg0,"@") ? true : false;'
	);
        
	$confGeneral['admin_password'] = array(
		name => "Admin Password",
		ex => "admin",
		desc => "Specify the admin password here",
		check => 'return strlen($arg0) >= 1 ? true : false;'
	);
        
	$aTemporalityWritableFolders = array(
		'../cache/',
                '../application/config/',
                '../media/captcha/',
                '../media/photo_profile/'
	);

/*----------Vars----------------*/
/*------------------------------*/


$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$error = '';

// --------------------------------------------


$InstallPageContent = InstallPageContent( $error );

mb_internal_encoding('UTF-8');

echo PageHeader( $action, $error );
echo $InstallPageContent;
echo PageFooter( $action );

function InstallPageContent(&$error) {
	global $aConf, $confFirst, $confDB, $confGeneral;
        $action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
	$ret = '';

	switch ($action) {

		case 'step5':
			$ret .= genMainPage();
		break;

		case 'step4':
			$errorMessage = checkConfigArray($confGeneral, $error);
			$ret .= (strlen($errorMessage)) ? genSiteGeneralConfig($errorMessage) : genInstallationProcessPage();
		break;

		case 'step3':
			$errorMessage = checkConfigArray($confDB, $error);
			$errorMessage .= CheckSQLParams();

			$ret .=  (strlen($errorMessage)) ? genDatabaseConfig($errorMessage) : genSiteGeneralConfig();
		break;

		case 'step2':
			$errorMessage = checkConfigArray($confFirst, $error);
			$ret .= (strlen($errorMessage)) ? genPathCheckingConfig($errorMessage) : genDatabaseConfig();
		break;

		case 'step1':
			$ret .= genPathCheckingConfig();
		break;
                
                case 'preInstall':
			$ret .= genPreInstallPermissionTable();
		break;
            
		default:
			$ret .= StartInstall();
		break;
	}

	return $ret;
}

function PageHeader($action = '', $error = '') {
	global $aConf;

	$actions = array(
		"startInstall" => "MeTu+ Installation",
                "preInstall" => "Permissions",
		"step1" => "Paths",
		"step2" => "Database",
		"step3" => "Config",
		"step4" => "Installation Process",
		"step5" => "Main Page",
	);

	if( !strlen( $action ) )
		$action = "startInstall";

	$activeStyle = ($action == "step5") ? 'Active' : 'Inactive';

	$iCounterCurrent = 1;
	$iCounterActive	 = 1;

	foreach ($actions as $actionKey => $actionValue) {
		if ($action != $actionKey) {
			$iCounterActive++;
		} else
			break;
	}

	if (strlen($error))
		$iCounterActive--;

	$subActions = '';
	foreach ($actions as $actionKey => $actionValue) {
		if ($iCounterActive == $iCounterCurrent) {
			$subActions .= '<div id="topActive">' . $actionValue . '</div>';
		} elseif (($iCounterActive - $iCounterCurrent) == -1) {
			$subActions .= '<img src="images/active_inactive.gif" /><div id="topInactive">' . $actionValue . '</div><img src="images/inactive_inactive.gif" />';
		} elseif (($iCounterActive - $iCounterCurrent) == 1) {
			$subActions .= '<div id="topInactive">' . $actionValue . '</div><img src="images/inactive_active.gif" />';
		} else {
			$subActions .= '<div id="topInactive">' . $actionValue . '</div>';
			if ($actionKey != "step6")
				$subActions .= '<img src="images/inactive_inactive.gif" />';
		}
		$iCounterCurrent++;
	}

	return <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
		<head>
			<title>MeTu+ Installation Script</title>
			<link href="css/general.css" rel="stylesheet" type="text/css" />
                        <link href='../templates/tmpl_metu/images/favicon.ico' rel='icon' type='image/x-icon'/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<!--[if lt IE 7.]>
			<script defer type="text/javascript" src="../templates/js/pngfix.js"></script>
			<![endif]-->
		</head>
		<body>
			<div id="main">
				<div id="topMenu{$activeStyle}">
					{$subActions}
				</div>
			<div id="header">
				<img src="images/Logo.png" alt="" /></div>
			<div id="content">
EOF;
}

function PageFooter($action) {
	$tambahan = '';

	return <<<EOF
			</div>
		{$tambahan}
		</div>
	</body>
</html>
EOF;
}

// pre install
function genPreInstallPermissionTable($sErrorMessage = '') {
    global $aTemporalityWritableFolders;

	$sCurPage = $_SERVER['PHP_SELF'];
	$sErrorMessage .= (ini_get('safe_mode') == 1 || ini_get('safe_mode') == 'On') ? "Please turn off <b>safe_mode</b> in your php.ini file configuration" : '';
	$sError = printInstallError($sErrorMessage);

	$sPermTable = showFolderPermissions($aTemporalityWritableFolders);

	return <<<EOF
<div class="position">Permissions</div>
{$sError}
<div class="LeftRirght">
	<div class="clearBoth"></div>
	<div class="left">
		MeTu+ memerlukan special <span style="font-weight:bold;color:green;">Writable (755)</span> permission untuk folder-folder di bawah ini, bila anda menemukan <span style="font-weight:bold;color:red;">Not Writable</span> silahkan disesuaikan.
	</div>
	<div class="clear_both"></div>
	<div class="right">
		<script src="../plugins/jquery/jquery-1.6.1.min.js" type="text/javascript" language="javascript"></script>
		{$sPermTable}
		<div class="formKeeper">
			<div class="button_area_1">
				<form action="{$sCurPage}" method="post">
					<input id="button" type="image" src="images/check.gif" />
					<input type="hidden" name="action" value="preInstall" />
				</form>
			</div>
			<div class="button_area_2">
				<form action="{$sCurPage}" method="post">
					<input id="button" type="image" src="images/next.gif" />
					<input type="hidden" name="action" value="step1" />
				</form>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
</div>
EOF;
}


function StartInstall() {
	global $confStructure_core;

	return <<<EOF
<div class="install_pic">
	 {$confStructure_core['name']} {$confStructure_core['ver']}.{$confStructure_core['build']}
</div>

<div class="install_text">
	Selamat datang di MeTu+ installation page<br />
	Click tombol berikut untuk memulai installasi.
</div>

<div class="install_button">
	<form action="{$_SERVER['PHP_SELF']}" method="post">
	<input id="button" type="image" src="images/install.gif" />
	<input type="hidden" name="action" value="preInstall" />
	</form>
</div>
EOF;
}

function genPathCheckingConfig($errorMessage = '') {
	global  $aConf, $confFirst;

	$currentPage = $_SERVER['PHP_SELF'];

	$error = printInstallError( $errorMessage );
	$pathsTable = createTable($confFirst);

	return <<<EOF
<div class="position">Paths Check</div>
{$error}
<div class="LeftRirght">
	<div class="clearBoth"></div>
	<div class="left">
		MeTu+ checks general script paths.
	</div>
	<div class="right">
		<form action="{$currentPage}" method="post">
			<table cellpadding="0" cellspacing="1" width="100%" border="0" style="background-color:silver;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				{$pathsTable}
			</table>
			<div class="formKeeper">
				<input id="button" type="image" src="images/next.gif" />
				<input type="hidden" name="action" value="step2" />
			</div>
		</form>
	</div>
	<div class="clearBoth"></div>
</div>
EOF;
}

function genDatabaseConfig($errorMessage = '') {
	global $confDB;

	$currentPage = $_SERVER['PHP_SELF'];
	$DbParamsTable = createTable($confDB);

	$errors = '';
	if (strlen($errorMessage)) {
		$errors = printInstallError($errorMessage);
		unset($_POST['db_name']);
		unset($_POST['db_user']);
		unset($_POST['db_password']);
	}

	$oldDataParams = '';
	foreach($_POST as $postKey => $postValue) {
		$oldDataParams .= ('action' == $postKey || isset($confDB[$postKey])) ? '' : '<input type="hidden" name="' . $postKey . '" value="' . $postValue . '" />';
	}

	return <<<EOF
<div class="position">Database</div>
{$errors}
<div class="LeftRirght">
	<div class="clearBoth"></div>
	<div class="left">
	</div>
	<div class="right">
		<form action="{$currentPage}" method="post">
			<table cellpadding="0" cellspacing="1" width="100%" border="0" style="background-color:silver;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				{$DbParamsTable}
			</table>
			<div class="formKeeper">
				<input id="button" type="image" src="images/next.gif" />
				<input type="hidden" name="action" value="step3" />
				{$oldDataParams}
			</div>
		</form>
	</div>
	<div class="clearBoth"></div>
</div>
EOF;
}

function genSiteGeneralConfig($errorMessage = '') {
	global $confGeneral;

	$currentPage = $_SERVER['PHP_SELF'];
	$paramsTable = createTable($confGeneral);

	$errors = '';
	if (strlen($errorMessage)) {
		$errors = printInstallError($errorMessage);
		unset($_POST['site_title']);
		unset($_POST['site_email']);
		unset($_POST['notify_email']);
		unset($_POST['bug_report_email']);
	}

	$oldDataParams = '';
	foreach($_POST as $postKey => $postValue) {
		$oldDataParams .= ('action' == $postKey || isset($confGeneral[$postKey])) ? '' : '<input type="hidden" name="' . $postKey . '" value="' . $postValue . '" />';
	}

	return <<<EOF
<div class="position">Configuration</div>
{$errors}
<div class="LeftRirght">
	<div class="clearBoth"></div>
	<div class="left"></div>
	<div class="right">
		<form action="{$currentPage}" method="post">
			<table cellpadding="0" cellspacing="1" width="100%" border="0" style="background-color:silver;">
				<tr class="head">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				{$paramsTable}
			</table>
			<div class="formKeeper">
				<input id="button" type="image" src="images/next.gif" />
				<input type="hidden" name="action" value="step4" />
				{$oldDataParams}
			</div>
		</form>
	</div>
	<div class="clearBoth"></div>
</div>
EOF;
}

function genInstallationProcessPage($errorMessage = '') {
	global $confStructure_core, $aConf, $confFirst, $confDB, $confGeneral;

	
	$sAdminPassword = get_magic_quotes_gpc() ? stripslashes($_REQUEST['admin_password']) : $_REQUEST['admin_password'];
	$resRunSQL = RunSQL( $sAdminPassword );

	$sForm = '';
	
	if ('done' ==  $resRunSQL) {
		$sForm = '
		<div class="formKeeper">
			<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
				<input type="image" src="images/next.gif" />
				<input type="hidden" name="action" value="step5" />
			</form>
		</div>
		<div class="clearBoth"></div>';
	} else {
		$sForm = $resRunSQL . '
		<div class="formKeeper">
			<form action="' . $_SERVER['PHP_SELF'] . '" method="post">
				<input type="image" src="images/back.gif" />';
		foreach ($_POST as $sKey => $sValue) {
			if ($sKey != "action")
				$sForm .= '<input type="hidden" name="' . $sKey . '" value="' . $sValue . '" />';
		}
		$sForm .= '<input type="hidden" name="action" value="step2" />
			</form>
		</div>
		<div class="clearBoth"></div>';
		return $sForm;
	}
       
	foreach ($confDB as $key => $val) {
		$aConf['dbTempl'] = str_replace ("%$key%", $_POST[$key], $aConf['dbTempl']);
	}
	

	$innerCode = '';
        
        $fp = fopen($aConf['db_file'], 'w');
	if ($fp) {
		fputs($fp, $aConf['dbTempl']);
		fclose($fp);
		chmod($aConf['db_file'], 0666);
		//$innerCode .='Config file telah berhasil ditulis di <strong>' . $aConf['db_file'] . '</strong><br />';
	} else {
		$text = 'Warning!!! can not get write access to config file ' . $aConf['db_file'] . '. Here is config file</font><br>';
		$innerCode .= printInstallError($text);
		$trans = get_html_translation_table(HTML_ENTITIES);
		$templ = strtr($aConf['dbTempl'], $trans);
		$sInnerCode .= '<textarea cols="20" rows="10" class="headerTextarea">' . $aConf['dbTempl'] . '</textarea>';
	}
	return <<<EOF
<div class="position">Process install sudah selesai</div>
<div class="LeftRirght">
	{$sForm}
</div>
EOF;
}

// check of config pages steps
function checkConfigArray($checkedArray, &$error) {

	$errorMessage = '';

	foreach ($checkedArray as $key => $value) {
		if (! strlen($value['check'])) continue;

		$funcbody = $value['check'];
		$func = create_function('$arg0', $funcbody);

		if (! $func($_POST[$key])) {
			$fieldErr = $value['name'];
			$errorMessage .= "Please, input valid data to <b>{$fieldErr}</b> field<br />";
			$error_arr[$key] = 1;
			unset($_POST[$key]);
		} else
			$error_arr[$key] = 0;

		//$config_arr[$sKey]['def'] = $_POST[$sKey];
	}

	if (strlen($errorMessage)) {
		$error = 'error';
	}

	return $errorMessage;
}

function genMainPage() {
	return <<<EOF
<script type="text/javascript">
	window.location = "../index.php";
</script>
EOF;
}

function printInstallError($text) {
	$ret = (strlen($text)) ? '<div class="error">' . $text . '</div>' : '';
	return $ret;
}

function createTable($arr) {
	$ret = '';
	$i = '';
        $error_arr = array();
	foreach($arr as $key => $value) {
		$sStyleAdd = (($i%2) == 0) ? 'background-color:#ede9e9;' : 'background-color:#fff;';

		$def_exp_text = "";
		if (strlen($value['def_exp'])) {
		    $funcbody = $value['def_exp'];
		    $func = create_function("", $funcbody);
		    $def_exp = $func();
			if (strlen($def_exp)) {
				$def_exp_text = "&nbsp;<font color=green>found</font>";
				$value['def'] = $def_exp;
			} else {
				$def_exp_text = "&nbsp;<font color=red>not found</font>";
			}
		}

		$st_err = ($error_arr[$key] == 1) ? ' style="background-color:#FFDDDD;" ' : '';

		$ret .= <<<EOF
	<tr class="cont" style="{$sStyleAdd}">
		<td>
			<div>{$value['name']}</div>
			<div>Description:</div>
			<div>Example:</div>
		</td>
		<td>
			<div><input {$st_err} size="30" name="{$key}" value="{$value['def']}" /> {$def_exp_text}</div>
			<div>{$value['desc']}</div>
			<div style="font-style:italic;">{$value['ex']}</div>
		</td>
	</tr>
EOF;
		$i ++;
	}

	return $ret;
}

function rewriteFile($code, $replace, $file) {
	$ret = '';
	$fs = filesize($file);
	$fp = fopen($file, 'r');
	if ($fp) {
		$fcontent = fread($fp, $fs);
		$fcontent = str_replace($code, $replace, $fcontent);
		fclose($fp);
		$fp = fopen($file, 'w');
		if ($fp) {
			if (fputs($fp, $fcontent)) {
				$ret .= true;
			} else {
				$ret .= false;
			}
			fclose ( $fp );
		} else {
			$ret .= false;
		}
	} else {
		$ret .= false;
	}
	return $ret;
}

function RunSQL($sAdminPassword) {
        global $site_options_1;
        global $confStructure_core;
        
        $siteEmail = DbEscape($_POST['site_email']);
	$siteTitle = DbEscape($_POST['site_title']);
	$siteDesc = DbEscape($_POST['site_desc']);
        $siteUrl = DbEscape($_POST['site_url']);
        $dirRoot = DbEscape($_POST['dir_root']);
        
	$confDB['host']   = $_POST['db_host'];
	$confDB['sock']   = $_POST['db_sock'];
	$confDB['port']   = $_POST['db_port'];
	$confDB['user']   = $_POST['db_user'];
	$confDB['passwd'] = $_POST['db_password'];
	$confDB['db']     = $_POST['db_name'];
        $confDB['table_prefix'] = $_POST['table_prefix'];
        

	$confDB['host'] .= ( $confDB['port'] ? ":{$confDB['port']}" : '' ) . ( $confDB['sock'] ? ":{$confDB['sock']}" : '' );

	$pass = true;
	$errorMes = '';
	$filename = $_POST['sql_file'];

	$vLink = @mysql_connect($confDB['host'], $confDB['user'], $confDB['passwd']);

	if( !$vLink )
		return printInstallError( mysql_error() );

	if (!mysql_select_db ($confDB['db'], $vLink))
		return printInstallError( $confDB['db'] . ': ' . mysql_error() );

    mysql_query ("SET sql_mode = ''", $vLink);

    if (! ($f = fopen ( $filename, "r" )))
    	return printInstallError( 'Could not open file with sql instructions:' . $filename  );

	//Begin SQL script executing
	$s_sql = "";
	while ($s = fgets ( $f, 10240)) {
		$s = trim( $s ); //Utf with BOM only

                $s = str_replace("_table_prefix_", $confDB['table_prefix'], $s);
                $s = str_replace("_site_url_", $siteUrl, $s);
                
		if (! strlen($s)) continue;
		if (mb_substr($s, 0, 1) == '#') continue; //pass comments
		if (mb_substr($s, 0, 2) == '--') continue;
		if (substr($s, 0, 5) == "\xEF\xBB\xBF\x2D\x2D") continue;

		$s_sql .= $s;

		if (mb_substr($s, -1) != ';') continue;

		$res = mysql_query($s_sql, $vLink);
		if (!$res)
			$errorMes .= 'Error while executing: ' . $s_sql . '<br />' . mysql_error() . '<hr />';

		$s_sql = '';
	}

    $sSiteEmail = DbEscape($_POST['site_email']);
    //
    //khusus Codeigniter 
    //admin encryption nya kita buat sendiri di page ini (lihat bottom)
    $sSaltDB = genRndSalt();
    $sAdminPasswordDB = encryptUserPwd($sAdminPassword, $sSaltDB); // encryptUserPwd
    $sAdminQuery = "
        INSERT INTO `{$confDB['table_prefix']}user`
            (`email`, `password`, `salt`, `fullname`, `activation`, `access`)
        VALUES
            ('{$sSiteEmail}', '{$sAdminPasswordDB}', '{$sSaltDB}', 'Administration', 1 , 1 )
    ";
    mysql_query($sAdminQuery, $vLink);
    
	if (!$res)
		$errorMes .= 'Error while executing: ' . $s_sql  . '<br />' . mysql_error() . '<hr />';

    fclose($f);
    //mari buat cache untuk user admin
    $array_admin = array(
        'ID' => 1,
        'fullname' => 'Administrator',
        'email' => $sSiteEmail,
        'password' => $sAdminPasswordDB,
        'salt' => $sSaltDB,
        'activation' => 1,
        'access' => 1,
        'description' => '',
        'sex' => 'male',
        'edit' => '',
        'code_activation' =>'',
        'profile_pic' => 0,
    );
    create_cache_file('../cache/user1.php', $array_admin, 'user');
    
	if ($siteEmail != '' && $siteTitle != '') {
            
            $site_options_2 = array(
                'site_email' => $siteEmail,
                'site_title' => $siteTitle,
                'site_description' => $siteDesc,
                'site_url' => $siteUrl
            );
            
            $site_options_3 = array_merge($site_options_1, $site_options_2);
            
            $metu_db = array(
                'dbprefix' => $confDB['table_prefix'],
            );
            
            $confStructure_core_2 = array(
                'dir_root' =>$dirRoot
            );
            
            $confStructure_core = array_merge($confStructure_core, $confStructure_core_2);
            
            foreach($site_options_3 as $key_site => $value_site){
               if(!( mysql_query("INSERT INTO `{$confDB['table_prefix']}options`(`name`, `content`) VALUES ('{$key_site}', '{$value_site}')", $vLink)))
                    $ret .= "<font color=red><i><b>Error on insert ".$key_site."=>".$value_site." </b>:</i> ".mysql_error($vLink)."</font><hr>";
            }
            //buat cache file untuk metu
            create_cache_file('../cache/sys_site_options.php', $site_options_3, 'site_options');
            create_cache_file('../cache/sys_metu_options.php', $confStructure_core, 'structure_core');
            create_cache_file('../cache/sys_metu_db.php', $metu_db, 'metu_db');
	} else {
		$ret .= "<font color=red><i><b>Error</b>:</i> Mohon dicheck kembali site_email  atau site_title</font><hr>";
	}

    mysql_close($vLink);

    $errorMes .= $ret;

    if (strlen($errorMes)) {
    	return printInstallError($errorMes);
    } else {
    	return 'done';
    }
//    return $ret."Truncating tables finished.<br>";
}

function DbEscape($s, $isDetectMagixQuotes = true) {
    if (get_magic_quotes_gpc() && $isDetectMagixQuotes)
        $s = stripslashes ($s);
    return mysql_real_escape_string($s);
}

function CheckSQLParams() {
	$confDB['host']   = $_POST['db_host'];
	$confDB['sock']   = $_POST['db_sock'];
	$confDB['port']   = $_POST['db_port'];
	$confDB['user']   = $_POST['db_user'];
	$confDB['passwd'] = $_POST['db_password'];
	$confDB['db']     = $_POST['db_name'];

	$confDB['host'] .= ( $confDB['port'] ? ":{$confDB['port']}" : '' ) . ( $confDB['sock'] ? ":{$confDB['sock']}" : '' );

	$vLink = @mysql_connect($confDB['host'], $confDB['user'], $confDB['passwd']);

	if (!$vLink)
		return printInstallError(mysql_error());

	if (!mysql_select_db ($confDB['db'], $vLink))
		return printInstallError($confDB['db'] . ': ' . mysql_error());

	mysql_close($vLink);
}

//KHUSUS CODEIGNITER KITA BUAT SENDIRI encrypsinya
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
        return genRndDgt(8, true);
}

// Encrypt User Password
function encryptUserPwd($pwd, $salt) {
        return sha1(md5($pwd) . $salt);
}

/*
fungsi untuk membuat cache file
cache file akan disimpan pada folder cache
$cache_filename : nama file yang akan dibuat, gunakan relative/absolute path
$cache_array = array yang akan dimasukkan kedalam filename
$name_array = nama array pada file yang dibuat
*/

function create_cache_file($cache_filename, $cache_array, $name_array){
    $ret = '';
    $ret .='<?';
     $ret .="\r\n$".$name_array." = array(";
    //
    foreach($cache_array as $cache_key => $cache_value){
        $ret .="\r\n\t\"".$cache_key."\"=> \"".$cache_value."\",";
    }
    //
    $ret .="\r\n);\r\n";
    $ret .='?>';
    
    //mari kita buat filenya
    $fp = fopen($cache_filename, 'w');
    if ($fp) {
            fputs($fp, $ret);
            fclose($fp);
            chmod($cache_filename, 0666);
            //$innerCode .='Config file telah berhasil ditulis di <strong>' . $aConf['header_file'] . '</strong><br />';
    }
}

function isMetuWritable($file_or_folder){
    clearstatcache();
    return (is_writable($file_or_folder));
}

function showFolderPermissions($array_file){
    $ret = '';
    foreach($array_file as $item_file){
        if( isMetuWritable($item_file))
            $ret .= $item_file .'<span style="color:green;font-weight:bold;"> Writeable</span><br/>';
        else
            $ret .= $item_file .'<span style="color:red;font-weight:bold;"> Not Writeable</span><br/>';
    }
    
    return $ret;
    
}

?>
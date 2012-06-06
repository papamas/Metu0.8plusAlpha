<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<title><?=stripcslashes($title)?></title>
	<link href='<?=base_url()?>templates/tmpl_twitter/images/favicon.ico' rel='icon' type='image/x-icon'/>
	<meta name="description" content="__description__" />
	<meta name="keywords" content="__keywords__" />
	<link href="<?=base_url()?>templates/tmpl_twitter/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>templates/tmpl_twitter/css/general.css" rel="stylesheet" type="text/css" />
	<script src="<?=base_url()?>plugins/js/functions.js" type="text/javascript" language="javascript"></script>
	<script src="<?=base_url()?>plugins/jquery/jquery-1.6.1.min.js" type="text/javascript" language="javascript"></script>
	<!-- script lanjutan-->
	<script type="text/javascript">
	var base_url = "<?=base_url()?>";
	</script>

</head>
<body>

<?=$this->load->view($this->Mediatutorialheader->get_site_template().'_output_header')?>

<!--BEGIN MAIN DIV-->
<div class="mainDiv">
<?=$body?>
<?=$this->load->view($this->Mediatutorialheader->get_site_template().'_catatan')?>
<?=$this->load->view($this->Mediatutorialheader->get_site_template().'_output_footer')?>
</div>
<!--END OF MAIN DIV-->
 
    </body>
</html>
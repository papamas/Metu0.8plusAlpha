<span class="error"><b><?=$login_failed?></b></span><br/>

<?=validation_errors() ?>
<?=form_open(base_url().'login/')?>
<table>
    <tr><td>Email</td><td><input type="text" name="email" value="<?=set_value('email') ?>"/> </td></tr>
    <tr><td>Password</td><td><input type="password" name="password" value="<?=set_value('password')?>" /> </td></tr>
    <tr><td></td><td><input type="submit" name="submit_login" value="Submit"/> </td></tr>
</table>

<?=form_close()?>
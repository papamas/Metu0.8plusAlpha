
<div class="extra separator">
    <?=form_open(base_url()."register/")?>
        <span class="error"><?=$captcha_return?><?=validation_errors() ?></span>
        <table>
            <tr><td>Full name*</td><td><input type="text" name="fullname" value="<?=set_value('fullname') ?>"/> </td></tr>
            <tr><td>Email*</td><td><input type="text" name="email" value="<?=set_value('email') ?>" /></td></tr>
            <tr><td>Password*</td><td><input type="password" name="password" value="<?=set_value('password') ?>" /></td></tr>
            <tr><td>Retype-Password*</td><td><input type="password" name="password_2" value="<?=set_value('password_2') ?>" /></td></tr>
            <tr><td>Sex</td><td>
                <?
                $options = array(
                    'male' => 'male',
                    'female' => 'female'
                );
                ?>
                <?=form_dropdown('sex', $options, set_value('sex'))?>
            </td></tr>
            <tr><td>Description</td><td><textarea name="description"><?=set_value('description')?></textarea></td></tr>
            <tr><td>Enter Code</td><td><?=$cap_img?><br/><input type="text" name="captcha" value=""/></td></tr>
            <tr><td></td><td><input type="submit" value="Submit" name="submit"/> </td></tr>
        </table>
    <?=form_close()?>
</div>
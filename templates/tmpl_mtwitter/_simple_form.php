<?=form_open($action_url)?>
    <span class="error"><?=validation_errors() ?></span>
    <?=$table_form?>
<?=form_close()?>
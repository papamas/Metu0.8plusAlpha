<!--script BEGIN-->


<script type="text/javascript">
$(document).ready(function(){
  get_html_data(base_url+"profile/show_details/",'', 'profile_detail_loading', 'profile_detail');
});

function edit_detail(){
    get_html_data(base_url+"profile/show_details/edit/",'', 'profile_detail_loading', 'profile_detail');
}

function edit_detail_pass(){
    get_html_data(base_url+"profile/show_details/edit/pass/",'', 'profile_detail_loading', 'profile_detail');
}

function cancel_edit_detail(){
    get_html_data(base_url+"profile/show_details/",'', 'profile_detail_loading', 'profile_detail');
}

function load_simple_upload(){
    get_html_data(base_url+"upload/upload_form/simple/",'', 'btn_loading', 'upload_form_pic');
}

<?=$extra_script?>
</script>
<!--script END-->
<style>
#profile_detail table td{
  vertical-align: text-top;
}
</style>
<div class="box_shadowed" id="box_shadowed_member_area">
    <div id="content">
      <?=$box_shadowed_content?>
    </div>
</div>

<div class="column_1" style="width:400px;">
    <?=$column_1?>
</div>

<div class="column_2" style="width:285px;">
    <?=$column_2?>
</div>
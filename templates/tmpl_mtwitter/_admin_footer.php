
<div id="footermainPan">
    <div id="footerPan">
      <?=$this->Administrationmenu->menu_bottom()?>
      <?
      $site_details = $this->Mediatutorialheader->site_details();
      $structure_core = $this->Mediatutorialheader->structure_core();
      //
      $powered = $structure_core['name'].' '.$structure_core['ver'].' build '.$structure_core['build'].' - '.$structure_core['coding'];
      
      ?>
      
      <p class="copyright"><?=$this->Mediatutorialheader->copyRight($structure_core['year'])?></p>
      <p class="powered">Powered by <?=$powered?> </p>
    </div>
</div>
<?php

$mypage = 'style_settings';
$settings = OOPlugin::getProperty('be_utilities',$mypage,'settings');

$center_checked = $settings['center']==1 ? 'checked="checked" ' : '';

$dw = new rex_select();
$dw->setId("default_width");
$dw->setName("settings[default_width]");
$dw->setStyle('class="rex-form-select"');
$dw->setSize(1);
foreach($settings['width'] as $i=>$w)
  $dw->addOption($I18N->Msg('a240style_be_width').' '.($i+1),$i);
$dw->setSelected($settings['default_width']);

echo '
<div class="rex-addon-output">

<h2 class="rex-hl2">'.$I18N->Msg('a240style_head').'</h2>

<div class="rex-area">
  <div class="rex-form">

  <form action="index.php?page=be_utilities&amp;subpage='.$mypage.'" method="post" id="a240-form">
    
    <fieldset class="rex-form-col-1">
      <div class="rex-form-wrapper">
      
        <div class="rex-form-row">
          <p class="rex-form-checkbox rex-form-label-right">
            <input class="rex-form-checkbox" type="checkbox" name="settings[center]" id="center" value="1" '.$center_checked.'/>
            <label for="center">'.$I18N->Msg('a240style_be_center').'</label>
          </p>
        </div>
        
        <div class="rex-form-row">
          <p class="rex-form-select">
            <label for="default_width">'.$I18N->Msg('a240style_default_width').': </label>
            '.$dw->get().'
          </p>
        </div>
        
      </div>
    </fieldset>
';
$count = count($settings['width']);
for ($i = 0; $i < $count; $i++) {
  echo '
    <fieldset class="rex-form-col-1" id="be-width-'.$i.'">
      <legend>'.$I18N->Msg('a240style_be_width').' '.($i+1).'</legend>
      <div class="rex-form-wrapper">
      
        <div class="rex-form-row">
          <p class="rex-form-text">
            <label for="width">'.$I18N->Msg('a240style_width').': </label>
            <input type="text" name="settings[width][]" id="width" size="3" style="width:40px;" value="'.$settings['width'][$i].'" /> px
          </p>
        </div>
      
        <div class="rex-form-row">
          <p class="rex-form-text">
            <label for="width_desc">'.$I18N->Msg('a240style_width_desc').': </label>
            <input type="text" name="settings[width_desc][]" id="width_desc" value="'.$settings['width_desc'][$i].'" />
          </p>
        </div>
        
      </div>
    </fieldset>
  ';
}
    
echo '
    <fieldset class="rex-form-col-1">
      <input type="hidden" name="a240_update" value="style_settings" />
      <div class="rex-form-wrapper">
        <div class="rex-form-row">
          <p>
            <input type="button" id="a240style_add_width" class="rex-form-submit" value="&quot;'.$I18N->Msg('a240style_be_width').' '.($count+1).'&quot; '.$I18N->Msg('a240style_add').'" />
            <input type="button" id="a240style_delete_width" class="rex-form-submit rex-form-submit-2" value="&quot;'.$I18N->Msg('a240style_be_width').' '.($count).'&quot; '.$I18N->Msg('a240style_delete').'" />
          </p>
        </div>
      </div>
      <div class="rex-form-row">
        <p>
          <input type="submit" class="rex-form-submit" value="'.$I18N->Msg('a240_save').'" />
          <input type="submit" class="rex-form-submit rex-form-submit-2" name="default_settings" value="'.$I18N->Msg('a240_default_settings').'" onclick="return confirm(\''.$I18N->Msg('a240_really_reset').'\')" />
        </p>
      </div>
    </fieldset>
  
  </form>
  </div>
</div>
</div>

<script type="text/javascript">
<!--

jQuery(function($) {
  var i = '.$count.';
  a240style_buttons();
  $("#a240style_add_width").click(function() {
    var fieldset = $("#a240-form fieldset:eq("+i+")").clone();
    $("#a240-form fieldset:eq("+i+")").after(fieldset);
    $("#default_width").append("<option value=\""+i+"\">'.$I18N->Msg('a240style_be_width').' "+(i+1)+"</option>");
    i++;
    $("#a240-form fieldset:eq("+i+") legend").text("'.$I18N->Msg('a240style_be_width').' "+i);
    $("#a240-form fieldset:eq("+i+") input").val("");
    $("#a240-form fieldset:eq("+i+") input").focus();
    $("#a240-form fieldset:eq("+i+") input").blur();
    a240style_buttons();
  });
  $("#a240style_delete_width").click(function() {
    $("#a240-form fieldset:eq("+i+")").remove();
    $("#default_width option:last").remove();
    i--;
    a240style_buttons();
  });
  function a240style_buttons() {
    $("#a240style_add_width").val("\"'.$I18N->Msg('a240style_be_width').' "+(i+1)+"\" '.$I18N->Msg('a240style_add').'");
    $("#a240style_delete_width").val("\"'.$I18N->Msg('a240style_be_width').' "+i+"\" '.$I18N->Msg('a240style_delete').'");
    if (i==1)
      $("#a240style_delete_width").attr("disabled","disabled");
    else
      $("#a240style_delete_width").removeAttr("disabled");
  }
});

//--></script>
';
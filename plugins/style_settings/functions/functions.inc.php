<?php

function rex_a240style_extensions_handler($params)
{
  global $REX;
  $page = $params['subject'];
  $settings = OOPlugin::getProperty('be_utilities','style_settings','settings');
  if(!in_array($page,array('mediapool','linkmap'))) {
    if (count($settings['width'])>1) {
      if ($page=='profile' || $page=='user') {
        rex_register_extension('OUTPUT_FILTER','rex_a240style_opf');
        if (rex_post('upd_profile_button', 'string'))
          rex_a240style_save_profile();
      }
    }
    $dir = '../files/addons/be_utilities/plugins/style_settings/';
    $style = OOPlugin::isActivated('be_style','agk_skin') ? 'agk' : 'default';
    $width = rex_a240style_get_width();
    rex_a240style_check_width_file($style,$width);
    rex_a240_add_css($dir."$width.width_$style.css");
    if ($settings['center']=='1')
      rex_a240_add_css($dir."center_$style.css");
  }
}

function rex_a240style_opf($params)
{
  global $REX,$I18N;
  $output = $params['subject'];
  $page = $REX['PAGE'];
  $settings = OOPlugin::getProperty('be_utilities','style_settings','settings');
  if ($page == 'profile') {
    $name = 'userperm_be_width';
    $labelfor = "userperm-mylang";
    $format = '%s';
    $width_id = rex_a240style_get_user_width_id(false);
  } else {
    $name = 'userperm_extra[]';
    $labelfor = "userperm-startpage";
    $format = 'be_width[%s]';
    $width_id = -1;
    $user_id = rex_request('user_id','int',0);
    if ($user_id != 0) {
      $sql = new rex_sql();
      $sql->setQuery('SELECT rights FROM '.$REX['TABLE_PREFIX'].'user WHERE user_id='.$user_id);
      $width_id = rex_a240style_get_user_width_id(false,$sql->getValue('rights'));
    }
  }
  $select = new rex_select();
  $select->setName($name);
  $select->setId('userperm_be_width');
  $select->setSize(1);
  $select->setStyle('class="rex-form-select"');
  $select->addOption($I18N->Msg('a240style_default_width'),sprintf($format,-1));
  foreach($settings['width_desc'] as $i=>$desc) {
    $desc = $desc != '' ? rex_translate($desc) : $settings['width'][$i]."px";
    $select->addOption($desc,sprintf($format,$i));
  }
  $select->setSelected(sprintf($format,$width_id));
  $p = '
    <p class="rex-form-col-b rex-form-select">
      <label for="userperm_be_width">'.$I18N->Msg('a240style_be_width').'</label>
      '.$select->get().'
    </p>  
  ';
  $output = preg_replace('/(\<label for\=\"'.$labelfor.'\"\>(.*?)\<\/p\>)/s','$1'.$p,$output);
  return $output;
}

function rex_a240style_save_profile()
{
  global $REX;
  $width = rex_post('userperm_be_width','int',-1);
  $rights = $REX['USER']->getValue('rights');
  $rights = preg_replace('/#be_width\[[0-9]*\]/','',$rights);
  if ($width >= 0)
    $rights .= 'be_width['.$width.']#';
  $REX['USER']->setValue('rights',$rights);
}

function rex_a240style_get_width()
{
  global $REX;
  $settings = OOPlugin::getProperty('be_utilities','style_settings','settings');
  if (isset($settings['user_width']))
    return $settings['user_width'];
  $default_width = $settings['default_width'];
  $width_id = $default_width;
  if (count($settings['width_desc'])>1)
    $width_id = rex_a240style_get_user_width_id();
  if (isset($settings['width'][$width_id]))
    $width = $settings['width'][$width_id];
  elseif (isset($settings['width'][$default_width]))
    $width = $settings['width'][$default_width];
  else
    $width = $settings['width'][0];
  $settings['user_width'] = $width;
  OOPlugin::setProperty('be_utilities','style_settings','settings',$settings);
  return $width;
}

function rex_a240style_get_user_width_id($default = true, $rights = null)
{
  global $REX;
  if ($rights === null && is_object($REX['USER']))
    $rights = $REX['USER']->getValue('rights');
  if ($rights !== null) {
    if (preg_match_all('@#be_width\[([0-9]*)\]#@', $rights, $matches)) {
    	foreach ($matches[1] as $match)
      	return $match;
  	}
  }
  if ($default) {
    $settings = OOPlugin::getProperty('be_utilities','style_settings','settings');
    return $settings['default_width'];
  }
  return -1;
}

function rex_a240style_check_width_file($style, $width)
{
  global $REX;
  $file = $REX['MEDIAFOLDER']."/addons/be_utilities/plugins/style_settings/$width.width_$style.css";
  if (!file_exists($file)) {
    $ofile = $REX['INCLUDE_PATH']."/addons/be_utilities/plugins/style_settings/files/964.width_$style.css";
    $content = rex_get_file_contents($ofile);
    $content = preg_replace_callback('@width: [0-9]+?px; \/\* \-([0-9]+?)px( \/([0-9]+))? \*\/@','rex_a240style_replace_width',$content);
    rex_put_file_contents($file,$content);
  }
}

function rex_a240style_replace_width($success)
{
  global $REX;
  $width = rex_a240style_get_width();
  if (isset($success[2])) {
    $div = $success[3];
  } else {
    $div = 1;
    $success[2] = '';
  }
  return 'width: '.intval(($width-$success[1])/$div).'px; /* -'.$success[1].'px'.$success[2].' */';
}


function rex_a240_add_css($file)
{
  rex_register_extension('PAGE_HEADER','_rex_a240_add_css',array('file'=>$file));
}

function rex_a240_add_js($file)
{
  rex_register_extension('PAGE_HEADER','_rex_a240_add_js',array('file'=>$file));
}

function _rex_a240_add_css($params)
{
  return $params['subject']."\n  ".'<link rel="stylesheet" type="text/css" href="'.$params['file'].'" />';
}

function _rex_a240_add_js($params)
{
  return $params['subject']."\n  ".'<script src="'.$params['file'].'" type="text/javascript"></script>';
}


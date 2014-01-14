<?php

$mypage = 'style_settings';

if ($REX['REDAXO']) {
  $I18N->appendFile(dirname(__FILE__).'/lang/');
  $REX['ADDON']['name'][$mypage] = $I18N->Msg('a240style_name');
}

$REX['ADDON']['version'][$mypage] = '2.1.6';
$REX['ADDON']['author'][$mypage] = 'Gregor Harlan';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';

$REX['ADDON']['settings'][$mypage]['center'] = '0';
$REX['ADDON']['settings'][$mypage]['default_width'] ='0';
$REX['ADDON']['settings'][$mypage]['width_desc'] = array();
$REX['ADDON']['settings'][$mypage]['width'] = array();

if (file_exists(dirname(__FILE__).'/settings.inc.php'))
  require_once (dirname(__FILE__).'/settings.inc.php');

if (empty($REX['ADDON']['settings'][$mypage]['width_desc']))
  $REX['ADDON']['settings'][$mypage]['width_desc'][] = '';
if (empty($REX['ADDON']['settings'][$mypage]['width']))
  $REX['ADDON']['settings'][$mypage]['width'][] = '964';

if($REX["REDAXO"])
{
  require_once(dirname(__FILE__).'/functions/functions.inc.php');
  
  rex_register_extension('PAGE_CHECKED', 'rex_a240style_extensions_handler');
  
  // register plugin
  rex_plugin_factory::registerPlugin('be_utilities', 'style_settings', 'Style Settings', $I18N->msg('style_settings_description'), '2.1.6', 'Gregor Harlan', 'forum.redaxo.de', true);

}
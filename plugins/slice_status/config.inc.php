<?php
// --- DYN
$REX['ADDON']['slice_status']['ajax_mode'] = "1";
$REX['ADDON']['slice_status']['menuitem_position'] = "right";
// --- /DYN

// includes
require_once($REX['INCLUDE_PATH'] . '/addons/be_extensions/plugins/slice_status/classes/class.rex_slice_status.inc.php');

if ($REX['REDAXO']) {
	// add lang file
	$I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/be_extensions/plugins/slice_status/lang/');

	// add to extension manager
	$extension = new rex_extension('slice_status', 'Slice Status', $I18N->msg('slice_status_description'), '1.2.5', 'WebDevOne', 'forum.redaxo.de', true);
	$REX['extension_manager']->addExtension($extension);

	// update slice status in db if necessary
	if (rex_get('function') == 'updateslicestatus') {
		rex_slice_status::updateSliceStatusInDB(rex_get('article_id'), rex_get('clang'), rex_get('slice_id'), rex_get('new_status'));
	}

	// handle slice menu
	rex_register_extension('ART_SLICE_MENU', 'rex_slice_status::modifySliceEditMenu');

	// add css/js files to page header
	rex_register_extension('PAGE_HEADER', 'rex_slice_status::appendToPageHeader');
}

// handle slice visibility in frontend
rex_register_extension('SLICE_SHOW', 'rex_slice_status::sliceShow');
?>

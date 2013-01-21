<?php
if ($REX['REDAXO']) {
	// add lang file
	$I18N->appendFile($REX['INCLUDE_PATH'] . '/addons/be_extensions/plugins/favicon/lang/');

	// add to extension manager
	$extension = new rex_extension('favicon', 'Favicon', $I18N->msg('favicon_description'), '1.0.0', 'WebDevOne', 'forum.redaxo.de', false);
	$REX['extension_manager']->addExtension($extension);

	// includes
	require_once($REX['INCLUDE_PATH'] . '/addons/be_extensions/plugins/favicon/classes/class.rex_favicon.inc.php');

	// in rex version > 4.4.1 there is already a favicon ;)
	if ($REX['VERSION'] <= 4 && $REX['SUBVERSION'] <= 4 && $REX['MINORVERSION'] <= 1) {
		// add favicon to page header
		rex_register_extension('PAGE_HEADER', 'rex_favicon::appendToPageHeader');
	}
}

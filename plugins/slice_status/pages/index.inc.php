<?php
$ajax_mode = trim(rex_request('ajax_mode', 'string'));
$menuitem_position = trim(rex_request('menuitem_position', 'string'));

$config_file = $REX['INCLUDE_PATH'] . '/addons/be_extensions/plugins/slice_status/config.inc.php';

if (rex_request('func', 'string') == 'update') {
	$REX['ADDON']['slice_status']['ajax_mode'] = $ajax_mode;
	$REX['ADDON']['slice_status']['menuitem_position'] = $menuitem_position;

	$content = '
		$REX[\'ADDON\'][\'slice_status\'][\'ajax_mode\'] = "' . $ajax_mode . '";
		$REX[\'ADDON\'][\'slice_status\'][\'menuitem_position\'] = "' . $menuitem_position . '";
	';

	if (rex_replace_dynamic_contents($config_file, str_replace("\t", "", $content)) !== false) {
		echo rex_info($I18N->msg('be_extensions_configfile_update'));
	} else {
		echo rex_warning($I18N->msg('be_extensions_configfile_nosave'));
	}
}

if (!is_writable($config_file)) {
	echo rex_warning($I18N->msg('be_extensions_configfile_nowrite'), $config_file);
}
?>

<div class="rex-addon-output">
	<div class="rex-form">

		<h2 class="rex-hl2"><?php echo $I18N->msg('be_extensions_settings'); ?></h2>

		<form action="index.php" method="post">

			<fieldset class="rex-form-col-1">
				<div class="rex-form-wrapper">
					<input type="hidden" name="page" value="be_extensions" />
					<input type="hidden" name="subpage" value="plugin.slice_status" />
					<input type="hidden" name="func" value="update" />

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-checkbox">
							<label for="ajax_mode"><?php echo $I18N->msg('slice_status_ajax_mode'); ?></label>
							<input type="checkbox" name="ajax_mode" id="ajax_mode" value="1" <?php if ($REX['ADDON']['slice_status']['ajax_mode'] == 1) { echo 'checked="checked"'; } ?>>
						</p>
					</div>

					<div class="rex-form-row">
						<p class="rex-form-col-a rex-form-select">
							<label for="menuitem_position"><?php echo $I18N->msg('slice_status_menuitem_position'); ?></label>
							<select name="menuitem_position" size="1" id="menuitem_position" class="rex-form-select">
								<option value="left" <?php if ($REX['ADDON']['slice_status']['menuitem_position'] == 'left') { echo 'selected="selected"'; } ?>><?php echo $I18N->msg('slice_status_left'); ?></option>
								<option value="right" <?php if ($REX['ADDON']['slice_status']['menuitem_position'] == 'right') { echo 'selected="selected"'; } ?>><?php echo $I18N->msg('slice_status_right'); ?></option>
							</select>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v1">
						<p class="rex-form-col-a rex-form-read">
							<label for="css_hint"><?php echo $I18N->msg('slice_status_css_hint'); ?></label>
							<span class="rex-form-read" id="css_hint"><code>/files/addons/be_extensions/plugins/slice_status/slice_status.css</code></span>
						</p>
					</div>

					<div class="rex-form-row rex-form-element-v2">
						<p class="rex-form-submit">
							<input type="submit" class="rex-form-submit" name="sendit" value="<?php echo $I18N->msg('be_extensions_settings_save'); ?>" />
						</p>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<style type="text/css">
div.rex-form-row label {
	width: 240px !important; 
}

span#css_hint code {
	font-size: 0.9em;
}

</style>

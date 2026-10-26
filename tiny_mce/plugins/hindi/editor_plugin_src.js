/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('hindi', 'en,he,no,ru,ru_KOI8-R,ru_UTF-8,fi,cy,es,is,pl'); // <- Add a comma separated list of all supported languages

/****
 * Steps for creating a plugin from this hindi:
 *
 * 1. Change all "hindi" to the name of your plugin.
 * 2. Remove all the callbacks in this file that you don't need.
 * 3. Remove the popup.htm file if you don't need any popups.
 * 4. Add your custom logic to the callbacks you needed.
 * 5. Write documentation in a readme.txt file on how to use the plugin.
 * 6. Upload it under the "Plugins" section at sourceforge.
 *
 ****/

/**
 * Information about the plugin.
 */
function TinyMCE_hindi_getInfo() {
	return {
		longname : 'hindi plugin',
		author : 'Your name',
		authorurl : 'http://www.yoursite.com',
		infourl : 'http://www.yoursite.com/docs/hindi.html',
		version : "1.0"
	};
};

/**
 * Gets executed when a editor instance is initialized
 */
function TinyMCE_hindi_initInstance(inst) {
	// You can take out plugin specific parameters
	alert("Initialization parameter:" + tinyMCE.getParam("hindi_someparam", false));
}

/**
 * Gets executed when a editor needs to generate a button.
 */
function TinyMCE_hindi_getControlHTML(control_name) {
	switch (control_name) {
		case "hindi":
			var cmd = 'tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mcehindi\', true);return false;';
			return '<a href="javascript:' + cmd + '" onclick="' + cmd + '" target="_self" onmousedown="return false;"><img id="{$editor_id}_hindi" src="{$pluginurl}/images/hindi.gif" title="{$lang_hindi_desc}" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" /></a>';
	}

	return "";
}

/**
 * Gets executed when a command is called.
 */
function TinyMCE_hindi_execCommand(editor_id, element, command, user_interface, value) {
	// Handle commands
	switch (command) {
		// Remember to have the "mce" prefix for commands so they don't intersect with built in ones in the browser.
		case "mcehindi":
			// Show UI/Popup
			if (user_interface) {
				// Open a popup window and send in some custom data in a window argument
				var hindi = new Array();

				hindi['file'] = '../../plugins/hindi/popup.htm'; // Relative to theme
				hindi['width'] = 300;
				hindi['height'] = 200;

				tinyMCE.openWindow(hindi, {editor_id : editor_id, some_custom_arg : "somecustomdata"});

				// Let TinyMCE know that something was modified
				tinyMCE.triggerNodeChange(false);
			} else {
				// Do a command this gets called from the hindi popup
				alert("execCommand: mcehindi gets called from popup.");
			}

			return true;
	}

	// Pass to next handler in chain
	return false;
}

/**
 * Gets executed when the selection/cursor position was changed.
 */
function TinyMCE_hindi_handleNodeChange(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {
	// Deselect hindi button
	tinyMCE.switchClassSticky(editor_id + '_hindi', 'mceButtonNormal');

	// Select hindi button if parent node is a strong or b
	if (node.parentNode.nodeName == "STRONG" || node.parentNode.nodeName == "B")
		tinyMCE.switchClassSticky(editor_id + '_hindi', 'mceButtonSelected');

	return true;
}

/**
 * Gets executed when contents is inserted / retrived.
 */
function TinyMCE_hindi_cleanup(type, content) {
	switch (type) {
		case "get_from_editor":
			alert("[FROM] Value HTML string: " + content);

			// Do custom cleanup code here

			break;

		case "insert_to_editor":
			alert("[TO] Value HTML string: " + content);

			// Do custom cleanup code here

			break;

		case "get_from_editor_dom":
			alert("[FROM] Value DOM Element " + content.innerHTML);

			// Do custom cleanup code here

			break;

		case "insert_to_editor_dom":
			alert("[TO] Value DOM Element: " + content.innerHTML);

			// Do custom cleanup code here

			break;
	}

	return content;
}

/**
 * $RCSfile: editor_plugin_src.js,v $
 * $Revision: 1.0 $
 * $Date: 2006/03/01 $
 *
 * @author Vishal Pahuja
 */
var IE = tinyMCE.isMSIE;
var filePath = "../jscripts/tiny_mce/plugins/salaiteepp/jscripts/";
if(typeof scriptFilePath != 'undefined') {
    filePath = scriptFilePath;
}

// Singleton class
var TinyMCE_salaiteeppPlugin = {
	/**
	 * Returns information about the plugin as a name/value array.
	 * The current keys are longname, author, authorurl, infourl and version.
	 *
	 * @returns Name/value array containing information about the plugin.
	 * @type Array
	 */
	getInfo : function() {
		return {
			longname : 'Salaitee Plus Plus',
			author : 'Vishal Pahuja',
			authorurl : 'http://www.pahuja.net',
			infourl : 'http://www.pahuja.net',
			version : "1.0"
		};
	},

	/**
	 * Gets executed when a TinyMCE editor instance is initialized.
	 *
	 * @param {TinyMCE_Control} Initialized TinyMCE editor control instance.
	 */
	initInstance : function(inst) {
		// You can take out plugin specific parameters
		//alert("Initialization parameter:" + tinyMCE.getParam("salaiteepp_someparam", false));

		// Register custom keyboard shortcut
		inst.addShortcut('ctrl', 't', 'lang_salaiteepp_desc', 'mceTemplate');
	},

	/**
	 * Returns the HTML code for a specific control or empty string if this plugin doesn't have that control.
	 * A control can be a button, select list or any other HTML item to present in the TinyMCE user interface.
	 * The variable {$editor_id} will be replaced with the current editor instance id and {$pluginurl} will be replaced
	 * with the URL of the plugin. Language variables such as {$lang_somekey} will also be replaced with contents from
	 * the language packs.
	 *
	 * @param {string} cn Editor control/button name to get HTML for.
	 * @return HTML code for a specific control or empty string.
	 * @type string
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "salaiteepp":
				return tinyMCE.getButtonHTML(cn, 'lang_salaiteepp_desc', '{$pluginurl}/images/template.gif', 'salaiteepp', true);
		}

		return "";
	},

	/**
	 * Executes a specific command, this function handles plugin commands.
	 *
	 * @param {string} editor_id TinyMCE editor instance id that issued the command.
	 * @param {HTMLElement} element Body or root element for the editor instance.
	 * @param {string} command Command name to be executed.
	 * @param {string} user_interface True/false if a user interface should be presented.
	 * @param {mixed} value Custom value argument, can be anything.
	 * @return true/false if the command was executed by this plugin or not.
	 * @type
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			// Remember to have the "mce" prefix for commands so they don't intersect with built in ones in the browser.
			case "mcesalaiteepp":
				// Show UI/Popup
				if (user_interface) {
					// Open a popup window and send in some custom data in a window argument
					var template = new Array();

					template['file'] = '../../plugins/salaiteepp/popup.htm'; // Relative to theme
					template['width'] = 300;
					template['height'] = 200;

					tinyMCE.openWindow(template, {editor_id : editor_id, some_custom_arg : "somecustomdata"});

					// Let TinyMCE know that something was modified
					tinyMCE.triggerNodeChange(false);
				} else {
					// Do a command this gets called from the template popup
					//alert("execCommand: mceTemplate gets called from popup.");
				}

				return true;
		}

		// Pass to next handler in chain
		return false;
	},

	/**
	 * Gets called ones the cursor/selection in a TinyMCE instance changes. This is useful to enable/disable
	 * button controls depending on where the user are and what they have selected. This method gets executed
	 * alot and should be as performance tuned as possible.
	 *
	 * @param {string} editor_id TinyMCE editor instance id that was changed.
	 * @param {HTMLNode} node Current node location, where the cursor is in the DOM tree.
	 * @param {int} undo_index The current undo index, if this is -1 custom undo/redo is disabled.
	 * @param {int} undo_levels The current undo levels, if this is -1 custom undo/redo is disabled.
	 * @param {boolean} visual_aid Is visual aids enabled/disabled ex: dotted lines on tables.
	 * @param {boolean} any_selection Is there any selection at all or is there only a cursor.
	 */
	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {
		// Select template button if parent node is a strong or b
		if (node.parentNode.nodeName == "STRONG" || node.parentNode.nodeName == "B") {
			tinyMCE.switchClass(editor_id + '_template', 'mceButtonSelected');
			return true;
		}

		// Deselect template button
		tinyMCE.switchClass(editor_id + '_template', 'mceButtonNormal');
	},

	/**
	 * Gets called when a TinyMCE editor instance gets filled with content on startup.
	 *
	 * @param {string} editor_id TinyMCE editor instance id that was filled with content.
	 * @param {HTMLElement} body HTML body element of editor instance.
	 * @param {HTMLDocument} doc HTML document instance.
	 */
	setupContent : function(editor_id, body, doc) {
	},

	/**
	 * Gets called when the contents of a TinyMCE area is modified, in other words when a undo level is
	 * added.
	 *
	 * @param {TinyMCE_Control} inst TinyMCE editor area control instance that got modified.
	 */
	onChange : function(inst) {
	},

	/**
	 * Gets called when TinyMCE handles events such as keydown, mousedown etc. TinyMCE
	 * doesn't listen on all types of events so custom event handling may be required for
	 * some purposes.
	 *
	 * @param {Event} e HTML editor event reference.
	 * @return true - pass to next handler in chain, false - stop chain execution
	 * @type boolean
	 */
	handleEvent : function(e) {
		// Display event type in statusbar
		top.status = "template plugin event: " + e.type;

		return true; // Pass to next handler
	},

	/**
	 * Gets called when HTML contents is inserted or retrived from a TinyMCE editor instance.
	 * The type parameter contains what type of event that was performed and what format the content is in.
	 * Possible valuses for type is get_from_editor, insert_to_editor, get_from_editor_dom, insert_to_editor_dom.
	 *
	 * @param {string} type Cleanup event type.
	 * @param {mixed} content Editor contents that gets inserted/extracted can be a string or DOM element.
	 * @param {TinyMCE_Control} inst TinyMCE editor instance control that performes the cleanup.
	 * @return New content or the input content depending on action.
	 * @type string
	 */
	cleanup : function(type, content, inst) {
		switch (type) {
			case "get_from_editor":
				//alert("[FROM] Value HTML string: " + content);

				// Do custom cleanup code here

				break;

			case "insert_to_editor":
				//alert("[TO] Value HTML string: " + content);

				// Do custom cleanup code here

				break;

			case "get_from_editor_dom":
				//alert("[FROM] Value DOM Element " + content.innerHTML);

				// Do custom cleanup code here

				break;

			case "insert_to_editor_dom":
				//alert("[TO] Value DOM Element: " + content.innerHTML);

				// Do custom cleanup code here

				break;
		}

		return content;
	},

	// Private plugin internal methods

	/**
	 * This is just a internal plugin method, prefix all internal methods with a _ character.
	 * The prefix is needed so they doesn't collide with future TinyMCE callback functions.
	 *
	 * @param {string} a Some arg1.
	 * @param {string} b Some arg2.
	 * @return Some return.
	 * @type string
	 */
	_someInternalFunction : function(a, b) {
		return 1;
	}
};

// Adds the plugin class to the list of available TinyMCE plugins
tinyMCE.addPlugin("salaiteepp", TinyMCE_salaiteeppPlugin);

// Handle an event
function keypressEvent(event) {

	var target;

	if(IE)
		target = event.srcElement;
	else
		target = event.target;

	if(event.type == 'keydown'){

		var key;
		if(IE){
			key = event.keyCode;

			//alt, backspace, delete. key value 18 is for 'alt' key itself
			if(event.altKey && key != 18 || key == 8 || key == 46) {

				//hidden field, tells whether convertion should take place or not
				if(document.indicForm.convertFlag.value != "true")
					return;

				// Call event handler of specific file that handles specific keyboard layout
				eventHandler(target,event);
			}
		}
	}else if(event.type == 'keypress'){
		//alert(event.keyCode);

		//hidden field, tells whether convertion should take place or not
		if(document.indicForm.convertFlag.value != "true")
	        return;

		// Call event handler of specific file that handles specific keyboard layout
		eventHandler(target,event);
	}


	// Continue handling
	return true;
}
/*
function keydownEvent(event) {

	//var target = event.target;

	if(event.type == 'keydown'){

		var key;
		if(tinyMCE.isMSIE){
			key = event.keyCode;
			if(event.altKey && key != 18 || key == 8 || key == 46) {  //alt, backspace, delete
				keypressEvent(event);         //key value 18 is for 'alt' key itself
			}
		}
	}

	// Continue handling
	return true;

}
*/
function togHintMenu() {
//alert("togHintMenu");

    var selectedIndex,keyboardLabel,offset;
    var showHint,convertFlag,selectCombo;

    //selectCombo     = document.indicForm.selectLanguage;
    var selectCombo = document.getElementById("languageSelect");
    alert(selectCombo + " selectCombo ");

    selectedIndex   = selectCombo.selectedIndex;
    keyboardLabel   = selectCombo.options[selectedIndex].label;
    offset          = document.indicForm.offset.value;
    convertFlag     = document.indicForm.convertFlag.value;
    //showHint        = document.indicForm.chk_show_hint.checked;
    showHint =        document.getElementById("div_keymap_hint");

    writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint);
//alert("/togHintMenu");
}

function writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint) {
//alert("writeCookie");

    var today   = new Date();
    var expires = new Date(today.getTime() + (56 * 86400000));
    var indexes = new String();
    indexes     = keyboardLabel +"-"+ selectedIndex +"-"+ offset +"-"+ convertFlag +"-"+ showHint;

    setCookie("indicLangCookie",indexes,expires);
//alert("/writeCookie");
}

function initializeIndicCookie() {
//alert("initializeIndicCookie");

    var languageIndex, cookieValue, keyboardLabel, indicCookie;
    var offset, convertFlag, showHint,div_keymap_hint;

    div_keymap_hint = document.getElementById("div_keymap_hint");
    div_keymap_hint.style.display = 'none';

    keyboardLabel = new String();
    indicCookie   = getCookie("indicLangCookie");

    if(indicCookie) {

        cookieValue     = new String(indicCookie);
        keyboardLabel   = cookieValue.substring(0,cookieValue.indexOf("-"));
        cookieValue     = cookieValue.substring(cookieValue.indexOf("-")+1,cookieValue.length);
        languageIndex   = cookieValue.substring(0,cookieValue.indexOf("-"));
        cookieValue     = cookieValue.substring(cookieValue.indexOf("-")+1,cookieValue.length);
        offset          = cookieValue.substring(0,cookieValue.indexOf("-"));
        cookieValue     = cookieValue.substring(cookieValue.indexOf("-")+1,cookieValue.length);
        convertFlag     = cookieValue.substring(0,cookieValue.indexOf("-"));
        showHint        = cookieValue.substring(cookieValue.indexOf("-")+1,cookieValue.length);

//        document.indicForm.selectLanguage.options[languageIndex].selected = true;
       // document.indicForm.offset.value = offset;
       // document.indicForm.convertFlag.value = convertFlag;

        showHint = (showHint == "true")? true : false;
        //document.indicForm.chk_show_hint.checked = showHint;
        //document.getElementById("div_keymap_hint") = showHint;

    }

    if(keyboardLabel == "inscript") {
        loadContent(filePath + "IndicInput_IME_INS.js","keyboardScript");
    }
    else if(keyboardLabel == "wx") {
        loadContent(filePath + "IndicInput_IME_WX.js","keyboardScript");
    }
    else if(keyboardLabel.indexOf("multi") == 0) {
        div_keymap_hint.style.display = '';
        loadContent(filePath + "IndicInput_IME_multi.js","keyboardScript");
    }

    if(typeof auto != 'undefined' && auto) {
        //machine translation and transliteration enabled
        //specific for translate.php

        loadContent(filePath + "machtranslit.js","miscel");
    }
//alert("/initializeIndicCookie");
}

/* Functions to Set and Get Cookies */

function getCookie(name) {
  var start = document.cookie.indexOf(name+"=");
  var len = start+name.length+1;
  if ((!start) && (name != document.cookie.substring(0,name.length)))
    return null;
  if (start == -1)
    return null;
  var end = document.cookie.indexOf(";",len);
  if (end == -1)
    end = document.cookie.length;
  return unescape(document.cookie.substring(len,end));
}

function setCookie(name,value,expires,path,domain,secure) {
  document.cookie = name + "=" +escape(value) +
        ( (expires) ? ";expires=" + expires.toGMTString() : "") +
        ( (path) ? ";path=" + path : "") +
        ( (domain) ? ";domain=" + domain : "") +
        ( (secure) ? ";secure" : "");
}

/* This method changes the javascript depending on the keyboard layout selected */
function loadContent(file_name,element_name) {
    var head,script;

    head = document.getElementsByTagName('head').item(0);
    script = document.getElementsByName(element_name).item(0);
    if(script)
        head.removeChild(script);
    script = document.createElement('script');
    script.src = file_name;
    script.type = 'text/javascript';
    script.name = element_name;
    head.appendChild(script);
}

function selectLang(selectCombo) {
//alert("selectLang");

    var valueAtIndex,result,selectedIndex,keyboardLabel;
    var showHint,offset,convertFlag,div_keymap_hint;

    div_keymap_hint = document.getElementById("div_keymap_hint");
//    alert(div_keymap_hint.style.display);
    div_keymap_hint.style.display = 'none';

    selectedIndex = selectCombo.selectedIndex;
    keyboardLabel = new String(selectCombo.options[selectedIndex].label);
    //aszalert(keyboardLabel + "keyboardLabel");
    //showHint      = document.indicForm.chk_show_hint.checked;
    showHint =        document.getElementById("div_keymap_hint");
    valueAtIndex  = "";

    if(keyboardLabel.indexOf("multi") != 0) {
        valueAtIndex = selectCombo.options[selectedIndex].value;
    }

    result        = setOffset(valueAtIndex);

    offset        = result.offset;
    convertFlag   = result.convertFlag;
    //alert(offset + " offset "  + convertFlag + " con vertFlasg");

    document.indicForm.offset.value = offset;
    document.indicForm.convertFlag.value = convertFlag;

    if(result.languageSelected) {
        writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint);
    }

    if(keyboardLabel == "inscript") {
        loadContent(filePath + "IndicInput_IME_INS.js","keyboardScript");
    }
    else if(keyboardLabel == "wx"){
        loadContent(filePath + "IndicInput_IME_WX.js","keyboardScript");
    }
    else if(keyboardLabel.indexOf("multi") == 0) {
        div_keymap_hint.style.display = '';
        loadContent(filePath + "IndicInput_IME_multi.js","keyboardScript");
    }
    if(typeof auto != 'undefined' && auto) {
        //machine translation and transliteration enabled
        //specific for translate.php

        loadContent(filePath + "machtranslit.js","miscel");
    }
}

function setOffset(value) {

    var languageSelected = true;
    var offset = "",convertFlag = true;

    switch(value) {

        case '':
            break;
        case '-1':
            offset=0;
            convertFlag = false;
            break;
        case '0' :
            offset=0;
            break;
        case '1' :
            offset=(128*1);
            break;
        case '2' :
            offset=(128*2);
            break;
        case '3' :
            offset=(128*3);
            break;
        case '4' :
            offset=(128*4);
            break;
        case '5' :
            offset=(128*5);
            break;
        case '6' :
            offset=(128*6);
            break;
        case '7' :
            offset=(128*7);
            break;
        case '8' :
            offset=(128*8);
            break;
        default:
            convertFlag=false;
            languageSelected = false;
    }
    return {offset:offset,convertFlag:convertFlag,languageSelected:languageSelected};
}

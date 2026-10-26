/*
 * indicSupport.js
 * This file is part of Entrans
 *
 * Copyright (C) 2005 Khader Abbeb N
 * Copyright (C) 2005 R.Vigneswaran 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, 
 * Boston, MA 02111-1307, USA. 
 *
 */

/*
 * This page loads the script that handles the key events on the fly. This page also
 * sets and gets cookie values.
 *
 *                                              Author: Surekha and Raghavan
 *                                              Source: http://mail.sarai.net:8080/indic/index.html
 *                                              Customization by: R.Vigneswaran
 */

// Javascript functions for IME

    //variable IE will be set if the browser is Internet Explorer
var IE = !window.opera && (window.event || document.all); 

var filePath = "";
if(typeof scriptFilePath != 'undefined') {
    filePath = scriptFilePath;
}

function togHintMenu() {
//alert("togHintMenu");

    var selectedIndex,keyboardLabel,offset;
    var showHint,convertFlag,selectCombo;

    selectCombo     = document.indicForm.selectLanguage;
    
    selectedIndex   = selectCombo.selectedIndex;
    keyboardLabel   = selectCombo.options[selectedIndex].label;
    offset          = document.indicForm.offset.value;
    convertFlag     = document.indicForm.convertFlag.value;  
    showHint        = document.indicForm.chk_show_hint.checked;
    
    writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint);
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
    showHint      = document.indicForm.chk_show_hint.checked;
    valueAtIndex  = "";
  
    if(keyboardLabel.indexOf("multi") != 0) {
        valueAtIndex = selectCombo.options[selectedIndex].value;
    }
  
    result        = setOffset(valueAtIndex);
  
    offset        = result.offset;
    convertFlag   = result.convertFlag;  
  
    document.indicForm.offset.value = offset;
    document.indicForm.convertFlag.value = convertFlag;
  
    if(result.languageSelected) {
        writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint);
    }
  
    if(keyboardLabel == "inscript") {
    alert(filePath);
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

function writeCookie(keyboardLabel,selectedIndex,offset,convertFlag,showHint) {
//alert("writeCookie");

    var today   = new Date();
    var expires = new Date(today.getTime() + (56 * 86400000));
    var indexes = new String();
    indexes     = keyboardLabel +"-"+ selectedIndex +"-"+ offset +"-"+ convertFlag +"-"+ showHint;
    
    setCookie("indicLangCookie",indexes,expires);
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

        document.indicForm.selectLanguage.options[languageIndex].selected = true;
        document.indicForm.offset.value = offset;
        document.indicForm.convertFlag.value = convertFlag;
        
        showHint = (showHint == "true")? true : false;
        document.indicForm.chk_show_hint.checked = showHint;
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

// End of js for IME.

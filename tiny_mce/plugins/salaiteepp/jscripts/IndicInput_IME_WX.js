/*  This code is used to capture events on a textArea or a textField.
    The key character is captured and converted to Unicode for display. */
var vowelFlag = false;
var vowel_nn = false;
var offset;
var isciiToUnicodeArray = new Array();
var virtualKeyboardArray = new Array();
var hindiUnicodeStart = 2304;
var currentTextControl;
var isNav = false;
var w,languageIndex;
var imatraFlag = false;
var oldSelectionStart,oldSelectionEnd;

    //variable IE will be set if the browser is Internet Explorer
//var IE = !window.opera && (window.event || document.all);
var classAttrib = (IE)? "className":"class";

initializeArray();
checkBrowser();

offset = parseInt(document.indicForm.offset.value);
function checkBrowser() {
  if(parseInt(navigator.appVersion)>=4) {
    if(navigator.appName=="Netscape") {
      isNav = true;
    }
  }
  else {
    isNav = false;
  }
}

                          //capture events
function eventHandler(target,event) {
   //events originated from the specified target only be processed
    //if(target.type == "textarea" && target.getAttribute(classAttrib) == "indic_ime")
        handleCharacter(target,event,replaceAscii);
}

                       //sorting the unicode according to iscii order

function initializeArray() {
  isciiToUnicodeArray.push(2305); // ISCII 161
  isciiToUnicodeArray.push(2306); // ISCII 162
  isciiToUnicodeArray.push(2307); // ISCII 163
  isciiToUnicodeArray.push(2309); // ISCII 164
  isciiToUnicodeArray.push(2310); // ISCII 165
  isciiToUnicodeArray.push(2311); // ISCII 166
  isciiToUnicodeArray.push(2312); // ISCII 167
  isciiToUnicodeArray.push(2313); // ISCII 168
  isciiToUnicodeArray.push(2314); // ISCII 169
  isciiToUnicodeArray.push(2315); // ISCII 170
  isciiToUnicodeArray.push(2318); // ISCII 171
  isciiToUnicodeArray.push(2319); // ISCII 172
  isciiToUnicodeArray.push(2320); // ISCII 173
  isciiToUnicodeArray.push(2317); // ISCII 174
  isciiToUnicodeArray.push(2322); // ISCII 175
  isciiToUnicodeArray.push(2323); // ISCII 176
  isciiToUnicodeArray.push(2324); // ISCII 177
  isciiToUnicodeArray.push(2321); // ISCII 178
  var uniHinCons = 2325;
  for(var i=180;i<=223;i++) {
    if(i == 217) {
      isciiToUnicodeArray.push(0);
      uniHinCons = 2366;
    }
    isciiToUnicodeArray.push(uniHinCons);
    uniHinCons++;
  }
  isciiToUnicodeArray.push(2374); // ISCII 224
  isciiToUnicodeArray.push(2375); // ISCII 225
  isciiToUnicodeArray.push(2376); // ISCII 226
  isciiToUnicodeArray.push(2373); // ISCII 227
  isciiToUnicodeArray.push(2378); // ISCII 228
  isciiToUnicodeArray.push(2379); // ISCII 229
  isciiToUnicodeArray.push(2380); // ISCII 230
  isciiToUnicodeArray.push(2377); // ISCII 231
  isciiToUnicodeArray.push(2378); // ISCII 232
  isciiToUnicodeArray.push(2364); // ISCII 233
  isciiToUnicodeArray.push(2404); // ISCII 234
  for(var i=235;i<=240;i++) {
    isciiToUnicodeArray.push(0);
  }
  var hinUnicodeDigits = 2406;
  for(var i=241;i<=250;i++) {
    isciiToUnicodeArray.push(hinUnicodeDigits);
    hinUnicodeDigits++;
  }
}


function handleCharacter(textControl, event, keyChecker) {
    var keyCode = 0;

    if(IE)
        keyCode = event.keyCode;
    else if(event.which)
        keyCode = event.which;

    var key = String.fromCharCode(keyCode);
    if(! ( keyCode == 0 || keyCode == 8 || keyCode ==13 || keyCode == 47 ||
           keyCode == 96 || (keyCode >=32 && keyCode <=45) ||
           (keyCode >=58 && keyCode <=64) || (keyCode >=91 &&
           keyCode <=94) || (keyCode >122 && keyCode <=126) ||
           (keyCode == 86) || (keyCode == 89) ) ) //if not special symbols
    {
	    var keyCheck = keyChecker(keyCode,key);
	    if (keyCode && event && IE) {    //If IE
        	if (keyCheck.replaceKey) {
    		    event.keyCode = keyCheck.newKey.charCodeAt(0);
    		    if(keyCheck.newKey.length == 2) {
    	        	textControl.value = textControl.value + keyCheck.newKey.charAt(1);
    	    	}
    	    	if (event.preventDefault) {
            		event.preventDefault();
          		}
          		return true;
        	}
      	}//if IE ends
      	else if (typeof textControl.setSelectionRange != 'undefined') {       //If netscape
        	if (keyCheck.replaceKey) {
          		if (event.preventDefault) {      // cancel the key event and insert the newKey for the current selection
            		event.preventDefault();
          		}
          		oldSelectionStart = textControl.selectionStart;
          		oldSelectionEnd = textControl.selectionEnd;
          		var selectedText = textControl.value.substring(oldSelectionStart,oldSelectionEnd);
    	        var newText = typeof keyCheck.newKey != 'undefined' ?
          		keyCheck.newKey.charAt(0) : String.fromCharCode(keyCheck.newKey.charCodeAt(0));
          		if(keyCheck.newKey.length == 2) {
          			textControl.value = textControl.value.substring(0,oldSelectionStart -1) + newText
                       + keyCheck.newKey.charAt(1) + textControl.value.substring(oldSelectionEnd);
          		}
          		else if(vowel_nn) {
          		    textControl.value = textControl.value.substring(0,(oldSelectionStart-1)) +  newText
                       + textControl.value.substring(oldSelectionEnd);
          		    vowel_nn = false;
          		}
          		else {
          			textControl.value = textControl.value.substring(0,oldSelectionStart) +  newText
                       + textControl.value.substring(oldSelectionEnd);
          		}
          		textControl.setSelectionRange(oldSelectionStart + newText.length,oldSelectionStart + newText.length);
          		if(imatraFlag) {
          			var lastChar = textControl.value.substring(textControl.value.length-1,textControl.value.length);
          			var previousToLastChar = textControl.value.substring(textControl.value.length-2,textControl.value.length-1);
			        textControl.value = textControl.value.substring(0,textControl.value.length-2) + lastChar + previousToLastChar;
		            imatraFlag = false;
	        	}
        	  	return false;
        	}
        	else {
        	    return true;
        	}
      	}//if netscape ends
    }// if not special symbols ends
    else if( keyCode == 86 || keyCode == 89) {
    	var key = String.fromCharCode(keyCode);
    	var textAreaContent = textControl.value;
    	var lastCharCode = textAreaContent.charCodeAt(textAreaContent.length-1,textAreaContent.length);
    	lastCharCode = lastCharCode - offset;
    	isciiCode = getIsciiCode(lastCharCode);
    	switch(key) {
    	    case 'V':
    	      --isciiCode;
    	      unicode = getUnicodeFromIsciiCode(isciiCode);
    	      break;
    	    case 'Y':
    	      isciiCode++;
    	      unicode = getUnicodeFromIsciiCode(isciiCode);
    	      break;
    	}
    	textControl.value = textControl.value.substring(0,textControl.value.length-1) + String.fromCharCode(unicode+offset);
      	if(navigator.appName!="Netscape") {
        	window.event.keyCode = 0;
      	}
      	else {
        	event.preventDefault();
      	}
    }
    else {
        if(vowelFlag) {
    	    var ch = String.fromCharCode((2309+offset));
    	    if(navigator.appName!="Netscape") {
    		    textControl.value = textControl.value + ch;
            }
        	else {
          		textControl.value = textControl.value.substring(0,oldSelectionStart) +  ch ;
        	}
        	vowelFlag = false;
      	}
    }
}

function getUnicodeFromIsciiCode(isciiCode) {
  isciiCode = isciiCode - 161;
  return isciiToUnicodeArray[isciiCode];
}

function getIsciiCode(unicode) {
  var isciiCode=0;
  for(var ai=0;ai<isciiToUnicodeArray.length;ai++) {
    if(isciiToUnicodeArray[ai] == unicode) {
      isciiCode = ai + 161;
      break;
    }
  }
  return isciiCode;
}

function replaceAscii(keyCode,key) {
  var unicodeCharacters = getUnicode(keyCode);
  if(unicodeCharacters.newKeyCode1==0) {
    newChar = String.fromCharCode(unicodeCharacters.newKeyCode2);
  }
  else {
    newChar = String.fromCharCode(unicodeCharacters.newKeyCode1) +
    String.fromCharCode(unicodeCharacters.newKeyCode2);
  }
  return { replaceKey:true, newKey:newChar };
}

function getUnicode(keyCode) {
				var key = String.fromCharCode(keyCode);
				if(vowelFlag) {
					switch(key) {
						case 'A': { vowel_nn = navigator.appName=="Netscape" ?
								true : false ;vowelFlag = false;
								return {newKeyCode1:0, newKeyCode2:(2310+offset)};
								break;
						}
						case 'i': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2311+offset) };
								break;
						}
						case 'I': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2312+offset) };
								break;
						}
						case 'u': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2313+offset) };
								break;
						}
						case 'U': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2314+offset) };
								break;
						}
						case 'q': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								if(offset != 640) {
									return { newKeyCode1:0, newKeyCode2:(2315+offset) };
								}
								else {
									if(navigator.appName=="Netscape") {
										return { newKeyCode1:0,newKeyCode2:-1};
									}
									else {
										return { newKeyCode1:0,newKeyCode2:0};
									}
								}
								break;
						}
						case 'L': {
								vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								if(offset != 640) {
									return { newKeyCode1:0, newKeyCode2:(2316+offset) };
								}
								else{
									if(navigator.appName=="Netscape") {
										return { newKeyCode1:0, newKeyCode2:-1 };
									}
									else {
										//if(navigator.appName=="Microsoft")
										return { newKeyCode1:0,newKeyCode2:0};
									}
								}
								break;
						}
						case 'e': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2319+offset) };
								break;
						}
						case 'E': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2320+offset) };
								break;
						}
						case 'o': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2323+offset) };
								break;
						}
						case 'O': { vowel_nn = navigator.appName=="Netscape" ?
								true : false;vowelFlag = false;
								return { newKeyCode1:0, newKeyCode2:(2324+offset) };
								break;
						}
						case 'Q': {
								if(offset != 640) { // if input language is not Tamil
									vowel_nn = navigator.appName=="Netscape" ?
									true : false;vowelFlag = false;
									return { newKeyCode1:0, newKeyCode2:(2400+offset) };
								}
								break;
						}
						default : {
							vowelFlag = false;
							return {
								newKeyCode1:getConsonant(keyCode), newKeyCode2:(2309+offset)
							};
							break;
						}
					}
				}
				else {
					var newKeyCode = getConsonant(keyCode);
					return { newKeyCode1:0, newKeyCode2:newKeyCode };
				}
			}

			function getConsonant(keyCode) {
				var key = String.fromCharCode(keyCode);
				switch(key) {
					case 'a': {
						vowelFlag = true;
		                if(navigator.appName == "Netscape") {
							return ;
						}
						else if(navigator.appName == "IE") {
							return 0;
						}
						break;
					}
					case 'Z': {
							// If the input Language is either Tamil or Kannada
						if( (offset != 640) && (offset != 896) ) {
							return (2305+offset);
						}
						else {
							if(navigator.appName == "Netscape") {
								return -1;
							}
							else {
								return 0;
							}
						}
						break;
					} // "chandabindu"
					case 'M': {
						return (2306+offset);
						break;
					} // DEVANAGARI CHARACTER "anuswar"
					case 'H': {
						return(2307+offset);
						break;
					} // DEVANAGARI CHARACTER "visarg"
					case 'k': {
						return(2325+offset);
						break;
					} // DEVANAGARI CHARACTER "ka"
					case 'K': {
						if(offset == 640) {
							return(2325+offset);
						}
						else {
							return(2326+offset); // "kha"
						}
					break;
					}
					case 'g': {
						if(offset == 640) {
							return(2325+offset);
						}
						else {
							return(2327+offset); //  "ga"
						}
					break;
					}
					case 'G': {
						if(offset == 640) {
							return(2325+offset);
						}
						else {
							return(2328+offset); //  "gha"
						}
					break;
					}
					case 'f': {
						return(2329+offset); //"nga"
						break;
					}
					case 'c': {
						return(2330+offset); // "ca"
						break;
					}
					case 'C': {
						if(offset == 640 ) { // if the input language is Tamil.
							return(2330+offset); // ca and cha are same in Tamil.
						}
						else {
							return(2331+offset);   // "cha"
						}
					break;
					}
					case 'j': {
						return(2332+offset); // "ja"
						break;
					}
					case 'J': {
						if(offset == 640) {
							return(2332+offset); // in tamil ja and jha are same.
						}
						else {
							return(2333+offset); //  "jha"
						}
						break;
					}
					case 'F': {
						return(2334+offset); // "nya"
						break;
					}
					case 't': {
						return(2335+offset); // "tta"
						break;
					}
					case 'T': {
						if(offset == 640) {
							return(2335+offset); // in tamil tta and ttha are same.
						}
						else {
							return(2336+offset); //  "jha"
						}
						break;
					}
					case 'd': {
						if(offset == 640) {
							return(2335+offset); // in tamil tta,ttha,dda are same.
						}
						else {
							return(2337+offset); //  "jha"
						}
						break;
					}
					case 'D': {
						if(offset == 640) {
							return(2335+offset); // in tamil tta,ttha,dda,ddha are same.
						}
						else {
							return(2338+offset); //  "ddha"
						}
						break;
					}
					case 'N': {
						return(2339+offset); // "nna"
						break;
					}
					case 'w': {
						return(2340+offset); // DEVANAGARI CHARACTER "ta"
						break;
					}
					case 'W': {
						if(offset == 640) {
							return(2340+offset); // in tamil ta and tha are same.
						}
						else {
							return(2341+offset); //  "tha"
						}
						break;
					}
					case 'x': {
						if(offset == 640) {
							return(2340+offset); // in tamil ta,tha,da are same.
						}
						else {
							return(2342+offset); //  "da"
						}
						break;
					}
					case 'X': {
						if(offset == 640) {
							return(2340+offset); // in tamil ta,tha,da and dha are same.
						}
						else {
							return(2343+offset); //  "dha"
						}
						break;
					}
					case 'n': {
						return(2344+offset); // "na"
						break;
					}
					case 'p': {
						return(2346+offset); // "pa"
						break;
					}
					case 'P': {
						if(offset == 640) {
							return(2346+offset); // in tamil pa,pha are same.
						}
						else {
							return(2347+offset); //  "dha"
						}
						break;
					}
					case 'b': {
						if(offset == 640) {
							return(2346+offset); // in tamil pa,pha,ba are same.
						}
						else {
							return(2348+offset); //  "ba"
						}
						break;
					}
					case 'B': {
						if(offset == 640) {
							return(2346+offset); // in tamil pa,pha,ba & bha are same.
						}
						else {
							return(2349+offset); //  "bha"
						}
						break;
					}
					case 'm': {
						return(2350+offset); // "ma"
						break;
					}
					case 'y': {
						return(2351+offset); // "ya"
						break;
					}
					case 'r': {
						return(2352+offset); // "ra"
						break;
					}
					case 'l': {
						return(2354+offset); // "la"
						break;
					}
					case 'v': {
						return(2357+offset); // "va"
						break;
					}
					case 'S': {
						if(offset != 640) { //if the input language is not tamil.
							return(2358+offset); // "Sha"
						}
						break;
					}
					case 'R': {
						return(2359+offset); // "SSa"
						break;
					}
					case 's': {
						return(2360+offset); // "Sa"
						break;
					}
					case 'h': {
						return(2361+offset); // "ha"
						break;
					}
					case 'z': {
						if(offset < 640) { // 'Nukta' will not be in south indian scripts.
							return(2364+offset);
						}
						break;
					} //  "Nukta" (only in North indian scripts).
					case 'A': {
						return(2366+offset); // "aA"
						break;
					}
					case 'i': {
						if(isNav && offset==0) {
							imatraFlag = true;
						}
						return(2367+offset); // Vowel Sign "ii"
						break;
					}
					case 'I': {
						return(2368+offset); // Vowel Sign "iI"
						break;
					}
					case 'u': {
						return(2369+offset); // Vowel Sign "u"
						break;
					}
					case 'U': {
						return(2370+offset); // Vowel Sign "uU"
						break;
					}
					case 'q': {
						return(2371+offset); // Vowel Sign Vocalic "R"
						break;
					}
					case 'e': {
						if(offset == 896) {
							return (3270);
						}
						else if(offset == 768)  {
							return (3142);
						}
						else {
							return(2375+offset); // Vowel Sign "E"
						}
						break;
					}
					case 'E': {
						return(2376+offset); // Vowel Sign "AI"
						break;
					}
					case 'o': {
						return(2379+offset); // Vowel Sign "O"
						break;
					}
					case 'O': {
						return(2380+offset); // Vowel Sign "AU"
						break;
					}
					case '_': {
						return(2381+offset); // HALANT
						break;
					}
					case '.': {
						if(offset < 640) { //if the input language is not a South indian lang.
							return(2404+offset); // VIRAM
						}
						else {
							return(46);
						}
						break;
					}
					case '0': {
						if(offset != 640) {
							return(2406+offset); // DEVANAGARI DIGIT ZERO
						}
						else {
								if(navigator.appName == "Netscape") {
									return -1;
								}
								else {
									return 0;
								}
						}
						break;
					}
					case '1': {
						return(2407+offset); // DIGIT ONE
						break;
					}
					case '2': {
						return(2408+offset); // DIGIT TWO
						break;
					}
					case '3': {
						return(2409+offset); // DIGIT THREE
						break;
					}
					case '4': {
						return(2410+offset); // DIGIT FOUR
						break;
					}
					case '5': {
						return(2411+offset); // DIGIT FIVE
						break;
					}
					case '6': {
						return(2412+offset); // DIGIT SIX
						break;
					}
					case '7': {
						return(2413+offset); // DIGIT SEVEN
						break;
					}
					case '8': {
						return(2414+offset); // DIGIT EIGHT
						break;
					}
					case '9': {
						return(2415+offset); // DIGIT NINE
						break;
					}
				}
			}


//end of IME

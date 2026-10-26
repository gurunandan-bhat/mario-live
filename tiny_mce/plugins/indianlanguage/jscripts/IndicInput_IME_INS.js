/*  This code is used to capture events on a textArea or a textField.
    The key character is captured and converted to Unicode for display. */

    var offset;
    var virtualKeyboardArray = new Array();
    var hindiUnicodeStart = 2304;
    var w,languageIndex;

    //variable IE will be set if the browser is Internet Explorer
    //var IE = !window.opera && (window.event || document.all);
    var classAttrib = (IE)? "className":"class";

	offset = parseInt(document.indicForm.offset.value);

    function eventHandler(target,event) {
   //events originated from the specified target only be processed
        //if(target.type == "textarea" && target.getAttribute(classAttrib) == "indic_ime")
    		handleCharacter(target,event,replaceAscii);
    }

    function handleCharacter(textControl, event, keyChecker) {
   		var keyCode = 0;

   		if(IE)
   		    keyCode = event.keyCode;
   		else if(event.which)
   		    keyCode = event.which;

		var key = String.fromCharCode(keyCode);

   		var keyCheck = keyChecker(keyCode,key);
   		//If IE
   		if (keyCode && event && IE) {
   		    if (keyCheck.replaceKey) {
    			event.keyCode = keyCheck.newKey.charCodeAt(0);
   				if(keyCheck.newKey.length == 2) {
   			 	  textControl.value = textControl.value +
	    		  keyCheck.newKey.charAt(1);
   				}
				if (event.preventDefault) {
					event.preventDefault();
				}
				return true;
	    	}
		}//if IE
					//If netscape
		else if (typeof textControl.setSelectionRange != 'undefined') {
	    	if (keyCheck.replaceKey) {
					// cancel the key event and insert the newKey for the current selection
				if (event.preventDefault) {
					event.preventDefault();
				}
				var oldSelectionStart = textControl.selectionStart;
				var oldSelectionEnd = textControl.selectionEnd;
				var selectedText = textControl.value.substring(
				oldSelectionStart,oldSelectionEnd);
				var newText = typeof keyCheck.newKey != 'undefined' ?
				keyCheck.newKey.charAt(0) : String.fromCharCode(
				keyCheck.newKey.charCodeAt(0));
				textControl.value = textControl.value.substring(0,
				oldSelectionStart) + newText + textControl.value.substring(oldSelectionEnd);
                textControl.setSelectionRange(oldSelectionStart + newText.length,oldSelectionStart +
                                newText.length);
				return false;
	    	}
	    	else {
				return true;
	    	}
		}
    }

	function replaceAscii(keyCode,key) {
		var unicodeCharacters = getUnicode(keyCode);
		return { replaceKey:unicodeCharacters.replace, newKey:unicodeCharacters.newChar };
	}

		function getUnicode(keyCode) {
			var key = String.fromCharCode(keyCode);
			var newChar,replace;
			switch(key) {
				case 'a':{ replace=true;newChar=getChar(2379+offset);break; }
				case 'A':{ replace=true;newChar=getChar(2323+offset);break; }
				case 'b':{ replace=true;newChar=getChar(2357+offset);break; }
				case 'B':{ replace=true;newChar=getChar(2356+offset);break; }
				case 'c':{ replace=true;newChar=getChar(2350+offset);break; }
				case 'C':{ replace=true;newChar=getChar(2339+offset);break; }
				case 'd':{ replace=true;newChar=getChar(2381+offset);break; }
				case 'D':{ replace=true;newChar=getChar(2309+offset);break; }
				case 'e':{ replace=true;newChar=getChar(2366+offset);break; }
				case 'E':{ replace=true;newChar=getChar(2310+offset);break; }
				case 'f':{ replace=true;newChar=getChar(2367+offset);break; }
				case 'F':{ replace=true;newChar=getChar(2311+offset);break; }
				case 'g':{ replace=true;newChar=getChar(2369+offset);break; }
				case 'G':{ replace=true;newChar=getChar(2313+offset);break; }
				case 'h':{ replace=true;newChar=getChar(2346+offset);break; }
				case 'H':{ replace=true;newChar=getChar(2347+offset);break; }
				case 'i':{ replace=true;newChar=getChar(2327+offset);break; }
				case 'I':{ replace=true;newChar=getChar(2328+offset);break; }
				case 'j':{ replace=true;newChar=getChar(2352+offset);break; }
				case 'J':{ replace=true;newChar=getChar(2353+offset);break; }
				case 'k':{ replace=true;newChar=getChar(2325+offset);break; }
				case 'K':{ replace=true;newChar=getChar(2326+offset);break; }
				case 'l':{ replace=true;newChar=getChar(2340+offset);break; }
				case 'L':{ replace=true;newChar=getChar(2341+offset);break; }
				case 'm':{ replace=true;newChar=getChar(2360+offset);break; }
				case 'M':{ replace=true;newChar=getChar(2358+offset);break; }
				case 'n':{ replace=true;newChar=getChar(2354+offset);break; }
				case 'N':{ replace=true;newChar=getChar(2355+offset);break; }
				case 'o':{ replace=true;newChar=getChar(2342+offset);break; }
				case 'O':{ replace=true;newChar=getChar(2343+offset);break; }
				case 'p':{ replace=true;newChar=getChar(2332+offset);break; }
				case 'P':{ replace=true;newChar=getChar(2333+offset);break; }
				case 'q':{ replace=true;newChar=getChar(2380+offset);break; }
				case 'Q':{ replace=true;newChar=getChar(2324+offset);break; }
				case 'r':{ replace=true;newChar=getChar(2368+offset);break; }
				case 'R':{ replace=true;newChar=getChar(2312+offset);break; }
				case 's':{ replace=true;newChar=getChar(2375+offset);break; }
				case 'S':{ replace=true;newChar=getChar(2319+offset);break; }
				case 't':{ replace=true;newChar=getChar(2370+offset);break; }
				case 'T':{ replace=true;newChar=getChar(2314+offset);break; }
				case 'u':{ replace=true;newChar=getChar(2361+offset);break; }
				case 'U':{ replace=true;newChar=getChar(2329+offset);break; }
				case 'v':{ replace=true;newChar=getChar(2344+offset);break; }
				case 'V':{ replace=true;newChar=getChar(2345+offset);break; }
				case 'w':{ replace=true;newChar=getChar(2376+offset);break; }
				case 'W':{ replace=true;newChar=getChar(2320+offset);break; }
				case 'x':{ replace=true;newChar=getChar(2306+offset);break; }
				case 'X':{ replace=true;newChar=getChar(2305+offset);break; }
				case 'y':{ replace=true;newChar=getChar(2348+offset);break; }
				case 'Y':{ replace=true;newChar=getChar(2349+offset);break; }
				case 'z':{ replace=true;newChar=getChar(2374+offset);break; }
				case 'Z':{ replace=true;newChar=getChar(2318+offset);break; }
				case '[':{ replace=true;newChar=getChar(2337+offset);break; }
				case ']':{ replace=true;newChar=getChar(2364+offset);break; }
				case '{':{ replace=true;newChar=getChar(2338+offset);break; }
				case '}':{ replace=true;newChar=getChar(2334+offset);break; }
				case '"':{ replace=true;newChar=getChar(2336+offset);break; }
				case '\'':{ replace=true;newChar=getChar(2335+offset);break; }
				case ';':{ replace=true;newChar=getChar(2330+offset);break; }
				case ':':{ replace=true;newChar=getChar(2331+offset);break; }
				//case '.':{ replace=true;newChar=getChar(2379+offset);break; }
				case '<':{ replace=true;newChar=getChar(2359+offset);break; }
				//case ',':{ replace=true;newChar=getChar(2379+offset);break; }
				case '>':{ replace=true;newChar=getChar(2404+offset);break; }
				case '0':{ replace=true;newChar=getChar(2406+offset);break; }
				case '1':{ replace=true;newChar=getChar(2407+offset);break; }
				case '2':{ replace=true;newChar=getChar(2408+offset);break; }
				case '3':{ replace=true;newChar=getChar(2409+offset);break; }
				case '4':{ replace=true;newChar=getChar(2410+offset);break; }
				case '5':{ replace=true;newChar=getChar(2411+offset);break; }
				case '6':{ replace=true;newChar=getChar(2412+offset);break; }
				case '7':{ replace=true;newChar=getChar(2413+offset);break; }
				case '8':{ replace=true;newChar=getChar(2414+offset);break; }
				case '9':{ replace=true;newChar=getChar(2415+offset);break; }
				case '/':{ replace=true;newChar=getChar(2351+offset);break; }
				case '\\':{ replace=true;newChar=getChar(2377+offset);break; }
				case '~':{ replace=true;newChar=getChar(2378+offset);break; }
				case '|':{ replace=true;newChar=getChar(2321+offset);break; }
				case '?':{ replace=true;newChar=getChar(2399+offset);break; }
				case '!':{ replace=true;newChar=getChar(2317+offset);break; }
				case '@':{ replace=true;newChar=getChar(2373+offset);break; }
				case '#':{ replace=true;newChar=getChar(2322+offset);break; }
				case '_':{ replace=true;newChar=getChar(2307+offset);break; }
				case '+':{ replace=true;newChar=getChar(2315+offset);break; }
				case '=':{ replace=true;newChar=getChar(2371+offset);break; }
				case '&':{ //ksha
							replace=true;
							newChar=getChar(2325+offset,2381+offset,2359+offset);
							break;
						 }
				case '^':{ //tra
							replace=true;
							newChar=getChar(2340+offset,2381+offset,2352+offset);
							break;
						 }
				case '*':{ //shra
							replace=true;
							newChar=getChar(2358+offset,2381+offset,2352+offset);
							break;
						 }
				case '%':{ //gna
							replace=true;
							newChar=getChar(2332+offset,2381+offset,2334+offset);
							break;
						 }
				default :{ replace=false;}

			}
			return { replace:replace,newChar:newChar};
		}

		function getChar(code) {
			var newChar = String.fromCharCode(code);
			return newChar;
		}

		function getChar(code1,code2,code3) {
			var newChar = String.fromCharCode(code1) +
						String.fromCharCode(code2) +
						String.fromCharCode(code3);
			return newChar;
		}

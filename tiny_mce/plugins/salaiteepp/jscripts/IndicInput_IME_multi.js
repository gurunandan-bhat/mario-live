var lang_vowel =
            new Array(
                "a,aa,A,a',i,ii,ee,ia,i',I,u,uu,oo,U,ua,u',e,E,ea,ae,e',ai,o,O,oe," +
                "oa,o',au,ou,aq,q,Q,sri,0,1,2,3,4,5,6,7,8,9",
                "a,aa,A,a',i,ii,ee,ia,i',I,u,uu,oo,U,ua,u',r'u,Ru,e,E,ea,ae,e',ai," +
                "o,O,oe,oa,o',au,ou,~l,~L,M,\@h,\@H,\@M,q,\@2,oM,OM,0,1,2,3,4,5,6," +
                "7,8,9,|,||",
                "a,aa,A,a',i,ii,ee,ia,i',I,u,uu,oo,U,ua,u',R,r',r'u,Ru,e,E,ea,ae,"  +
                "e',ai,o,O,oe,oa,o',au,ou,~l,~L,M,\@h,\@H,@M,\@2,0,1,2,3,4,5,6,7,"  +
                "8,9,|,||"
            );

        //unicode value for independent vowel - when added with the starting unicode
        //value of a particular indic language will produce the indic character

var lang_vowel_code =
            new Array(
                "5,6,6,6,7,8,8,8,8,8,9,10,10,10,10,10,14,15,15,15,15,16,18,19,19," +
                "19,19,20,20,3,3,3,56 77 48 64,102,103,104,105,106,107,108,109,"   +
                "110,111",
                "5,6,6,6,7,8,8,8,8,8,9,10,10,10,10,10,11,96,15,15,15,15,14,16,19," +
                "19,19,19,18,20,20,12,97,2,3,3,1,60,61,80,80,102,103,104,105,106," +
                "107,108,109,110,111,100,101",
                "5,6,6,6,7,8,8,8,8,8,9,10,10,10,10,10,11,11,96,96,14,15,15,15,15," +
                "16,18,19,19,19,19,20,20,12,97,2,3,3,1,-707,102,103,104,105,106,"  +
                "107,108,109,110,111,-668,-667"
            );

        //unicode value for dependent vowel - when added with the starting unicode
        //value of a particular indic language will produce the indic character

var lang_vowel_symbol_code =
            new Array(
                ",62,62,62,63,64,64,64,64,64,65,66,66,66,66,66,70,71,71,71,71,72," +
                "74,75,75,75,75,76,76,,,,,,,,,,,,,,",
                ",62,62,62,63,64,64,64,64,64,65,66,66,66,66,66,67,68,71,71,71,71," +
                "70,72,75,75,75,75,74,76,76,98,99,2,3,3,1,60,61,,,,,,,,,,,,,,",
                ",62,62,62,63,64,64,64,64,64,65,66,66,66,66,66,67,67,68,68,70,71," +
                "71,71,71,72,74,75,75,75,75,76,76,,,2,3,3,1,,,,,,,,,,,,,"
            );

        //key map for consonant characters for different languages - should follow
        //the same keymap standard as vowel characters.
        //halant character will be added automatically to consonants

var lang_consonant =
            new Array(
                "ksh,k,kh,K,Kh,g,gh,G,Gh,~m,ng,c,ch,C,Ch,c',j,jh,J,Jh,~n,ny,T,t',Th,"  +
                "th',D,d',Dh,dh',N,nh,t,th,d,dh,n,n',p,ph,f,P,Ph,b,bh,B,Bh,m,y,r," +
                "R,r',l,L,lh,Lh,l',z,Z,zh,Zh,v,w,S,s',sh,Sh,s,h,H",
                "k,kh,kH,K,Kh,KH,g,gh,gH,G,Gh,GH,~m,c,ch,cH,C,Ch,CH,c',j,jh,jH,J," +
                "Jh,JH,~n,T,t',Th,TH,th',tH',D,d',Dh,DH,dh',dH',N,nh,nH,n',t,th,"  +
                "tH,d,dh,dH,n,p,ph,pH,f,P,Ph,PH,b,bh,bH,B,Bh,BH,m,y,r,l,L,lh,v,w," +
                "S,s',sh,sH,Sh,SH,s,h,H",
                "k,kh,kH,K,Kh,KH,g,gh,gH,G,Gh,GH,~m,c,ch,cH,C,Ch,CH,c',j,jh,jH,J," +
                "Jh,JH,~n,T,t',Th,TH,th',tH',D,d',Dh,DH,dh',dH',N,nh,nH,n',t,th,"  +
                "tH,d,dh,dH,n,p,ph,pH,f,P,Ph,PH,b,bh,bH,B,Bh,BH,m,y,r,l,v,w,S,s'," +
                "sh,sH,Sh,SH,s,h,H,L,lh,Lh,l',r\",~r"
            );

        //unicode value for consonants - when added with the starting unicode
        //value of a particular indic language will produce the indic character

var lang_consonant_code =
            new Array(
                "21 77 55,21,21,21,21,21,21,21,21,25,25,26,26,26,26,26,28,28,28,28,30,30,31," +
                "31,31,31,31,31,31,31,35,35,36,36,36,36,40,41,42,42,42,42,42,42,42," +
                "42,42,46,47,48,49,49,50,51,52,51,51,52,52,52,52,53,53,55,55,55,55," +
                "56,57,57",
                "21,22,22,22,22,22,23,24,24,24,24,24,25,26,26,26,27,27,27,27,28,29," +
                "29,29,29,29,30,31,31,32,32,32,32,33,33,34,34,34,34,35,35,35,35,36," +
                "37,37,38,39,39,40,42,43,43,43,43,43,43,44,45,45,45,45,45,46,47,48," +
                "50,51,52,53,53,54,54,55,55,55,55,56,57,57",
                "21,22,22,22,22,22,23,24,24,24,24,24,25,26,26,26,27,27,27,27,28,29," +
                "29,29,29,29,30,31,31,32,32,32,32,33,33,34,34,34,34,35,35,35,35,36," +
                "37,37,38,39,39,40,42,43,43,43,43,43,43,44,45,45,45,45,45,46,47,48," +
                "50,53,53,54,54,55,55,55,55,56,57,57,51,51,51,51,49,49"
            );



    //details stored in lang_details are in the following order

    //"keyboard_label","vowel_index","vowel_code_index","consonant_index",
    //"consonant_code_index","codebase_value","halant_value"

var lang_details =
    new Array(
        new Array("tamil_rts"   ,"0"    ,"0"    ,"0"    ,"0"    ,"0x0b80"  ,"77"),
        new Array("hindi_rts"   ,"1"    ,"1"    ,"1"    ,"1"    ,"0x0900"  ,"77"),
        new Array("marathi_rts" ,"1"    ,"1"    ,"1"    ,"1"    ,"0x0900"  ,"77"),
        new Array("telugu_rts"  ,"2"    ,"2"    ,"2"    ,"2"    ,"0x0c00"  ,"77")
    );

var isMenu = false;     //flag tells us the display status of hint menu

//variable IE will be set if the browser is Internet Explorer
//var IE = !window.opera && (window.event || document.all);

//needed to get the value for the class attribute for any tag
var classAttrib = (IE)? "className":"class";

var vowel;
var vowel_code;
var vowel_symbol_code;
var consonant;
var consonant_code;
var charlist;
var halant;
var codebase;

        //prevChar - previously typed character(s), may form another indic character
        //while adding new character(s)
var prevChar = "";
var prevLen = 0;    //length of the string stored in 'prevChar'

        //isInBothSet - tells us whether the last character typed present in both
        //vowel and consonant character set
var isInBothSet = false;

        //strInBothSet - contains the previously typed string which is present in
        //vowel and consonant character set
var strInBothSet = "";

load();     //called when the page first loaded, to initialize some global variables

document.onclick = freeze;
document.onkeyup = splEvent;

/*
Specific funtion for Internet Explorer. It is called in response to keyup event.
It handles the event for some specific keys.
*/
function splEvent(event)             //specific for IE
{
    var key;
    if(IE) {
        key = window.event.keyCode;
        switch(key) {
            case 8:   // backspace
            case 17:  // control
            case 18:  // alt
            case 33:  // page up
            case 34:  // page down
            case 35:  // end
            case 36:  // home
            case 37:  // left arrow
            case 38:  // up arrow
            case 39:  // right arrow
            case 40:  // down arrow
            case 45:  // insert
            case 46:  // delete
                //characters typed upto now won't be changed by
                //the addition of characters
                freeze();
        }
    }
}

/*
This function calls the function 'getUniChar' by sending the text to be transliterated
and gets back the transliterated text. Then inserts the transliterated text into the
appropriate place in the editable area.
*/
function eventHandler(textControl,event)
{
//alert("eventHandler");
    var selectionStart,selectionEnd,result,scrollTop,scrollLeft;
    var keyCode=0,str="";

    //events originated from the specified target only be processed
//alert(textControl.getAttribute(classAttrib));
    //if(textControl.type!="textarea" || textControl.getAttribute(classAttrib)!="indic_ime")
        //return;

    if(IE)
        keyCode = event.keyCode;
    else if(event.which)
        keyCode = event.which;

    var key = String.fromCharCode(keyCode);

    if(event.ctrlKey || event.altKey) {
        //don't process the key if control or alt pressed
    }
    else if(charlist.indexOf(key) != -1) {
        //if the key is mapped fully or partially to any indic character

        if(event.preventDefault) //prevent its default functionality
            event.preventDefault();
        else
            event.returnValue = false;

        //str - english character(s) to be converted into Indic character(s)
        str = prevChar + key;
        result = getUniChar(str);
        key = result.str;       //the converted indic character(s)

        prevChar = str.substring(result.freezpos);
        //freezpos is a position within the english string.
        //While converting english string into indic, the characters starting
        //from freezpos won't affect the characters upto freezpos.

        isInBothSet = result.bothcharset;
        //isInBothSet is true if recently typed character(s) can form combinations
        //both in vowel and consonant charset
        //eg., 'r' can be a consonant or it can be changed to vowel by the addition
        //of a single quote(r')

        strInBothSet = result.charsetstr;
        //recently typed character(s) that form combinations both in vowel and
        //consonant charset

        if(document.selection) {    // for IE
            textControl.focus();
            sel = document.selection.createRange();
            sel.moveStart('character',-prevLen);
            sel.text = key; //replace the selected text by the character(s) in 'key'

            sel.select();       //deselect, if selected
        }
        else if(textControl.setSelectionRange) {    // for Netscape, Firefox
            selectionStart = textControl.selectionStart - prevLen;
            selectionEnd = textControl.selectionEnd;
            scrollTop = textControl.scrollTop;
            scrollLeft = textControl.scrollLeft;

            textControl.value = textControl.value.substring(0,selectionStart) +  key +
                                textControl.value.substring(selectionEnd);
            textControl.setSelectionRange(selectionStart + key.length,selectionStart +
                                key.length);

            textControl.scrollTop = scrollTop;   //set the top line to be displayed
            textControl.scrollLeft = scrollLeft; //set the left column to be displayed
        }
        else {      // for other Browsers - opera
            textControl.value = textControl.value.substring(0,textControl.value.length
                                                                    -prevLen) + key;
        }
        //I don't know how to find the cursor position in a Textarea in Opera, So I
        //just append or replace some recently typed characters

        prevLen = result.indic.length;
        //prevLen - contains the length of the indic charcter(s) which can be affected
        //by the addition of new characters

        //show or hide hint menu for typing indic character
        //if(prevChar != "" && document.getElementById("div_keymap_hint").checked;)
            //showMenu(prevChar,textControl);
        //else
            hideMenu();

        return;     //return without calling freeze

    }//end of code for converting the key

    else if((keyCode >=65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)) {
        //prevent displaying of alphabets not mapped
        if(event.preventDefault)
            event.preventDefault();
        else
            event.returnValue = false;
    }

    freeze();
}

/*
This function is able to transliterate the english string into indic equivalent.
*/
function getUniChar(str, mode)
{
//alert("getUniChar");
    var i,result="",prevresult="",resultstr="",temp="",match="",indic="",start=0;
    var charsetstr="",newstr="",isPrevHalf=false,freezpos=0,tempresult="";
    var bothcharset=false;

    for(i=0;i<str.length;i++) {
        //take characters one by one from incoming string 'str' and form a string
        //which needs to be compared with the key map
        newstr = str.substring(start,i+1);

        //find the charset in which the combination exists
        result = findCharSet(newstr);
        match = "";

        if(result.match == "nomatch")     //no matching combinations found
            match = "nomatch";
        else if(result.match == "notexact") {
            match = "notexact";
            //one or more combinations start with the string but not exactly
            //equals to the string
        }
        else if(result.charset == "vowel") {
            //string exactly matches with one combination in vowel charset
            if((result.vowcount + result.conscount) == 1) {
                //the string matches with only one combination in vowel charset only -
                //won't be affected by the addition of new characters
                match = "vowel";
            }
            else {
                //many combinations in vowel charset(and consonant charset may also)
                //start with the string - can be changed to another vowel or even
                //consonant by the addition of new characters
                match = "vowel*";
            }
        }
        else if(result.charset == "consonant") {
            //string exactly matches with one combination in consonant charset
            if((result.vowcount + result.conscount) == 1) {
                //the string matches with only one combination in consonant
                //charset only
                match = "consonant";
            }
            else {
                //many combinations in consonant charset(and vowel charset may also)
                //start with the string
                match = "consonant*";
            }
        }

        if(match == "vowel") {
            if(isPrevHalf &&
            (vowel_code[result.index]=="5"||vowel_symbol_code[result.index]!="")) {
                //the previous character is a consonant and (the current vowel
                //character has dependent vowel sign or it is the first vowel of
                //indic language(don't have dependent vowel sign))

                resultstr = resultstr.substring(0,resultstr.length-1);
                //remove the halant from the result string

                if(vowel_code[result.index] != "5") {
                    //the current letter is not the first vowel, add dependent
                    //vowel sign
                    resultstr += fromCharCodeArray(
                                    parseAndAdd(vowel_symbol_code[result.index],
                                    codebase)
                                 );
                }
            }
            else {
                //previous character is not a consonant, add the independent vowel
                //to the result
                resultstr += fromCharCodeArray(
                                parseAndAdd(vowel_code[result.index],
                                codebase)
                             );
            }
            start = i+1; indic = ""; isPrevHalf = false;
            freezpos = start;
            //string upto current character can be freezed
        }
        else if(match == "consonant") {
            //add the consonant character and halant to the result
            indic =
                fromCharCodeArray(
                    parseAndAdd(consonant_code[result.index]+" "+halant,codebase)
                );
            resultstr += indic;
            freezpos = start; start = i+1; isPrevHalf = true;
        }
        else if(match == "nomatch" || (result.match == "notexact" && mode == "inner"))
        {
            //mode will be having the value 'inner' at the time of recursive call
            //inner mode & notexact string is treated as nomatch string

            if(newstr.length == 1) {
                //only one mapped character that doesn't match with any combination
                //as it is.

                if(isSplChar(newstr.charAt(0))) {
                    //it is a special character like single quote as in r'
                    resultstr += newstr;    //add it to the result
                }
                //'else' is not needed, because a single alphabet with
                //match = nomatch will not have indic equivalent.

                start = i+1; isPrevHalf = false; indic = "";
                freezpos = start;
                //string upto current character can be freezed since the newcoming
                //character can't affect the last special character
            }
            else if(prevresult.match == "notexact") {
                if(newstr.length == 2) {
                    //one character, match = notexact(at the previous iteration)

                    if(isSplChar(newstr.charAt(0))) {
                        //eg., tilde character(~)
                        resultstr += newstr.charAt(0);
                    }
                    //'else' is not needed, because a single alphabet with
                    //match = notexact will not have indic equivalent

                    indic = ""; start = i; freezpos = start; i--; isPrevHalf = false;
                }
                else {
                    //more than one character, match = notexact
                    //(at the previous iteration) eg., r' in Hindi

                    resultstr = resultstr.substring(0,resultstr.length-indic.length);

                    //following is a recursive call to function 'getUniChar'
                    tempresult = getUniChar(
                                    str.substring(freezpos,start)+
                                    newstr.substring(0,newstr.length - 1),"inner"
                                 );
                    indic = tempresult.indic;
                    freezpos += tempresult.freezpos;
                    start = i;
                    //start from the last character, since addition of this failed to
                    //make any combinations

                    i--;
                    //to compensate the i++ in for loop so that last character
                    //will be used as start

                    resultstr += tempresult.str;

                    if(indic.charCodeAt(indic.length-1) == halant + codebase) {
                        //the last character of returned indic string is halant -
                        //so the last character is a consonant
                        isPrevHalf = true;
                    }
                    else
                        isPrevHalf = false;
                }
            }
            else if(prevresult.charset == "vowel" &&
                    (prevresult.vowcount + prevresult.conscount) > 1) {
                //previous match = vowel* - similar to the case match = vowel

                if(isPrevHalf && (vowel_code[prevresult.index]=="5"||
                                  vowel_symbol_code[prevresult.index]!="")) {

                    resultstr = resultstr.substring(0,resultstr.length-1);

                    if(vowel_code[prevresult.index] != "5") {
                        resultstr += fromCharCodeArray(
                            parseAndAdd(vowel_symbol_code[prevresult.index],codebase)
                        );
                    }
                }
                else {
                    resultstr += fromCharCodeArray(
                                    parseAndAdd(vowel_code[prevresult.index],
                                    codebase)
                                 );
                }
                start = i; freezpos = start; i--; isPrevHalf = false;
                indic = "";
            }
            else if(prevresult.charset == "consonant" &&
                    (prevresult.vowcount + prevresult.conscount) > 1) {
                //consonant* - similar to the case match = "consonant"

                indic = fromCharCodeArray(
                    parseAndAdd(consonant_code[prevresult.index]+" "+halant,codebase)
                );
                resultstr += indic;
                freezpos = start; start = i; i--; isPrevHalf = true;
            }
        }//else if(match=="nomatch" ...) ends here
        else if(i == str.length - 1) {
            //if the final character of the incoming string reached

            if(match == "vowel*") {
                //splvowcount - no. of combinations(in vowel charset) which start with
                //the formed string, having no dependent vowel symbol
                //(except 'a') eg., '|' in hindi,telugu
                //so they won't affect the previous character

                if(result.splvowcount == result.vowcount) {
                    //all combinations are vowels without dependent vowel sign -
                    //the input string can be freezed upto the previous character
                    freezpos = start;

                    indic = "";
                }

                //similar to the case match = vowel
                resultstr = resultstr.substring(0,resultstr.length - indic.length);

                if(isPrevHalf && (vowel_code[result.index]=="5"||
                                  vowel_symbol_code[result.index]!="")) {

                    indic = indic.substring(0,indic.length - 1);
                    if(vowel_code[result.index] != "5") {
                        //for 'a' no symbol is needed

                        indic += fromCharCodeArray(
                                    parseAndAdd(vowel_symbol_code[result.index],
                                    codebase)
                                 );
                    }
                }
                else {
                    indic += fromCharCodeArray(
                                parseAndAdd(vowel_code[result.index],
                                codebase)
                             );
                }
                resultstr += indic;
            }
            else if(match == "consonant*") {
                temp = fromCharCodeArray(
                        parseAndAdd(consonant_code[result.index]+" "+halant,codebase)
                    );
                if(result.vowcount == 0 || result.splvowcount == result.vowcount) {
                    //the formed string won't be changed into
                    //a vowel when adding character(s)
                    //so previous characters won't be affected, can be freezed

                    freezpos = start;
                    indic = temp;
                }
                else {
                    //the formed string may be changed into a vowel when adding
                    //one or more characters
                    //eg., consonant character r can be changed to vowel(r')
                    //by adding single quote in telugu_rts keymap

                        bothcharset = true;
                        charsetstr = newstr;
                        indic += temp;
                }
                resultstr += temp;
            }
            else if(match == "notexact") {
                if(newstr.length == 1) {
                    //only one character in the formed string 'newstr'

                    if(isSplChar(newstr.charAt(0))) {
                        //special character (not an alphabet)  eg., tilde(~)

                        indic += newstr;
                        resultstr += newstr;
                    }
                    //'else' is not needed, because a single alphabet with
                    //match = notexact will not have indic equivalent

                    if(result.vowcount == 0) {
                        indic = newstr;
                        freezpos = start;
                    }
                    else {
                        bothcharset = true;
                        //indicates the formed string is in both character set

                        charsetstr = newstr;  //the string
                    }
                }
                else {
                    //the formed character contains more than one character

                    //similar to the case prevresult.match = notexact
                    resultstr =
                            resultstr.substring(0,resultstr.length - indic.length);

                    tempresult =
                            getUniChar(str.substring(freezpos,start)+newstr,"inner");

                    indic = tempresult.str;
                    resultstr += tempresult.str;
                }
            }
        }//else if(i == str.length - 1) ends here

        prevresult = result;
    }
    return {str:resultstr,indic:indic,freezpos:freezpos,
            bothcharset:bothcharset,charsetstr:charsetstr};
}

/*
finds the character set in which the string exists
*/
function findCharSet(str)
{
//alert("findCharSet");
    var i,match="nomatch",index=-1,charset="",consmatch="",vowmatch="";
    var conscount=0,consindex=-1,vowcount=0,vowindex=-1,splvowcount=0;

    for(i=0;i<vowel.length;i++) {    //searching the vowel character set

        if(vowel[i].indexOf(str)==0) {
            vowcount++;

            if(vowel_symbol_code[i] == "" && vowel_code[i] != "5")
                splvowcount++;

            if(str == vowel[i]) {
                vowmatch = "exact";
                vowindex = i;
            }
        }
    }
    if(vowcount > 0 && vowmatch == "")
        vowmatch = "notexact";

    for(i=0;i<consonant.length;i++) {   //searching the consonant character set

        if(consonant[i].indexOf(str)==0) {
            conscount++;

            if(str == consonant[i]) {
                consmatch = "exact";
                consindex = i;
            }
        }
    }
    if(conscount > 0 && consmatch == "")
        consmatch = "notexact";

    //determine which character set to return according to different conditions
    if((vowmatch == "" && (consmatch == "notexact" || consmatch == "exact")) ||
       (vowmatch == "notexact" && consmatch == "exact")) {

        charset = "consonant";
        match = consmatch;
        index = consindex;
    }
    else if(vowmatch != "") {
        charset = "vowel";
        match = vowmatch;
        index = vowindex;
    }
    return {match:match,index:index,vowcount:vowcount,conscount:conscount,
            charset:charset,splvowcount:splvowcount};
}

/*
sets there is no character which will be affected by the forecoming characters
*/
function freeze()
{
//alert("freeze");
    prevChar = "";
    prevLen = 0;
    hideMenu();
}

/*
makes arrangement for displaying hint menu. calls init() function
to initialize some global variables.
*/
function load()
{
//alert("load");
    var i,parent,style,txtarea;
    var body,div,table,tr,td,tbody;
    var keyboardLabel,selectCombo;

    body = document.getElementsByTagName('body').item(0);

    txtarea = document.getElementsByTagName('textarea');
    if(txtarea) {
        for(i=0;i<txtarea.length;i++) {
            if(txtarea[i].getAttribute(classAttrib) == "indic_ime")
                txtarea[i].onblur = freeze;
        }
    }

    div = document.getElementById("menudiv");
    if(div) {
        parent = div.parentNode;
        parent.removeChild(div);
    }
    div = document.createElement('div');
    div.id = "menudiv";
    div.style.position = "absolute";
    div.style.display = "none";
    body.appendChild(div);

    table = document.createElement('table');
    table.id = 'outertbl';
    style = 'width:82px;border-collapse:separate;border-spacing:0px;' +
            'padding:0;background-color:gray';
    table.setAttribute('style',style);

    table.style.backgroundColor = 'gray';    //for IE

    div.appendChild(table);
    tbody = document.createElement('tbody');
    table.appendChild(tbody);
    tr = document.createElement('tr');
    tbody.appendChild(tr);
    td = document.createElement('td');
    tr.appendChild(td);

//    selectCombo = document.indicForm.selectLanguage;
var selectCombo = document.getElementById("languageSelect");
    keyboardLabel = selectCombo.options[selectCombo.selectedIndex].label;

    for(i=0;i<lang_details.length;i++)      //determine wihch language is selected
        if(keyboardLabel == "multi_"+lang_details[i][0])
            break;

    if(i < lang_details.length) {
        init(i);
    }
    else {
        alert(
            "Error: This language keymap has some problem. Please use other keymaps"
            );
    }
}

/*
initializes the global variables with character sets and
other language specific details
*/
function init(index)
{
//alert("init");

    var i,j;
    var vowel_index,vowel_code_index,consonant_index,consonant_code_index;

    vowel_index       = parseInt(lang_details[index][1]);
    vowel_code_index  = parseInt(lang_details[index][2]);
    consonant_index   = parseInt(lang_details[index][3]);
    consonant_code_index = parseInt(lang_details[index][4]);

    vowel             = lang_vowel[vowel_index].split(",");
    vowel_code        = lang_vowel_code[vowel_code_index].split(",");
    vowel_symbol_code = lang_vowel_symbol_code[vowel_code_index].split(",");
    consonant         = lang_consonant[consonant_index].split(",");
    consonant_code    = lang_consonant_code[consonant_code_index].split(",");

    codebase          = parseInt(lang_details[index][5]);
    halant            = parseInt(lang_details[index][6]);

    charlist = "";
    for(i=0;i<vowel.length;i++)
        for(j=0;j<vowel[i].length;j++)
            if(charlist.indexOf(vowel[i].charAt(j)) == -1)
                charlist += vowel[i].charAt(j);

    for(i=0;i<consonant.length;i++)
        for(j=0;j<consonant[i].length;j++)
            if(charlist.indexOf(consonant[i].charAt(j)) == -1)
                charlist += consonant[i].charAt(j);

    freeze();
}

/*
parses the string 'str' at space and adds the value 'val' to each string
and returns as an integer array
*/
function parseAndAdd(str,val)
{
//alert("parseAndAdd");

    var i,arr;

    str = str.split(" ");
    arr = new Array(str.length);

    for(i=0;i<str.length;i++)
    {
        arr[i] = parseInt(str[i]) + val;
    }
    return arr;
}

/*
returns the character string for the character codes given as an array
*/
function fromCharCodeArray(arr)
{
//alert("fromCharCodeArray");

    var i,str;

    str = "";

    for(i=0;i<arr.length;i++)
    {
        str += String.fromCharCode(arr[i]);
    }
    return str;
}

/*
used to hide the hint menu
*/
function hideMenu()
{
//alert("hideMenu");
    var div;
    var innertbl,parent;
    if(isMenu) {
        isMenu = false;
        div = document.getElementById("menudiv");
        div.style.display = "none";
        innertbl = document.getElementById('innertbl');
        parent = innertbl.parentNode;
        parent.removeChild(innertbl);
    }
}

/*
used to show the hint menu
*/
function showMenu(str,textControl)
{
//alert("showMenu");
    var div,resultcomb="",result="",style="",tempresult="";
    var innertbl,parent,tr,td,exactindex,tbody;
    var i,keyCode,engkey="",indickey="",count=0,obj;

    if(isMenu)
        hideMenu();

    if(isInBothSet && str != strInBothSet) {
        result = findSubSet(strInBothSet,true);        //case sensitive
        tempresult = findSubSet(str.substring(0,str.lastIndexOf(strInBothSet)),true);
    }
    else
        result = findSubSet(str,false);               //case insensitive

    exactindex = result.exactindex != -1 ? result.exactindex : 0;
    if(result.exactindex == -1 && tempresult == "") {           // for Ru etc.

        resultcomb = makeCharSet(str);
        if((result.vowindex.length + result.consindex.length +
            resultcomb.indic.length) <= 0) {

            return;
        }
    }
    else if(result.match == "consonant")
        resultcomb = makeCharSet(consonant[result.consindex[exactindex]]);

    parent = document.getElementById('outertbl');

    parent = parent.getElementsByTagName('td').item(0);

    innertbl = document.createElement('table');
    innertbl.id = "innertbl";
    innertbl.width = 80;
    innertbl.cellspacing = 0;
    innertbl.cellpadding = 0;
    style = 'background-color:#cccccc;font-family:sans-serif;font-size:15px;' +
            'font-size-adjust:0.58;line-height:20px;';
    innertbl.setAttribute('style',style);

    innertbl.style.backgroundColor = '#cccccc';    //for IE

    parent.appendChild(innertbl);
    tbody = document.createElement('tbody');
    innertbl.appendChild(tbody);

    count += result.vowindex.length + result.consindex.length;

    for(i=0;i<result.vowindex.length;i++) {
        tr = document.createElement('tr');
        if(i == exactindex && result.match == "vowel")
            tr.style.backgroundColor = 'gray';

        if(isInBothSet && str != strInBothSet) {
            engkey = consonant[tempresult.consindex[tempresult.exactindex]] +
                     vowel[result.vowindex[i]];
            keyCode =
                parseAndAdd(
                    consonant_code[tempresult.consindex[tempresult.exactindex]],
                    codebase
                );

            indickey = fromCharCodeArray(keyCode);
            keyCode = parseAndAdd(vowel_symbol_code[result.vowindex[i]],codebase);

            indickey += fromCharCodeArray(keyCode);
        }
        else {
            engkey = vowel[result.vowindex[i]];
            keyCode = parseAndAdd(vowel_code[result.vowindex[i]],codebase);
            indickey = fromCharCodeArray(keyCode);
        }

        td = document.createElement('td');
        td.appendChild(document.createTextNode(engkey));
        td.setAttribute('align',"center");
        tr.appendChild(td);
        td = document.createElement('td');
        td.appendChild(document.createTextNode(indickey));
        td.setAttribute('align',"center");
        tr.appendChild(td);
        tbody.appendChild(tr);

    }//for loop ends here

    for(i=0;i<result.consindex.length;i++) {
        tr = document.createElement('tr');

        if(i == exactindex && result.match == "consonant")
            tr.style.backgroundColor = "gray";

        td = document.createElement('td');
        td.appendChild(document.createTextNode(consonant[result.consindex[i]]));
        td.setAttribute('align',"center");
        tr.appendChild(td);
        td = document.createElement('td');
        keyCode =
            parseAndAdd(consonant_code[result.consindex[i]]+" "+halant,codebase);

        td.appendChild(
                document.createTextNode(fromCharCodeArray(keyCode))
            );

        td.setAttribute('align',"center");
        tr.appendChild(td);
        tbody.appendChild(tr);
    }

    if(resultcomb != "") {
        count += resultcomb.indic.length;

        for(i=0;i<resultcomb.indic.length;i++) {
            tr = document.createElement('tr');

            if(result.consindex.length <= 0 ) {
                if(resultcomb.exactindex != -1) {
                    if(i == resultcomb.exactindex)
                        tr.style.backgroundColor = "gray";
                }
                else if(i == 0)
                    tr.style.backgroundColor = "gray";
            }

            td = document.createElement('td');
            td.appendChild(document.createTextNode(resultcomb.eng[i]));
            td.setAttribute('align',"center");
            tr.appendChild(td);
            td = document.createElement('td');
            td.appendChild(document.createTextNode(resultcomb.indic[i]));
            td.setAttribute('align',"center");
            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    }

    var charHeight,menuHeight,menuLeft,menuTop,offsetLeft,offsetTop,scrollTop;
    var scrollBot,midMenu,midObjPos;

    offsetLeft = 0;
    offsetTop = 0;
    obj = textControl;

    if(obj.offsetParent) {
        while (obj.offsetParent) {
            offsetLeft += obj.offsetLeft;
            offsetTop += obj.offsetTop;
            obj = obj.offsetParent;
        }
    }

    if (self.pageYOffset)   // all except Explorer
        scrollTop = self.pageYOffset;
    else if (document.documentElement && document.documentElement.scrollTop) {
        // Explorer 6 Strict
        scrollTop = document.documentElement.scrollTop;
    }
    else if (document.body) // all other Explorers
        scrollTop = document.body.scrollTop;

    charHeight = 15 * 0.58 * 2 + 2;
    menuHeight = charHeight * count + count;

    scrollBot = scrollTop;
    if (self.innerHeight) // all except Explorer
        scrollBot += self.innerHeight;
    else if (document.documentElement && document.documentElement.clientHeight) {
        // Explorer 6 Strict Mode
        scrollBot += document.documentElement.clientHeight;
    }
    else if (document.body) // other Explorers
        scrollBot += document.body.clientHeight;

    midMenu = menuHeight / 2;
    midObjPos = offsetTop + textControl.clientHeight / 2;

    menuLeft = offsetLeft - 5 * charHeight;
    if(menuLeft < 0)
        menuLeft = offsetLeft + textControl.clientWidth + 2;
    if(menuHeight <= textControl.clientHeight) {
        menuTop = offsetTop;
        menuBot = offsetTop + menuHeight;
    }
    else {
        menuTop = midObjPos - midMenu;
        menuBot = midObjPos + midMenu;
    }

    if(menuBot > scrollBot)
        menuTop = scrollBot - menuHeight;
    if(menuTop < scrollTop)
        menuTop = scrollTop;

    div = document.getElementById('menudiv');
    div.style.left = menuLeft+'px';
    div.style.top = menuTop+'px';
    div.style.display = "";
    isMenu = true;
}

/*
used to find the combinations that start with the character(s) in 'str'
*/
function findSubSet(str,isCaseSensitive)
{
//alert("findSubSet");
    var i,j,vowindex,consindex,exp,exact=-1,tempstr,match="",exactindex=-1,pos=-2;

    vowindex = new Array();
    consindex = new Array();

    tempstr = str;
    while((pos=tempstr.indexOf("|",pos+2)) != -1) {
        tempstr = tempstr.substring(0,pos) + "\\" + tempstr.substring(pos);
    }

    if(isCaseSensitive)
        exp = new RegExp(tempstr);
    else
        exp = new RegExp(tempstr,"i");

    for(i=0,j=0;i<vowel.length;i++) {

        if(vowel[i].search(exp) != -1 &&
          (vowel[i].search(exp) == 0 || isSplChar(vowel[i].charAt(0))) &&
          (!isCaseSensitive || vowel_symbol_code[i] != "")) {

            if(vowel[i] == str)
                exact = j;
            vowindex[j++] = i;
        }
    }

    if(exact != -1) {
        match = "vowel";
        exactindex = exact;
    }

    exact = -1;
    for(i=0,j=0;i<consonant.length;i++) {

        if(consonant[i].search(exp) != -1 &&
          (consonant[i].search(exp) == 0 || isSplChar(consonant[i].charAt(0)))) {

            if(consonant[i] == str)
                exact = j;
            consindex[j++] = i;
        }
    }

    if(exact != -1) {
        match = "consonant";
        exactindex = exact;
    }
    return {vowindex:vowindex,consindex:consindex,match:match,exactindex:exactindex};
}

/*
used to find the consonant + vowel combinations
*/
function makeCharSet(str)
{
//alert("makeCharSet");
    var i,j,exp,index=0,eng,indic,exactindex=-1,vowkey,conskey,temp;

    eng = new Array();
    indic = new Array();

    for(i=0;i<consonant.length;i++) {

        if(str.indexOf(consonant[i]) == -1)
            continue;

        for(j=0;j<vowel.length;j++) {

            if((vowel_symbol_code[j] != "" || vowel_code[j] == "5") &&
               (consonant[i]+vowel[j]).indexOf(str) == 0) {

                conskey = parseAndAdd(consonant_code[i],codebase);
                temp = fromCharCodeArray(conskey);

                if(vowel_code[j] != "5") {
                    vowkey = parseAndAdd(vowel_symbol_code[j],codebase);
                    temp += fromCharCodeArray(vowkey);
                }

                if(index == 0 || temp != indic[index-1]) {
                    eng[index] = consonant[i]+vowel[j];
                    indic[index] = temp;
                    if(str == eng[index])
                        exactindex = index;
                    index++;
                }
            }
        }
    }
    return {eng:eng,indic:indic,exactindex:exactindex};
}

/*
used to find whether the character is an alphabet or not
*/
function isSplChar(chr)
{
//alert("isSplChar");
    var ascii = chr.charCodeAt(0);
    if(ascii < 65 || (ascii > 90 && ascii < 97) || ascii > 122)
        return true;
    return false;
}

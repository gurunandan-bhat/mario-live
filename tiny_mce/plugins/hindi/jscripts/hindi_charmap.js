function init() {
	tinyMCEPopup.resizeToInnerSize();
}



var charmap = new Array();
charmap = [
//OM
  ['ॐ','ॐ',true,'OM',true],
//The Devanagari numbers
['१','१',true,'Number One',true],
['२','२',true,'Number Two',true],
['३','३',true,'Number Three',true],
['४','४',true,'Number Four',true],
['५','५',true,'Number Five',true],
['६','६',true,'Number Six',true],
['७','७',true,'Number Seven',true],
['८','८',true,'Number Eight',true],
['९','९',true,'Number Nine',true],
['०','०',true,'Number Shunya',true],
//Vowels
['अ','अ',true,'Devanagari Letter A',true],
['आ','आ',true,'Devanagari Letter Aa',true],
['इ','इ',true,'Devanagari Letter I',true],
['ई','ई',true,'Devanagari Letter E ',true],
['उ','उ',true,'Devanagari Letter U',true],
['ऊ','ऊ',true,'Devanagari Letter Uu',true],
['ए','ए',true,'Devanagari Letter E',true],
['ऐ','ऐ',true,'Devanagari Letter Ai',true],
['ओ','ओ',true,'Devanagari Letter O',true],
['औ','औ',true,'Devanagari Letter Ao',true],
['अं','अं',true,'Devanagari Letter Ang',true],
['अः','अः',true,'Devanagari Letter Aha',true],
['अँ','अँ',true,'Devanagari Letter Chandr Am',true],
['ऑ','ऑ',true,'Devanagari Letter O',true],
['ऍ','ऍ',true,'Devanagari Letter A',true],
['ऋ','ऋ',true,'Devanagari Letter Rr',true],

//Devanagari Consonants
['क','क',true,'Devanagari Letter ka',true],
['ख','ख',true,'Devanagari Letter kha',true],
['ग','ग',true,'Devanagari Letter ga',true],
['घ','घ',true,'Devanagari Letter gha',true],
['ङ','ङ',true,'Devanagari Letter Nga',true],
['च','च',true,'Devanagari Letter cha',true],
['छ','छ',true,'Devanagari Letter chha',true],
['ज','ज',true,'Devanagari Letter ja',true],
['झ','झ',true,'Devanagari Letter jha',true],
['ञ','ञ',true,'Devanagari Letter Nja',true],
['ट','ट',true,'Devanagari Letter Ta',true],
['ठ','ठ',true,'Devanagari Letter tha',true],
['ड','ड',true,'Devanagari Letter da',true],
['ढ','ढ',true,'Devanagari Letter dha',true],
['ण','ण',true,'Devanagari Letter Na',true],
['त','त',true,'Devanagari Letter ta',true],
['थ','थ',true,'Devanagari Letter tha',true],
['द','द',true,'Devanagari Letter da',true],
['ध','ध',true,'Devanagari Letter dha',true],
['न','न',true,'Devanagari Letter na',true],
['प','प',true,'Devanagari Letter pa',true],
['फ','फ',true,'Devanagari Letter pha',true],
['ब','ब',true,'Devanagari Letter ba',true],
['भ','भ',true,'Devanagari Letter bha',true],
['म','म',true,'Devanagari Letter ma',true],
['य','य',true,'Devanagari Letter ya',true],
['र','र',true,'Devanagari Letter ra',true],
['ल','ल',true,'Devanagari Letter la',true],
['व','व',true,'Devanagari Letter va/wa',true],
['श','श',true,'Devanagari Letter sha',true],
['ष','ष',true,'Devanagari Letter Sha',true],
['स','स',true,'Devanagari Letter sa',true],
['ह','ह',true,'Devanagari Letter ha',true],
['क्ष','क्ष',true,'Devanagari Letter Ksha/xa',true],
['त्र','त्र',true,'Devanagari Letter Tra',true],
['ज्ञ','ज्ञ',true,'Devanagari Letter Gya/jNa',true],
['र्‍','र्‍',true,'Devanagari Letter R',true],
['ळ','ळ',true,'Devanagari Letter La',true],
//Nukta Consonants
['क़','क़',true,'Devanagari Letter Ka',true],
['ख़','ख़',true,'Devanagari Letter Kha',true],
['ग़','ग़',true,'Devanagari Letter Ga',true],
['ज़','ज़',true,'Devanagari Letter ja',true],
['ड़','ड़',true,'Devanagari Letter D_a',true],
['ढ़','ढ़',true,'Devanagari Letter Dh_a',true],
['फ़','फ़',true,'Devanagari Letter Pha/Fa',true],
['य़','य़',true,'Devanagari Letter Ya',true],

//Matra and Other Misc
['ँ','ँ',true,'Devnagari Sign/Maatra Chandrabindu',true],
['ं','ं',true,'Devanagari Sign/Maatra Anusvara',true],
['ः','ः',true,'Devanagari Sign/Maatra Visarga',true],
['ऽ','ऽ',true,'Devanagari Sign/Maatra Avagraha',true],
['ा','ा',true,'Devanagari Vowel Sign/Maatra Aa',true],
['ि','ि',true,'Devanagari Vowel Sign/Maatra I',true],
['ी','ी',true,'Devanagari Vowel Sign/Maatra Ii',true],
['ु','ु',true,'Devanagari Vowel Sign/Maatra U',true],
['ू','ू',true,'Devanagari Vowel Sign/Maatra Uu',true],
['ृ','ृ',true,'Devanagari Sign/Maatra Vocalic R',true],
['ॄ','ॄ',true,'Devanagari Vowel Sign/Maatra Vocalic Rri ',true],
['ॅ','ॅ',true,'Devanagari Vowel Sign/Maatra Chandra E',true],
['ॆ','ॆ',true,'Devanagari Vowel Sign/Maatra Short E',true],
['े','े',true,'Devanagari Vowel Sign/Maatra E',true],
['ै','ै',true,'Devanagari Vowel Sign/Maatra Ai',true],
['ॉ','ॉ',true,'Devanagari Vowel Sign/Maatra O',true],
['ॊ','ॊ',true,'Devanagari Vowel Sign/Maatra O',true],
['ो','ो',true,'Devanagari Vowel Sign/Maatra O',true],
['ौ','ौ',true,'Devanagari Vowel Sign/Maatra Au',true],
['्','्',true,'Devanagari Sign/Maatra Viram/Halant',true],
['॑','॑',true,'Devanagari Stress Sign/Maatra Udatta',true],
['॒','॒',true,'Devanagari Stress Sign/Maatra Anudatta',true],
['॓','॓',true,'Devanagari Grave Accent',true],
['॔','॔',true,'Devanagari Acute Accent',true],
['ॢ','ॢ',true,'Devanagari Vocalic Sign/Maatra Lr',true],
['ॣ','ॣ',true,'Devanagari Vocalic Sign/Maatra LI',true],
['।','।',true,'Devanagari Danda/Poorna Viram',true],
['॥','॥',true,'Devanagari Double Danda',true],

//Ardha Shabda
['क्‍','क्‍',true,'Devanagari Ardha Shabd ka',true],
['ख्‍','ख्‍',true,'Devanagari Ardha Shabd kha',true],
['ग्‍','ग्‍',true,'Devanagari Ardha Shabd ga',true],
['घ्‍','घ्‍',true,'Devanagari Ardha Shabd dha',true],
['स्‍','स्‍',true,'Devanagari Ardha Shabd sa',true],
['ह्‍','ह्‍',true,'Devanagari Ardha Shabd ha',true],
['क्ष्‍','क्ष्‍',true,'Devanagari Ardha Shabd Ksha/xa',true],
['ज्ञ्‍','ज्ञ्‍',true,'Devanagari Ardha Shabd Gya/jNa',true],
['च्‍','च्‍',true,'Devanagari Ardha Shabd cha',true],
['ज्‍','ज्‍',true,'Devanagari Ardha Shabd ja',true],
['झ्‍','झ्‍',true,'Devanagari Ardha Shabd jha',true],
['ञ्‍','ञ्‍',true,'Devanagari Ardha Shabd Nja',true],
['य्‍','य्‍',true,'Devanagari Ardha Shabd ya',true],
['ल्‍','ल्‍',true,'Devanagari Ardha Shabd la',true],
['व्‍','व्‍',true,'Devanagari Ardha Shabd va',true],
['श्‍','श्‍',true,'Devanagari Ardha Shabd sha',true],
['ष्‍','ष्‍',true,'Devanagari Ardha Shabd Sha',true],
['त्‍','त्‍',true,'Devanagari Ardha Shabd ta',true],
['थ्‍','थ्‍',true,'Devanagari Ardha Shabd tha',true],
['ध्‍','ध्‍',true,'Devanagari Ardha Shabd dha',true],
['न्‍','न्‍',true,'Devanagari Ardha Shabd na',true],
['प्‍','प्‍',true,'Devanagari Ardha Shabd pa',true],
['फ्‍','फ्‍',true,'Devanagari Ardha Shabd pha',true],
['ब्‍','ब्‍',true,'Devanagari Ardha Shabd ba',true],
['भ्‍','भ्‍',true,'Devanagari Ardha Shabd bha',true],
['म्‍','म्‍',true,'Devanagari Ardha Shabd ma',true],
//['‍','',true,'',true],
//Conjuncts
['‍द्द','द्द',true,'Devanagari Conjunct dda',true],
['‍द्ध','द्ध',true,'Devanagari Conjunct ddha',true],
['द्व','द्व',true,'Devanagari Conjunct dwa/dva',true],
['द्म‍','द्म',true,'Devanagari Conjunct dma',true],
['द्य‍','द्य',true,'Devanagari Conjunct dya',true],
['‍द्ब','द्ब',true,'Devanagari Conjunct dba',true],
['द्न','द्न',true,'Devanagari Conjunct dna',true],
['‍द्ग','द्ग',true,'Devanagari Conjunct dga',true],
['‍द्घ','द्घ',true,'Devanagari Conjunct dgha',true],
['ह्म‍','ह्म',true,'Devanagari Conjunct hma',true],
['‍ह्ल','ह्ल',true,'Devanagari Conjunct hla',true],
['ह्व‍','ह्व',true,'Devanagari Conjunct hva/hwa',true],
['‍ह्न','ह्न',true,'Devanagari Conjunct hna',true],
['ह्य‍','ह्य',true,'Devanagari Conjunct hya',true],
['‍ष्ट','ष्ट',true,'Devanagari Conjunct ShTa',true],
['ष्ठ‍','ष्ठ',true,'Devanagari Conjunct ShTha',true],
['त्त‍','त्त',true,'Devanagari Conjunct tta',true],
['क्त‍','क्त',true,'Devanagari Conjunct kta',true],
['श्च‍','श्च',true,'Devanagari Conjunct shcha',true],
['श्व‍','श्व',true,'Devanagari Conjunct shwa/shva',true],
['श्र‍','श्र',true,'Devanagari Conjunct shra',true],

// now here is the complete list ;)
	['&nbsp;',    '&#160;',  true, 'no-break space',false],
	['&amp;',     '&#38;',   true, 'ampersand',false],
	['&quot;',    '&#34;',   true, 'quotation mark',false],
// finance
	['&cent;',    '&#162;',  true, 'cent sign',false],
	['&euro;',    '&#8364;', true, 'euro sign',false],
	['&pound;',   '&#163;',  true, 'pound sign',false],
	['&yen;',     '&#165;',  true, 'yen sign',false],
// signs
	['&copy;',    '&#169;',  true, 'copyright sign',false],
	['&reg;',     '&#174;',  true, 'registered sign',false],
	['&trade;',   '&#8482;', true, 'trade mark sign',false],
	['&permil;',  '&#8240;', true, 'per mille sign',false],
	['&micro;',   '&#181;',  true, 'micro sign',false],
	['&middot;',  '&#183;',  true, 'middle dot',false],
	['&bull;',    '&#8226;', true, 'bullet',false],
	['&hellip;',  '&#8230;', true, 'three dot leader',false],
	['&prime;',   '&#8242;', true, 'minutes / feet',false],
	['&Prime;',   '&#8243;', true, 'seconds / inches',false],
	['&sect;',    '&#167;',  true, 'section sign',false],
	['&para;',    '&#182;',  true, 'paragraph sign',false],
	['&szlig;',   '&#223;',  true, 'sharp s / ess-zed',false],
// quotations
	['&lsaquo;',  '&#8249;', true, 'single left-pointing angle quotation mark',false],
	['&rsaquo;',  '&#8250;', true, 'single right-pointing angle quotation mark',false],
	['&laquo;',   '&#171;',  true, 'left pointing guillemet',false],
	['&raquo;',   '&#187;',  true, 'right pointing guillemet',false],
	['&lsquo;',   '&#8216;', true, 'left single quotation mark',false],
	['&rsquo;',   '&#8217;', true, 'right single quotation mark',false],
	['&ldquo;',   '&#8220;', true, 'left double quotation mark',false],
	['&rdquo;',   '&#8221;', true, 'right double quotation mark',false],
	['&sbquo;',   '&#8218;', true, 'single low-9 quotation mark',false],
	['&bdquo;',   '&#8222;', true, 'double low-9 quotation mark',false],
	['&lt;',      '&#60;',   true, 'less-than sign',false],
	['&gt;',      '&#62;',   true, 'greater-than sign',false],
	['&le;',      '&#8804;', true, 'less-than or equal to',false],
	['&ge;',      '&#8805;', true, 'greater-than or equal to',false],
	['&ndash;',   '&#8211;', true, 'en dash',false],
	['&mdash;',   '&#8212;', true, 'em dash',false],
	['&macr;',    '&#175;',  true, 'macron',false],
	['&oline;',   '&#8254;', true, 'overline',false],
	['&curren;',  '&#164;',  true, 'currency sign',false],
	['&brvbar;',  '&#166;',  true, 'broken bar',false],
	['&uml;',     '&#168;',  true, 'diaeresis',false],
	['&iexcl;',   '&#161;',  true, 'inverted exclamation mark',false],
	['&iquest;',  '&#191;',  true, 'turned question mark',false],
	['&circ;',    '&#710;',  true, 'circumflex accent',false],
	['&tilde;',   '&#732;',  true, 'small tilde',false],
	['&deg;',     '&#176;',  true, 'degree sign',false],
	['&minus;',   '&#8722;', true, 'minus sign',false],
	['&plusmn;',  '&#177;',  true, 'plus-minus sign',false],
	['&divide;',  '&#247;',  true, 'division sign',false],
	['&frasl;',   '&#8260;', true, 'fraction slash',false],
	['&times;',   '&#215;',  true, 'multiplication sign',false],
	['&sup1;',    '&#185;',  true, 'superscript one',false],
	['&sup2;',    '&#178;',  true, 'superscript two',false],
	['&sup3;',    '&#179;',  true, 'superscript three',false],
	['&frac14;',  '&#188;',  true, 'fraction one quarter',false],
	['&frac12;',  '&#189;',  true, 'fraction one half',false],
	['&frac34;',  '&#190;',  true, 'fraction three quarters',false]
// for more details please see w3c.org
/*

['‍','',true,'',true],
['‍','',true,'',true],
['‍','',true,'',true],
['‍','',true,'',true],
['‍','',true,'',true]*/


];




function renderCharMapHTML() {
	var charsPerRow = 21, tdWidth=20, tdHeight=20;
	var html = '<table border="0" cellspacing="1" cellpadding="0" width="' + (tdWidth*charsPerRow) + '"><tr height="' + tdHeight + '">';
	var cols=-1;
	//alert(charmap.length);
	for (var i=0; i<charmap.length; i++) {
		{
			cols++;
			html += ''
				+ '<td width="' + tdWidth + '" height="' + tdHeight + '" class="charmap"'
				+ ' onmouseover="tinyMCE.switchClass(this,\'charmapOver\');';
        if (charmap[i][4]==true)
          {        
          	html+='previewHChar(\'' + charmap[i][1] + '\',\'' + charmap[i][0] + '\',\'' + charmap[i][3] + '\');"';
          }
        else
        	{
        		html+='previewChar(\'' + charmap[i][1].substring(1,charmap[i][1].length) + '\',\'' + charmap[i][0].substring(1,charmap[i][0].length) + '\',\'' + charmap[i][3] + '\');"';
        	}
				//html+= 'previewChar(\'' + charmap[i][1].substring(1,charmap[i][1].length) + '\',\'' + charmap[i][0].substring(1,charmap[i][0].length) + '\',\'' + charmap[i][3] + '\');"'
				html+= ' onmouseout="tinyMCE.restoreClass(this,\'charmapOver\');"';
				if (charmap[i][4]==true)
				  {
				    html+=' nowrap="nowrap" onclick="insertHChar(\'' + charmap[i][1] + '\');"><a style="text-decoration: none;" onfocus="previewHChar(\'' + charmap[i][1] + '\',\'' + charmap[i][0] + '\',\'' + charmap[i][3] + '\');" href="javascript:insertChar(\'' + charmap[i][1] + '\');" onclick="return false;" onmousedown="return false;" title="' + charmap[i][3] + '">';
				  }
				else
					{
						html+=' nowrap="nowrap" onclick="insertChar(\'' + charmap[i][1].substring(2,charmap[i][1].length-1) + '\');"><a style="text-decoration: none;" onfocus="previewChar(\'' + charmap[i][1].substring(1,charmap[i][1].length) + '\',\'' + charmap[i][0].substring(1,charmap[i][0].length) + '\',\'' + charmap[i][3] + '\');" href="javascript:insertChar(\'' + charmap[i][1].substring(2,charmap[i][1].length-1) + '\');" onclick="return false;" onmousedown="return false;" title="' + charmap[i][3] + '">';
					}
				
				html+= charmap[i][1]
				+ '</a></td>';
			if ((cols+1) % charsPerRow == 0)
				html += '</tr><tr height="' + tdHeight + '">';
		}
	 }
	if (cols % charsPerRow > 0) {
		var padd = charsPerRow - (cols % charsPerRow);
		for (var i=0; i<padd-1; i++)
			html += '<td width="' + tdWidth + '" height="' + tdHeight + '" class="charmap">&nbsp;</td>';
	}
	html += '</tr></table>';
	document.write(html);
}


function insertChar(chr) {
	tinyMCEPopup.execCommand('mceInsertContent', false, '\&#' + chr + ';');

	// Refocus in window
	if (tinyMCEPopup.isWindow)
		window.focus();
}
function insertHChar(chr) {
	tinyMCEPopup.execCommand('mceInsertContent', false,  chr );

	// Refocus in window
	if (tinyMCEPopup.isWindow)
		window.focus();
}

function previewChar(codeA, codeB,codeN) {
	//alert(codeA + codeB + codeN);
	var elmA = document.getElementById('codeA');
	var elmB = document.getElementById('codeB');
	var elmV = document.getElementById('codeV');
	var elmN = document.getElementById('codeN');

	if (codeA=='#160;') {
		elmV.innerHTML = '__';
	} else {
		elmV.innerHTML = '&' + codeA;
	}

	elmB.innerHTML = '&amp;' + codeA;
	elmA.innerHTML = '&amp;' + codeB;
	elmN.innerHTML = codeN;
}

function previewHChar(codeA, codeB, codeN) {
	//alert("codeA " + codeA +  " CodeB " + codeB + " codeN " +  codeN);
	var elmA = document.getElementById('codeA');
	var elmB = document.getElementById('codeB');
	var elmV = document.getElementById('codeV');
	var elmN = document.getElementById('codeN');

	if (codeA=='#160;') {
		elmV.innerHTML = '__';
	} else {
		elmV.innerHTML = codeA;
	}

	elmB.innerHTML = codeA;
	elmA.innerHTML = codeB;
	elmN.innerHTML = codeN;
}


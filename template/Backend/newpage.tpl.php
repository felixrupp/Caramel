<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Create a new page:</h1>


<p><a href="?q=editpages">back to page overview</a></p>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
	
		<fieldset>
			<label for="path">URL path to page:</label> <input type="text" name="path" id="path" value="">
			<br>
			<label for="defaultLanguage">Default language record:</label> <select name="defaultLanguage" id="defaultLanguage">
				
				<option value="aa">Afar</option>
				<option value="ab">Abkhazian</option>
				<option value="ae">Avestan</option>
				<option value="af">Afrikaans</option>
				<option value="ak">Akan</option>
				<option value="am">Amharic</option>
				<option value="an">Aragonese</option>
				<option value="ar">Arabic</option>
				<option value="as">Assamese</option>
				<option value="av">Avaric</option>
				<option value="ay">Aymara</option>
				<option value="az">Azerbaijani</option>
				<option value="ba">Bashkir</option>
				<option value="be">Belarusian</option>
				<option value="bg">Bulgarian</option>
				<option value="bh">Bihari</option>
				<option value="bi">Bislama</option>
				<option value="bm">Bambara</option>
				<option value="bn">Bengali</option>
				<option value="bo">Tibetan</option>
				<option value="br">Breton</option>
				<option value="bs">Bosnian</option>
				<option value="ca">Catalan; Valencian</option>
				<option value="ce">Chechen</option>
				<option value="ch">Chamorro</option>
				<option value="co">Corsican</option>
				<option value="cr">Cree</option>
				<option value="cs">Czech</option>
				<option value="cu">Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic</option>
				<option value="cv">Chuvash</option>
				<option value="cy">Welsh</option>
				<option value="da">Danish</option>
				<option value="de">German</option>
				<option value="dv">Divehi; Dhivehi; Maldivian</option>
				<option value="dz">Dzongkha</option>
				<option value="ee">Ewe</option>
				<option value="el">Greek, Modern (1453-)</option>
				<option value="en" selected>English</option>
				<option value="eo">Esperanto</option>
				<option value="es">Spanish; Castilian</option>
				<option value="et">Estonian</option>
				<option value="eu">Basque</option>
				<option value="fa">Persian</option>
				<option value="ff">Fulah</option>
				<option value="fi">Finnish</option>
				<option value="fj">Fijian</option>
				<option value="fo">Faroese</option>
				<option value="fr">French</option>
				<option value="fy">Western Frisian</option>
				<option value="ga">Irish</option>
				<option value="gd">Gaelic; Scottish Gaelic</option>
				<option value="gl">Galician</option>
				<option value="gn">Guarani</option>
				<option value="gu">Gujarati</option>
				<option value="gv">Manx</option>
				<option value="ha">Hausa</option>
				<option value="he">Hebrew</option>
				<option value="hi">Hindi</option>
				<option value="ho">Hiri Motu</option>
				<option value="hr">Croatian</option>
				<option value="ht">Haitian; Haitian Creole</option>
				<option value="hu">Hungarian</option>
				<option value="hy">Armenian</option>
				<option value="hz">Herero</option>
				<option value="ia">Interlingua (International Auxiliary Language Association)</option>
				<option value="id">Indonesian</option>
				<option value="ie">Interlingue</option>
				<option value="ig">Igbo</option>
				<option value="ii">Sichuan Yi</option>
				<option value="ik">Inupiaq</option>
				<option value="io">Ido</option>
				<option value="is">Icelandic</option>
				<option value="it">Italian</option>
				<option value="iu">Inuktitut</option>
				<option value="ja">Japanese</option>
				<option value="jv">Javanese</option>
				<option value="ka">Georgian</option>
				<option value="kg">Kongo</option>
				<option value="ki">Kikuyu; Gikuyu</option>
				<option value="kj">Kuanyama; Kwanyama</option>
				<option value="kk">Kazakh</option>
				<option value="kl">Kalaallisut; Greenlandic</option>
				<option value="km">Central Khmer</option>
				<option value="kn">Kannada</option>
				<option value="ko">Korean</option>
				<option value="kr">Kanuri</option>
				<option value="ks">Kashmiri</option>
				<option value="ku">Kurdish</option>
				<option value="kv">Komi</option>
				<option value="kw">Cornish</option>
				<option value="ky">Kirghiz; Kyrgyz</option>
				<option value="la">Latin</option>
				<option value="lb">Luxembourgish; Letzeburgesch</option>
				<option value="lg">Ganda</option>
				<option value="li">Limburgan; Limburger; Limburgish</option>
				<option value="ln">Lingala</option>
				<option value="lo">Lao</option>
				<option value="lt">Lithuanian</option>
				<option value="lu">Luba-Katanga</option>
				<option value="lv">Latvian</option>
				<option value="mg">Malagasy</option>
				<option value="mh">Marshallese</option>
				<option value="mi">Maori</option>
				<option value="mk">Macedonian</option>
				<option value="ml">Malayalam</option>
				<option value="mn">Mongolian</option>
				<option value="mo">Moldavian</option>
				<option value="mr">Marathi</option>
				<option value="ms">Malay</option>
				<option value="mt">Maltese</option>
				<option value="my">Burmese</option>
				<option value="na">Nauru</option>
				<option value="nb">Bokmål, Norwegian; Norwegian Bokmål</option>
				<option value="nd">Ndebele, North; North Ndebele</option>
				<option value="ne">Nepali</option>
				<option value="ng">Ndonga</option>
				<option value="nl">Dutch; Flemish</option>
				<option value="nn">Norwegian Nynorsk; Nynorsk, Norwegian</option>
				<option value="no">Norwegian</option>
				<option value="nr">Ndebele, South; South Ndebele</option>
				<option value="nv">Navajo; Navaho</option>
				<option value="ny">Chichewa; Chewa; Nyanja</option>
				<option value="oc">Occitan (post 1500); Provençal</option>
				<option value="oj">Ojibwa</option>
				<option value="om">Oromo</option>
				<option value="or">Oriya</option>
				<option value="os">Ossetian; Ossetic</option>
				<option value="pa">Panjabi; Punjabi</option>
				<option value="pi">Pali</option>
				<option value="pl">Polish</option>
				<option value="ps">Pushto</option>
				<option value="pt">Portuguese</option>
				<option value="qu">Quechua</option>
				<option value="rm">Romansh</option>
				<option value="rn">Rundi</option>
				<option value="ro">Romanian</option>
				<option value="ru">Russian</option>
				<option value="rw">Kinyarwanda</option>
				<option value="sa">Sanskrit</option>
				<option value="sc">Sardinian</option>
				<option value="sd">Sindhi</option>
				<option value="se">Northern Sami</option>
				<option value="sg">Sango</option>
				<option value="si">Sinhala; Sinhalese</option>
				<option value="sk">Slovak</option>
				<option value="sl">Slovenian</option>
				<option value="sm">Samoan</option>
				<option value="sn">Shona</option>
				<option value="so">Somali</option>
				<option value="sq">Albanian</option>
				<option value="sr">Serbian</option>
				<option value="ss">Swati</option>
				<option value="st">Sotho, Southern</option>
				<option value="su">Sundanese</option>
				<option value="sv">Swedish</option>
				<option value="sw">Swahili</option>
				<option value="ta">Tamil</option>
				<option value="te">Telugu</option>
				<option value="tg">Tajik</option>
				<option value="th">Thai</option>
				<option value="ti">Tigrinya</option>
				<option value="tk">Turkmen</option>
				<option value="tl">Tagalog</option>
				<option value="tn">Tswana</option>
				<option value="to">Tonga (Tonga Islands)</option>
				<option value="tr">Turkish</option>
				<option value="ts">Tsonga</option>
				<option value="tt">Tatar</option>
				<option value="tw">Twi</option>
				<option value="ty">Tahitian</option>
				<option value="ug">Uighur; Uyghur</option>
				<option value="uk">Ukrainian</option>
				<option value="ur">Urdu</option>
				<option value="uz">Uzbek</option>
				<option value="ve">Venda</option>
				<option value="vi">Vietnamese</option>
				<option value="vo">Volapük</option>
				<option value="wa">Walloon</option>
				<option value="wo">Wolof</option>
				<option value="xh">Xhosa</option>
				<option value="yi">Yiddish</option>
				<option value="yo">Yoruba</option>
				<option value="za">Zhuang; Chuang</option>
				<option value="zh">Chinese</option>
				<option value="zu">Zulu</option>

			</select>
		</fieldset>
		
		<fieldset name="fieldset">
			<legend class="collapsableFieldset">Record for default language</legend>
							
			<label for="navigation">Name used in navigation:</label> <input type="text" name="navigation" id="navigation" value=''>
			<br>
			
			<label for="title">Website title:</label> <input type="text" name="title" id="title" value=''>
			<br>
			
			<label for="titletag">Title-tag used in navigation:</label> <input type="text" name="titletag" id="titletag" value=''>
			<br>
			
			<label for="metadescription">Description:</label> <textarea name="metadescription" id="metadescription"></textarea>
			<br>
			
			<label for="metakeywords">Keywords:</label> <input type="text" name="metakeywords" id="metakeywords" value=''>
			<br>
			
			<label for="metaauthor">Author:</label> <input type="text" name="metaauthor" id="metaauthor" value=''>
			<br>
			
			<label for="content">Page content:</label>
			<br>
			<textarea class="ckContent" name="content" id="content"></textarea>
		</fieldset>
		
			
		<input type="hidden" name="newpage" id="newpage">
		<input type="submit" name="submit" id="submit" value="Create">
	</form>


</div>
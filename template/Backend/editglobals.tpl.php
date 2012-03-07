<?php 
/**
 * @package template
 * @subpackage Backend
 */
?>

<h1>Global Settings</h1>

<div>

	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
		<fieldset>
			<label for="website_title"><?php echo $globals["website_title"]['label']; ?></label> <input type="text" name="website_title" id="website_title" value='<?php echo $globals["website_title"]["value"]; ?>'>
			<br>
			<label for="website_title_seperator"><?php echo $globals["website_title_seperator"]['label']; ?></label> <input type="text" name="website_title_seperator" id="website_title_seperator" value='<?php echo $globals["website_title_seperator"]["value"]; ?>'>
			<br>
			<label for="startpage"><?php echo $globals["startpage"]['label']; ?></label> <select name="startpage" id="startpage">
				<?php foreach($globals["startpage"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option["id"]; ?>"<?php if($option["id"]==$globals["startpage"]["value"]){echo ' selected';} ?>><?php echo $option["path"]; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="base"><?php echo $globals["base"]['label']; ?></label> <input type="text" name="base" id="base" value='<?php echo $globals["base"]["value"]; ?>'>
			<br>
			<label for="robots"><?php echo $globals["robots"]['label']; ?></label> <select name="robots" id="robots">
				<?php foreach($globals["robots"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$globals["robots"]["value"]){echo ' selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="speaking_urls"><?php echo $globals["speaking_urls"]['label']; ?></label> <input type="checkbox" name="speaking_urls" id="speaking_urls" value="true"<?php if($globals["speaking_urls"]["value"]=="true") echo " checked"?>>
		</fieldset>
			
		<fieldset>
			<label for="navigation_active_marker_position"><?php echo $globals["navigation_active_marker_position"]['label']; ?></label> <select name="navigation_active_marker_position" id="navigation_active_marker_position">
				<?php foreach($globals["navigation_active_marker_position"]["acceptedValues"] as $option) { ?>
				<option value="<?php echo $option; ?>"<?php if($option==$globals["navigation_active_marker_position"]["value"]){echo ' selected';} ?>><?php echo $option; ?></option>
				<?php } ?>		
			</select>
			<br>
			<label for="navigation_active_marker"><?php echo $globals["navigation_active_marker"]['label']; ?></label> <input type="text" name="navigation_active_marker" id="navigation_active_marker" value='<?php echo $globals["navigation_active_marker"]["value"]; ?>'>
			<br>
			<label for="navigation_active_class"><?php echo $globals["navigation_active_class"]['label']; ?></label> <input type="text" name="navigation_active_class" id="navigation_active_class" value='<?php echo $globals["navigation_active_class"]["value"]; ?>'>
			<br>
			<label for="navigation_class"><?php echo $globals["navigation_class"]['label']; ?></label> <input type="text" name="navigation_class" id="navigation_class" value='<?php echo $globals["navigation_class"]["value"]; ?>'>
		</fieldset>
		
		<fieldset>
			<label for="language_selector_in_footer"><?php echo $globals["language_selector_in_footer"]['label']; ?></label> <input type="checkbox" name="language_selector_in_footer" id="language_selector_in_footer" value="true"<?php if($globals["language_selector_in_footer"]["value"]=="true") echo " checked"?>>
			<br>
			<label for="language_selector_seperator"><?php echo $globals["language_selector_seperator"]['label']; ?></label> <input type="text" name="language_selector_seperator" id="language_selector_seperator" value='<?php echo $globals["language_selector_seperator"]["value"]; ?>'>
			<br>
			<label for="default_language"><?php echo $globals["default_language"]['label']; ?></label> <select name="default_language" id="default_language">
				
				<option value="aa"<?php if($globals["default_language"]["value"]=="aa") echo "selected"; ?>>Afar</option>
				<option value="ab"<?php if($globals["default_language"]["value"]=="ab") echo "selected"; ?>>Abkhazian</option>
				<option value="ae"<?php if($globals["default_language"]["value"]=="ae") echo "selected"; ?>>Avestan</option>
				<option value="af"<?php if($globals["default_language"]["value"]=="af") echo "selected"; ?>>Afrikaans</option>
				<option value="ak"<?php if($globals["default_language"]["value"]=="ak") echo "selected"; ?>>Akan</option>
				<option value="am"<?php if($globals["default_language"]["value"]=="am") echo "selected"; ?>>Amharic</option>
				<option value="an"<?php if($globals["default_language"]["value"]=="an") echo "selected"; ?>>Aragonese</option>
				<option value="ar"<?php if($globals["default_language"]["value"]=="ar") echo "selected"; ?>>Arabic</option>
				<option value="as"<?php if($globals["default_language"]["value"]=="as") echo "selected"; ?>>Assamese</option>
				<option value="av"<?php if($globals["default_language"]["value"]=="av") echo "selected"; ?>>Avaric</option>
				<option value="ay"<?php if($globals["default_language"]["value"]=="ay") echo "selected"; ?>>Aymara</option>
				<option value="az"<?php if($globals["default_language"]["value"]=="az") echo "selected"; ?>>Azerbaijani</option>
				<option value="ba"<?php if($globals["default_language"]["value"]=="ba") echo "selected"; ?>>Bashkir</option>
				<option value="be"<?php if($globals["default_language"]["value"]=="be") echo "selected"; ?>>Belarusian</option>
				<option value="bg"<?php if($globals["default_language"]["value"]=="bg") echo "selected"; ?>>Bulgarian</option>
				<option value="bh"<?php if($globals["default_language"]["value"]=="bh") echo "selected"; ?>>Bihari</option>
				<option value="bi"<?php if($globals["default_language"]["value"]=="bi") echo "selected"; ?>>Bislama</option>
				<option value="bm"<?php if($globals["default_language"]["value"]=="bm") echo "selected"; ?>>Bambara</option>
				<option value="bn"<?php if($globals["default_language"]["value"]=="bn") echo "selected"; ?>>Bengali</option>
				<option value="bo"<?php if($globals["default_language"]["value"]=="bo") echo "selected"; ?>>Tibetan</option>
				<option value="br"<?php if($globals["default_language"]["value"]=="br") echo "selected"; ?>>Breton</option>
				<option value="bs"<?php if($globals["default_language"]["value"]=="bs") echo "selected"; ?>>Bosnian</option>
				<option value="ca"<?php if($globals["default_language"]["value"]=="ca") echo "selected"; ?>>Catalan; Valencian</option>
				<option value="ce"<?php if($globals["default_language"]["value"]=="ce") echo "selected"; ?>>Chechen</option>
				<option value="ch"<?php if($globals["default_language"]["value"]=="ch") echo "selected"; ?>>Chamorro</option>
				<option value="co"<?php if($globals["default_language"]["value"]=="co") echo "selected"; ?>>Corsican</option>
				<option value="cr"<?php if($globals["default_language"]["value"]=="cr") echo "selected"; ?>>Cree</option>
				<option value="cs"<?php if($globals["default_language"]["value"]=="cs") echo "selected"; ?>>Czech</option>
				<option value="cu"<?php if($globals["default_language"]["value"]=="cu") echo "selected"; ?>>Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic</option>
				<option value="cv"<?php if($globals["default_language"]["value"]=="cv") echo "selected"; ?>>Chuvash</option>
				<option value="cy"<?php if($globals["default_language"]["value"]=="cy") echo "selected"; ?>>Welsh</option>
				<option value="da"<?php if($globals["default_language"]["value"]=="da") echo "selected"; ?>>Danish</option>
				<option value="de"<?php if($globals["default_language"]["value"]=="de") echo "selected"; ?>>German</option>
				<option value="dv"<?php if($globals["default_language"]["value"]=="dv") echo "selected"; ?>>Divehi; Dhivehi; Maldivian</option>
				<option value="dz"<?php if($globals["default_language"]["value"]=="dz") echo "selected"; ?>>Dzongkha</option>
				<option value="ee"<?php if($globals["default_language"]["value"]=="ee") echo "selected"; ?>>Ewe</option>
				<option value="el"<?php if($globals["default_language"]["value"]=="el") echo "selected"; ?>>Greek, Modern (1453-)</option>
				<option value="en"<?php if($globals["default_language"]["value"]=="en") echo "selected"; ?>>English</option>
				<option value="eo"<?php if($globals["default_language"]["value"]=="eo") echo "selected"; ?>>Esperanto</option>
				<option value="es"<?php if($globals["default_language"]["value"]=="es") echo "selected"; ?>>Spanish; Castilian</option>
				<option value="et"<?php if($globals["default_language"]["value"]=="et") echo "selected"; ?>>Estonian</option>
				<option value="eu"<?php if($globals["default_language"]["value"]=="eu") echo "selected"; ?>>Basque</option>
				<option value="fa"<?php if($globals["default_language"]["value"]=="fa") echo "selected"; ?>>Persian</option>
				<option value="ff"<?php if($globals["default_language"]["value"]=="ff") echo "selected"; ?>>Fulah</option>
				<option value="fi"<?php if($globals["default_language"]["value"]=="fi") echo "selected"; ?>>Finnish</option>
				<option value="fj"<?php if($globals["default_language"]["value"]=="fj") echo "selected"; ?>>Fijian</option>
				<option value="fo"<?php if($globals["default_language"]["value"]=="fo") echo "selected"; ?>>Faroese</option>
				<option value="fr"<?php if($globals["default_language"]["value"]=="fr") echo "selected"; ?>>French</option>
				<option value="fy"<?php if($globals["default_language"]["value"]=="fy") echo "selected"; ?>>Western Frisian</option>
				<option value="ga"<?php if($globals["default_language"]["value"]=="ga") echo "selected"; ?>>Irish</option>
				<option value="gd"<?php if($globals["default_language"]["value"]=="gd") echo "selected"; ?>>Gaelic; Scottish Gaelic</option>
				<option value="gl"<?php if($globals["default_language"]["value"]=="gl") echo "selected"; ?>>Galician</option>
				<option value="gn"<?php if($globals["default_language"]["value"]=="gn") echo "selected"; ?>>Guarani</option>
				<option value="gu"<?php if($globals["default_language"]["value"]=="gu") echo "selected"; ?>>Gujarati</option>
				<option value="gv"<?php if($globals["default_language"]["value"]=="gv") echo "selected"; ?>>Manx</option>
				<option value="ha"<?php if($globals["default_language"]["value"]=="ha") echo "selected"; ?>>Hausa</option>
				<option value="he"<?php if($globals["default_language"]["value"]=="he") echo "selected"; ?>>Hebrew</option>
				<option value="hi"<?php if($globals["default_language"]["value"]=="hi") echo "selected"; ?>>Hindi</option>
				<option value="ho"<?php if($globals["default_language"]["value"]=="ho") echo "selected"; ?>>Hiri Motu</option>
				<option value="hr"<?php if($globals["default_language"]["value"]=="hr") echo "selected"; ?>>Croatian</option>
				<option value="ht"<?php if($globals["default_language"]["value"]=="ht") echo "selected"; ?>>Haitian; Haitian Creole</option>
				<option value="hu"<?php if($globals["default_language"]["value"]=="hu") echo "selected"; ?>>Hungarian</option>
				<option value="hy"<?php if($globals["default_language"]["value"]=="hy") echo "selected"; ?>>Armenian</option>
				<option value="hz"<?php if($globals["default_language"]["value"]=="hz") echo "selected"; ?>>Herero</option>
				<option value="ia"<?php if($globals["default_language"]["value"]=="ia") echo "selected"; ?>>Interlingua (International Auxiliary Language Association)</option>
				<option value="id"<?php if($globals["default_language"]["value"]=="id") echo "selected"; ?>>Indonesian</option>
				<option value="ie"<?php if($globals["default_language"]["value"]=="ie") echo "selected"; ?>>Interlingue</option>
				<option value="ig"<?php if($globals["default_language"]["value"]=="ig") echo "selected"; ?>>Igbo</option>
				<option value="ii"<?php if($globals["default_language"]["value"]=="ii") echo "selected"; ?>>Sichuan Yi</option>
				<option value="ik"<?php if($globals["default_language"]["value"]=="ik") echo "selected"; ?>>Inupiaq</option>
				<option value="io"<?php if($globals["default_language"]["value"]=="io") echo "selected"; ?>>Ido</option>
				<option value="is"<?php if($globals["default_language"]["value"]=="is") echo "selected"; ?>>Icelandic</option>
				<option value="it"<?php if($globals["default_language"]["value"]=="it") echo "selected"; ?>>Italian</option>
				<option value="iu"<?php if($globals["default_language"]["value"]=="iu") echo "selected"; ?>>Inuktitut</option>
				<option value="ja"<?php if($globals["default_language"]["value"]=="ja") echo "selected"; ?>>Japanese</option>
				<option value="jv"<?php if($globals["default_language"]["value"]=="jv") echo "selected"; ?>>Javanese</option>
				<option value="ka"<?php if($globals["default_language"]["value"]=="ka") echo "selected"; ?>>Georgian</option>
				<option value="kg"<?php if($globals["default_language"]["value"]=="kg") echo "selected"; ?>>Kongo</option>
				<option value="ki"<?php if($globals["default_language"]["value"]=="ki") echo "selected"; ?>>Kikuyu; Gikuyu</option>
				<option value="kj"<?php if($globals["default_language"]["value"]=="kj") echo "selected"; ?>>Kuanyama; Kwanyama</option>
				<option value="kk"<?php if($globals["default_language"]["value"]=="kk") echo "selected"; ?>>Kazakh</option>
				<option value="kl"<?php if($globals["default_language"]["value"]=="kl") echo "selected"; ?>>Kalaallisut; Greenlandic</option>
				<option value="km"<?php if($globals["default_language"]["value"]=="km") echo "selected"; ?>>Central Khmer</option>
				<option value="kn"<?php if($globals["default_language"]["value"]=="kn") echo "selected"; ?>>Kannada</option>
				<option value="ko"<?php if($globals["default_language"]["value"]=="ko") echo "selected"; ?>>Korean</option>
				<option value="kr"<?php if($globals["default_language"]["value"]=="kr") echo "selected"; ?>>Kanuri</option>
				<option value="ks"<?php if($globals["default_language"]["value"]=="ks") echo "selected"; ?>>Kashmiri</option>
				<option value="ku"<?php if($globals["default_language"]["value"]=="ku") echo "selected"; ?>>Kurdish</option>
				<option value="kv"<?php if($globals["default_language"]["value"]=="kv") echo "selected"; ?>>Komi</option>
				<option value="kw"<?php if($globals["default_language"]["value"]=="kw") echo "selected"; ?>>Cornish</option>
				<option value="ky"<?php if($globals["default_language"]["value"]=="ky") echo "selected"; ?>>Kirghiz; Kyrgyz</option>
				<option value="la"<?php if($globals["default_language"]["value"]=="la") echo "selected"; ?>>Latin</option>
				<option value="lb"<?php if($globals["default_language"]["value"]=="lb") echo "selected"; ?>>Luxembourgish; Letzeburgesch</option>
				<option value="lg"<?php if($globals["default_language"]["value"]=="lg") echo "selected"; ?>>Ganda</option>
				<option value="li"<?php if($globals["default_language"]["value"]=="li") echo "selected"; ?>>Limburgan; Limburger; Limburgish</option>
				<option value="ln"<?php if($globals["default_language"]["value"]=="ln") echo "selected"; ?>>Lingala</option>
				<option value="lo"<?php if($globals["default_language"]["value"]=="lo") echo "selected"; ?>>Lao</option>
				<option value="lt"<?php if($globals["default_language"]["value"]=="lt") echo "selected"; ?>>Lithuanian</option>
				<option value="lu"<?php if($globals["default_language"]["value"]=="lu") echo "selected"; ?>>Luba-Katanga</option>
				<option value="lv"<?php if($globals["default_language"]["value"]=="lv") echo "selected"; ?>>Latvian</option>
				<option value="mg"<?php if($globals["default_language"]["value"]=="mg") echo "selected"; ?>>Malagasy</option>
				<option value="mh"<?php if($globals["default_language"]["value"]=="mh") echo "selected"; ?>>Marshallese</option>
				<option value="mi"<?php if($globals["default_language"]["value"]=="mi") echo "selected"; ?>>Maori</option>
				<option value="mk"<?php if($globals["default_language"]["value"]=="mk") echo "selected"; ?>>Macedonian</option>
				<option value="ml"<?php if($globals["default_language"]["value"]=="ml") echo "selected"; ?>>Malayalam</option>
				<option value="mn"<?php if($globals["default_language"]["value"]=="mn") echo "selected"; ?>>Mongolian</option>
				<option value="mo"<?php if($globals["default_language"]["value"]=="mo") echo "selected"; ?>>Moldavian</option>
				<option value="mr"<?php if($globals["default_language"]["value"]=="mr") echo "selected"; ?>>Marathi</option>
				<option value="ms"<?php if($globals["default_language"]["value"]=="ms") echo "selected"; ?>>Malay</option>
				<option value="mt"<?php if($globals["default_language"]["value"]=="mt") echo "selected"; ?>>Maltese</option>
				<option value="my"<?php if($globals["default_language"]["value"]=="my") echo "selected"; ?>>Burmese</option>
				<option value="na"<?php if($globals["default_language"]["value"]=="na") echo "selected"; ?>>Nauru</option>
				<option value="nb"<?php if($globals["default_language"]["value"]=="nb") echo "selected"; ?>>Bokmål, Norwegian; Norwegian Bokmål</option>
				<option value="nd"<?php if($globals["default_language"]["value"]=="nd") echo "selected"; ?>>Ndebele, North; North Ndebele</option>
				<option value="ne"<?php if($globals["default_language"]["value"]=="ne") echo "selected"; ?>>Nepali</option>
				<option value="ng"<?php if($globals["default_language"]["value"]=="ng") echo "selected"; ?>>Ndonga</option>
				<option value="nl"<?php if($globals["default_language"]["value"]=="nl") echo "selected"; ?>>Dutch; Flemish</option>
				<option value="nn"<?php if($globals["default_language"]["value"]=="nn") echo "selected"; ?>>Norwegian Nynorsk; Nynorsk, Norwegian</option>
				<option value="no"<?php if($globals["default_language"]["value"]=="no") echo "selected"; ?>>Norwegian</option>
				<option value="nr"<?php if($globals["default_language"]["value"]=="nr") echo "selected"; ?>>Ndebele, South; South Ndebele</option>
				<option value="nv"<?php if($globals["default_language"]["value"]=="nv") echo "selected"; ?>>Navajo; Navaho</option>
				<option value="ny"<?php if($globals["default_language"]["value"]=="ny") echo "selected"; ?>>Chichewa; Chewa; Nyanja</option>
				<option value="oc"<?php if($globals["default_language"]["value"]=="oc") echo "selected"; ?>>Occitan (post 1500); Provençal</option>
				<option value="oj"<?php if($globals["default_language"]["value"]=="oj") echo "selected"; ?>>Ojibwa</option>
				<option value="om"<?php if($globals["default_language"]["value"]=="om") echo "selected"; ?>>Oromo</option>
				<option value="or"<?php if($globals["default_language"]["value"]=="or") echo "selected"; ?>>Oriya</option>
				<option value="os"<?php if($globals["default_language"]["value"]=="os") echo "selected"; ?>>Ossetian; Ossetic</option>
				<option value="pa"<?php if($globals["default_language"]["value"]=="pa") echo "selected"; ?>>Panjabi; Punjabi</option>
				<option value="pi"<?php if($globals["default_language"]["value"]=="pi") echo "selected"; ?>>Pali</option>
				<option value="pl"<?php if($globals["default_language"]["value"]=="pl") echo "selected"; ?>>Polish</option>
				<option value="ps"<?php if($globals["default_language"]["value"]=="ps") echo "selected"; ?>>Pushto</option>
				<option value="pt"<?php if($globals["default_language"]["value"]=="pt") echo "selected"; ?>>Portuguese</option>
				<option value="qu"<?php if($globals["default_language"]["value"]=="qu") echo "selected"; ?>>Quechua</option>
				<option value="rm"<?php if($globals["default_language"]["value"]=="rm") echo "selected"; ?>>Romansh</option>
				<option value="rn"<?php if($globals["default_language"]["value"]=="rn") echo "selected"; ?>>Rundi</option>
				<option value="ro"<?php if($globals["default_language"]["value"]=="ro") echo "selected"; ?>>Romanian</option>
				<option value="ru"<?php if($globals["default_language"]["value"]=="ru") echo "selected"; ?>>Russian</option>
				<option value="rw"<?php if($globals["default_language"]["value"]=="rw") echo "selected"; ?>>Kinyarwanda</option>
				<option value="sa"<?php if($globals["default_language"]["value"]=="sa") echo "selected"; ?>>Sanskrit</option>
				<option value="sc"<?php if($globals["default_language"]["value"]=="sc") echo "selected"; ?>>Sardinian</option>
				<option value="sd"<?php if($globals["default_language"]["value"]=="sd") echo "selected"; ?>>Sindhi</option>
				<option value="se"<?php if($globals["default_language"]["value"]=="se") echo "selected"; ?>>Northern Sami</option>
				<option value="sg"<?php if($globals["default_language"]["value"]=="sg") echo "selected"; ?>>Sango</option>
				<option value="si"<?php if($globals["default_language"]["value"]=="si") echo "selected"; ?>>Sinhala; Sinhalese</option>
				<option value="sk"<?php if($globals["default_language"]["value"]=="sk") echo "selected"; ?>>Slovak</option>
				<option value="sl"<?php if($globals["default_language"]["value"]=="sl") echo "selected"; ?>>Slovenian</option>
				<option value="sm"<?php if($globals["default_language"]["value"]=="sm") echo "selected"; ?>>Samoan</option>
				<option value="sn"<?php if($globals["default_language"]["value"]=="sn") echo "selected"; ?>>Shona</option>
				<option value="so"<?php if($globals["default_language"]["value"]=="so") echo "selected"; ?>>Somali</option>
				<option value="sq"<?php if($globals["default_language"]["value"]=="sq") echo "selected"; ?>>Albanian</option>
				<option value="sr"<?php if($globals["default_language"]["value"]=="sr") echo "selected"; ?>>Serbian</option>
				<option value="ss"<?php if($globals["default_language"]["value"]=="ss") echo "selected"; ?>>Swati</option>
				<option value="st"<?php if($globals["default_language"]["value"]=="st") echo "selected"; ?>>Sotho, Southern</option>
				<option value="su"<?php if($globals["default_language"]["value"]=="su") echo "selected"; ?>>Sundanese</option>
				<option value="sv"<?php if($globals["default_language"]["value"]=="sv") echo "selected"; ?>>Swedish</option>
				<option value="sw"<?php if($globals["default_language"]["value"]=="sw") echo "selected"; ?>>Swahili</option>
				<option value="ta"<?php if($globals["default_language"]["value"]=="ta") echo "selected"; ?>>Tamil</option>
				<option value="te"<?php if($globals["default_language"]["value"]=="te") echo "selected"; ?>>Telugu</option>
				<option value="tg"<?php if($globals["default_language"]["value"]=="tg") echo "selected"; ?>>Tajik</option>
				<option value="th"<?php if($globals["default_language"]["value"]=="th") echo "selected"; ?>>Thai</option>
				<option value="ti"<?php if($globals["default_language"]["value"]=="ti") echo "selected"; ?>>Tigrinya</option>
				<option value="tk"<?php if($globals["default_language"]["value"]=="tk") echo "selected"; ?>>Turkmen</option>
				<option value="tl"<?php if($globals["default_language"]["value"]=="tl") echo "selected"; ?>>Tagalog</option>
				<option value="tn"<?php if($globals["default_language"]["value"]=="tn") echo "selected"; ?>>Tswana</option>
				<option value="to"<?php if($globals["default_language"]["value"]=="to") echo "selected"; ?>>Tonga (Tonga Islands)</option>
				<option value="tr"<?php if($globals["default_language"]["value"]=="tr") echo "selected"; ?>>Turkish</option>
				<option value="ts"<?php if($globals["default_language"]["value"]=="ts") echo "selected"; ?>>Tsonga</option>
				<option value="tt"<?php if($globals["default_language"]["value"]=="tt") echo "selected"; ?>>Tatar</option>
				<option value="tw"<?php if($globals["default_language"]["value"]=="tw") echo "selected"; ?>>Twi</option>
				<option value="ty"<?php if($globals["default_language"]["value"]=="ty") echo "selected"; ?>>Tahitian</option>
				<option value="ug"<?php if($globals["default_language"]["value"]=="ug") echo "selected"; ?>>Uighur; Uyghur</option>
				<option value="uk"<?php if($globals["default_language"]["value"]=="uk") echo "selected"; ?>>Ukrainian</option>
				<option value="ur"<?php if($globals["default_language"]["value"]=="ur") echo "selected"; ?>>Urdu</option>
				<option value="uz"<?php if($globals["default_language"]["value"]=="uz") echo "selected"; ?>>Uzbek</option>
				<option value="ve"<?php if($globals["default_language"]["value"]=="ve") echo "selected"; ?>>Venda</option>
				<option value="vi"<?php if($globals["default_language"]["value"]=="vi") echo "selected"; ?>>Vietnamese</option>
				<option value="vo"<?php if($globals["default_language"]["value"]=="vo") echo "selected"; ?>>Volapük</option>
				<option value="wa"<?php if($globals["default_language"]["value"]=="wa") echo "selected"; ?>>Walloon</option>
				<option value="wo"<?php if($globals["default_language"]["value"]=="wo") echo "selected"; ?>>Wolof</option>
				<option value="xh"<?php if($globals["default_language"]["value"]=="xh") echo "selected"; ?>>Xhosa</option>
				<option value="yi"<?php if($globals["default_language"]["value"]=="yi") echo "selected"; ?>>Yiddish</option>
				<option value="yo"<?php if($globals["default_language"]["value"]=="yo") echo "selected"; ?>>Yoruba</option>
				<option value="za"<?php if($globals["default_language"]["value"]=="za") echo "selected"; ?>>Zhuang; Chuang</option>
				<option value="zh"<?php if($globals["default_language"]["value"]=="zh") echo "selected"; ?>>Chinese</option>
				<option value="zu"<?php if($globals["default_language"]["value"]=="zu") echo "selected"; ?>>Zulu</option>
				
			</select>
		
		</fieldset>
			
		<input type="hidden" name="editglobals" id="editglobals">
		<input type="submit" name="submit" id="submit" value="Save">
	</form>

</div>

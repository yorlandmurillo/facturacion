<tbody><tr>
		<td class="fileas" align="left" width="450"><select name="exec[fileas_type]" id="exec[fileas_type]" onFocus="if(this.value=='Nombre') this.value='';self.status='orden propio'; return true;" onBlur="if(this.value=='') this.value='Nombre';self.status=''; return true;">
<option value="org_name: n_family, n_given">Compañía: Apellido, Nombre de pila</option>
<option value="org_name: n_family, n_prefix">Compañía: Apellido, Prefijo</option>
<option value="org_name: n_given n_family">Compañía: Nombre de pila Apellido</option>
<option value="org_name: n_fn">Compañía: Prefijo Nombre de pila Segundo nombre Apellido Sufijo</option>
<option value="n_family, n_given: org_name">Apellido, Nombre de pila: Compañía</option>
<option value="n_family, n_prefix: org_name">Apellido, Prefijo: Compañía</option>
<option value="n_given n_family: org_name">Nombre de pila Apellido: Compañía</option>

<option value="n_prefix n_family: org_name">Prefijo Apellido: Compañía</option>
<option value="n_fn: org_name">Prefijo Nombre de pila Segundo nombre Apellido Sufijo: Compañía</option>
<option value="org_name">Compañía</option>
<option value="org_name - org_unit">Compañía - Departamento</option>
<option value="n_given n_family">Nombre de pila Apellido</option>
<option value="n_prefix n_family">Prefijo Apellido</option>
<option value="n_family, n_given">Apellido, Nombre de pila</option>
<option value="n_family, n_prefix">Apellido, Prefijo</option>
<option value="n_fn">Prefijo Nombre de pila Segundo nombre Apellido Sufijo</option>

</select>
</td>
		<td align="right" width="350">&nbsp;</td>
	</tr>
	<tr valign="top">
		<td align="left">

<!-- BEGIN eTemplate etemplate.tab_widget -->
<div id="etemplate.tab_widget">




<!-- BEGIN grid  -->
<table cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td align="left">

<!-- BEGIN hbox -->

<table class="TabHeader">
	<tbody><tr>
		<td onClick="activate_tab('addressbook.edit.general','general|home|details|links','exec[general|cats|home|details|links|distribution_list|custom|custom_private]');" id="addressbook.edit.general-tab" onMouseOver="self.status='Nombre, Dirección'; return true;" onMouseOut="self.status=''; return true;" class="etemplate_tab_active">General </td>
		<td onClick="activate_tab('addressbook.edit.home','general|home|details|links','exec[general|cats|home|details|links|distribution_list|custom|custom_private]');" id="addressbook.edit.home-tab" onMouseOver="self.status='Domicilio particular, Cumpleaños, ...'; return true;" onMouseOut="self.status=''; return true;" class="etemplate_tab">Privado </td>

		<td onClick="activate_tab('addressbook.edit.details','general|home|details|links','exec[general|cats|home|details|links|distribution_list|custom|custom_private]');" id="addressbook.edit.details-tab" onMouseOver="self.status='Categorías, Notas, ...'; return true;" onMouseOut="self.status=''; return true;" class="etemplate_tab">Detalles </td>
		<td onClick="activate_tab('addressbook.edit.links','general|home|details|links','exec[general|cats|home|details|links|distribution_list|custom|custom_private]');" id="addressbook.edit.links-tab" onMouseOver="self.status='Enlaces'; return true;" onMouseOut="self.status=''; return true;" class="etemplate_tab">Enlaces </td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>
	<tr class="row_on_off">

		<td class="tab_body" align="left"><input name="exec[general|cats|home|details|links|distribution_list|custom|custom_private]" value="addressbook.edit.general" type="hidden">
<div style="display: inline;" id="addressbook.edit.general">


<!-- BEGIN eTemplate addressbook.edit.general -->
<div id="addressbook.edit.general">





<!-- BEGIN grid  -->
<table height="286">
	<tbody><tr valign="top">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/accounts.png" border="0"></td>

		<td align="left">

<!-- BEGIN vbox -->

<table>
	<tbody><tr>
		<td onClick="set_style_by_class('table','uploadphoto','display','inline'); return false;" class="photo"><img src="/egw-trunk/addressbook/templates/default/images/photo.png" id="photo" border="0"></td>
	</tr>
	<tr>
		<td>

<!-- BEGIN eTemplate addressbook.edit.upload -->
<div id="addressbook.edit.upload">





<!-- BEGIN grid  -->
<table class="uploadphoto">
	<tbody><tr>
		<td class="photo" align="left"><input name="exec[upload_photo_path]" value="." type="hidden">
<input name="exec[upload_photo]" value="" id="exec[upload_photo]" onMouseOver="self.status='Seleccione una foto jpeg en formato vertical. Se redimensionará a un ancho de 60 pixels.'; return true;" onMouseOut="self.status=''; return true;" onFocus="self.status='Seleccione una foto jpeg en formato vertical. Se redimensionará a un ancho de 60 pixels.'; return true;" onBlur="self.status=''; return true;" type="file">
</td>
	</tr>

	<tr>
		<td align="center"><input name="exec[]" value="Aceptar" id="exec[]" onClick="set_style_by_class('table','uploadphoto','display','none'); return false;" type="submit">
</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.edit.upload -->

</td>
	</tr>

</tbody></table>


<!-- END vbox -->

</td>
		<td align="left">

<!-- BEGIN grid  -->
<table>
	<tbody><tr>
		<td align="left">Nombre </td>
		<td onClick="set_style_by_class('table','editname','display','inline'); document.getElementById('exec[n_prefix]').focus();" colspan="2" class="cursorHand" align="left"><input name="exec[n_fn]" value="" id="exec[n_fn]" readonly="readonly" size="36">

</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">

<!-- BEGIN eTemplate addressbook.edit.name -->
<div id="addressbook.edit.name">





<!-- BEGIN grid  -->
<table class="editname" width="310" height="160">
	<tbody><tr>
		<td align="left" width="20%"><label for="exec[n_prefix]">Prefijo</label> </td>
		<td align="left"><input name="exec[n_prefix]" value="" id="exec[n_prefix]" onChange="setName(this);" size="35" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[n_given]">Nombre de pila</label> </td>

		<td align="left"><input name="exec[n_given]" value="" id="exec[n_given]" onChange="setName(this);" size="35" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[n_middle]">Segundo nombre</label> </td>
		<td align="left"><input name="exec[n_middle]" value="" id="exec[n_middle]" onChange="setName(this);" size="35" maxlength="64">
</td>
	</tr>
	<tr>

		<td align="left"><label for="exec[n_family]">Apellido</label> </td>
		<td align="left"><input name="exec[n_family]" value="" id="exec[n_family]" onChange="setName(this);" size="35" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[n_suffix]">Sufijo</label> </td>
		<td align="left"><input name="exec[n_suffix]" value="" id="exec[n_suffix]" onChange="setName(this);" size="35" maxlength="64">

</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><input name="exec[]" value="Aceptar" id="exec[]" onClick="set_style_by_class('table','editname','display','none'); if(document.getElementById('exec[title]')){document.getElementById('exec[title]').focus();} return false;" type="submit">
</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>

<!-- END eTemplate addressbook.edit.name -->

</td>
		<td align="left">&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[title]">Título</label> </td>
		<td colspan="2" align="left"><input name="exec[title]" value="" id="exec[title]" size="36" maxlength="64">
</td>
	</tr>

	<tr>
		<td align="left"><label for="exec[role]">Rol</label> </td>
		<td align="left"><input name="exec[role]" value="" id="exec[role]" size="20" maxlength="64">
</td>
		<td align="left"><label for="exec[room]">Habitación</label> <input name="exec[room]" value="" id="exec[room]" size="5">
</td>
	</tr>
</tbody></table>

<!-- END grid  -->

</td>
	</tr>
	<tr>
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/home.png" border="0"></td>
		<td align="left">organización </td>
		<td align="left"><input name="exec[org_name]" value="" id="exec[org_name]" onChange="setName(this);" size="45" maxlength="128">
</td>
	</tr>

	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[org_unit]">Departamento</label> </td>
		<td align="left"><input name="exec[org_unit]" value="" id="exec[org_unit]" size="45" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left"></td>

		<td align="left"><label for="exec[adr_one_street]">Calle</label> </td>
		<td align="left"><input name="exec[adr_one_street]" value="" id="exec[adr_one_street]" size="45" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
		<td align="left"><input name="exec[adr_one_street2]" value="" id="exec[adr_one_street2]" onFocus="self.status='Línea 2 de la dirección'; return true;" onBlur="self.status=''; return true;" size="45" maxlength="64">

</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[adr_one_locality]">Ciudad</label> </td>
		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0">

	<tbody><tr>
		<td><input name="exec[adr_one_postalcode]" value="" id="exec[adr_one_postalcode]" onFocus="self.status='Código postal'; return true;" onBlur="self.status=''; return true;" size="5" maxlength="64">
</td>
		<td class="leftPad5"><input name="exec[adr_one_locality]" value="" id="exec[adr_one_locality]" onFocus="self.status='Ciudad'; return true;" onBlur="self.status=''; return true;" size="35" maxlength="64">
</td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>

	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[adr_one_countryname]">País</label> </td>
		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td class="countrySelect"><select name="exec[adr_one_countryname]" id="exec[adr_one_countryname]">

<option value="">Seleccionar uno</option>
<option value="AX">AALAND ISLANDS</option>
<option value="AF">AFGHANISTAN</option>
<option value="AL">ALBANIA</option>
<option value="DE">ALEMANIA</option>
<option value="AS">AMERICAN SAMOA</option>
<option value="AD">ANDORRA</option>
<option value="AO">ANGOLA</option>
<option value="AI">ANGUILLA</option>

<option value="AQ">ANTARCTICA</option>
<option value="AG">ANTIGUA AND BARBUDA</option>
<option value="AN">ANTILLAS HOLANDESAS</option>
<option value="SA">ARABIA SAUDI</option>
<option value="DZ">ARGELIA</option>
<option value="AR">ARGENTINA</option>
<option value="AM">ARMENIA</option>
<option value="AW">ARUBA</option>
<option value="AU">AUSTRALIA</option>

<option value="AT">AUSTRIA</option>
<option value="AZ">AZERBAIJAN</option>
<option value="BS">BAHAMAS</option>
<option value="BH">BAHRAIN</option>
<option value="BD">BANGLADESH</option>
<option value="BB">BARBADOS</option>
<option value="BY">BELARUS</option>
<option value="BE">BELGICA</option>
<option value="BZ">BELIZE</option>

<option value="BJ">BENIN</option>
<option value="BM">BERMUDAS</option>
<option value="BT">BHUTAN</option>
<option value="BO">BOLIVIA</option>
<option value="BA">BOSNIA AND HERZEGOVINA</option>
<option value="BW">BOTSWANA</option>
<option value="BV">BOUVET ISLAND</option>
<option value="BR">BRASIL</option>
<option value="IO">BRITISH INDIAN OCEAN TERRITORY</option>

<option value="BN">BRUNEI DARUSSALAM</option>
<option value="BG">BULGARIA</option>
<option value="BF">BURKINA FASO</option>
<option value="BI">BURUNDI</option>
<option value="KH">CAMBODIA</option>
<option value="CF">CENTRAL AFRICAN REPUBLIC</option>
<option value="TD">CHAD</option>
<option value="CL">CHILE</option>
<option value="CN">CHINA</option>

<option value="CY">CHIPRE</option>
<option value="CX">CHRISTMAS ISLAND</option>
<option value="CC">COCOS (KEELING) ISLANDS</option>
<option value="CO">COLOMBIA</option>
<option value="KM">COMOROS</option>
<option value="CG">CONGO</option>
<option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
<option value="CK">COOK ISLANDS</option>
<option value="CI">COSTA DE MARFIL</option>

<option value="CR">COSTA RICA</option>
<option value="HR">CROACIA</option>
<option value="CU">CUBA</option>
<option value="CV">Cabo Verde</option>
<option value="CM">Camerún</option>
<option value="CA">Canadá</option>
<option value="DK">DINAMARCA</option>
<option value="DJ">DJIBOUTI</option>
<option value="DM">DOMINICA</option>

<option value="EC">ECUADOR</option>
<option value="EG">EGIPTO</option>
<option value="SV">EL SALVADOR</option>
<option value="AE">EMIRATOS ARABES UNIDOS</option>
<option value="ER">ERITREA</option>
<option value="SK">ESLOVAQUIA</option>
<option value="SI">ESLOVENIA</option>
<option value="ES">ESPAÑA</option>
<option value="US">ESTADOS UNIDOS</option>

<option value="EE">ESTONIA</option>
<option value="ET">ETIOPIA</option>
<option value="RU">FEDERACION RUSA</option>
<option value="FJ">FIJI</option>
<option value="PH">FILIPINAS</option>
<option value="FI">FINLANDIA</option>
<option value="TP">FORMER EAST TIMOR</option>
<option value="CS">FORMER SERBIA AND MONTENEGRO</option>
<option value="YU">FORMER YUGOSLAVIA</option>

<option value="FR" selected="selected">FRANCIA</option>
<option value="PF">FRENCH POLYNESIA</option>
<option value="TF">FRENCH SOUTHERN TERRITORIES</option>
<option value="GA">GABON</option>
<option value="GM">GAMBIA</option>
<option value="GE">GEORGIA</option>
<option value="GH">GHANA</option>
<option value="GI">GIBRALTAR</option>
<option value="GD">GRANADA</option>

<option value="GR">GRECIA</option>
<option value="GL">GREENLAND</option>
<option value="GP">GUADALUPE</option>
<option value="GU">GUAM</option>
<option value="GT">GUATEMALA</option>
<option value="GF">GUAYANA FRANCESA</option>
<option value="GN">GUINEA</option>
<option value="GQ">GUINEA ECUATORIAL</option>
<option value="GW">GUINEA-BISSAU</option>

<option value="GY">GUYANA</option>
<option value="HT">HAITI</option>
<option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option>
<option value="NL">HOLANDA</option>
<option value="VA">HOLY SEE (VATICANO)</option>
<option value="HN">HONDURAS</option>
<option value="HK">HONG KONG</option>
<option value="HU">HUNGRÍA</option>
<option value="IN">INDIA</option>

<option value="ID">INDONESIA</option>
<option value="IQ">IRAK</option>
<option value="IR">IRAN, ISLAMIC REPUBLIC OF</option>
<option value="IE">IRLANDA</option>
<option value="IS">ISLANDIA</option>
<option value="FO">ISLAS FEROE</option>
<option value="IL">ISRAEL</option>
<option value="IT">ITALIA</option>
<option value="KY">Islas Caimán</option>

<option value="JM">JAMAICA</option>
<option value="JP">JAPON</option>
<option value="JO">JORDANIA</option>
<option value="KZ">KAZAKSTAN</option>
<option value="KE">KENIA</option>
<option value="KI">KIRIBATI</option>
<option value="KP">KOREA DEMOCRATIC PEOPLES REPUBLIC OF</option>
<option value="KR">KOREA REPUBLIC OF</option>
<option value="KW">KUWAIT</option>

<option value="KG">KYRGYZSTAN</option>
<option value="LA">LAO PEOPLES DEMOCRATIC REPUBLIC</option>
<option value="LV">LATVIA</option>
<option value="LS">LESOTHO</option>
<option value="LB">LIBANO</option>
<option value="LR">LIBERIA</option>
<option value="LY">LIBYAN ARAB JAMAHIRIYA</option>
<option value="LI">LIECHTENSTEIN</option>
<option value="LT">LITUANIA</option>

<option value="LU">LUXEMBURGO</option>
<option value="MO">MACAU</option>
<option value="MG">MADAGASCAR</option>
<option value="MY">MALASIA</option>
<option value="MW">MALAWI</option>
<option value="MV">MALDIVAS</option>
<option value="ML">MALI</option>
<option value="MT">MALTA</option>
<option value="FK">MALVINAS</option>

<option value="MA">MARRUECOS</option>
<option value="MH">MARSHALL ISLANDS</option>
<option value="MQ">MARTINICA</option>
<option value="MU">MAURICIO</option>
<option value="MR">MAURITANIA</option>
<option value="YT">MAYOTTE</option>
<option value="MX">MEXICO</option>
<option value="FM">MICRONESIA, FEDERATED STATES OF</option>
<option value="MD">MOLDOVA, REPUBLIC OF</option>

<option value="MC">MONACO</option>
<option value="MN">MONGOLIA</option>
<option value="MS">MONTSERRAT</option>
<option value="MZ">MOZAMBIQUE</option>
<option value="MM">MYANMAR</option>
<option value="MK">Macedonia</option>
<option value="ME">Montenegro</option>
<option value="NA">NAMIBIA</option>
<option value="NR">NAURU</option>

<option value="NP">NEPAL</option>
<option value="NI">NICARAGUA</option>
<option value="NE">NIGER</option>
<option value="NG">NIGERIA</option>
<option value="NU">NIUE</option>
<option value="NF">NORFOLK ISLAND</option>
<option value="MP">NORTHERN MARIANA ISLANDS</option>
<option value="NO">NORUEGA</option>
<option value="NC">NUEVA CALEDONIA</option>

<option value="NZ">NUEVA ZELANDA</option>
<option value="OM">OMAN</option>
<option value="PK">PAKISTAN</option>
<option value="PW">PALAU</option>
<option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option>
<option value="PA">PANAMA</option>
<option value="PG">PAPUA NEW GUINEA</option>
<option value="PY">PARAGUAY</option>
<option value="PE">PERU</option>

<option value="PN">PITCAIRN</option>
<option value="PL">POLONIA</option>
<option value="PT">PORTUGAL</option>
<option value="PR">PUERTO RICO</option>
<option value="QA">QATAR</option>
<option value="GB">REINO UNIDO</option>
<option value="CZ">REPUBLICA CHECHA</option>
<option value="DO">REPUBLICA DOMINICANA</option>
<option value="RE">REUNION</option>

<option value="RW">RUANDA</option>
<option value="RO">RUMANIA</option>
<option value="EH">SAHARA OCCIDENTAL</option>
<option value="KN">SAINT KITTS AND NEVIS</option>
<option value="LC">SAINT LUCIA</option>
<option value="PM">SAINT PIERRE AND MIQUELON</option>
<option value="VC">SAINT VINCENT AND THE GRENADINES</option>
<option value="WS">SAMOA</option>
<option value="SM">SAN MARINO</option>

<option value="SH">SANTA ELENA</option>
<option value="ST">SAO TOME AND PRINCIPE</option>
<option value="SN">SENEGAL</option>
<option value="SC">SEYCHELLES</option>
<option value="SL">SIERRA LEONA</option>
<option value="SG">SINGAPUR</option>
<option value="SB">SOLOMON ISLANDS</option>
<option value="SO">SOMALIA</option>
<option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>

<option value="LK">SRI LANKA</option>
<option value="ZA">SUDAFRICA</option>
<option value="SD">SUDÁN</option>
<option value="SE">SUECIA</option>
<option value="CH">SUIZA</option>
<option value="SR">SURINAM</option>
<option value="SJ">SVALBARD AND JAN MAYEN</option>
<option value="SZ">SWAZILAND</option>
<option value="SY">SYRIAN ARAB REPUBLIC</option>

<option value="RS">Serbia</option>
<option value="TH">TAILANDIA</option>
<option value="TW">TAIWAN/TAIPEI</option>
<option value="TJ">TAJIKISTAN</option>
<option value="TZ">TANZANIA, UNITED REPUBLIC OF</option>
<option value="TL">TIMOR-LESTE</option>
<option value="TG">TOGO</option>
<option value="TK">TOKELAU</option>
<option value="TO">TONGA</option>

<option value="TT">TRINIDAD AND TOBAGO</option>
<option value="TN">TUNEZ</option>
<option value="TM">TURKMENISTAN</option>
<option value="TC">TURKS AND CAICOS ISLANDS</option>
<option value="TR">TURQUIA</option>
<option value="TV">TUVALU</option>
<option value="UA">UCRANIA</option>
<option value="UG">UGANDA</option>
<option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option>

<option value="UY">URUGUAY</option>
<option value="UZ">UZBEKISTAN</option>
<option value="VU">VANUATU</option>
<option value="VE">VENEZUELA</option>
<option value="VN">VIETNAM</option>
<option value="VG">VIRGIN ISLANDS, BRITISH</option>
<option value="VI">VIRGIN ISLANDS, U.S.</option>
<option value="WF">WALLIS AND FUTUNA</option>
<option value="YE">YEMEN</option>

<option value="ZM">ZAMBIA</option>
<option value="ZW">ZIMBAWE</option>
</select>
</td>
		<td class="leftPad5"><input name="exec[adr_one_region]" value="" id="exec[adr_one_region]" onFocus="self.status='Provincia'; return true;" onBlur="self.status=''; return true;" size="19" maxlength="64">
</td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>

	</tr>
	<tr valign="bottom" height="25">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/private.png" border="0"></td>
		<td align="left">Libreta de direcciones </td>
		<td class="owner" align="left"><select name="exec[owner]" id="exec[owner]" onFocus="self.status='Libreta de direcciones en la que guardar el contacto'; return true;" onBlur="self.status=''; return true;">
<option value="5" selected="selected">Personal</option>
<option value="-1">Grupo Default</option>
</select>
</td>

	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.edit.general -->

</div>
<div style="display: none;" id="addressbook.edit.home">


<!-- BEGIN eTemplate addressbook.edit.home -->
<div id="addressbook.edit.home">




<!-- BEGIN grid  -->
<table height="258">
	<tbody><tr>
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/accounts.png" border="0"></td>
		<td align="left"><label for="exec[adr_two_street]">Calle</label> </td>
		<td align="left"><input name="exec[adr_two_street]" value="" id="exec[adr_two_street]" size="45" maxlength="64">
</td>
	</tr>

	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
		<td align="left"><input name="exec[adr_two_street2]" value="" id="exec[adr_two_street2]" onFocus="self.status='Línea 2 de la dirección'; return true;" onBlur="self.status=''; return true;" size="45" maxlength="64">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[adr_two_locality]">Ciudad</label> </td>

		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td><input name="exec[adr_two_postalcode]" value="" id="exec[adr_two_postalcode]" onFocus="self.status='Código postal'; return true;" onBlur="self.status=''; return true;" size="5" maxlength="64">
</td>
		<td class="leftPad5"><input name="exec[adr_two_locality]" value="" id="exec[adr_two_locality]" onFocus="self.status='Ciudad'; return true;" onBlur="self.status=''; return true;" size="35" maxlength="64">
</td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[adr_two_countryname]">País</label> </td>
		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td class="countrySelect"><select name="exec[adr_two_countryname]" id="exec[adr_two_countryname]">
<option value="" selected="selected">Seleccionar uno</option>
<option value="AX">AALAND ISLANDS</option>
<option value="AF">AFGHANISTAN</option>
<option value="AL">ALBANIA</option>
<option value="DE">ALEMANIA</option>

<option value="AS">AMERICAN SAMOA</option>
<option value="AD">ANDORRA</option>
<option value="AO">ANGOLA</option>
<option value="AI">ANGUILLA</option>
<option value="AQ">ANTARCTICA</option>
<option value="AG">ANTIGUA AND BARBUDA</option>
<option value="AN">ANTILLAS HOLANDESAS</option>
<option value="SA">ARABIA SAUDI</option>
<option value="DZ">ARGELIA</option>

<option value="AR">ARGENTINA</option>
<option value="AM">ARMENIA</option>
<option value="AW">ARUBA</option>
<option value="AU">AUSTRALIA</option>
<option value="AT">AUSTRIA</option>
<option value="AZ">AZERBAIJAN</option>
<option value="BS">BAHAMAS</option>
<option value="BH">BAHRAIN</option>
<option value="BD">BANGLADESH</option>

<option value="BB">BARBADOS</option>
<option value="BY">BELARUS</option>
<option value="BE">BELGICA</option>
<option value="BZ">BELIZE</option>
<option value="BJ">BENIN</option>
<option value="BM">BERMUDAS</option>
<option value="BT">BHUTAN</option>
<option value="BO">BOLIVIA</option>
<option value="BA">BOSNIA AND HERZEGOVINA</option>

<option value="BW">BOTSWANA</option>
<option value="BV">BOUVET ISLAND</option>
<option value="BR">BRASIL</option>
<option value="IO">BRITISH INDIAN OCEAN TERRITORY</option>
<option value="BN">BRUNEI DARUSSALAM</option>
<option value="BG">BULGARIA</option>
<option value="BF">BURKINA FASO</option>
<option value="BI">BURUNDI</option>
<option value="KH">CAMBODIA</option>

<option value="CF">CENTRAL AFRICAN REPUBLIC</option>
<option value="TD">CHAD</option>
<option value="CL">CHILE</option>
<option value="CN">CHINA</option>
<option value="CY">CHIPRE</option>
<option value="CX">CHRISTMAS ISLAND</option>
<option value="CC">COCOS (KEELING) ISLANDS</option>
<option value="CO">COLOMBIA</option>
<option value="KM">COMOROS</option>

<option value="CG">CONGO</option>
<option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
<option value="CK">COOK ISLANDS</option>
<option value="CI">COSTA DE MARFIL</option>
<option value="CR">COSTA RICA</option>
<option value="HR">CROACIA</option>
<option value="CU">CUBA</option>
<option value="CV">Cabo Verde</option>
<option value="CM">Camerún</option>

<option value="CA">Canadá</option>
<option value="DK">DINAMARCA</option>
<option value="DJ">DJIBOUTI</option>
<option value="DM">DOMINICA</option>
<option value="EC">ECUADOR</option>
<option value="EG">EGIPTO</option>
<option value="SV">EL SALVADOR</option>
<option value="AE">EMIRATOS ARABES UNIDOS</option>
<option value="ER">ERITREA</option>

<option value="SK">ESLOVAQUIA</option>
<option value="SI">ESLOVENIA</option>
<option value="ES">ESPAÑA</option>
<option value="US">ESTADOS UNIDOS</option>
<option value="EE">ESTONIA</option>
<option value="ET">ETIOPIA</option>
<option value="RU">FEDERACION RUSA</option>
<option value="FJ">FIJI</option>
<option value="PH">FILIPINAS</option>

<option value="FI">FINLANDIA</option>
<option value="TP">FORMER EAST TIMOR</option>
<option value="CS">FORMER SERBIA AND MONTENEGRO</option>
<option value="YU">FORMER YUGOSLAVIA</option>
<option value="FR">FRANCIA</option>
<option value="PF">FRENCH POLYNESIA</option>
<option value="TF">FRENCH SOUTHERN TERRITORIES</option>
<option value="GA">GABON</option>
<option value="GM">GAMBIA</option>

<option value="GE">GEORGIA</option>
<option value="GH">GHANA</option>
<option value="GI">GIBRALTAR</option>
<option value="GD">GRANADA</option>
<option value="GR">GRECIA</option>
<option value="GL">GREENLAND</option>
<option value="GP">GUADALUPE</option>
<option value="GU">GUAM</option>
<option value="GT">GUATEMALA</option>

<option value="GF">GUAYANA FRANCESA</option>
<option value="GN">GUINEA</option>
<option value="GQ">GUINEA ECUATORIAL</option>
<option value="GW">GUINEA-BISSAU</option>
<option value="GY">GUYANA</option>
<option value="HT">HAITI</option>
<option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option>
<option value="NL">HOLANDA</option>
<option value="VA">HOLY SEE (VATICANO)</option>

<option value="HN">HONDURAS</option>
<option value="HK">HONG KONG</option>
<option value="HU">HUNGRÍA</option>
<option value="IN">INDIA</option>
<option value="ID">INDONESIA</option>
<option value="IQ">IRAK</option>
<option value="IR">IRAN, ISLAMIC REPUBLIC OF</option>
<option value="IE">IRLANDA</option>
<option value="IS">ISLANDIA</option>

<option value="FO">ISLAS FEROE</option>
<option value="IL">ISRAEL</option>
<option value="IT">ITALIA</option>
<option value="KY">Islas Caimán</option>
<option value="JM">JAMAICA</option>
<option value="JP">JAPON</option>
<option value="JO">JORDANIA</option>
<option value="KZ">KAZAKSTAN</option>
<option value="KE">KENIA</option>

<option value="KI">KIRIBATI</option>
<option value="KP">KOREA DEMOCRATIC PEOPLES REPUBLIC OF</option>
<option value="KR">KOREA REPUBLIC OF</option>
<option value="KW">KUWAIT</option>
<option value="KG">KYRGYZSTAN</option>
<option value="LA">LAO PEOPLES DEMOCRATIC REPUBLIC</option>
<option value="LV">LATVIA</option>
<option value="LS">LESOTHO</option>
<option value="LB">LIBANO</option>

<option value="LR">LIBERIA</option>
<option value="LY">LIBYAN ARAB JAMAHIRIYA</option>
<option value="LI">LIECHTENSTEIN</option>
<option value="LT">LITUANIA</option>
<option value="LU">LUXEMBURGO</option>
<option value="MO">MACAU</option>
<option value="MG">MADAGASCAR</option>
<option value="MY">MALASIA</option>
<option value="MW">MALAWI</option>

<option value="MV">MALDIVAS</option>
<option value="ML">MALI</option>
<option value="MT">MALTA</option>
<option value="FK">MALVINAS</option>
<option value="MA">MARRUECOS</option>
<option value="MH">MARSHALL ISLANDS</option>
<option value="MQ">MARTINICA</option>
<option value="MU">MAURICIO</option>
<option value="MR">MAURITANIA</option>

<option value="YT">MAYOTTE</option>
<option value="MX">MEXICO</option>
<option value="FM">MICRONESIA, FEDERATED STATES OF</option>
<option value="MD">MOLDOVA, REPUBLIC OF</option>
<option value="MC">MONACO</option>
<option value="MN">MONGOLIA</option>
<option value="MS">MONTSERRAT</option>
<option value="MZ">MOZAMBIQUE</option>
<option value="MM">MYANMAR</option>

<option value="MK">Macedonia</option>
<option value="ME">Montenegro</option>
<option value="NA">NAMIBIA</option>
<option value="NR">NAURU</option>
<option value="NP">NEPAL</option>
<option value="NI">NICARAGUA</option>
<option value="NE">NIGER</option>
<option value="NG">NIGERIA</option>
<option value="NU">NIUE</option>

<option value="NF">NORFOLK ISLAND</option>
<option value="MP">NORTHERN MARIANA ISLANDS</option>
<option value="NO">NORUEGA</option>
<option value="NC">NUEVA CALEDONIA</option>
<option value="NZ">NUEVA ZELANDA</option>
<option value="OM">OMAN</option>
<option value="PK">PAKISTAN</option>
<option value="PW">PALAU</option>
<option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option>

<option value="PA">PANAMA</option>
<option value="PG">PAPUA NEW GUINEA</option>
<option value="PY">PARAGUAY</option>
<option value="PE">PERU</option>
<option value="PN">PITCAIRN</option>
<option value="PL">POLONIA</option>
<option value="PT">PORTUGAL</option>
<option value="PR">PUERTO RICO</option>
<option value="QA">QATAR</option>

<option value="GB">REINO UNIDO</option>
<option value="CZ">REPUBLICA CHECHA</option>
<option value="DO">REPUBLICA DOMINICANA</option>
<option value="RE">REUNION</option>
<option value="RW">RUANDA</option>
<option value="RO">RUMANIA</option>
<option value="EH">SAHARA OCCIDENTAL</option>
<option value="KN">SAINT KITTS AND NEVIS</option>
<option value="LC">SAINT LUCIA</option>

<option value="PM">SAINT PIERRE AND MIQUELON</option>
<option value="VC">SAINT VINCENT AND THE GRENADINES</option>
<option value="WS">SAMOA</option>
<option value="SM">SAN MARINO</option>
<option value="SH">SANTA ELENA</option>
<option value="ST">SAO TOME AND PRINCIPE</option>
<option value="SN">SENEGAL</option>
<option value="SC">SEYCHELLES</option>
<option value="SL">SIERRA LEONA</option>

<option value="SG">SINGAPUR</option>
<option value="SB">SOLOMON ISLANDS</option>
<option value="SO">SOMALIA</option>
<option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
<option value="LK">SRI LANKA</option>
<option value="ZA">SUDAFRICA</option>
<option value="SD">SUDÁN</option>
<option value="SE">SUECIA</option>
<option value="CH">SUIZA</option>

<option value="SR">SURINAM</option>
<option value="SJ">SVALBARD AND JAN MAYEN</option>
<option value="SZ">SWAZILAND</option>
<option value="SY">SYRIAN ARAB REPUBLIC</option>
<option value="RS">Serbia</option>
<option value="TH">TAILANDIA</option>
<option value="TW">TAIWAN/TAIPEI</option>
<option value="TJ">TAJIKISTAN</option>
<option value="TZ">TANZANIA, UNITED REPUBLIC OF</option>

<option value="TL">TIMOR-LESTE</option>
<option value="TG">TOGO</option>
<option value="TK">TOKELAU</option>
<option value="TO">TONGA</option>
<option value="TT">TRINIDAD AND TOBAGO</option>
<option value="TN">TUNEZ</option>
<option value="TM">TURKMENISTAN</option>
<option value="TC">TURKS AND CAICOS ISLANDS</option>
<option value="TR">TURQUIA</option>

<option value="TV">TUVALU</option>
<option value="UA">UCRANIA</option>
<option value="UG">UGANDA</option>
<option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option>
<option value="UY">URUGUAY</option>
<option value="UZ">UZBEKISTAN</option>
<option value="VU">VANUATU</option>
<option value="VE">VENEZUELA</option>
<option value="VN">VIETNAM</option>

<option value="VG">VIRGIN ISLANDS, BRITISH</option>
<option value="VI">VIRGIN ISLANDS, U.S.</option>
<option value="WF">WALLIS AND FUTUNA</option>
<option value="YE">YEMEN</option>
<option value="ZM">ZAMBIA</option>
<option value="ZW">ZIMBAWE</option>
</select>
</td>
		<td class="leftPad5"><input name="exec[adr_two_region]" value="" id="exec[adr_two_region]" onFocus="self.status='Provincia'; return true;" onBlur="self.status=''; return true;" size="19" maxlength="64">
</td>

	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>
	<tr height="30">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/gear.png" border="0"></td>
		<td align="left"><label for="exec[bday]">Fecha de nacimiento</label> </td>

		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr>
		<td>

<!-- BEGIN eTemplate *** generated fields for date -->
<div id="*** generated fields for date">




<!-- BEGIN grid  -->
<table cellspacing="0">
	<tbody><tr>
		<td align="left"><input id="exec[bday][str]" name="exec[bday][str]" size="10" value="" onFocus="self.status=''; return true;" onBlur="self.status=''; return true;" type="text">
<script type="text/javascript">
document.writeln('<img id="exec[bday][str]-trigger" src="/egw-trunk/phpgwapi/templates/default/images/datepopup.gif" title="Seleccionar fecha" style="cursor:pointer; cursor:hand;"/>');
Calendar.setup(
{
	inputField  : "exec[bday][str]",
	button      : "exec[bday][str]-trigger"
}
);
</script><img id="exec[bday][str]-trigger" src="/egw-trunk/phpgwapi/templates/default/images/datepopup.gif" title="Seleccionar fecha" style="cursor: pointer;">

</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate *** generated fields for date -->

</td>
		<td align="right"><label for="exec[tz]">Zona horaria</label> <select name="exec[tz]" id="exec[tz]">
<option value="-23">-23</option>
<option value="-22">-22</option>
<option value="-21">-21</option>
<option value="-20">-20</option>
<option value="-19">-19</option>

<option value="-18">-18</option>
<option value="-17">-17</option>
<option value="-16">-16</option>
<option value="-15">-15</option>
<option value="-14">-14</option>
<option value="-13">-13</option>
<option value="-12">-12</option>
<option value="-11">-11</option>
<option value="-10">-10</option>

<option value="-9">-9</option>
<option value="-8">-8</option>
<option value="-7">-7</option>
<option value="-6">-6</option>
<option value="-5">-5</option>
<option value="-4">-4</option>
<option value="-3">-3</option>
<option value="-2">-2</option>
<option value="-1">-1</option>

<option value="0" selected="selected">0</option>
<option value="1">+1</option>
<option value="2">+2</option>
<option value="3">+3</option>
<option value="4">+4</option>
<option value="5">+5</option>
<option value="6">+6</option>
<option value="7">+7</option>
<option value="8">+8</option>

<option value="9">+9</option>
<option value="10">+10</option>
<option value="11">+11</option>
<option value="12">+12</option>
<option value="13">+13</option>
<option value="14">+14</option>
<option value="15">+15</option>
<option value="16">+16</option>
<option value="17">+17</option>

<option value="18">+18</option>
<option value="19">+19</option>
<option value="20">+20</option>
<option value="21">+21</option>
<option value="22">+22</option>
<option value="23">+23</option>
</select>
</td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>
	<tr valign="top">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/private.png" border="0"></td>
		<td align="left"><label for="exec[pubkey]">Clave pública</label> </td>
		<td align="left"><textarea name="exec[pubkey]" id="exec[pubkey]" rows="4" cols="40"></textarea>

</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.edit.home -->

</div>
<div style="display: none;" id="addressbook.edit.details">


<!-- BEGIN eTemplate addressbook.edit.details -->
<div id="addressbook.edit.details">




<!-- BEGIN grid  -->
<div style="overflow: auto; width: 100%; height: 258px;">
<table width="100%">
	<tbody><tr valign="top">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/folder.png" border="0"></td>
		<td align="left">Categorías </td>
		<td align="left"><div id="exec[cat_id]" style="border: 2px inset lightgray; overflow: auto; width: 99%; height: 5.1em; background-color: white; text-align: left;">
</div></td>

	</tr>
	<tr class="row_on_off" valign="top">
		<td align="left"><img src="/egw-trunk/phpgwapi/templates/jerryr/images/edit.png" border="0"></td>
		<td align="left">Notas </td>
		<td align="left"><textarea name="exec[note]" id="exec[note]" rows="6" cols="50"></textarea>
</td>
	</tr>
	<tr>

		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/home.png" border="0"></td>
		<td align="left">Última fecha </td>
		<td align="left"><span id="last_link"></span></td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">Fecha siguiente </td>
		<td align="left"><span id="next_link"></span></td>

	</tr>
	<tr class="row_off_off" valign="top">
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/gear.png" border="0"></td>
		<td align="left">Creado &nbsp;</td>
		<td align="left">

<!-- BEGIN hbox -->

<table cellpadding="0" cellspacing="0">
	<tbody><tr>

		<td>[demo] Demo Account</td>
		<td class="leftPad5"><span id="created">2008/10/15 00:37</span></td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
	</tr>
	<tr class="row_on_on">

		<td align="left">&nbsp;</td>
		<td align="left">última modificación </td>
		<td class="leftPad5" align="left"><span id="modified"></span></td>
	</tr>
</tbody></table>
</div>
<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.edit.details -->

</div>
<div style="display: none;" id="addressbook.edit.links">


<!-- BEGIN eTemplate addressbook.edit.links -->
<div id="addressbook.edit.links">





<!-- BEGIN grid  -->
<div style="overflow: auto; width: 100%; height: 258px;">
<table width="100%">
	<tbody><tr class="th">
		<td align="left">Crear enlaces nuevos </td>

	</tr>
	<tr>
		<td align="left">

<!-- BEGIN eTemplate etemplate.link_widget.to -->
<div id="etemplate.link_widget.to">

<style type="text/css">
<!--
.link_select { white-space: nowrap; }
.link_hide { display: none; }
.hide_comment input { display: none; width: 99%; }

-->
</style>



<!-- BEGIN box -->

<div>


<!-- BEGIN box -->

<div id="exec[link_to][search_line]">


<!-- BEGIN hbox -->

<table>
	<tbody><tr>
		<td><select name="exec[link_to][app]" id="exec[link_to][app]" onFocus="self.status='Seleccionar aplicación para buscar'; return true;" onBlur="self.status=''; return true;">
<option value="projectmanager">Administrador de proyectos</option>

<option value="phpbrain">Base de conocimiento</option>
<option value="calendar">Calendario</option>
<option value="timesheet">Hoja de presencia</option>
<option value="addressbook">Libreta de direcciones</option>
<option value="resources">Recursos</option>
<option value="infolog">Registro de notas y tareas</option>
<option value="tracker">Sistema de seguimiento</option>
<option value="wiki">Wiki</option>
</select>

</td>
		<td><input name="exec[link_to][query]" value="Buscar" id="exec[link_to][query]" onFocus="if(this.value=='Buscar') this.value='';" onBlur="if(this.value=='') this.value='Buscar';">
</td>
		<td><input name="exec[link_to][start_search]" value="&gt;" id="exec[link_to][start_search]" onMouseOver="self.status='Pulse aquí para iniciar la búsqueda'; return true;" onMouseOut="self.status=''; return true;" onFocus="self.status='Pulse aquí para iniciar la búsqueda'; return true;" onBlur="self.status=''; return true;" onClick="xajax_doXMLHTTP('addressbook.link_widget.ajax_search.etemplate',document.getElementById('exec[link_to][app]').value,document.getElementById('exec[link_to][query]').value,'exec[link_to][id]','exec[link_to][search_line]','exec[link_to][remark]'+','+'exec[link_to][select_line]','exec[link_to][query]'); return false;" type="submit">
</td>
	</tr>
</tbody></table>


<!-- END hbox -->



<!-- BEGIN grid  -->

<table>
	<tbody><tr>
		<td align="left"><label for="exec[link_to][file]">Adjuntar fichero</label> <input name="exec[link_to][file_path]" value="." type="hidden">
<input name="exec[link_to][file]" value="" id="exec[link_to][file]" onMouseOver="self.status='Introduzca el nombre del fichero para subir y adjuntar. Use [Examinar...] Para buscarlo'; return true;" onMouseOut="self.status=''; return true;" onFocus="self.status='Introduzca el nombre del fichero para subir y adjuntar. Use [Examinar...] Para buscarlo'; return true;" onBlur="self.status=''; return true;" size="12" type="file">
</td>
		<td align="left"><input name="exec[link_to][attach]" value="Adjuntar" id="exec[link_to][attach]" onMouseOver="self.status='pulse aquí para adjuntar el fichero'; return true;" onMouseOut="self.status=''; return true;" onFocus="self.status='pulse aquí para adjuntar el fichero'; return true;" onBlur="self.status=''; return true;" type="submit">
</td>
		<td onClick="document.getElementById('exec[link_to][remark]').style.display=document.getElementById('exec[link_to][comment]').checked?'block':'none';" align="left"><input name="exec[link_to][comment]" value="1" id="exec[link_to][comment]" onFocus="self.status='nota opcional sobre el enlace'; return true;" onBlur="self.status=''; return true;" onChange="document.getElementById('exec[link_to][remark]').style.display=this.checked?'block':'none';" type="checkbox">
</td>
	</tr>

</tbody></table>
<!-- END grid  -->

</div>


<!-- END box -->



<!-- BEGIN box -->

<div class="link_select link_hide" id="exec[link_to][select_line]">
<select name="exec[link_to][id]" id="exec[link_to][id]" onChange="if (!this.value) { document.getElementById('exec[link_to][search_line]').style.display='inline'; document.getElementById('exec[link_to][remark]').style.display=document.getElementById('exec[link_to][select_line]').style.display='none';}">
</select>
<input name="exec[link_to][create]" value="Enlace" id="exec[link_to][create]" onMouseOver="self.status='pulse aquí para crear el enlace'; return true;" onMouseOut="self.status=''; return true;" onFocus="self.status='pulse aquí para crear el enlace'; return true;" onBlur="self.status=''; return true;" type="submit">
</div>


<!-- END box -->

<div class="hide_comment">
<input name="exec[link_to][remark]" value="Comentario" id="exec[link_to][remark]" onFocus="if(this.value=='Comentario') this.value='';self.status='nota opcional sobre el enlace'; return true;" onBlur="if(this.value=='') this.value='Comentario';self.status=''; return true;" size="50" maxlength="50">
</div>
</div>


<!-- END box -->


</div>
<!-- END eTemplate etemplate.link_widget.to -->

</td>

	</tr>
	<tr class="th">
		<td align="left">Enlaces existentes </td>
	</tr>
	<tr>
		<td align="left"><span id="link_to"></span></td>
	</tr>
</tbody></table>
</div>

<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.edit.links -->

</div>
</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate etemplate.tab_widget -->

</td>
		<td align="left">

<!-- BEGIN vbox -->

<table>
	<tbody><tr>
		<td>

<!-- BEGIN eTemplate addressbook.editphones -->
<div id="addressbook.editphones">




<!-- BEGIN grid  -->
<table class="editphones">
	<tbody><tr>
		<td colspan="3" class="windowheader" align="center">Editar números de teléfono - <span id="fn"></span></td>
	</tr>
	<tr class="th">
		<td align="left">Descripción </td>
		<td align="left">Número </td>

		<td align="left">pref </td>
	</tr>
	<tr>
		<td class="bold" align="left"><label for="exec[tel_work2]">Empresa</label> </td>
		<td align="left"><input name="exec[tel_work2]" value="" id="exec[tel_work2]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_work" id="exec[tel_prefer][tel_work]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>

	</tr>
	<tr>
		<td align="left"><label for="exec[tel_cell2]">Teléfono móvil</label> </td>
		<td align="left"><input name="exec[tel_cell2]" value="" id="exec[tel_cell2]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_cell" id="exec[tel_prefer][tel_cell]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>

		<td align="left"><label for="exec[tel_fax]">Fax</label> </td>
		<td align="left"><input name="exec[tel_fax2]" value="" id="exec[tel_fax2]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_fax" id="exec[tel_prefer][tel_fax]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_car]">Teléfono del coche</label> </td>

		<td align="left"><input name="exec[tel_car]" value="" id="exec[tel_car]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_car" id="exec[tel_prefer][tel_car]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_pager]">Buscapersonas</label> </td>
		<td align="left"><input name="exec[tel_pager]" value="" id="exec[tel_pager]" size="30">
</td>

		<td align="left"><input name="exec[tel_prefer]" value="tel_pager" id="exec[tel_prefer][tel_pager]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td colspan="3" align="left"><hr>
</td>
	</tr>
	<tr>
		<td class="bold" align="left"><label for="exec[assistent]">Asistente</label> </td>

		<td colspan="2" align="left"><input name="exec[assistent]" value="" id="exec[assistent]" size="35">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_assistent]">Número</label> </td>
		<td align="left"><input name="exec[tel_assistent]" value="" id="exec[tel_assistent]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_assistent" id="exec[tel_prefer][tel_assistent]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>

	</tr>
	<tr>
		<td colspan="3" align="left"><hr>
</td>
	</tr>
	<tr>
		<td class="bold" align="left"><label for="exec[tel_home2]">Privado</label> </td>
		<td align="left"><input name="exec[tel_home2]" value="" id="exec[tel_home2]" size="30">

</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_home" id="exec[tel_prefer][tel_home]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_cell_private]">Teléfono móvil</label> </td>
		<td align="left"><input name="exec[tel_cell_private]" value="" id="exec[tel_cell_private]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_cell_private" id="exec[tel_prefer][tel_cell_private]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">

</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_fax_home]">Fax</label> </td>
		<td align="left"><input name="exec[tel_fax_home]" value="" id="exec[tel_fax_home]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_fax_home" id="exec[tel_prefer][tel_fax_home]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>

	<tr>
		<td colspan="3" align="left"><hr>
</td>
	</tr>
	<tr>
		<td align="left"><label for="exec[tel_other]">Otro teléfono</label> </td>
		<td align="left"><input name="exec[tel_other]" value="" id="exec[tel_other]" size="30">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_other" id="exec[tel_prefer][tel_other]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">

</td>
	</tr>
	<tr>
		<td colspan="3" align="center"><input name="exec[]" value="Aceptar" id="exec[]" onClick="set_style_by_class('table','editphones','display','none'); if (window.hidephones) hidephones(this.form); return false;" type="submit">
</td>
	</tr>
</tbody></table>
<!-- END grid  -->


</div>
<!-- END eTemplate addressbook.editphones -->

</td>
	</tr>
	<tr>
		<td><fieldset class="phoneGroup" style="border:solid;border-color:#990000;">
		<legend style="border:solid 2px;color:#990000;">&nbsp;N&uacute;meros de tel&eacute;fono&nbsp;</legend>


        <!-- BEGIN grid  -->
<table>
	<tbody><tr>
		<td align="left" width="20"><img src="/egw-trunk/addressbook/templates/default/images/phone.png" border="0"></td>
		<td align="left" width="120"><label for="exec[tel_work]">Empresa</label> </td>

		<td class="telNumbers" align="left"><input name="exec[tel_work]" value="" id="exec[tel_work]" size="24" maxlength="40">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_work" id="exec[tel_prefer][tel_work]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[tel_cell]">Teléfono móvil</label> </td>
		<td class="telNumbers" align="left"><input name="exec[tel_cell]" value="" id="exec[tel_cell]" size="24" maxlength="40">

</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_cell" id="exec[tel_prefer][tel_cell]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[tel_home]">Privado</label> </td>
		<td class="telNumbers" align="left"><input name="exec[tel_home]" value="" id="exec[tel_home]" size="24" maxlength="40">
</td>

		<td align="left"><input name="exec[tel_prefer]" value="tel_home" id="exec[tel_prefer][tel_home]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">Fax </td>
		<td class="telNumbers" align="left"><input name="exec[tel_fax]" value="" id="exec[tel_fax]" size="24" maxlength="40">
</td>
		<td align="left"><input name="exec[tel_prefer]" value="tel_fax" id="exec[tel_prefer][tel_fax]" onFocus="self.status='Seleccionar el número de teléfono como forma preferida de contacto'; return true;" onBlur="self.status=''; return true;" type="radio">

</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left">&nbsp;</td>
		<td align="left"><input name="exec[]" value="Más..." id="exec[]" accesskey="m" onClick="set_style_by_class('table','editphones','display','inline'); if (window.showphones) showphones(this.form); return false;" type="submit">
</td>
		<td align="left">&nbsp;</td>
	</tr>
</tbody></table>

<!-- END grid  -->


</fieldset>
</td>
	</tr>
	<tr>
		<td><fieldset class="emailGroup"><legend>Correo electrónico e Internet</legend>


<!-- BEGIN grid  -->
<table>

	<tbody><tr>
		<td align="left" width="20"><img src="/egw-trunk/addressbook/templates/default/images/internet.png" border="0"></td>
		<td align="left" width="120"><label for="exec[url]">URL</label> </td>
		<td align="left"><input name="exec[url]" value="" id="exec[url]" size="28" maxlength="128">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>

		<td align="left"><label for="exec[url_home]">Privado</label> </td>
		<td align="left"><input name="exec[url_home]" value="" id="exec[url_home]" size="28" maxlength="128">
</td>
	</tr>
	<tr>
		<td align="left"><img src="/egw-trunk/addressbook/templates/default/images/email.png" border="0"></td>
		<td align="left"><label for="exec[email]">Correo electrónico</label> </td>

		<td align="left"><input name="exec[email]" value="" id="exec[email]" size="28" maxlength="128">
</td>
	</tr>
	<tr>
		<td align="left">&nbsp;</td>
		<td align="left"><label for="exec[email_home]">Privado</label> </td>
		<td align="left"><input name="exec[email_home]" value="" id="exec[email_home]" size="28" maxlength="128">
</td>
	</tr>

</tbody></table>
<!-- END grid  -->


</fieldset>
</td>
	</tr>
</tbody></table>


<!-- END vbox -->

</td>
	</tr>
	<tr>

		<td align="left">

<!-- BEGIN hbox -->

<table>
	<tbody><tr>
		<td><span id="button[edit]"></span></td>
		<td><span id="button[copy]"></span></td>
		<td><span id="button[vcard]"></span></td>
		<td><input name="exec[button][save]" value="Grabar" id="exec[button][save]" accesskey="s" type="submit">
</td>

		<td><input name="exec[button][apply]" value="Aplicar" id="exec[button][apply]" type="submit">
</td>
		<td><input name="exec[button][cancel]" value="Cancelar" id="exec[button][cancel]" onClick="if(0) return true; self.close(); return false;" type="submit">
</td>
	</tr>
</tbody></table>


<!-- END hbox -->

</td>
		<td align="left"><span id="button[delete]"></span></td>
	</tr>

</tbody>
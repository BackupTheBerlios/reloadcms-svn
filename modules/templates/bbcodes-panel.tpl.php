<script language="JavaScript" type="text/javascript">
<!--

var usedcode = ' ';

function inserttext(text, txtarea) {
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function insertbbcode(code, button, txtarea) {
    index = usedcode.indexOf(',' + code);
    if(index != -1){
        tmpstr = ',' + code;
        inserttext('[/' + code + ']', txtarea);
        usedcode = usedcode.substring(0, index) + usedcode.substring(index + tmpstr.length, usedcode.length);
        button.value = button.value.substring(0, button.value.length-1);
    } else {
        inserttext('[' + code + ']', txtarea);
        usedcode = usedcode + ',' + code;
        button.value = button.value + '*';
    }
}
//-->
</script>
<table border="0" cellspacing="0" cellpadding="2">
<tr align="left" valign="middle"> 
    <td><input type="button" class="button" accesskey="b" name="" value=" B " style="font-weight:bold;" onClick="insertbbcode('b', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" accesskey="i" name="i" value=" i " style="font-style:italic;" onClick="insertbbcode('i', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="u" name="u" value=" u " style="text-decoration: underline;" onClick="insertbbcode('u', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="s" name="s" value=" s " style="text-decoration: line-through;" onClick="insertbbcode('s', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" name="move" value=" Marquee " onClick="insertbbcode('move', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="c" name="quote" value=" Quote " onClick="insertbbcode('quote', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="d" name="code" value=" Code " onClick="insertbbcode('code', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="o" name="img" value=" Img " onClick="insertbbcode('img', this, <?=$tpldata['textarea']?>);"/></td>
    <td><input type="button" class="button" accesskey="f" name="file" value=" File " onClick="insertbbcode('file', this, <?=$tpldata['textarea']?>);"/></td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="2">
<tr align="left" valign="middle"> 
    <td><input type="button" class="button" name="" value=" Left " onClick="insertbbcode('align=left', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" name="" value=" Center " onClick="insertbbcode('align=center', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" name="" value=" Right " onClick="insertbbcode('align=right', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" name="" value=" Red " style="color: red;" onClick="insertbbcode('color=red', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" name="" value=" Green " style="color: green;" onClick="insertbbcode('color=green', this, <?=$tpldata['textarea']?>);" name="b"/></td>
    <td><input type="button" class="button" name="" value=" Blue " style="color: blue;" onClick="insertbbcode('color=blue', this, <?=$tpldata['textarea']?>);" name="b"/></td>
</tr>
</table>
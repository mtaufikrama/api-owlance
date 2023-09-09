<? 
// mode = "" berarti gak bisa minus dan bisa koma;
// mode = "0" berarti  gak bisa minus dan gak bisa koma;
// mode = "1" berarti  bisa minus dan bisa koma;
// 07/01/2010 16:30 add browser compatibility (Firefox)
function input_persen($mode="") {
	?> onkeypress="javascript:
	if (navigator.appName=='Microsoft Internet Explorer'){ 
		if (event.keyCode > 57 || ((event.keyCode < 48) && (event.keyCode != 46) 
		<? if ($mode!="0") {?> && (event.keyCode !=44)<? if ($mode=="1"){?> && (event.keyCode !=45) <?} }?>)) 
		event.returnValue = false;
	} else { 
		if (event.which > 57 || ((event.which < 48) && (event.which != 46) 
		<? if ($mode!="0") {?> && (event.which !=44)<? if ($mode=="1"){?> && (event.which !=45) <?} }?>)) 
		return false; 
	}"
		onkeyup="var str=this.value;
			<?if ($mode!="1"){?>if (parseInt(str)<1){
			this.value=0
				return true;
			} <?}?>
			var re1 = /\,/g
			
			if (navigator.appName=='Microsoft Internet Explorer'){
				if ((event.keyCode==37) || (event.keyCode==39))
				return true;
			} else {
				if ((event.which==37) || (event.which==39))
				return true;
			}
				
			str = str.replace(re1,'')
			
			arr = str.split('.')
			
			str = arr[0]

			var re = /(-?\d+)(\d{3})(,\d*)?/
			while (re.test(str)) {
				str = str.replace(re, '$1.$2$3')
			}

			if (arr.length > 1) 
				nilaiBelakang = '.' + arr[1]
			else
			    nilaiBelakang = ''

			str += nilaiBelakang
			
			this.value = str"<?}?>
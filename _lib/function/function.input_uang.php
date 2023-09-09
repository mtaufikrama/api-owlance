<? 
// mode = "" berarti gak bisa minus dan bisa koma;
// mode = "0" berarti  gak bisa minus dan gak bisa koma;
// mode = "1" berarti  bisa minus dan bisa koma;
#--------- Validasi Uang
function input_uang($mode="") {
	?>onkeypress="javascript:if (event.keyCode > 57 || ((event.keyCode < 48) && (event.keyCode != 46) 
	<? if ($mode!="0") {?> && (event.keyCode !=44)<? if ($mode=="1"){?> && (event.keyCode !=45) <?} }?>)) event.returnValue = false;" onkeyup="var str=this.value;
			<?if ($mode!="1"){?>if (parseInt(str)<1){
			this.value=0
				return true;
			} <?}?>
			var re1 = /\./g
			if ((event.keyCode==37) || (event.keyCode==39))
				return true;
			str = str.replace(re1,'')

			arr = str.split(',')

			str = arr[0]

			var re = /(-?\d+)(\d{3})(,\d*)?/
			while (re.test(str)) {
				str = str.replace(re, '$1.$2$3')
			}

			if (arr.length > 1) 
				nilaiBelakang = ',' + arr[1]
			else
			    nilaiBelakang = ''

			str += nilaiBelakang

			this.value = str"<?}?>
			


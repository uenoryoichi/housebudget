<?php //セレクトオプションのループ設定   ref)    http://php-fan.org/ymdpulldown.html
function optionLoop($start, $end, $value = null){
	for($i = $start; $i <= $end; $i++){
		if(isset($value) &&  $value == $i){
			echo "<option value=\"{$i}\" selected=\"selected\">{$i}</option>";
		}else{
			echo "<option value=\"{$i}\">{$i}</option>";
		}
	}
}

?>
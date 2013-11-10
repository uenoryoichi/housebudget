<div class="form-group">
	<select name="year" class="form-control">
		<?php optionLoop('1950', date('Y'), date('Y'));?>
	</select>
</div>
<span class="help-inline">年</span>
							
<div class="form-group">
	<select name="month" class="form-control" >
		<?php optionLoop('1', '12', date('m'));?>
	</select>
</div>
<span>月</span>		

<div class="form-group">
	<select name="day" class="form-control" >
		<?php optionLoop('1', '31', date('d'));?>
	</select>
</div>
<span>日</span>
							
<div class="form-group">
  	<select name="hour" class="form-control">
		<?php optionLoop('0', '23', date('H'));?>
	</select>
</div>
<span class="help-inline">時</span>
							
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
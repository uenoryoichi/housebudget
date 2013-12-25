<?php function optionLoop2($record,$selected) 
{
	if(!empty($selected)){		//更新時
		for ($i=0,$count_record=count($record); $i<$count_record; $i++){
			if ($selected==$record[$i]['id']) {
				print ('<option value="'.h($record[$i]['id']).'" selected>'.h($record[$i]['name']).'</option>');
			}else {
				print('<option value="'.h($record[$i]['id']).'">'.h($record[$i]['name']).'</option>');
			}
		}
	}else {							//入力時
		for ($i=0,$count_record=count($record); $i<$count_record; $i++){
			print('<option value="'.h($record[$i]['id']).'">'.h($record[$i]['name']).'</option>');
		}
	};
}
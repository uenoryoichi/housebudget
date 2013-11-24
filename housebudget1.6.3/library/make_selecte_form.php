<?php 
//前提テーブルのプライマリはid、名称はnameで登録されている
//すべてのユーザーが使うものはuser_id=initial_id(標準は0)の値として登録
//初期選択は$selectedで指定。中身は$tableで指定したテーブルのid
function make_selecte_form($table_name,$initial_id,$user_id,$selected) {
	$sql=sprintf('SELECT * FROM %s
					WHERE user_id=%d OR user_id=%d
					ORDER BY ID ASC',
			mysql_real_escape_string($table_name),
			mysql_real_escape_string($initial_id),
			mysql_real_escape_string($user_id)
	);
	$result = mysql_query($sql) or die(mysql_error());

	$record=NULL;
	while ($row = mysql_fetch_assoc($result)) {
		$record[] = $row;
	}

	if(isset($selected)){		//更新時
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
	}
}



?>


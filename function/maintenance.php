<?php
function getTeacher($teacherID){
	$result = mysql_query("SELECT * FROM tb_teacher WHERE teacherID = ".$teacherID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['teacherID']
	// 1 - $row['teacherName']

	return $row['teacherID']."/".$row['teacherName'];
}

function getRoom($roomID){
	$result = mysql_query("SELECT * FROM tb_room WHERE roomID = ".$roomID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['roomID']
	// 1 - $row['room']

	return $row['roomID']."/".$row['room'];
}

function getUserM($userID){
	$query = "
		SELECT
			`tb_user`.`userID` as 'usrid',
			`tb_user`.`username` as 'usr',
			`tb_user`.`password` as 'psw',
			`tb_user`.`name` as 'name',
			`tb_user`.`userlvlID` as 'usrlvlid',
			`tb_userlvl`.`userlvl` as 'usrlvl',
			`tb_user`.`changable` as 'changable'
		FROM tb_user
			`tb_user`
		INNER JOIN `tb_userlvl`
		ON `tb_user`.`userlvlID` = `tb_userlvl`.`userlvlID`
	";

	$result = mysql_query($query." WHERE userID = ".$userID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['usrid']		userID
	// 1 - $row['usr']			username
	// 2 - $row['psw']			password
	// 3 - $row['name']			name
	// 4 - $row['usrlvlid']		userlvlID
	// 5 - $row['usrlvl']		userlvl
	// 6 - $row['changable']	changable

	return $row['usrid']."?".$row['usr']."?".$row['psw']."?".$row['name']."?".$row['usrlvlid']."?".$row['usrlvl']."?".$row['changable'];
}

function getUserLvl($userlvlID){
	$result = mysql_query("SELECT * FROM tb_userlvl WHERE userlvlID = ".$userlvlID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['userlvlID']
	// 1 - $row['userlvl']

	return $row['userlvlID']."?".$row['userlvl'];
}
?>
<?php
function getUser($userID){
    $query = "
    SELECT
        `tb_user`.`name` as 'name',
        `tb_userlvl`.`userlvl` as 'userlvl',
        `tb_user`.`userID` as 'userID',
        `tb_user`.`changable` as 'changable'
    FROM `tb_user`
    INNER JOIN `tb_userlvl`
    ON `tb_user`.`userlvlID` = `tb_userlvl`.`userlvlID`
    ";
    $result = mysql_query($query." WHERE userID = ".$userID);
    $row = mysql_fetch_array($result);
    return $row['userID']."-".$row['name']."-".$row['userlvl']."-".$row['changable'];
}

function getToday(){
    $myDate=explode("/",date("Y/m/d"));

    if($myDate[1]=="01"){
        $month = "January";
    }
    elseif($myDate[1]=="02"){
        $month = "February";
    }
    elseif($myDate[1]=="03"){
        $month = "March";
    }
    elseif($myDate[1]=="04"){
        $month = "April";
    }
    elseif($myDate[1]=="05"){
        $month = "May";
    }
    elseif($myDate[1]=="06"){
        $month = "June";
    }
    elseif($myDate[1]=="07"){
        $month = "July";
    }
    elseif($myDate[1]=="08"){
        $month = "August";
    }
    elseif($myDate[1]=="09"){
        $month = "September";
    }
    elseif($myDate[1]=="10"){
        $month = "October";
    }
    elseif($myDate[1]=="11"){
        $month = "November";
    }
    elseif($myDate[1]=="12"){
        $month = "December";
    }

    return $month." ".$myDate[2].", ".$myDate[0]."?".date("Y/m/d");
}

function getBreakDate($date){
    $xdate = explode("/",$date);
    
    if($xdate[1]=="01"){
        $month = "January";
    }
    elseif($xdate[1]=="02"){
        $month = "February";
    }
    elseif($xdate[1]=="03"){
        $month = "March";
    }
    elseif($xdate[1]=="04"){
        $month = "April";
    }
    elseif($xdate[1]=="05"){
        $month = "May";
    }
    elseif($xdate[1]=="06"){
        $month = "June";
    }
    elseif($xdate[1]=="07"){
        $month = "July";
    }
    elseif($xdate[1]=="08"){
        $month = "August";
    }
    elseif($xdate[1]=="09"){
        $month = "September";
    }
    elseif($xdate[1]=="10"){
        $month = "October";
    }
    elseif($xdate[1]=="11"){
        $month = "November";
    }
    elseif($xdate[1]=="12"){
        $month = "December";
    }

    return $month." ".$xdate[2].", ".$xdate[0];
}

function getBreakDateEQ($date){

    $xdate = explode("/",$date);
    
    if($xdate[0]=="01"){
        $month = "January";
    }
    elseif($xdate[0]=="02"){
        $month = "February";
    }
    elseif($xdate[0]=="03"){
        $month = "March";
    }
    elseif($xdate[0]=="04"){
        $month = "April";
    }
    elseif($xdate[0]=="05"){
        $month = "May";
    }
    elseif($xdate[0]=="06"){
        $month = "June";
    }
    elseif($xdate[0]=="07"){
        $month = "July";
    }
    elseif($xdate[0]=="08"){
        $month = "August";
    }
    elseif($xdate[0]=="09"){
        $month = "September";
    }
    elseif($xdate[0]=="10"){
        $month = "October";
    }
    elseif($xdate[0]=="11"){
        $month = "November";
    }
    elseif($xdate[0]=="12"){
        $month = "December";
    }

    return $month." ".$xdate[1].", ".$xdate[2];
}
?>
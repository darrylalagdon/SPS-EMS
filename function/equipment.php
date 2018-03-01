<?php
function getEquipment($equipmentID){
    $query = "
        SELECT 
            tb_equipment.equipmentID as 'eqID',
            tb_equipment.equipmentNo as 'eqName',
            tb_equipmenttype.equipmentType as 'eqType',
            tb_equipment.brand as 'eqbrand',
            tb_equipment.model as 'eqmodel',
            tb_equipment.purchaseDate as 'eqpurdate',
            tb_equipment.purchaseCost as 'eqpurcost',
            tb_equipment.warranty as 'eqwarranty',
            tb_teacher.teacherName as 'eqteacher',
            tb_room.room as 'eqroom',
            tb_equipment.equipmentTypeID as 'eqTypeID',
            tb_equipment.teacherID as 'eqTeacherID',
            tb_equipment.roomID as 'eqRoomID',
            tb_equipment.conditionID as 'eqConditionID',
            tb_equipment.status as 'eqstatus',
            tb_equipment.remark as 'remark'
        FROM tb_equipment
        INNER JOIN tb_equipmenttype ON tb_equipment.equipmentTypeID = tb_equipmenttype.equipmentTypeID
        INNER JOIN tb_teacher ON tb_equipment.teacherID = tb_teacher.teacherID
        INNER JOIN tb_room ON tb_equipment.roomID = tb_room.roomID
    ";
    $result = mysql_query($query."WHERE tb_equipment.equipmentID = ".$equipmentID);
    $row = mysql_fetch_array($result);

    $status2 = "";
    if($row['eqstatus']!=0){
        $status2 = "Borrowed";
    }

    if($row['eqConditionID']==1){
        $condition2 = "Working";
    }
    elseif($row['eqConditionID']==2){
        $condition2 = "Damage";
    }
    elseif($row['eqConditionID']==3){
        $condition2 = "Dispose";
    }

    // 0 - equipmentID          eqID
    // 1 - equipmentNo          eqName
    // 2 - equipmentType        eqType
    // 3 - brand                eqbrand
    // 4 - model                eqmodel
    // 5 - purchaseDate         eqpurdate
    // 6 - purchaseCost         eqpurcost
    // 7 - warranty             eqwarranty
    // 8 - teacherName          eqteacher
    // 9 - roomName             eqroom
    // 10 - equipmentTypeID     eqTypeID
    // 11 - teacherID           eqTeacherID
    // 12 - roomID              eqRoomID
    // 13 - conditionID         eqConditionID
    // 14 - status              eqstatus
    // 15 - status2             status2         --make a string value output of the status
    // 16 - condition2          condition2      --make a string value output of the condition
    // 17 - remark              remark

    return $row['eqID']."?".$row['eqName']."?".$row['eqType']."?".$row['eqbrand']."?".$row['eqmodel']."?".$row['eqpurdate']."?".$row['eqpurcost']."?".$row['eqwarranty']."?".$row['eqteacher']."?".$row['eqroom']."?".$row['eqTypeID']."?".$row['eqTeacherID']."?".$row['eqRoomID']."?".$row['eqConditionID']."?".$row['eqstatus']."?".$status2."?".$condition2."?".$row['remark'];
}

function getEqType($eqtypeID){
    $result = mysql_query("SELECT * FROM tb_equipmenttype WHERE equipmentTypeID = ".$eqtypeID);
    $row = mysql_fetch_array($result);

    // array order
    // 0 - $row['equipmentTypeID']
    // 1 - $row['equipmentType']

    return $row['equipmentTypeID']."/".$row['equipmentType'];
}

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

function getCondition($conditionID){
    $result = mysql_query("SELECT * FROM tb_condition WHERE conditionID = ".$conditionID);
    $row = mysql_fetch_array($result);

    // array order
    // 0 - $row['conditionID']
    // 1 - $row['condition']

    return $row['conditionID']."/".$row['condition'];
}

function getBorrow($borrowID){
    $query = "
        SELECT
            tb_borrow.borrowID as 'borrow_id',
            tb_borrow.equipmentID as 'equipment_id',
            tb_borrow.teacherID as 'teacherID',
            tb_borrow.dateTimeBorrow as 'Borrow',
            tb_borrow.dateTimeReturn as 'Return',
            tb_borrow.purpose as 'purpose',
            tb_borrow.roomID as 'room_id',
            tb_teacher.teacherName as 'teacher',
            tb_room.room as 'room'
        FROM tb_borrow
        INNER JOIN tb_teacher
        ON tb_borrow.teacherID = tb_teacher.teacherID
        INNER JOIN tb_room
        ON tb_borrow.roomID = tb_room.roomID
    ";

    // array order
    // 0 - $row['borrow_id']
    // 1 - $row['equipment_id']
    // 2 - $row['teacherID']
    // 3 - $row['Borrow']
    // 4 - $row['Return']
    // 5 - $row['purpose']
    // 6 - $row['room_id']
    // 7 - $row['teacher']
    // 8 - $row['room']

    $result = mysql_query($query." WHERE borrowID = ".$borrowID);
    $row = mysql_fetch_array($result);

    return $row['borrow_id']."?".$row['equipment_id']."?".$row['teacherID']."?".$row['Borrow']."?".$row['Return']."?".$row['purpose']."?".$row['room_id']."?".$row['teacher']."?".$row['room'];
}
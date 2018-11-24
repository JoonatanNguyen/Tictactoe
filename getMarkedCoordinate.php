<?php
    $textMessage = file_get_contents('php://input');
    $body = json_decode($textMessage);
    $userId = $body->userId;
    $markedCoordinateResult = array();

    $tictactoeDb = new PDO('mysql:host=127.0.0.1;port=8889;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');

    $getMarkedCoordinate = $tictactoeDb->prepare(
        "SELECT Mark, Coordinate FROM GamePlays WHERE GroupId IN (SELECT GroupId FROM Users WHERE Id = :userId)");
    $getMarkedCoordinate->bindValue(":userId", $userId);
    $getMarkedCoordinate->execute();
    for ($i = 0; $i < $getMarkedCoordinate->rowCount(); $i++) {
        $row = $getMarkedCoordinate->fetch();
        array_push($markedCoordinateResult, array(
            'mark'=>$row["Mark"],
            'coordinate'=>$row["Coordinate"]
        ));
    }
    $getMarkedCoordinate = NULL;

    print json_encode($markedCoordinateResult);


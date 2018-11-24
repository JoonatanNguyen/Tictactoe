<?php
    $textMessage = file_get_contents('php://input');
    $body = json_decode($textMessage);
    $userId = $body->userId;
    $coordinate = $body->coordinate;

    $tictactoeDb = new PDO('mysql:host=127.0.0.1;port=8889;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');


    $getGroupIdResult = $tictactoeDb->prepare("SELECT GroupId FROM Users WHERE Id = :userId");
    $getGroupIdResult->bindValue(":userId", $userId);
    $getGroupIdResult->execute();
    $groupId = $getGroupIdResult->fetch()["GroupId"];
    $getGroupIdResult = null;

    $getLatestPlayUserId = $tictactoeDb->prepare(
        "SELECT UserId FROM GamePlays WHERE GroupId = :groupId ORDER BY CreatedAt DESC LIMIT 1");
    $getLatestPlayUserId->bindValue(":groupId", $groupId);
    $getLatestPlayUserId->execute();
    $latestUserId = $getLatestPlayUserId->fetch()["UserId"];
    $getLatestPlayUserId = NULL;

    if ($latestUserId == $userId) {
        http_response_code(400);
        print json_encode(array(
            'errorMessage'=> 'Please wait for the other player.'
        ));
    } else {
        $getMarkResult = $tictactoeDb->prepare("SELECT Mark FROM Users WHERE Id = :userId");
        $getMarkResult->bindValue(":userId", $userId);
        $getMarkResult->execute();
        $mark = $getMarkResult->fetch()["Mark"];
        $getMarkResult = null;

        $insertNewMove = $tictactoeDb->prepare(
            "INSERT INTO GamePlays(UserId, GroupId, Coordinate, Mark)
        VALUES (:userId, :groupId, :coordinate, :mark)"
        );
        $insertNewMove->bindValue(":userId", $userId);
        $insertNewMove->bindValue(":groupId", $groupId);
        $insertNewMove->bindValue(":coordinate", $coordinate);
        $insertNewMove->bindValue(":mark", $mark);
        $insertNewMove->execute();
        $insertNewMove = null;


        print json_encode(array (
            'mark' => $mark
        ));
    }



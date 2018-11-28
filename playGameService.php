<?php
    $textMessage = file_get_contents('php://input');
    $body = json_decode($textMessage);
    $userId = $body->userId;
    $coordinate = $body->coordinate;
    $mark = '';

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

        $winningCase = array(
            array("1:1", "1:2", "1:3"),
            array("1:1", "2:1", "3:1"),
            array("1:2", "2:2", "3:2"),
            array("1:3", "2:3", "3:3"),
            array("2:1", "2:2", "2:3"),
            array("3:1", "3:2", "3:3"),
            array("1:1", "2:2", "3:3"),
            array("1:3", "2:2", "3:1")
        );

        $getMovesResult = array();
        $getPlayersMoves = $tictactoeDb->prepare(
            "SELECT Coordinate FROM GamePlays WHERE Mark = :mark AND GroupId = :groupId");
        $getPlayersMoves->bindValue(":mark", $mark);
        $getPlayersMoves->bindValue(":groupId", $groupId);
        $getPlayersMoves->execute();

        for ($a = 0; $a < $getPlayersMoves->rowCount(); $a++) {
            $row = $getPlayersMoves->fetch();
            array_push($getMovesResult, $row["Coordinate"]);
        }
        $getPlayersMoves = NULL;

        $win = false;
        for ($i = 0; $i < count($winningCase); $i++) {
            if (in_array($winningCase[$i][0], $getMovesResult) && in_array($winningCase[$i][1], $getMovesResult) && in_array($winningCase[$i][2], $getMovesResult)) {
                $win = true;
            }
        }
        if ($win) {
            print json_encode(array (
                'mark' => $mark,
                'successMessage' => 'You Win'
            ));
        }
        else {
            print json_encode(array (
                'mark' => $mark
            ));
        }

    }








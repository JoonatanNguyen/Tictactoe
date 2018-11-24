<?php
    $textMessage = file_get_contents('php://input');
    $body = json_decode($textMessage);
    $userId = $body->userId;
    $name = $body->name;

    $tictactoeDb = new PDO('mysql:host=127.0.0.1;port=8889;dbname=tictactoe', 'WATestUser1', 'WATestPwd1');

    $groupsResult = $tictactoeDb->query(
        "SELECT GroupId FROM (
        SELECT COUNT(Id) AS JoinedPlayers, GroupId FROM Users
        GROUP BY GroupId
        ) AS JoinedPlayersList WHERE JoinedPlayers = 1"
    );
    if ($groupsResult->rowCount() > 0) {
        createNewUser($groupsResult->fetch()["GroupId"], "o");
    } else {
        $groupId = gen_uuid();

        // create a primary key first
        createNewGroup($groupId);
        createNewUser($groupId, "x");
    }

    function createNewUser($groupId, $mark) {
        global $tictactoeDb, $userId, $name;

        $createNewUser = $tictactoeDb->prepare("INSERT INTO Users (Id, GroupId, Name, Mark) VALUES (:userId, :groupId, :name, :mark)");
        $createNewUser->bindValue(":userId", $userId);
        $createNewUser->bindValue(":groupId", $groupId);
        $createNewUser->bindValue(":name", $name);
        $createNewUser->bindValue(":mark", $mark);
        $createNewUser->execute();
        $createNewUser = NULL;
    }

    function createNewGroup($groupId) {
        global $tictactoeDb;

        $createNewGroup = $tictactoeDb->prepare("INSERT INTO Groups (Id) VALUES (:groupId)");
        $createNewGroup->bindValue(":groupId", $groupId);
        $createNewGroup->execute();
        $createNewGroup = NULL;
    }

    // Helpers

    // Generate new UUID
    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    print json_encode([]);



<?php
    session_start();
    $_SESSION["hassession"] = true;
?>

<html>
    <head>
        <link rel="stylesheet" href="./indexStyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--        <script src="MyConnect.js"></script>-->
        <script src="MyConnect$.js"></script>
    </head>
    <body>
        <div id="setNickBox">
            <textarea id="textBox"></textarea>
            <button onclick="playOnClick()">PLAY</button>
        </div>
        <table id="tableGrid">
            <tr>
                <td>
                    <button onclick="buttonOneOnClick(event);" id="1:1" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x1:1">
                        <img src="O.jpg" class="oImage" id="o1:1">
                    </button>
                </td>
                <td>
                    <button  onclick="buttonTwoOnClick(event)" id="1:2" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x1:2">
                        <img src="O.jpg" class="oImage" id="o1:2">
                    </button>
                </td>
                <td>
                    <button onclick="buttonThreeOnClick(event)" id="1:3" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x1:3">
                        <img src="O.jpg" class="oImage" id="o1:3">
                    </button>
                </td>

            </tr>
            <tr>
                <td>
                    <button onclick="buttonFourOnClick(event)" id="2:1" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x2:1">
                        <img src="O.jpg" class="oImage" id="o2:1">
                    </button>
                </td>
                <td>
                    <button onclick="buttonFiveOnClick(event)" id="2:2" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x2:2">
                        <img src="O.jpg" class="oImage" id="o2:2">
                    </button>
                </td>
                <td>
                    <button onclick="buttonSixOnClick(event)" id="2:3" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x2:3">
                        <img src="O.jpg" class="oImage" id="o2:3">
                    </button>
                </td>
            </tr>
            <tr>
                <td>
                    <button onclick="buttonSevenOnClick(event)" id="3:1" class="buttonGrid">
                    <img src="X.png" class="xImage" id="x3:1">
                    <img src="O.jpg" class="oImage" id="o3:1">
                    </button>
                </td>
                <td>
                    <button onclick="buttonEightOnClick(event)" id="3:2" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x3:2">
                        <img src="O.jpg" class="oImage" id="o3:2">
                    </button>
                </td>
                <td>
                    <button onclick="buttonNineOnClick(event)" id="3:3" class="buttonGrid">
                        <img src="X.png" class="xImage" id="x3:3">
                        <img src="O.jpg" class="oImage" id="o3:3">
                    </button>
                </td>
            </tr>
        </table>
        <script src="main.js"></script>
    </body>
</html>

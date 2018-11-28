// var script = document.createElement('script');
// script.src = './jquery/jquery-3.3.1.js';
// script.type = 'text/javascript';
// document.getElementsByTagName('head')[0].appendChild(script);

//get mark, coordinate from db
setInterval(getMarkedCoordinate, 3000);

let chosenCoordinates = [];

// console.log(sessionStorage.getItem('userId'));

if (sessionStorage.getItem('userId') == null) {
    document.getElementById('setNickBox').style.display = 'block';
    document.getElementById('tableGrid').style.display = 'none';
}
else {
    document.getElementById('setNickBox').style.display = 'none';
    document.getElementById('tableGrid').style.display = 'block';
}

function playOnClick() {
    let options = {
        userId: guid(),
        name: document.getElementById('textBox').value
    };

    post(
        'startGameService',
        options,
        function() {
            sessionStorage.setItem('userId', options.userId);
            document.getElementById('setNickBox').style.display = 'none';
            document.getElementById('tableGrid').style.display = 'block';
        },
        function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.responseText);
        }
    );
}

function buttonOneOnClick(e) {
    choose(e.target.id)
}

function buttonTwoOnClick(e) {
    choose(e.target.id)
}

function buttonThreeOnClick(e) {
    choose(e.target.id)
}

function buttonFourOnClick(e) {
    choose(e.target.id)
}

function buttonFiveOnClick(e) {
    choose(e.target.id)
}

function buttonSixOnClick(e) {
    choose(e.target.id)
}

function buttonSevenOnClick(e) {
    choose(e.target.id)
}

function buttonEightOnClick(e) {
    choose(e.target.id)
}

function buttonNineOnClick(e) {
    choose(e.target.id)
}

function choose(chosenCoordinate) {
    document.getElementById(chosenCoordinate).disabled = true;
    let options = {
        userId: sessionStorage.getItem('userId'),
        coordinate: chosenCoordinate
    };
    post(
        'playGameService',
        options,
        function (response) {
           //call back function of JS
            let enableMark = document.getElementById(response.mark + chosenCoordinate);
            enableMark.style.display = 'block';
            chosenCoordinates.push(chosenCoordinates);
            console.log(response.successMessage);
            if (response.successMessage) {
                alert(response.successMessage);
            }
        },
        function (XMLHttpRequest) {
            alert(XMLHttpRequest.responseJSON.errorMessage);
        }
    );
}

function getMarkedCoordinate() {

    let options = {
        userId: sessionStorage.getItem('userId')
    };
    post(
        'getMarkedCoordinate',
        options,
        function (response) {
            let unchosenCoordinates = [];
            //call back function of JS
            response.forEach(function(item) {
                if (!chosenCoordinates.includes(item.coordinate)) {
                    unchosenCoordinates.push(item);
                }
            });
            unchosenCoordinates.forEach(function (item) {
                let enableMark = document.getElementById(item.mark + item.coordinate);
                enableMark.style.display = 'block';
            })
        },
        function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.responseText);
        });

}

// Helpers
function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}
// var script = document.createElement('script');
// script.src = './jquery/jquery-3.3.1.js';
// script.type = 'text/javascript';
// document.getElementsByTagName('head')[0].appendChild(script);

class MyConnect extends XMLHttpRequest {
    constructor(options, target, resultHandler) {
        super();

        this.handleResultsWith = resultHandler;
        this.onreadystatechange = this.ajaxin;
        this.open("POST", target + ".php", true);
        this.setRequestHeader("Content-type", "application/json");
        this.send(JSON.stringify(options));
    }

    ajaxin() {
        // alert("AJAX stuff occurred");
        if (this.readyState === 4) {
            console.log(this.responseText);
            if (this.status === 200) {
                let response = null;
                try{
                    response = JSON.parse(this.responseText);
                }
                catch (exception) {
                    console.log("This is not JSON: " + this.responseText);
                }
                if (response != null)
                    this.handleResultsWith(response);
            }
            else {
                alert(this.responseText.errorMessage);
            }
        }
    }
}
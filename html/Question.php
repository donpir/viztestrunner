<?php
    require_once '../helper/SessionHelper.php';
    require_once '../helper/SessionData.php';

    $sessiondata = SessionHelper::getInstance();
?>


<html>
<head>
    <title>Question</title>

    <!-- POLYMER COMPONENTS -->
    <link rel="import" href="../bower_components/polymer/polymer.html">
    <script type="text/javascript" src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="../bower_components/iron-flex-layout/iron-flex-layout.html">
    <link rel="import" href="../bower_components/paper-toast/paper-toast.html">

    <link rel="import" href="../bower_components/paper-dialog/paper-dialog.html">

    <link rel="import" href="question-wc.html">

</head>
<body>

    <style is="custom-style">
        .flex-horizontal {
        @apply(--layout-horizontal);
        }
        .flexchild {
        @apply(--layout-flex);
        }

        paper-dialog.colored {
            border: 2px solid;
            border-color: var(--paper-grey-500);
            background-color: var(--paper-light-grey-50);
            color: var(--paper-black-500);

        }
    </style>

    <div id="divCompleted" style="display: none;">
        <h2>Test Completed! Thank you!</h2>
    </div>

    <div id="container" class="container flex-horizontal">
        <div style="border: 1px solid;">
            <image id="imgVisualization" src=""></image><br/>
        </div>
        <div style="margin-left: 6px;" class="flexchild">
            <question-wc id="questionwc"></question-wc><br/>
            <input type="button" value="Confirm" id="btnConfirm" onclick="btnConfirmClick()" />
        </div>
    </div>
    <div style="font-size: .8em;">
    Nickname: <?php echo $sessiondata->nickname ?> (id <?php echo $sessiondata->id ?>)
    </div>

    <paper-toast text="Hello world!"></paper-toast>

    <paper-dialog id="colors" class="colored" modal>
        <h2>Question completed</h2>
        <p>Please, <?php echo $sessiondata->nickname ?> take your time. Click on next button to answer the next question.</p>
        <p><input type="button" value="Next" id="btnNext" onclick="btnNext()" /></p>
    </paper-dialog>

    <script type="text/javascript">
        var qidx = 0;
        var lastJsonResponse = null;

        function btnConfirmClick() {
            //var scope = Polymer.dom(document.querySelector('question-wc'));
            //scope = Polymer.dom(this.$).querySelector('question-wc');
            //var domQuestionwc = document.getElementById("questionwc");

            var questionwc = document.querySelector('question-wc');
            var isValid = questionwc.hasValidInput();
            if (isValid == false) {
                var toast = document.querySelector('paper-toast');
                toast.text = "Provide an answer.";
                toast.show();
                return;
            }

            var container = document.getElementById("container");
            container.style.display = "none";

            //Post the response to the server.
            var http = new XMLHttpRequest();
            var url = "/viztestrunner/restservices/save";

            var response = questionwc.getResponse();

            var params = { question: { index: qidx + "", response: response.label } };
            var strParams = JSON.stringify(params);
            http.open("POST", url, true);
            http.setRequestHeader("Content-Type", "application/json");
            http.onreadystatechange = function() {//Call a function when the state changes.
                if(http.readyState == 4 && http.status == 200) {
                    var responseContent = http.responseText;
                    //console.log(responseContent);
                    var jsonResponse = JSON.parse(responseContent);
                    if (jsonResponse.success == false) {
                        alert(responseContent);
                        return;
                    }

                    if (lastJsonResponse != null && lastJsonResponse.hasNext == false) {
                        var div = document.getElementById("divCompleted");
                        div.style.display = "block";
                        return;
                    }

                    //TODO: to check the response.
                    var dialog = document.querySelector('paper-dialog');
                    dialog.open();

                }
            }
            http.send(strParams);
        };//EndFunction.

        function btnNext() {
            qidx++;
            startLoading();

            var container = document.getElementById("container");
            container.style.display = "flex";

            var dialog = document.querySelector('paper-dialog');
            dialog.close();
        };//EndFunction.

        var httpGetAsync = function(theUrl, callback) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200)
                    callback(xhttp.responseText);
            };
            xhttp.open("GET", theUrl, true); // true for asynchronous
            xhttp.send(null);
        };//EndFunction.

        function startLoading() {
            var baseurl = "/viztestrunner/restservices/loadnext/" + qidx;
            httpGetAsync(baseurl, loadNext);
        }

        window.onload = function() {
            startLoading();
        };//EndFunction.

        function loadNext(response) {
            var jsonResponse = JSON.parse(response);
            lastJsonResponse = jsonResponse;
            if (jsonResponse.success == false) {
                alert("Error.");
                return;
            }

            var questionwc = document.querySelector('question-wc');
            //var questionwc = document.getElementById("questionwc");
            /*if (typeof questionwc.question != 'undefined') {
                questionwc.question.answerOptions = [];
            }*/
            questionwc.question = jsonResponse.data;

            var imagewc = document.getElementById("imgVisualization");
            imagewc.setAttribute("src", "../experiment/" + jsonResponse.data.imageUrl);
        };
    </script>

</body>
</html>
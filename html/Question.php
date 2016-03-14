<?php
    require_once '../helper/SessionHelper.php';
    require_once '../helper/SessionData.php';
    session_start();

    $sessiondata = (new SessionHelper())->getInstance();
?>


<html>
<head>
    <title>Question</title>

    <!-- POLYMER COMPONENTS -->
    <link rel="import" href="../bower_components/polymer/polymer.html">
    <script type="text/javascript" src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="../bower_components/iron-flex-layout/iron-flex-layout.html">
    <link rel="import" href="../bower_components/paper-toast/paper-toast.html">

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
    </style>

    <div class="container flex-horizontal">
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

    <script type="text/javascript">
        var qidx = 0;

        function btnConfirmClick() {
            //var scope = Polymer.dom(document.querySelector('question-wc'));
            //scope = Polymer.dom(this.$).querySelector('question-wc');
            //var domQuestionwc = document.getElementById("questionwc");

            var questionwc = document.querySelector('question-wc');
            var isValid = questionwc.hasValidInput();
            if (isValid == false) {

                var toast = document.querySelector('paper-toast');
                toast.text = "Provide an answer.";
                toast.show()
                return;
            }

            qidx++;
            startLoading();
            console.log("conferma");
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
            if (jsonResponse.success == false) {
                alert("Error.");
                return;
            }

            var questionwc = document.querySelector('question-wc');
            //var questionwc = document.getElementById("questionwc");
            questionwc.question = jsonResponse.data;

            var imagewc = document.getElementById("imgVisualization");
            imagewc.setAttribute("src", "../experiment/" + jsonResponse.data.imageUrl);
        };
    </script>

</body>
</html>
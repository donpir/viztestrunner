<html>
<head>
    <title>Question</title>

    <!-- POLYMER COMPONENTS -->
    <link rel="import" href="../bower_components/polymer/polymer.html">
    <script type="text/javascript" src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="../bower_components/iron-flex-layout/iron-flex-layout.html">

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
        <div style="border: 1px solid;"><image id="imgVisualization" src=""></image></div>
        <div style="margin-left: 6px;" class="flexchild">
            <question-wc id="questionwc"></question-wc><br/>
            <input type="button" value="Confirm" id="btnConfirm" onclick="btnConfirmClick()" />
        </div>
    </div>

    <script type="text/javascript">
        var qidx = 0;

        function btnConfirmClick() {
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
            if (response.success == false) {
                alert("Error.");
                return;
            }

            var questionwc = document.getElementById("questionwc");
            questionwc.question = jsonResponse.data;

            var imagewc = document.getElementById("imgVisualization");
            imagewc.setAttribute("src", "../experiment/" + jsonResponse.data.imageUrl);
        };
    </script>

</body>
</html>
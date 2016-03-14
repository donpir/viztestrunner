<html>
<head>
    <title>Question</title>

    <!-- POLYMER COMPONENTS -->
    <link rel="import" href="../bower_components/polymer/polymer.html">
    <script type="text/javascript" src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>

    <link rel="import" href="question-wc.html">

</head>
<body>

    <question-wc id="questionwc"></question-wc><br/>
    <input type="button" value="Confirm" id="btnConfirm" onclick="btnConfirmClick()" />

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
        };
    </script>

</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Status</title>
</head>
<body>

<div>
    The Export progress status is at <span id="percentage">{{ $downloadRequests->percentage }}</span>
</div>

<div id="download-link" style="display: none">
    Your download is ready. <a href="/export/download/{{$downloadRequests->id}}">Click here</a> to start the download.
</div>

<script>

    setInterval(updateStatus, 1000);

    /**
     * function to update the status
     */
    function updateStatus() {
        fetch('/export/status/percentage/{{$downloadRequests->id}}',
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                response.json().then((data) => {
                    document.getElementById('percentage').innerText = data.percentage;
                    if(data.percentage === 100){
                        document.getElementById('download-link').style.display = "block";
                    }

                });
            });
    }


</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinidi Iota Framework</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Affinidi Iota Framework</h1>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary" id="iota-btn">Request Avvanz Credentials</button>
        </div>
        <div class="text-center mt-4" id="divMessage">
        </div>
    </div>

    <script>
        const divMessage = document.getElementById('divMessage');

        const responseCode = "{{ $response_code }}";
        if (responseCode) {
            divMessage.textContent = "Get the response code from callback url";

            const iotaRedirectString = localStorage.getItem("iotaRedirect") || "{}";
            const iotaRedirect = JSON.parse(iotaRedirectString);
            const params = {
                ...iotaRedirect,
                responseCode
            };

            divMessage.textContent = "Fetching VP Response from the response code";
            fetch('/api/iota-complete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(params)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    if (!data.vpToken) {
                        divMessage.textContent = 'Failed to get response from iota: ' + '' + data.message;
                        divMessage.classList.add('text-danger');
                        return;
                    }
                    divMessage.classList.remove('text-center');
                    divMessage.innerHTML = "<b>Here is your VP Response</b> <br/> <pre>" + JSON.stringify(JSON.parse(data.vpToken), null, 2) + "</pre>";
                    window.history.replaceState(null, '', window.location.pathname);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    divMessage.textContent = 'Failed iota request.';
                    divMessage.classList.add('text-danger');
                });


        }

        document.getElementById('iota-btn').addEventListener('click', function() {

            divMessage.textContent = "Initiating request";

            const nonce = crypto.randomUUID().slice(0, 10);
            const configurationId = "{{ $config_id }}";
            const queryId = "{{ $avvanz_query_id }}";
            const redirectUri = window.location.href;

            fetch('/api/iota-start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        configurationId,
                        queryId,
                        redirectUri,
                        nonce,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    if (!data.correlationId || !data.transactionId) {
                        divMessage.textContent = 'Failed to request credential: ' + '' + data.message;
                        divMessage.classList.add('text-danger');
                        return;
                    }
                    divMessage.textContent = "Got the response from initiated request";

                    const toStore = {
                        nonce,
                        queryId,
                        configurationId,
                        correlationId: data.correlationId,
                        transactionId: data.transactionId,
                    };

                    localStorage.setItem("iotaRedirect", JSON.stringify(toStore));
                    divMessage.textContent = "Redirecting to vault...";
                    window.location.href = data.vaultLink;
                })
                .catch((error) => {
                    console.error('Error:', error);
                    divMessage.textContent = 'Failed iota request.';
                    divMessage.classList.add('text-danger');
                });
        });
    </script>
</body>

</html>
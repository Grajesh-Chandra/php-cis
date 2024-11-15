<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinidi Issuance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Affinidi Credential Issuance Service</h1>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary" id="issue-credential-btn">Issue Credential</button>
        </div>
        <div class="text-center mt-4" id="divResponse" style="display: none">
            Offer URL: <p id="credentialOfferUri"></p>
            Transaction Code: <p id="txCode"></p>
            <a id="vaultLink" href="#" class="btn btn-primary" target="_blank">Claim Offer</a>
        </div>
        <div class="text-center mt-4" id="divResponseError" style="display: none">
        </div>
    </div>

    <script>
        document.getElementById('issue-credential-btn').addEventListener('click', function() {

            fetch('/api/issue-credential', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    // Add any necessary data here
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                //alert('Credential issued successfully!');
                if(data.credentialOfferUri) {
                    const divRequest = document.getElementById('divRequest');
                    const divResponse = document.getElementById('divResponse');
                    divRequest.style.display = 'none';
                    divResponse.style.display = '';
                    document.getElementById('credentialOfferUri').textContent = data.credentialOfferUri;
                    document.getElementById('txCode').textContent = data.txCode;
                    document.getElementById('vaultLink').href  = data.vaultLink;
                    divResponse.classList.add('text-success');
                } else {
                    const divResponseError = document.getElementById('divResponseError');
                    divResponseError.style.display = '';
                    divResponseError.textContent = 'Failed to issue credential.' + '' + data.message;
                    divResponseError.classList.add('text-danger');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                // alert('Failed to issue credential.');
                const divResponseError = document.getElementById('divResponseError');
                divResponseError.style.display = '';
                document.getElementById('credentialOfferUri').textContent = 'Failed to issue credential.';
                divResponseError.classList.add('text-danger');
            });
        });
    </script>
</body>
</html>
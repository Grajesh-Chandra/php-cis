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
        <div class="text-center mt-4">
            <a href="/">Home</a>
        </div>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary issue-credential-btn" data-type="personalInformation">Issue Personal Information Verification Credential</button>
        </div>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary issue-credential-btn" data-type="address">Issue Address Verification Credential</button>
        </div>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary issue-credential-btn" data-type="education">Issue Education Verification Credential</button>
        </div>
        <div class="text-center mt-4" id="divRequest">
            <button class="btn btn-primary issue-credential-btn" data-type="employment">Issue Employment Verification Credential</button>
        </div>
        <div class="text-center mt-4" id="divResponse" style="display: none">
            Offer URL: <p id="credentialOfferUri"></p>
            Transaction Code: <p id="txCode"></p>
            <a id="vaultLink" href="#" class="btn btn-primary" target="_blank">Claim Offer</a>
            <a id="backLink" href="/cis" class="btn btn-primary">Return Back</a>
        </div>
        <div class="text-center mt-4" id="divResponseError" style="display: none">
        </div>
    </div>

    <script>
        document.querySelectorAll('.issue-credential-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const type = this.getAttribute('data-type');
                issueCredential(type);
                document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = 'none');
            });
        });

        function issueCredential(type) {
            const divResponseError = document.getElementById('divResponseError');
            divResponseError.style.display = '';
            divResponseError.textContent = 'Processing Issuance for ' + type + ' VC, Please wait...';
            fetch('/api/issue-credential', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        credentialType: type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    if (data.credentialOfferUri) {
                        const divRequest = document.getElementById('divRequest');
                        const divResponse = document.getElementById('divResponse');
                        divRequest.style.display = 'none';
                        divResponse.style.display = '';
                        document.getElementById('credentialOfferUri').textContent = data.credentialOfferUri;
                        document.getElementById('txCode').textContent = data.txCode;
                        document.getElementById('vaultLink').href = data.vaultLink;
                        divResponse.classList.add('text-success');
                        divResponseError.style.display = 'none';
                    } else {
                        const divRequest = document.getElementById('divRequest');
                        divRequest.style.display = '';                        
                        divResponseError.textContent = 'Failed to issue credential.' + '' + data.message;
                        divResponseError.classList.add('text-danger');
                        document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    const divRequest = document.getElementById('divRequest');
                    divRequest.style.display = ''; 
                    divResponseError.textContent = 'Failed to issue credential.' + '' + error.message;
                    divResponseError.classList.add('text-danger');
                    document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                });
        }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinidi Issuance</title>
    <style>
        /* Intuitive Design Styles - Consistent across all pages */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #eef2f7;
            color: #4a5568;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 900px;
            /* Wider container to match Iota page */
            box-sizing: border-box;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .header-body {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 2.2rem;
            color: #374151;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .navigation-link {
            display: inline-block;
            margin-bottom: 25px;
            color: #0694a2;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navigation-link:hover {
            color: #047a85;
            text-decoration: underline;
        }

        .card-body {
            margin-bottom: 30px;
            text-align: center;
        }

        hr.mt-2 {
            border: 0;
            border-top: 2px solid #e0e0e0;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .alert {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            border-width: 1px;
        }

        .alert-info {
            background-color: #e0f7fa;
            color: #0f566b;
            border-color: #b2ebf2;
        }

        .alert-danger {
            background-color: #fdecea;
            color: #991b1b;
            border-color: #fcc2c3;
        }

        .alert-success {
            background-color: #e6f9ec;
            color: #155724;
            border-color: #bef2c4;
        }


        .button-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            /* justify-content: center;  <- REMOVE this line if you don't want the whole group centered */
        }

        .issue-credential-btn,
        .action-button {
            display: flex;
            align-items: center;
            /* justify-content: center;  ! REMOVED - Ensure this is commented out or removed */
            padding: 15px 30px;
            background-color: #0694a2;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .issue-credential-btn svg,
        .action-button svg {
            margin-right: 10px;
            height: 20px;
            width: 20px;
            fill: #ffffff;
        }


        .issue-credential-btn:hover,
        .action-button:hover {
            background-color: #047a85;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .issue-credential-btn:active,
        .action-button:active {
            background-color: #03606b;
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }


        #divResponse,
        #divResponseError {
            margin-top: 25px;
            padding: 0px;
            /* Removed padding here, card will provide padding */
            border-radius: 10px;
            background-color: transparent;
            /* Make background transparent as card is used */
            border: none;
            /* No border needed */
            text-align: center;
        }

        #divResponse p,
        #divResponseError p {
            margin: 15px 0;
            font-size: 1.1rem;
        }

        #vaultLink,
        #backLink {
            margin: 0 15px;
            text-decoration: none;
        }

        /* Enhanced Offer Ready Section - Same as Iota Page's VP Response Card */
        .offer-ready-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 30px;
            text-align: left;
            margin-bottom: 25px;
            /* Add margin between sections if needed */
        }

        .offer-ready-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .offer-ready-icon {
            height: 40px;
            width: 40px;
            fill: #10b981;
            margin-right: 20px;
        }

        .offer-ready-title {
            font-size: 1.7rem;
            color: #374151;
            /* Darker title color */
            margin: 0;
            font-weight: 700;
        }

        .offer-ready-body {
            margin-bottom: 20px;
        }

        .offer-ready-detail {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .offer-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .offer-info-item {
            display: flex;
            flex-direction: column;
        }

        .offer-info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .offer-info-value {
            background-color: #f0f4f8;
            padding: 12px 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.95rem;
            color: #2d3748;
            overflow-wrap: break-word;
        }

        .offer-ready-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .claim-button {
            background-color: #10b981;
        }

        .claim-button:hover {
            background-color: #0b8a65;
        }

        .return-button {
            background-color: #6b7280;
        }

        .return-button:hover {
            background-color: #4a5568;
        }

        /* Icons - Simple SVG Icons (Inline for simplicity, consider icon library for larger projects) */
        .icon-personal::before {
            content: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 12a8 8 0 1 0 0 16 8 8 0 0 0 0-16z"/></svg>');
        }

        .icon-address::before {
            content: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 10L2 17l10 5 10-5-10-5z"/></svg>');
        }

        .icon-education::before {
            content: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5 13v6h14v-6l-7-3-7 3zM12 3L2 8l10 5 10-5-10-5z"/></svg>');
        }

        .icon-employment::before {
            content: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M2 8h20v12H2V8zm10-6a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg>');
        }

        /* Enhanced Home Button Style - Same as Iota Page */
        .home-button-enhanced {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #6b7280;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            margin-bottom: 25px;
            display: inline-block;
        }

        .home-button-enhanced:hover {
            background-color: #4a5568;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .home-button-enhanced:active {
            background-color: #374151;
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }


        /* Webhook Status Section  - Enhanced Card Style */
        #webhookStatus {
            margin-top: 25px;
            display: none;
            /* Hidden by default, shown after offer */
        }

        .webhook-response-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 30px;
            text-align: left;
            margin-bottom: 25px;
        }

        .webhook-response-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .webhook-response-icon {
            height: 40px;
            width: 40px;
            fill: #10b981;
            /* Using success icon color for webhook status */
            margin-right: 20px;
        }

        .webhook-response-title {
            font-size: 1.7rem;
            color: #374151;
            /* Darker title color */
            margin: 0;
            font-weight: 700;
        }

        .webhook-response-body {
            margin-bottom: 20px;
        }

        .webhook-response-detail {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }


        .webhook-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .webhook-info-item {
            display: flex;
            flex-direction: column;
        }

        .webhook-info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .webhook-info-value {
            background-color: #f0f4f8;
            padding: 12px 15px;
            border-radius: 8px;
            font-family: monospace;
            /* Monospace font for webhook data */
            font-size: 0.95rem;
            color: #2d3748;
            overflow-wrap: break-word;
        }


        /* Status Check Button Style - Same as before */
        .status-check-button {
            background-color: #2563eb;
            align-items: center;
            /* Example: Blue color */
        }

        .status-check-button:hover {
            background-color: #1e40af;
            /* Darker blue on hover */
        }


        /* JSON Response Display Styles - Reused from Iota page for consistency if needed */
        .json-response-container {
            background-color: #f7fafc;
            /* Same as divResponse background */
            border: 1px solid #e0e0e0;
            /* Same border style */
            border-radius: 8px;
            padding: 20px;
            font-family: monospace;
            /* Monospace font for JSON-like appearance */
            font-size: 0.95rem;
            color: #2d3748;
            text-align: left;
            /* Align text to the left for readability */
        }

        .json-item {
            margin-bottom: 8px;
            /* Spacing between key-value pairs */
            display: flex;
            /* Use flex to align label and value nicely */
            align-items: baseline;
            /* Align items at the baseline */
        }

        .json-label {
            font-weight: bold;
            margin-right: 10px;
            color: #374151;
            /* Slightly darker label text */
            flex-shrink: 0;
            /* Prevent label from shrinking */
            width: 150px;
            /* Wider label for CIS page */
            display: inline-block;
            /* Ensure consistent width behavior */
            text-align: right;
            /* Right align labels for better readability */
        }

        .json-value {
            word-wrap: break-word;
            /* Break long words if needed */
            overflow-wrap: break-word;
            /* Alternative for older browsers */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header-body">
            <h1>Affinidi Credential Issuance Service</h1>
            <a href="/" class="home-button-enhanced">Home</a>
        </div>

        <div class="card-body">
            <div class="button-group" id="divRequest">
                <button class="issue-credential-btn" data-type="personalInformation">
                    <svg class="icon-personal"></svg> Personal Information
                </button>
                <button class="issue-credential-btn" data-type="address">
                    <svg class="icon-address"></svg> Address Verification
                </button>
                <button class="issue-credential-btn" data-type="education">
                    <svg class="icon-education"></svg> Education Verification
                </button>
                <button class="issue-credential-btn" data-type="employment">
                    <svg class="icon-employment"></svg> Employment Verification
                </button>
            </div>
        </div>


        <div class="card-body" id="divResponse" style="display: none">
            <div class="offer-ready-card">
                <div class="offer-ready-header">
                    <svg class="offer-ready-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.5 9.75a.75.75 0 0 1 1.5 0v2.25a.75.75 0 0 1-1.5 0V12zm1.5-4.5a.75.75 0 0 1 .75.75h.008a.75.75 0 0 1-.75.75H12a.75.75 0 0 1-.75-.75V7.5a.75.75 0 0 1 .75-.75h.008z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M12 17.25a5.25 5.25 0 1 0 0-10.5 5.25 5.25 0 0 0 0 10.5zm0 1.5a6.75 6.75 0 1 1 0-13.5 6.75 0 0 1 0 13.5z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="offer-ready-title">Credential Offer Ready!</h3>
                </div>
                <div class="offer-ready-body">
                    <p class="offer-ready-detail">Your Verifiable Credential offer has been successfully generated.</p>
                    <div class="offer-info">
                        <div class="offer-info-item">
                            <span class="offer-info-label">Offer URL:</span>
                            <p class="offer-info-value" id="credentialOfferUri"></p>
                        </div>
                        <div class="offer-info-item">
                            <span class="offer-info-label">Transaction Code:</span>
                            <p class="offer-info-value" id="txCode"></p>
                        </div>
                    </div>
                </div>
                <div class="offer-ready-actions">
                    <a id="vaultLink" href="#" class="action-button claim-button" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.75 15.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8.25 17.25h7.5a3.75 3.75 0 0 0-7.5 0zM15.75 15.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM15.75 17.25H18a3.75 3.75 0 0 0-3.75-3.75h-1.5a3.75 3.75 0 0 0-3.75 3.75h.75a2.25 2.25 0 0 1 4.5 0zM5.25 8.25a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0zM6.75 9.75H3A2.25 2.25 0 0 1 5.25 7.5h1.5a2.25 2.25 0 0 1 2.25 2.25v.75a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 10.5v-1.5a2.25 2.25 0 0 1 1.5-2.25zM18.75 8.25a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0zM20.25 9.75h-3.75a2.25 2.25 0 0 1 2.25-2.25h1.5a2.25 2.25 0 0 1 2.25 2.25v.75a2.25 2.25 0 0 1-2.25 2.25h-1.5a2.25 2.25 0 0 1-2.25-2.25v-1.5a2.25 2.25 0 0 1 1.5-2.25z" />
                        </svg> Claim Offer
                    </a>
                    <a id="backLink" href="/cis" class="action-button return-button">Return Back</a>
                </div>
                <p id="issuanceId" style="display: none;"></p>

                <div id="webhookStatus" class="webhook-response-card" style="display: none;">
                    <div class="webhook-response-header">
                        <svg class="webhook-response-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.5 9.75a.75.75 0 0 1 1.5 0v2.25a.75.75 0 0 1-1.5 0V12zm1.5-4.5a.75.75 0 0 1 .75.75h.008a.75.75 0 0 1-.75.75H12a.75.75 0 0 1-.75-.75V7.5a.75.75 0 0 1 .75-.75h.008z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12 17.25a5.25 5.25 0 1 0 0-10.5 5.25 5.25 0 0 0 0 10.5zm0 1.5a6.75 6.75 0 1 1 0-13.5 6.75 0 0 1 0 13.5z" clip-rule="evenodd" />
                        </svg>
                        <h4 class="webhook-response-title">Credential Status</h4>
                    </div>
                    <div class="webhook-response-body">
                        <p class="webhook-response-detail" id="webhookMessage">Credential Status: Waiting to be checked.</p>
                        <div id="webhookResult"></div>
                    </div>
                </div>
                <div style="text-align: center;">
                    <button id="checkStatusButton" class="action-button status-check-button">Check Credential Status</button>
                </div>
            </div>

        </div>

        <div class="card-body" id="divResponseError" style="display: none">
            <div class="alert alert-danger"></div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.issue-credential-btn').forEach(button => {
            button.addEventListener('click', issueCredentialHandler);
        });

        async function issueCredentialHandler() {
            const type = this.getAttribute('data-type');
            issueCredential(type);
            document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = 'none');
        }


        function issueCredential(type) {
            const divResponseError = document.getElementById('divResponseError');
            divResponseError.style.display = '';
            divResponseError.querySelector('.alert-danger').textContent = 'Processing Issuance for ' + type + ' VC, Please wait...';

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
                        divResponseError.style.display = 'none';

                        // SET ISSUANCE ID HERE:
                        document.getElementById('issuanceId').textContent = data.issuanceId; // Assuming your API response returns "issuanceId"

                        // Show webhook status section (inside offer ready card now)
                        const webhookStatus = document.getElementById('webhookStatus');
                        webhookStatus.style.display = 'block';
                        document.getElementById('webhookMessage').textContent = 'Credential Status: Waiting to be checked.'; // Initial message
                        document.getElementById('webhookResult').innerHTML = ''; // Clear previous results

                    } else {
                        const divRequest = document.getElementById('divRequest');
                        divRequest.style.display = '';
                        divResponseError.querySelector('.alert-danger').textContent = 'Failed to issue credential: ' + data.message;
                        document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    const divRequest = document.getElementById('divRequest');
                    divRequest.style.display = '';
                    divResponseError.querySelector('.alert-danger').textContent = 'Failed to issue credential: ' + error.message;
                    document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                });
        }


        // New function to handle button click for checking status
        document.getElementById('checkStatusButton').addEventListener('click', fetchCredentialStatus);

        async function fetchCredentialStatus() {
            const webhookResultDiv = document.getElementById('webhookResult');
            const webhookMessageDiv = document.getElementById('webhookMessage');
            webhookMessageDiv.textContent = 'Checking credential status...';
            webhookResultDiv.innerHTML = ''; // Clear previous content

            try {
                const issuanceId = document.getElementById('issuanceId').textContent;
                const response = await fetch('/api/issued-credential', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        issuanceId
                    })
                });

                if (!response.ok) {
                    webhookMessageDiv.textContent = 'Error checking credential status:';
                    webhookResultDiv.innerHTML = `<div class="alert alert-danger">HTTP error! status: ${response.status}</div>`;
                    return;
                }

                const statusData = await response.json();
                console.log('Credential Status Data (JSON):', statusData);

                if (statusData && Object.keys(statusData).length > 0) {
                    webhookMessageDiv.textContent = 'Credential Status Details:';
                    webhookResultDiv.innerHTML = ''; // Clear previous alerts

                    // Create a container for the JSON display
                    const webhookInfoContainer = document.createElement('div');
                    webhookInfoContainer.className = 'webhook-info'; // Using webhook-info class for styling

                    // Function to format and append each key-value pair
                    function addWebhookKeyValue(key, value) {
                        const itemDiv = document.createElement('div');
                        itemDiv.className = 'webhook-info-item';
                        const labelSpan = document.createElement('span');
                        labelSpan.className = 'webhook-info-label';
                        labelSpan.textContent = key + ':'; // Added colon for label
                        const valuePara = document.createElement('p');
                        valuePara.className = 'webhook-info-value';

                        if (typeof value === 'object' && value !== null) {
                            // If value is an object (and not null), stringify it to JSON
                            valuePara.textContent = JSON.stringify(value, null, 2); // Use 2 spaces for indentation for readability
                            valuePara.style.whiteSpace = 'pre-wrap'; // Preserve formatting of JSON
                            valuePara.style.fontFamily = 'monospace'; // Use monospace for JSON-like appearance
                            valuePara.style.fontSize = '0.9rem'; // Match font size
                        } else {
                            // If it's not an object (string, number, boolean, etc.), display as is
                            valuePara.textContent = value;
                        }

                        itemDiv.appendChild(labelSpan);
                        itemDiv.appendChild(valuePara);
                        webhookInfoContainer.appendChild(itemDiv);
                    }

                    // Iterate through the JSON data and display it as key-value pairs
                    for (const key in statusData) {
                        if (statusData.hasOwnProperty(key)) {
                            addWebhookKeyValue(key, statusData[key]);
                        }
                    }
                    webhookResultDiv.appendChild(webhookInfoContainer);

                    // OPTIONAL: If you want to also display the complete JSON response like in Iota page
                    /*
                    const completeResponseCard = document.createElement('div');
                    completeResponseCard.className = 'vp-complete-response-card'; // Reusing style
                    const completeResponseHeader = document.createElement('h5'); // Slightly smaller header
                    completeResponseHeader.className = 'vp-complete-response-header';
                    completeResponseHeader.textContent = 'Complete Webhook Response (JSON)';
                    const completeResponsePre = document.createElement('pre');
                    completeResponsePre.textContent = JSON.stringify(statusData, null, 2);
                    completeResponseCard.appendChild(completeResponseHeader);
                    completeResponseCard.appendChild(completeResponsePre);
                    webhookResultDiv.appendChild(completeResponseCard);
                    */


                } else {
                    webhookMessageDiv.textContent = 'Credential Status:';
                    webhookResultDiv.innerHTML = `<div class="alert alert-info">No status data received yet.</div>`;
                }


            } catch (error) {
                console.error('Error fetching credential status:', error);
                webhookMessageDiv.textContent = 'Error checking credential status:';
                webhookResultDiv.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            }
        }
    </script>
</body>

</html>
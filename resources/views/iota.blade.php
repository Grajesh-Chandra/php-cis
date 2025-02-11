<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinidi Iota Framework</title>
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
            /* Wider container to accommodate two columns if needed */
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

        .affinidi-login-div {
            margin-bottom: 20px;
        }

        .affinidi-login-dark-l {
            /*  --- AFFINIDI LOGIN BUTTON STYLES - DO NOT MODIFY --- */
            border: 0;
            width: 224px;
            height: 56px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            box-sizing: border-box;
            align-items: center;
            gap: 12px;
            padding: 12px 32px;
            object-fit: contain;
            border-radius: 48px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="29" height="24" viewBox="0 0 29 24" fill="none"><path d="M3.22 20.281A11.966 11.966 0 0 0 11.904 24c3.415 0 6.498-1.428 8.683-3.719H3.219h.001zM20.588 6.762H1.106A11.933 11.933 0 0 0 0 10.48h20.588V6.762zM20.586 3.719A11.966 11.966 0 0 0 11.902 0 11.966 11.966 0 0 0 3.22 3.719h17.367zM20.588 13.521H0c.167 1.319.548 2.57 1.106 3.719h19.482v-3.718zM22.703 6.762c.558 1.148.94 2.4 1.106 3.718h4.78V6.762h-5.886z" fill="%23040822"/><path d="M28.586 20.281h-8V24h8V20.28zM22.703 17.24h5.886v-3.718h-4.78a11.933 11.933 0 0 1-1.106 3.718zM28.586 0h-8v3.719h8V0z" fill="%23040822"/><path d="M23.807 10.48A11.931 11.931 0 0 0 22.7 6.76a12.012 12.012 0 0 0-2.115-3.041v16.563A12.045 12.045 0 0 0 22.7 17.24 11.932 11.932 0 0 0 23.9 12c0-.516-.031-1.023-.094-1.522v.001z" fill="%231D58FC"/></svg>') no-repeat 25px center;
            background-color: #ffffff;
            color: #000;
            padding-left: 60px;
            flex-grow: 0;
            font-family: Figtree;
            font-size: 18px;
            font-weight: 600;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.22;
            letter-spacing: 0.6px;
            text-decoration: none;
        }

        .affinidi-login-dark-l:hover {
            background-color: #e6e6e9;
        }

        .affinidi-login-dark-l:active {
            background-color: #cdced3;
        }

        .affinidi-login-dark-l-loading {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><g clip-path="url(%230e2gocc7wa)"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.727 4.545v2.728l3.864-3.637L9.727 0v2.727C5.457 2.727 2 5.982 2 10c0 1.427.444 2.755 1.198 3.873l1.41-1.327A5.09 5.09 0 0 1 3.932 10c0-3.01 2.598-5.455 5.795-5.455zm6.53 1.582-1.41 1.328c.425.763.676 1.627.676 2.545 0 3.01-2.599 5.454-5.796 5.454v-2.727l-3.863 3.637L9.727 20v-2.727c4.27 0 7.727-3.255 7.727-7.273a6.904 6.904 0 0 0-1.197-3.873z" fill="%231D2138"/></g><defs><clipPath id="0e2gocc7wa"><path fill="%23fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>') no-repeat center;
            background-color: #e6e6e9;
        }

        .affinidi-login-dark-l:disabled {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 30 24" fill="none"><path d="M3.927 20.281A11.966 11.966 0 0 0 12.61 24c3.416 0 6.499-1.428 8.684-3.719H3.926h.001zM21.295 6.762H1.813A11.933 11.933 0 0 0 .707 10.48h20.588V6.762zM21.293 3.719A11.967 11.967 0 0 0 12.609 0a11.966 11.966 0 0 0-8.683 3.719h17.367zM21.295 13.521H.707c.167 1.319.548 2.57 1.106 3.719h19.482v-3.718zM23.41 6.762c.558 1.148.94 2.4 1.106 3.718h4.78V6.762H23.41z" fill="%23fff"/><path d="M29.293 20.281h-8V24h8V20.28zM23.41 17.24h5.886v-3.718h-4.78a11.933 11.933 0 0 1-1.106 3.718zM29.293 0h-8v3.719h8V0z" fill="%23fff"/><path d="M24.514 10.48a11.934 11.934 0 0 0-1.106-3.72 12.017 12.017 0 0 0-2.115-3.041v16.563a12.05 12.05 0 0 0 2.115-3.042 11.935 11.935 0 0 0 1.2-5.24c0-.516-.031-1.023-.094-1.522v.001z" fill="%23fff"/></svg>') no-repeat 25px center;
            background-color: #e6e6e9;
            color: #ffffff;
        }


        .iota-button,
        #iota-btn {
            /* Button style for Iota Request - similar to CIS page buttons */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #0694a2;
            /* Teal color for button */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
            /* Add some top margin */
            display: inline-block;
            /* To allow width: auto to work if needed */
        }

        .iota-button:hover,
        #iota-btn:hover {
            background-color: #047a85;
            /* Darker teal on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .iota-button:active,
        #iota-btn:active {
            background-color: #03606b;
            /* Even darker teal on active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }


        #divMessage {
            margin-top: 25px;
            padding: 0px;
            border-radius: 10px;
            background-color: transparent;
            border: none;
            text-align: center;
            font-size: 1.1rem;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        #divMessage.text-danger {
            color: #991b1b;
        }

        #divMessage b {
            font-weight: 700;
        }

        #divMessage pre {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            text-align: left;
        }

        /* Enhanced Home Button Style */
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

        /* Enhanced VP Response Display Styles */
        .vp-response-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            padding: 30px;
            text-align: left;
            margin-bottom: 25px;
            /* Add margin between cards */
        }

        .vp-response-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .vp-response-icon {
            height: 40px;
            width: 40px;
            fill: #10b981;
            margin-right: 20px;
        }

        .vp-response-title {
            font-size: 1.7rem;
            color: #374151;
            margin: 0;
            font-weight: 700;
        }

        .vp-response-body {
            margin-bottom: 20px;
        }

        .vp-response-detail {
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .subject-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .subject-info-item {
            display: flex;
            flex-direction: column;
        }

        .subject-info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .subject-info-value {
            background-color: #f0f4f8;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 1rem;
            color: #2d3748;
            overflow-wrap: break-word;
        }

        /* Styles for Complete Response Card */
        .vp-complete-response-card {
            background-color: #f7f7fc;
            /* Lighter background for complete response */
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            /* Slightly less shadow */
            padding: 25px;
            margin-bottom: 30px;
            overflow-x: auto;
            /* Horizontal scroll if needed */
            font-size: 0.9rem;
            /* Slightly smaller font for code */
            font-family: monospace;
            /* Monospace font for code */
            color: #555;
            /* Slightly lighter text color */
            white-space: pre-wrap;
            /* Preserve formatting */
        }

        .vp-complete-response-header {
            font-size: 1.3rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 20px;
            text-align: center;
            /* Center align header */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header-body">
            <h1>Affinidi Iota Framework</h1>
        </div>

        <div class="card-body">
            <a href="/" class="home-button-enhanced">Home</a>
        </div>

        <div class="card-body">
            <div id="divRequest">
                <button class="iota-button" id="iota-btn">Request Avvanz Credentials</button>
            </div>
            <div id="divMessage">
            </div>
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
                    if (!data.vp_token) {
                        divMessage.textContent = 'Failed to get response from iota: ' + '' + data.message;
                        divMessage.classList.add('text-danger');
                        window.history.replaceState(null, '', window.location.pathname);
                        return;
                    }

                    // Parse the VP token
                    const vpResponse = JSON.parse(data.vp_token);

                    // Clear the default message
                    divMessage.innerHTML = '';
                    divMessage.classList.remove('text-danger', 'text-center');

                    // **Create Complete VP Response Card**
                    const completeResponseCard = document.createElement('div');
                    completeResponseCard.className = 'vp-complete-response-card';
                    const completeResponseHeader = document.createElement('h4');
                    completeResponseHeader.className = 'vp-complete-response-header';
                    completeResponseHeader.textContent = 'Complete VP Response (JSON)';
                    const completeResponsePre = document.createElement('pre');
                    completeResponsePre.textContent = JSON.stringify(vpResponse, null, 2);
                    completeResponseCard.appendChild(completeResponseHeader);
                    completeResponseCard.appendChild(completeResponsePre);
                    divMessage.appendChild(completeResponseCard); // Add complete response card first


                    // **Container for Verifiable Credential Cards**
                    const vcCardsContainer = document.createElement('div'); // Just a container, no special class needed for now
                    divMessage.appendChild(vcCardsContainer); // Append container to divMessage

                    // **Iterate through verifiableCredentials array and create individual VC cards**
                    vpResponse.verifiableCredential.forEach(verifiableCredential => {
                        // Create VP Response Card Container (renamed to VC card for clarity)
                        const vcCard = document.createElement('div');
                        vcCard.className = 'vp-response-card'; // Reusing existing card style

                        // VP Response Header (renamed to VC Header)
                        const vcHeader = document.createElement('div');
                        vcHeader.className = 'vp-response-header';
                        const vcIcon = document.createElement('svg'); // You might want to replace this with a proper icon
                        vcIcon.className = 'vp-response-icon';
                        vcIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.5 9.75a.75.75 0 0 1 1.5 0v2.25a.75.75 0 0 1-1.5 0V12zm1.5-4.5a.75.75 0 0 1 .75.75h.008a.75.75 0 0 1-.75.75H12a.75.75 0 0 1-.75-.75V7.5a.75.75 0 0 1 .75-.75h.008z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12 17.25a5.25 5.25 0 1 0 0-10.5 5.25 5.25 0 0 0 0 10.5zm0 1.5a6.75 6.75 0 1 1 0-13.5 6.75 0 0 1 0 13.5z" clip-rule="evenodd" />
                        </svg>`; // Reusing success icon
                        const vcTitle = document.createElement('h3');
                        vcTitle.className = 'vp-response-title';
                        vcTitle.textContent = 'Verifiable Credential Details';
                        vcHeader.appendChild(vcIcon);
                        vcHeader.appendChild(vcTitle);
                        vcCard.appendChild(vcHeader);


                        // VP Response Body (renamed to VC Body)
                        const vcBody = document.createElement('div');
                        vcBody.className = 'vp-response-body';
                        const vcDetail = document.createElement('p');
                        vcDetail.className = 'vp-response-detail';
                        vcDetail.textContent = 'Details of this verifiable credential are shown below:';
                        vcBody.appendChild(vcDetail);
                        vcCard.appendChild(vcBody);


                        // Verifiable Credential Info Section (renamed from subjectInfo)
                        const vcInfo = document.createElement('div');
                        vcInfo.className = 'subject-info'; // Reusing subject-info class for styling

                        // **Iterate through verifiableCredential properties**
                        for (const key in verifiableCredential) {
                            if (verifiableCredential.hasOwnProperty(key) && key !== '@context' && key !== 'type') { // Keep filtering context and type if you prefer

                                const item = document.createElement('div');
                                item.className = 'subject-info-item';
                                const label = document.createElement('span');
                                label.className = 'subject-info-label';
                                label.textContent = key;
                                const value = document.createElement('p');
                                value.className = 'subject-info-value';

                                // Handle objects and arrays as values
                                if (typeof verifiableCredential[key] === 'object') {
                                    value.textContent = JSON.stringify(verifiableCredential[key], null, 2);
                                    value.style.whiteSpace = 'pre-wrap';
                                } else {
                                    value.textContent = verifiableCredential[key];
                                }

                                item.appendChild(label);
                                item.appendChild(value);
                                vcInfo.appendChild(item);
                            }
                        }
                        vcBody.appendChild(vcInfo); // Append VC info to VC body
                        vcCard.appendChild(vcBody); // Append VC body to VC card
                        vcCardsContainer.appendChild(vcCard); // Append individual VC card to the container

                    });


                    window.history.replaceState(null, '', window.location.pathname);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    divMessage.textContent = 'Failed iota request.';
                    divMessage.classList.add('text-danger');
                    window.history.replaceState(null, '', window.location.pathname);
                });


        }

        document.getElementById('iota-btn').addEventListener('click', function() {

            divMessage.classList.remove('text-danger');
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
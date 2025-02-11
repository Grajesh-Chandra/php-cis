<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affinidi Issuance</title>
    <style>
        /* Intuitive Design Styles */
        body {
            font-family: 'Roboto', sans-serif;
            /* More modern, friendly font */
            background-color: #eef2f7;
            /* Softer, slightly warmer background grey */
            color: #4a5568;
            /* Medium grey, softer than #333 */
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
            /* Increased padding for spaciousness */
            border-radius: 12px;
            /* More rounded corners */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            /* Slightly stronger, softer shadow */
            width: 100%;
            max-width: 700px;
            box-sizing: border-box;
            margin-top: 40px;
            /* Increased top margin */
            margin-bottom: 40px;
            /* Increased bottom margin */
        }

        .header-body {
            text-align: center;
            margin-bottom: 40px;
            /* Increased margin */
        }

        h1 {
            font-size: 2.2rem;
            /* Slightly larger title */
            color: #374151;
            /* Darker, but still softer than pure black */
            margin-bottom: 15px;
            font-weight: 700;
            /* Bold font weight for title */
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
            /* Increased margin */
            text-align: center;
        }

        hr.mt-2 {
            border: 0;
            border-top: 2px solid #e0e0e0;
            /* Slightly thicker hr */
            margin-top: 20px;
            /* Increased margin */
            margin-bottom: 20px;
            /* Increased margin */
        }

        .alert {
            padding: 20px;
            /* Increased padding */
            border-radius: 8px;
            /* Rounded corners for alerts */
            margin-bottom: 20px;
            /* Increased margin */
            text-align: center;
            font-weight: 500;
            border-width: 1px;
            /* Add border width for all alerts */
        }

        .alert-info {
            background-color: #e0f7fa;
            /* Light teal background for info */
            color: #0f566b;
            /* Darker teal text for info */
            border-color: #b2ebf2;
        }

        .alert-danger {
            background-color: #fdecea;
            /* Light red background for danger */
            color: #991b1b;
            /* Darker red text for danger */
            border-color: #fcc2c3;
        }

        .alert-success {
            background-color: #e6f9ec;
            /* Light green background for success */
            color: #155724;
            border-color: #bef2c4;
        }


        .button-group {
            display: grid;
            /* Using grid for better button layout */
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            /* Responsive button columns */
            gap: 20px;
            /* Increased button spacing */
            margin-bottom: 30px;
            /* Increased margin */
        }

        .issue-credential-btn,
        .action-button {
            display: flex;
            /* Flex for icon and text alignment */
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            /* Increased button padding */
            background-color: #0694a2;
            /* Teal button color */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            /* Rounded corners for buttons */
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            /* Slightly larger font */
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Added transform for click feedback */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            /* Subtle button shadow */
        }

        .issue-credential-btn svg,
        .action-button svg {
            margin-right: 10px;
            /* Spacing between icon and text */
            height: 20px;
            width: 20px;
            fill: #ffffff;
            /* Icon color white */
        }


        .issue-credential-btn:hover,
        .action-button:hover {
            background-color: #047a85;
            /* Darker teal on hover */
            transform: translateY(-2px);
            /* Slight lift on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Increased shadow on hover */
        }

        .issue-credential-btn:active,
        .action-button:active {
            background-color: #03606b;
            /* Even darker teal on active */
            transform: translateY(0);
            /* Reset transform on active */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            /* Reset shadow on active */
        }


        #divResponse,
        #divResponseError {
            margin-top: 25px;
            /* Increased margin */
            padding: 30px;
            /* Increased padding */
            border-radius: 10px;
            /* Rounded corners for response areas */
            background-color: #f7fafc;
            /* Very light grey background */
            border: 1px solid #e0e0e0;
            text-align: center;
        }

        #divResponse p,
        #divResponseError p {
            margin: 15px 0;
            /* Increased paragraph margin */
            font-size: 1.1rem;
        }

        #vaultLink,
        #backLink {
            margin: 0 15px;
            /* Increased spacing between action buttons */
            text-decoration: none;
        }

        /* Enhanced Offer Ready Section */
        .offer-ready-card {
            background-color: #ffffff;
            /* White background card */
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            /* Subtle card shadow */
            padding: 30px;
            text-align: left;
            /* Left align text within the card */
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
            /* Success/Green color for icon */
            margin-right: 20px;
        }

        .offer-ready-title {
            font-size: 1.7rem;
            color: #10b981;
            /* Green title color */
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
            /* Stack offer info items */
            gap: 15px;
            margin-bottom: 25px;
        }

        .offer-info-item {
            display: flex;
            flex-direction: column;
            /* Label above value */
        }

        .offer-info-label {
            font-weight: 600;
            color: #374151;
            /* Darker label color */
            margin-bottom: 5px;
        }

        .offer-info-value {
            background-color: #f0f4f8;
            /* Light grey background for value */
            padding: 12px 15px;
            border-radius: 8px;
            font-family: monospace;
            /* Monospace font for code-like values */
            font-size: 0.95rem;
            color: #2d3748;
            /* Dark grey value color */
            overflow-wrap: break-word;
            /* Break long URLs */
        }

        .offer-ready-actions {
            display: flex;
            justify-content: center;
            /* Center action buttons */
            gap: 20px;
        }

        .claim-button {
            background-color: #10b981;
            /* Green Claim Offer button */
        }

        .claim-button:hover {
            background-color: #0b8a65;
            /* Darker green on hover */
        }

        .return-button {
            background-color: #6b7280;
            /* Grey Return Back button */
        }

        .return-button:hover {
            background-color: #4a5568;
            /* Darker grey on hover */
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

        /* Enhanced Home Button Style */
        .home-button-enhanced {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #6b7280;
            /* Grey Home Button Color - Distinct from Teal */
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
            /* Keep margin for consistency */
            display: inline-block;
            /* Ensure it behaves like a button */
        }

        .home-button-enhanced:hover {
            background-color: #4a5568;
            /* Darker Grey on Hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .home-button-enhanced:active {
            background-color: #374151;
            /* Even Darker Grey on Active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
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
            </div>
        </div>

        <div class="card-body" id="divResponseError" style="display: none">
            <div class="alert alert-danger"></div>
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
            divResponseError.querySelector('.alert-danger').textContent = 'Processing Issuance for ' + type + ' VC, Please wait...'; // Correctly set alert text

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

                        divResponseError.style.display = 'none'; // Hide error div on success
                    } else {
                        const divRequest = document.getElementById('divRequest');
                        divRequest.style.display = '';
                        divResponseError.querySelector('.alert-danger').textContent = 'Failed to issue credential: ' + data.message; // Correctly set alert text
                        document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    const divRequest = document.getElementById('divRequest');
                    divRequest.style.display = '';
                    divResponseError.querySelector('.alert-danger').textContent = 'Failed to issue credential: ' + error.message; // Correctly set alert text
                    document.querySelectorAll('.issue-credential-btn').forEach(btn => btn.style.display = '');
                });
        }
    </script>
</body>

</html>
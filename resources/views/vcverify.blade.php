<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Verifiable Credential</title>
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

        /* Reusing iota-button style for consistency */
        .verify-button {
            display: inline-flex;
            /* Use inline-flex for better alignment if needed */
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #0694a2;
            /* Teal color */
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
        }

        .verify-button:hover {
            background-color: #047a85;
            /* Darker teal on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .verify-button:active {
            background-color: #03606b;
            /* Even darker teal on active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .verify-button:disabled {
            background-color: #cccccc;
            /* Grey out when disabled */
            color: #666666;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }


        #divMessage {
            margin-top: 25px;
            padding: 15px;
            /* Add some padding */
            border-radius: 10px;
            background-color: transparent;
            /* Keep transparent by default */
            border: none;
            text-align: center;
            font-size: 1.1rem;
            word-wrap: break-word;
            white-space: pre-wrap;
            /* Preserve formatting */
            min-height: 50px;
            /* Ensure space for messages */
        }

        #divMessage.text-danger {
            color: #991b1b;
            background-color: #fdecea;
            /* Add background for alerts */
            border: 1px solid #fcc2c3;
        }

        #divMessage.text-success {
            color: #155724;
            background-color: #e6f9ec;
            /* Add background for alerts */
            border: 1px solid #bef2c4;
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
            margin-top: 10px;
            /* Space between message and code block */
        }

        /* Enhanced Home Button Style */
        .home-button-enhanced {
            display: inline-flex;
            /* Use inline-flex */
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

        /* Textarea Styles */
        .vc-textarea {
            width: 100%;
            min-height: 200px;
            /* Adjust height as needed */
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            /* Light gray border */
            font-family: monospace;
            /* Good for JSON */
            font-size: 0.95rem;
            box-sizing: border-box;
            /* Include padding and border in width */
            margin-bottom: 20px;
            resize: vertical;
            /* Allow vertical resizing */
            background-color: #f9fafb;
            /* Slightly off-white background */
            color: #374151;
        }

        .vc-textarea:focus {
            outline: none;
            border-color: #0694a2;
            /* Teal border on focus */
            box-shadow: 0 0 0 3px rgba(6, 148, 162, 0.2);
            /* Subtle focus ring */
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
            /* Align label left */
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header-body">
            <h1>Verify Verifiable Credential</h1>
            <p>Paste the Verifiable Credential JSON below to verify its integrity and validity.</p>
        </div>

        <div class="card-body"> <!-- Align content left for the form -->
            <a href="/" class="home-button-enhanced" style="display: inline-block; margin-bottom: 30px;">Home</a> <!-- Keep home button accessible -->

            <div class="form-group">
                <label for="vcDetails" class="form-label">Verifiable Credential (JSON):</label>
                <textarea id="vcDetails" class="vc-textarea" placeholder="Paste your Verifiable Credential JSON here..."></textarea>
            </div>

            <div style="text-align: center;"> <!-- Center the button -->
                <button class="verify-button" id="verify-btn">Verify Credential</button>
            </div>

            <div id="divMessage">
                <!-- Verification results will be displayed here -->
            </div>
        </div>

    </div>

    <script>
        const verifyBtn = document.getElementById('verify-btn');
        const vcDetailsTextarea = document.getElementById('vcDetails');
        const divMessage = document.getElementById('divMessage');

        verifyBtn.addEventListener('click', function() {
            const vcData = vcDetailsTextarea.value.trim();

            // Clear previous messages and styles
            divMessage.textContent = '';
            divMessage.className = ''; // Reset classes
            divMessage.style.textAlign = 'center'; // Default alignment

            if (!vcData) {
                divMessage.textContent = 'Please paste the Verifiable Credential details.';
                divMessage.classList.add('text-danger'); // Use danger style for validation error
                return;
            }

            let parsedVC;
            try {
                parsedVC = JSON.parse(vcData);
            } catch (error) {
                divMessage.textContent = 'Invalid JSON format. Please check the pasted credential.';
                divMessage.classList.add('text-danger');
                return;
            }

            // Disable button and show loading state
            verifyBtn.disabled = true;
            verifyBtn.textContent = 'Verifying...';
            divMessage.textContent = 'Verifying credential, please wait...';
            divMessage.style.textAlign = 'center';


            fetch('/api/verify-credentials', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        // Add CSRF token header if your application uses it for API routes
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        verifiableCredentials: parsedVC
                    }) // Send as an object expected by the backend
                })
                .then(response => {
                    // Check if the response is successful (status code 2xx)
                    if (!response.ok) {
                        // If not OK, try to parse the error response body
                        return response.json().then(errData => {
                            // Throw an error with the message from the server, or a default message
                            throw new Error(errData.message || `HTTP error! Status: ${response.status}`);
                        }).catch(() => {
                            // If parsing the error body fails, throw a generic error
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        });
                    }
                    return response.json(); // Parse the successful JSON response
                })
                .then(data => {
                    console.log('Verification Success:', data);
                    divMessage.classList.remove('text-danger'); // Ensure no error style
                    divMessage.classList.add('text-success'); // Add success style
                    divMessage.style.textAlign = 'left'; // Align results left

                    // Display a user-friendly success message and the structured response
                    let messageContent = `<b>Verification Result:</b><br>`;
                    if (typeof data === 'object' && data !== null) {
                        // Display the key-value pairs from the response
                        for (const key in data) {
                            if (data.hasOwnProperty(key)) {
                                messageContent += `<b>${key}:</b> ${JSON.stringify(data[key], null, 2)}<br>`;
                            }
                        }
                        // Optionally add the raw JSON in a <pre> block if needed
                        // messageContent += '<br><b>Raw Response:</b><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                    } else {
                        messageContent += JSON.stringify(data, null, 2); // Fallback for non-object responses
                    }
                    divMessage.innerHTML = messageContent;


                })
                .catch((error) => {
                    console.error('Verification Error:', error);
                    divMessage.classList.remove('text-success'); // Ensure no success style
                    divMessage.classList.add('text-danger'); // Add danger style
                    divMessage.style.textAlign = 'center'; // Center error message
                    divMessage.textContent = `Verification failed: ${error.message}`;
                })
                .finally(() => {
                    // Re-enable button and restore text regardless of success or failure
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'Verify Credential';
                });
        });
    </script>
</body>

</html>
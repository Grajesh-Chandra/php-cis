<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revoke Verifiable Credential</title>
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

        /* Reusing button style for consistency */
        .revoke-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #dc3545;
            /* Red color for revoke action */
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

        .revoke-button:hover {
            background-color: #c82333;
            /* Darker red on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .revoke-button:active {
            background-color: #bd2130;
            /* Even darker red on active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .revoke-button:disabled {
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
            border-radius: 10px;
            background-color: transparent;
            border: none;
            text-align: center;
            font-size: 1.1rem;
            word-wrap: break-word;
            white-space: pre-wrap;
            min-height: 50px;
        }

        #divMessage.text-danger {
            color: #991b1b;
            background-color: #fdecea;
            border: 1px solid #fcc2c3;
        }

        #divMessage.text-success {
            color: #155724;
            background-color: #e6f9ec;
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
        }

        /* Enhanced Home Button Style */
        .home-button-enhanced {
            display: inline-flex;
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

        /* Input Field Styles */
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            /* Light gray border */
            font-size: 1rem;
            box-sizing: border-box;
            /* Include padding and border in width */
            background-color: #f9fafb;
            /* Slightly off-white background */
            color: #374151;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input:focus {
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
            <h1>Revoke Verifiable Credential</h1>
            <p>Enter the details below to revoke a specific credential.</p>
        </div>

        <div class="card-body">
            <a href="/" class="home-button-enhanced" style="margin-bottom: 30px;">Home</a>

            <div class="form-group">
                <label for="credentialId" class="form-label">Credential ID:</label>
                <input type="text" id="credentialId" class="form-input" placeholder="e.g., claimId:253b0e8dcd46b789789">
            </div>

            <div class="form-group">
                <label for="revocationReason" class="form-label">Revocation Reason:</label>
                <select id="revocationReason" class="form-input">
                    <option value="INVALID_CREDENTIAL">INVALID_CREDENTIAL</option>
                    <option value="COMPROMISED_ISSUER">COMPROMISED_ISSUER</option>
                </select>
            </div>


            <div style="text-align: center;"> <!-- Center the button -->
                <button class="revoke-button" id="revoke-btn">Revoke Credential</button>
            </div>

            <div id="divMessage">
                <!-- Revocation results will be displayed here -->
            </div>
        </div>

    </div>

    <script>
        const revokeBtn = document.getElementById('revoke-btn');
        const credentialIdInput = document.getElementById('credentialId');
        const revocationReasonInput = document.getElementById('revocationReason');
        const divMessage = document.getElementById('divMessage');

        revokeBtn.addEventListener('click', function() {
            const credentialId = credentialIdInput.value.trim();
            const revocationReason = revocationReasonInput.value.trim();

            divMessage.textContent = '';
            divMessage.className = ''; // Reset classes
            divMessage.style.textAlign = 'center'; // Default alignment

            // Basic Validation
            if (!credentialId) {
                divMessage.textContent = 'Please enter the Credential ID.';
                divMessage.classList.add('text-danger');
                credentialIdInput.focus(); // Focus on the empty field
                return;
            }
            if (!revocationReason) {
                divMessage.textContent = 'Please enter the Revocation Reason.';
                divMessage.classList.add('text-danger');
                revocationReasonInput.focus(); // Focus on the empty field
                return;
            }

            // Disable button and show loading state
            revokeBtn.disabled = true;
            revokeBtn.textContent = 'Revoking...';
            divMessage.textContent = 'Submitting revocation request, please wait...';
            divMessage.style.textAlign = 'center';

            const payload = {
                credentialId: credentialId,
                revocationReason: revocationReason
            };

            fetch('/api/revoke-credentials', { // Changed endpoint
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        // Add CSRF token header if your application uses it for API routes
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload) // Send the structured payload
                })
                .then(response => {
                    // Check if the response is successful (status code 2xx)
                    if (!response.ok) {
                        // Try to parse error response body
                        return response.json().then(errData => {
                            throw new Error(errData.message || `HTTP error! Status: ${response.status}`);
                        }).catch(() => {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        });
                    }
                    // If response is OK, but might not have a body (e.g., 204 No Content)
                    // Check content-type or status code if needed. Assuming JSON response for success here.
                    if (response.status === 204) {
                        return {
                            message: 'Credential revoked successfully.'
                        }; // Create a success object for consistent handling
                    }
                    return response.json(); // Parse the successful JSON response
                })
                .then(data => {
                    console.log('Revocation Success:', data);
                    divMessage.classList.remove('text-danger');
                    divMessage.classList.add('text-success');
                    divMessage.style.textAlign = 'center'; // Center success message

                    // Display a user-friendly success message
                    divMessage.textContent = data.message || 'Credential revoked successfully!';

                    // Optionally clear fields on success
                    credentialIdInput.value = '';
                    // revocationReasonInput.value = '';

                })
                .catch((error) => {
                    console.error('Revocation Error:', error);
                    divMessage.classList.remove('text-success');
                    divMessage.classList.add('text-danger');
                    divMessage.style.textAlign = 'center';
                    divMessage.textContent = `Revocation failed: ${error.message}`;
                })
                .finally(() => {
                    // Re-enable button and restore text
                    revokeBtn.disabled = false;
                    revokeBtn.textContent = 'Revoke Credential';
                });
        });
    </script>
</body>

</html>
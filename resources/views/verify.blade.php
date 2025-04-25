<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Document Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #3B82F6;
            --primary-hover: #2563EB;
            --success: #10B981;
            --error: #EF4444;
            --background: #F8FAFC;
            --text: #1E293B;
            --border: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .verification-container {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 640px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #0F172A;
        }

        .header p {
            color: #64748B;
            line-height: 1.5;
        }

        .upload-section {
            border: 2px dashed var(--border);
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            position: relative;
            background: #F8FAFC;
        }

        .upload-section:hover {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.03);
        }

        .upload-section.active {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.05);
        }

        .upload-input {
            display: none;
        }

        .upload-label {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: transform 0.2s ease;
        }

        .upload-label:hover .upload-icon {
            transform: translateY(-2px);
        }

        .file-info {
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #64748B;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            background-color: #0694a2;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .submit-btn:hover {
            background: var(--primary-hover);
            background-color: #0694a2;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .status-message {
            margin-top: 1.5rem;
            padding: 1.25rem;
            border-radius: 0.75rem;
            display: none;
            align-items: center;
            gap: 1rem;
            animation: fadeIn 0.3s ease;
        }

        .status-message.active {
            display: flex;
        }

        .status-message.success {
            background: #ECFDF5;
            color: #065F46;
        }

        .status-message.error {
            background: #FEF2F2;
            color: #991B1B;
        }

        /* CSS for PDF Content <pre> - using CLASS SELECTOR now */
        .pdf-content-pre {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-top: 10px;
            margin-bottom: 0px;
            font-size: 0.9em;
        }

        /* CSS for JSON Attachment Content <pre> - using CLASS SELECTOR now */
        .json-attachment-pre {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #eee;
            padding: 5px;
            background-color: #f9f9f9;
            font-size: 0.8em;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-top: 5px;
            margin-bottom: 0px;
        }

        /* CSS for PDF Content Hash <pre> */
        .hash-pre {
            font-size: 0.85em;
            /* Slightly smaller font for hash */
            background-color: #f0f0f0;
            /* Light gray background */
            padding: 8px;
            border-radius: 0.5rem;
            overflow-x: auto;
            /* Enable horizontal scroll if hash is very long */
            word-break: break-all;
            /* Break long hash string if needed */
            margin-top: 5px;
            margin-bottom: 10px;
        }


        .spinner {
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blob {
            position: absolute;
            background: var(--primary);
            opacity: 0.1;
            filter: blur(40px);
            z-index: -1;
        }

        .blob-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
        }

        .blob-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -100px;
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

        .header-body {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>

    <div class="verification-container">
        <div class="blob blob-1"></div>
        <div class="header-body">
            <a href="/" class="home-button-enhanced">Home</a>
        </div>
        <div class="blob blob-2"></div>
        <div class="header">
            <h1>Secure Document Verification</h1>
            <p>Upload your PDF document for instant verification and validation</p>

        </div>

        <form id="verificationForm" enctype="multipart/form-data">
            @csrf
            <div class="upload-section" id="dropZone">
                <input type="file" class="upload-input" id="fileInput" name="pdf_file" accept=".pdf" required>
                <label for="fileInput" class="upload-label">
                    <div class="upload-icon">
                        <i data-feather="upload"></i>
                    </div>
                    <div>
                        <h3>Drag & Drop Files</h3>
                        <p>or click to browse (Max 25MB)</p>
                    </div>
                </label>
                <div class="file-info" id="fileInfo"></div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span>Verify Document</span>
                <div class="spinner"></div>
            </button>
        </form>

        <div class="status-message" id="statusMessage">
            <i data-feather="alert-circle"></i>
            <div class="message-content"></div>
        </div>
    </div>

    <script>
        feather.replace();

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const form = document.getElementById('verificationForm');
        const submitBtn = document.getElementById('submitBtn');
        const statusMessage = document.getElementById('statusMessage');
        const spinner = submitBtn.querySelector('.spinner');

        // Drag & Drop handlers
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('active');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('active');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('active');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        // File input change handler
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        function handleFileSelect(file) {
            if (file.type !== 'application/pdf') {
                showError('Please upload a valid PDF file');
                return;
            }

            if (file.size > 25 * 1024 * 1024) {
                showError('File size exceeds 25MB limit');
                return;
            }

            fileInfo.innerHTML = `
                <strong>Selected File:</strong> ${file.name}<br>
                <span class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
            `;
        }

        async function handleSubmit(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('pdf_file', fileInput.files[0]);

            submitBtn.disabled = true;
            spinner.style.display = 'block';
            submitBtn.querySelector('span').textContent = 'Verifying...';
            statusMessage.classList.remove('active');

            try {
                const response = await fetch("{{ route('verify.pdf') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    showSuccess(data.message, data);
                } else {
                    showError(data.error || 'Verification failed. Please try again.');
                }

            } catch (error) {
                showError('An error occurred during verification. Please check your connection and try again.');
                console.error('API Error:', error);
            } finally {
                submitBtn.disabled = false;
                spinner.style.display = 'none';
                submitBtn.querySelector('span').textContent = 'Verify Document';
                form.reset();
                fileInfo.innerHTML = '';
            }
        }

        function showSuccess(message, data) {
            let detailedMessage = message + `<br><br><b>Extracted PDF Content:</b><br><pre class="pdf-content-pre">${data.pdf_content}</pre>`;

            // Display PDF Content Hash
            detailedMessage += `<br><b>PDF Content Hash (SHA-256):</b><br><pre class="hash-pre">${data.pdf_content_hash || 'Not Calculated'}</pre>`;


            if (data.attachments && data.attachments.length > 0) {
                let attachmentsHTML = "<br><br><b>Attachments:</b><ul>";
                data.attachments.forEach(attachment => {
                    attachmentsHTML += `<li><b>${attachment.filename}</b> (Type: ${attachment.mime_type || 'application/octet-stream'})<br>`;

                    if (attachment.filename.toLowerCase().endsWith('.json')) {
                        try {
                            const decodedJSON = JSON.stringify(JSON.parse(atob(attachment.content_base64)), null, 2);
                            attachmentsHTML += `<pre class="json-attachment-pre">${decodedJSON}</pre>`;
                        } catch (e) {
                            attachmentsHTML += `<span style="color: orange;">Could not decode/display JSON content.</span>`;
                            console.error("JSON Decode Error for attachment:", attachment.filename, e);
                        }
                    } else if (attachment.content_encoding === 'base64') {
                        attachmentsHTML += `<span style="font-size: 0.9em;">Attachment content is base64 encoded binary data and cannot be directly displayed here.</span>`;
                    } else if (attachment.content) {
                        attachmentsHTML += `<pre class="json-attachment-pre">${attachment.content}</pre>`;
                    } else {
                        attachmentsHTML += "No text content extracted.";
                    }
                    attachmentsHTML += "</li>";
                });
                attachmentsHTML += "</ul>";
                detailedMessage += attachmentsHTML;
            }

            statusMessage.className = 'status-message success active';
            statusMessage.innerHTML = `
                <i data-feather="check-circle"></i>
                <div class="message-content">${detailedMessage}</div>
            `;
            feather.replace();
        }


        function showError(message) {
            statusMessage.className = 'status-message error active';
            statusMessage.innerHTML = `
                <i data-feather="alert-triangle"></i>
                <div class="message-content">${message}</div>
            `;
            feather.replace();
        }

        form.addEventListener('submit', handleSubmit);
    </script>
</body>

</html>
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

        .verification-container::before {}

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
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            background: var(--primary-hover);
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
    </style>
</head>

<body>
    <div class="verification-container">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="header">
            <h1>Secure Document Verification</h1>
            <p>Upload your PDF document for instant verification and validation</p>
        </div>

        <form id="verificationForm" enctype="multipart/form-data">
            @csrf
            <div class="upload-section" id="dropZone">
                <input type="file" class="upload-input" id="fileInput" name="file" accept=".pdf" required>
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
            formData.append('file', fileInput.files[0]);

            submitBtn.disabled = true;
            spinner.style.display = 'block';
            submitBtn.querySelector('span').textContent = 'Verifying...';
            statusMessage.classList.remove('active');

            try {
                const response = await fetch("{{ route('verify.pdf') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                        }
                    });

                const data = await response.json(); // Parse JSON response from API

                if (response.ok) {
                    showSuccess(data.message); // Display success message from API
                    if (data.status) { // Check if status is returned and display it
                        showSuccess(data.message + `<br><b>Status:</b> ${data.status}`); // Append status to message
                    } else {
                        showSuccess(data.message);
                    }
                } else {
                    showError(data.error || 'Verification failed. Please try again.'); // Display error message from API or generic error
                }

            } catch (error) {
                showError('An error occurred during verification. Please check your connection and try again.'); // Generic error for network issues etc.
                console.error('API Error:', error); // Log error for debugging
            } finally {
                submitBtn.disabled = false;
                spinner.style.display = 'none';
                submitBtn.querySelector('span').textContent = 'Verify Document';
                form.reset(); // Reset the form after submission (clears file input)
                fileInfo.innerHTML = ''; // Clear file info display
            }
        }

        function showSuccess(message) {
            statusMessage.className = 'status-message success active';
            statusMessage.innerHTML = `
                <i data-feather="check-circle"></i>
                <div class="message-content">${message}</div>
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

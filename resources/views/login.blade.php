<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PHP Demo App - Simplified Login</title>
    <style>
        /* --- Reset and Global Styles --- */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #0a1128;
            /* Dark Blue Background - Avanz Style */
            color: #e0e0e0;
            /* Light Grey text for general readability */
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* Center content vertically */
            min-height: 100vh;
        }

        .container {
            background-color: #f9f9f9;
            /* Very Light Grey Container Background */
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
            /* Reduced max width for single column */
            margin-top: 30px;
            padding: 30px;
            /* Increased padding for better spacing in single column */
            box-sizing: border-box;
            text-align: center;
            /* Center align content in container */
        }

        /* --- Header Section --- */
        .header {
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
        }

        .header-logo {
            font-size: 2.8em;
            color: #2563eb;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-tagline {
            font-size: 1em;
            color: #6b7280;
            margin-top: 0;
        }

        /* --- Main Content Area (Single Column now) --- */
        .main-content {
            width: 100%;
            /* Main content takes full container width */
        }

        /* --- Login Form Section (Now the only column) --- */
        .login-form-section {
            max-width: 100%;
            /* Allow login form to take full width */
            margin: 0 auto;
            /* Center login form if needed */
        }

        .login-form-section h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.8em;
            /* Slightly larger heading for focus */
            color: #374151;
            /* Dark grey heading color */
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 1em;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .form-actions {
            text-align: center;
            margin-top: 20px;
        }

        .login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 30px;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            font-size: 1.1em;
        }

        .login-button:hover {
            background-color: #1d4ed8;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 8px;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #0694a2;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .register-section {
            text-align: center;
            margin-top: 20px;
        }

        .register-text {
            font-size: 0.95em;
            color: #4a5568;
            margin-bottom: 10px;
        }

        .register-button {
            display: inline-block;
            padding: 10px 25px;
            background-color: #e0e7ff;
            color: #1e3a8a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }

        .register-button:hover {
            background-color: #c3dafe;
        }

        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #718096;
            margin: 25px 0;
        }

        .or-divider::before,
        .or-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #cbd5e0;
            margin: 0 15px;
        }

        .affinidi-login-button-container {
            text-align: center;
            margin-bottom: 20px;
            margin: 0 auto;
        }

        .affinidi-login-dark-l {
            /*  --- AFFINIDI LOGIN BUTTON STYLES - ORIGINAL CSS --- */
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

        /* --- Footer Section --- */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 0.9em;
            color: #718096;
            margin-top: 30px;
            width: 100%;
        }

        .footer a {
            color: #0694a2;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* --- Responsive Design (adjust container for smaller screens) --- */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
                margin-top: 20px;
            }
        }

        @media (max-width: 500px) {
            .container {
                width: 100%;
                margin-top: 10px;
                border-radius: 0;
                box-shadow: none;
            }

            .header-logo {
                font-size: 2.2em;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container">
        <header class="header">
            <h1 class="header-logo">Affinidi <span style="color:#3b82f6;">Reference App</span></h1>
            <p class="header-tagline">Unlock Potential of Decentralised Technology</p>
        </header>

        <main class="main-content">
            <div class="login-form-section">
                <h2>Login</h2>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                </div>
                <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
                <div class="form-actions">
                    <button type="submit" class="login-button">
                        LOGIN <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </button>
                </div>


                <div class="register-section">
                    <p class="register-text">Don't have an account?</p>
                    <a href="/register" class="register-button">REGISTER NOW</a>
                </div>

                <div class="or-divider">OR</div>

                <div class="affinidi-login-button-container">
                    <a class="affinidi-login-dark-l" href="/login/affinidi">
                        Affinidi Login
                    </a>
                </div>


            </div>
        </main>
    </div>

    <footer class="footer">
        <p>Drop us a note to learn more at <a href="mailto:support@affinidi.com">support@affinidi.com</a> </p>
        <p>&copy; 2025 Affinidi Private Limited. All rights reserved.</p>
    </footer>

</body>

</html>
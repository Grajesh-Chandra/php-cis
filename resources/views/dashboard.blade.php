<!DOCTYPE html>
<html>

<head>
    <title>Laravel Dashboard</title>
    <style>
        /* Intuitive Design Styles - Consistent with CIS & Demo App Pages */
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
            max-width: 700px;
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

        .alert-success {
            background-color: #e6f9ec;
            color: #155724;
            border-color: #bef2c4;
        }

        .alert-danger {
            background-color: #fdecea;
            color: #991b1b;
            border-color: #fcc2c3;
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


        .dashboard-alert-success {
            background-color: #e6f9ec;
            /* Light green background for success - consistent */
            color: #155724;
            /* Dark green text for success - consistent */
            border-color: #bef2c4;
            /* Green border - consistent */
            padding: 20px;
            /* Consistent padding with other alerts */
            border-radius: 8px;
            /* Consistent rounded corners with other alerts */
            margin-bottom: 20px;
            /* Consistent margin with other alerts */
            text-align: center;
            /* Keep text centered */
            font-weight: 500;
            /* Consistent font weight */
            border-width: 1px;
            /* Consistent border width */
        }


        .logout-button {
            /* Button style for Logout - similar to Explore Links buttons */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #6b7280;
            /* Grey color for Logout button */
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
            /* Add some top margin to separate from welcome text */
            width: auto;
            /* Adjust width to content */
            display: inline-block;
            /* To allow width: auto to work if needed */
        }

        .logout-button:hover {
            background-color: #4a5568;
            /* Darker grey on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logout-button:active {
            background-color: #374151;
            /* Even darker grey on active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .explore-links {
            margin-top: 30px;
            /* Add margin above explore links section */
        }

        .explore-links a {
            /* Button style for Explore Links - using iota-button style for consistency */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background-color: #0694a2;
            /* Teal color for buttons */
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
            /* Spacing between links */
        }

        .explore-links a:hover {
            background-color: #047a85;
            /* Darker teal on hover */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .explore-links a:active {
            background-color: #03606b;
            /* Even darker teal on active */
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
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
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header-body">
            <h1>Dashboard</h1>
            <a href="/" class="home-button-enhanced">Home</a>
        </div>

        <div class="card-body">
            <div class="dashboard-alert-success">
                Congratulations, your login was successful!
            </div>
            <h3>Welcome <i>{{ session("user")['email'] }}</i></h3>
        </div>

        <div class="card-body">
            <a class="logout-button" href="/logout">
                Logout
            </a>
        </div>

        <div class="card-body">
            <h2 class="h4 mb-1">Explore More</h2>
            <hr class="mt-2">
            <div class="explore-links">
                <a href="/cis">
                    Affinidi Credential Issuance
                </a>
                <a href="/iota">
                    Affinidi Iota Framework
                </a>
            </div>
        </div>
    </div>
</body>

</html>
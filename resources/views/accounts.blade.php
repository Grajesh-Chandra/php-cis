<!DOCTYPE html>
<html>

<head>
    <title>Laravel Dashboard - Services Menu</title>
    <style>
        /* Intuitive Design Styles - Consistent & with Menu */
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

        .dashboard-container {
            background-color: #ffffff;
            padding: 30px;
            /* Slightly reduced padding for overall container */
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            width: 95%;
            /* Wider container to accommodate menu */
            max-width: 900px;
            /* Increased max width for menu and content */
            box-sizing: border-box;
            margin-top: 30px;
            /* Slightly reduced top margin */
            margin-bottom: 30px;
            /* Slightly reduced bottom margin */
            display: flex;
            flex-direction: column;
            /* Stack header, menu, and content */
            align-items: stretch;
            /* Stretch items to container width */
        }

        /* --- Dashboard Header Section --- */
        .dashboard-header {
            text-align: left;
            /* Align header text to the left */
            margin-bottom: 20px;
            /* Reduced header margin */
            display: flex;
            justify-content: space-between;
            /* Space out title and logout button */
            align-items: center;
            /* Vertically align title and button */
        }

        .dashboard-header h1 {
            font-size: 2.0rem;
            /* Slightly smaller main heading */
            color: #374151;
            margin-bottom: 0;
            /* Remove bottom margin for title */
            font-weight: 700;
        }

        /* --- Logout Button (in Header) --- */
        .logout-button-header {
            /* Logout button style - adjusted for header */
            padding: 10px 20px;
            /* Smaller padding for header button */
            background-color:rgb(118, 156, 233);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            /* Smaller font size for header button */
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            /* Subtle shadow for header button */
        }

        .logout-button-header:hover {
            background-color: #4a5568;
            transform: translateY(-1px);
            /* Less lift on hover for header button */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .logout-button-header:active {
            background-color: #374151;
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }


        /* --- Main Content Card --- */
        .card-body {
            padding: 30px;
            /* Padding for content area */
            text-align: center;
            background-color: #ffffff;
            /* White background for content card */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            /* Lighter shadow for content card */
        }

        hr.mt-2 {
            border: 0;
            border-top: 2px solid #e0e0e0;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .dashboard-alert-success {
            background-color: #e6f9ec;
            color: #155724;
            border-color: #bef2c4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            border-width: 1px;
        }

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .dashboard-container {
                width: 98%;
                /* Adjust container width on smaller screens */
                padding: 20px;
                /* Adjust padding on smaller screens */
                margin-top: 20px;
                margin-bottom: 20px;
                border-radius: 0;
                /* Remove border-radius for full-width on small screens */
                box-shadow: none;
                /* Remove shadow for full-width on small screens */
            }

            .dashboard-header {
                flex-direction: column;
                /* Stack header items vertically */
                text-align: center;
                /* Center header text on small screens */
                align-items: center;
                /* Center items in header */
            }

            .dashboard-header h1 {
                margin-bottom: 10px;
                /* Add a bit of margin below title when stacked */
                font-size: 1.8rem;
                /* Smaller header font on small screens */
            }

            .services-menu ul {
                flex-direction: column;
                /* Stack menu items vertically on small screens */
                text-align: center;
                /* Center align menu items */
                gap: 10px;
                /* Reduce gap between stacked menu items */
            }

            .services-menu a {
                padding: 10px 15px;
                /* Adjust padding for stacked menu items */
            }

            .card-body {
                padding: 20px;
                /* Adjust card body padding on smaller screens */
            }
        }

        @media (max-width: 500px) {
            .dashboard-container {
                padding: 15px;
                /* Even smaller padding for very small screens */
                margin-top: 15px;
                margin-bottom: 15px;
            }

            .dashboard-header h1 {
                font-size: 1.6rem;
                /* Even smaller header font on very small screens */
            }

            .services-menu a {
                font-size: 0.95rem;
                /* Slightly smaller font in menu on very small screens */
                padding: 8px 12px;
                /* Adjust menu item padding for very small screens */
            }

            .card-body {
                padding: 15px;
                /* Even smaller card body padding on very small screens */
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Account Details</h1>
            <a href="/home" class="logout-button-header">Home</a>
        </div>


        <div class="card-body">
            <div class="dashboard-alert-success">
                Congratulations, your login was successful!
            </div>
            <h3>Welcome <i>{{ session("user")['email'] }}</i></h3>
        </div>

    </div>
</body>

</html>
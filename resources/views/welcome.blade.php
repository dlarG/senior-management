<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizen Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        header {
            background-color: #fff;
            color: #333;
            padding: 20px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #007bff;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        nav li {
            margin-left: 20px;
        }

        nav a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #007bff;
        }

        .hero {
            background: linear-gradient(135deg, #e0f7fa 0%, #c5e1e6 100%);
            color: #333;
            padding: 80px 30px;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #007bff;
        }

        .hero p {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 30px;
        }

        .hero .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .hero .button:hover {
            background-color: #0056b3;
        }

        .features {
            padding: 60px 30px;
            text-align: center;
            background-color: #fff;
        }

        .features h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #333;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .feature-item {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            text-align: left;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .feature-item h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #007bff;
        }

        .feature-item p {
            color: #666;
        }

        .cta {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 80px 30px;
        }

        .cta h2 {
            font-size: 2.5em;
            margin-bottom: 30px;
        }

        .cta p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .cta .button {
            background-color: white;
            color: #28a745;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .cta .button:hover {
            background-color: #218838;
            color: white;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            width: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            header {
                padding: 15px;
            }

            .logo {
                font-size: 1.2em;
            }

            nav ul {
                flex-direction: column;
                align-items: flex-end;
            }

            nav li {
                margin: 10px 0;
            }

            .hero {
                padding: 60px 20px;
            }

            .hero h1 {
                font-size: 2.2em;
            }

            .hero p {
                font-size: 1em;
            }

            .features {
                padding: 40px 20px;
            }

            .features h2 {
                font-size: 2em;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }

            .feature-item {
                padding: 20px;
            }

            .cta {
                padding: 60px 20px;
            }

            .cta h2 {
                font-size: 2em;
            }

            .cta p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">SCMS</div>
        <nav>
            <ul>
                <li><a href="#features">Features</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="{{ route('login') }}" class="button">Login</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Senior Citizen Management in Your Barangay</h1>
            <p>Our system provides an efficient and user-friendly way to manage senior citizen records, track important updates, and organize community programs.</p>
            <a href="#features" class="button">Learn More</a>
        </div>
    </section>

    <section id="features" class="features">
        <h2>Explore Our Powerful Features</h2>
        <ul class="feature-list">
            <li class="feature-item">
                <h3>Centralized Database</h3>
                <p>Maintain a secure and easily accessible database of all senior citizens.</p>
            </li>
            <li class="feature-item">
                <h3>Deceased Tracking</h3>
                <p>Efficiently record and manage information about deceased senior citizens.</p>
            </li>
            <li class="feature-item">
                <h3>Program Organization</h3>
                <p>Plan, manage, and track participation in various senior citizen programs.</p>
            </li>
            <li class="feature-item">
                <h3>Simple Data Updates</h3>
                <p>Update and modify records quickly with an intuitive interface.</p>
            </li>
            <li class="feature-item">
                <h3>Insightful Reporting (Future)</h3>
                <p>Generate valuable reports on senior citizen demographics and program engagement (coming soon).</p>
            </li>
            <li class="feature-item">
                <h3>Data Security</h3>
                <p>Protect sensitive information with robust security measures.</p>
            </li>
        </ul>
    </section>

    <section id="cta" class="cta">
        <h2>Ready to Transform Your Barangay's Approach?</h2>
        <p>Discover how the Senior Citizen Management System can streamline your operations and better serve your community.</p>
        <a href="#contact" class="button">Contact Us</a>
    </section>

    <footer id="contact">
        <p>&copy; 2025 Senior Citizen Management System - Hilongos, Eastern Visayas</p>
    </footer>

    <script>
        
        document.querySelector('.cta .button').addEventListener('click', function(event) {
            alert("Thank you for your interest! Please reach out to ortizanothrezamae@gmail.com for more details.");
            event.preventDefault();
        });
    </script>
</body>
</html>
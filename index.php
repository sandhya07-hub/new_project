<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FraudCheck</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"> 

    <style>
        :root {
            --primary-color: #7c3aed; /* light purple */
            --primary-hover: #6d28d9;
            --bg-color: #f3f4f6;
            --text-main: #111827;
            --text-muted: #6b7280;
            --radius: 12px;
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* HERO SECTION */
        .hero {
            max-width: 1100px;
            width: 100%;
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        /* TEXT */
        .hero-text h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            animation: fadeIn 0.6s ease forwards;
        }

        .hero-text h1 span {
            color: var(--primary-color);
        }

        .hero-text p {
            font-size: 1.125rem;
            color: var(--text-muted);
            max-width: 480px;
            margin-bottom: 2rem;
        }

        /* BUTTON */
        .hero-buttons {
            display: flex;
        }

        .btn {
            text-decoration: none;
            padding: 0.9rem 2.2rem;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            background: var(--primary-color);
            color: white;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        /* IMAGE - vertical floating animation */
        .hero-img img {
            width: 100%;
            max-width: 460px;
            margin-left: auto;
            display: block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            25% {
                transform: translateY(-20px);
            }
        }
        

        /* Fade-in animation */
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

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-img img {
                margin: 2rem auto 0;
            }
        }
    </style>
</head>

<body>

    <div class="hero">
        <div class="hero-text">
            <h1><span>Assignment Problem</span>  Hungarian Method</h1>
            <p>
                Solve the assignment problem using the Hungarian Method by reducing the cost matrix, covering all zeros with the minimum number of lines, and determining the optimal assignment.
            </p>
            <form action='matrix.php' method='post'>
                <div class="hero-buttons">
                    <input type="submit" class="btn start" value="Start">
                </div>
            </form>
        </div>

        <div class="hero-img">
            <img src="h.png" alt="Fraud Detection Illustration">
        </div>
    </div>

</body>

</html>



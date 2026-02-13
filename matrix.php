<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment Problem Solver</title>
    <style>
        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            --primary-color: #7c3aed; /* Light purple / violet */
            --primary-hover: #6d28d9;
            --bg-color: #f5f3ff; /* Light purple background */
            --card-bg: #ffffff;
            --text-main: #1e1b4b;
            --text-muted: #6b7280;
            --border-color: #ddd6fe;
            --radius: 12px;
            --shadow-md: 0 4px 6px rgba(124, 58, 237, 0.1);
            --shadow-lg: 0 10px 25px rgba(124, 58, 237, 0.08);
        }

        /* Reset & Body */
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
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Input box */
        .box {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.6s ease forwards;
        }

        .box label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .box input {
            width: 60px;
            padding: 0.5rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.3s;
        }

        .box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(124, 58, 237, 0.3);
            outline: none;
        }

        .box button {
            margin-top: 1rem;
            padding: 0.6rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-md);
        }

        .box button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Matrix Table */
        table {
            width: 100%;
            max-width: 500px;
            border-collapse: collapse;
            margin: 1rem auto;
            animation: fadeInUp 0.6s ease forwards;
        }

        table th, table td {
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            text-align: center;
        }

        table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        table input {
            width: 60px;
            padding: 0.4rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            text-align: center;
            transition: all 0.3s;
        }

        table input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(124, 58, 237, 0.3);
            outline: none;
        }

        /* Solve Button */
        #solveBtn {
            display: inline-block;
            padding: 0.6rem 1.5rem;
            background: #c4b5fd; /* lighter purple */
            color: var(--text-main);
            font-weight: 600;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.3s;
            box-shadow: var(--shadow-md);
        }

        #solveBtn:hover {
            background: #a78bfa;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 600px) {
            .box, table {
                width: 100%;
            }

            table input {
                width: 40px;
            }
        }
    </style>

    <script>
        function generateMatrix() {
            const jobs = document.getElementById("jobs").value;
            const workers = document.getElementById("workers").value;
            const matrixArea = document.getElementById("matrixArea");
            matrixArea.innerHTML = "";

            if (jobs < 1 || workers < 1 || jobs > 6 || workers > 6) {
                alert("Please enter values between 1 and 6");
                return;
            }

            const size = Math.min(jobs, workers);

            let table = "<table><tr><th></th>";

            for (let j = 0; j < size; j++) {
                table += `<th>J${j + 1}</th>`;
            }
            table += "</tr>";

            for (let i = 0; i < size; i++) {
                table += `<tr><th>W${i + 1}</th>`;
                for (let j = 0; j < size; j++) {
                    table += `<td><input type="number" name="cost[${i}][${j}]" required></td>`;
                }
                table += "</tr>";
            }

            table += "</table>";
            matrixArea.innerHTML = table;

            document.getElementById("solveBtn").style.display = "inline-block";
        }
    </script>
</head>

<body>

    <h1>Assignment Problem Using Hungarian Algorithm</h1>

    <div class="box">
        <label for="workers">Enter number of predecessors (W):</label>
        <input type="number" id="workers" min="1" max="6" value="3">

        <br><br>

        <label for="jobs">Enter number of activities (J):</label>
        <input type="number" id="jobs" min="1" max="6" value="3">

        <br><br>

        <button type="button" onclick="generateMatrix()">Generate Matrix</button>
    </div>

    <form method="post" action="solve.php">
        <div id="matrixArea"></div>
        <br>
        <button type="submit" id="solveBtn" style="display:none;">
            Solve Assignment Problem
        </button>
    </form>

</body>
</html>

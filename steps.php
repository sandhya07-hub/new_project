<?php
session_start();

if (!isset($_SESSION['cost'])) {
    header("Location: index.html");
    exit();
}

$originalCost = $_SESSION['cost'];
$cost = $_SESSION['cost'];
$n = count($cost);

function printMatrix($matrix, $title) {
    echo "<div class='matrix-container'>";
    echo "<h3>$title</h3>";
    echo "<table class='matrix-table'>";
    foreach ($matrix as $row) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hungarian Method Step-by-Step</title>

<style>
/* Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* Variables */
:root {
    --primary-color: #7c3aed;
    --primary-hover: #6d28d9;
    --bg-color: #f5f3ff;
    --card-bg: #ffffff;
    --text-main: #1e1b4b;
    --text-muted: #6b7280;
    --border-color: #ddd6fe;
    --radius: 12px;
    --shadow-md: 0 4px 6px rgba(124, 58, 237, 0.1);
    --shadow-lg: 0 10px 25px rgba(124, 58, 237, 0.08);
}

/* General Body */
body {
    background-color: var(--bg-color);
    color: var(--text-main);
    font-family: 'Inter', system-ui, sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
    min-height: 100vh;
}

h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
    color: var(--primary-color);
    animation: fadeIn 0.6s ease forwards;
}

h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--primary-color);
    animation: fadeIn 0.5s ease forwards;
}

/* Matrix Container */
.matrix-container {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    padding: 1rem 1.5rem;
    margin: 1rem 0;
    width: 90%;
    max-width: 500px;
    animation: fadeInUp 0.6s ease forwards;
}

.matrix-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

.matrix-table td {
    border: 1px solid var(--border-color);
    padding: 0.5rem;
    font-weight: 500;
    transition: background 0.3s;
}

.matrix-table td:hover {
    background: rgba(124, 58, 237, 0.1);
    border-color: var(--primary-color);
}

/* Back Button */
a {
    margin-top: 2rem;
    display: inline-block;
    text-decoration: none;
    padding: 0.7rem 1.8rem;
    background-color: var(--primary-color);
    color: white;
    font-weight: 600;
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    transition: all 0.3s;
    animation: fadeIn 0.8s ease forwards;
}

a:hover {
    background-color: var(--primary-hover);
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

@media (max-width: 600px) {
    .matrix-container, a {
        width: 95%;
    }
    h2 {
        font-size: 1.5rem;
    }
}
</style>

</head>
<body>

<h2>Step-by-Step Solution (Hungarian Method)</h2>

<?php
/* Original Matrix */
printMatrix($cost, "Original Cost Matrix");

/* Step 1: Row Reduction */
for ($i = 0; $i < $n; $i++) {
    $min = min($cost[$i]);
    for ($j = 0; $j < $n; $j++) {
        $cost[$i][$j] -= $min;
    }
}
printMatrix($cost, "After Row Reduction");

/* Step 2: Column Reduction */
for ($j = 0; $j < $n; $j++) {
    $min = min(array_column($cost, $j));
    for ($i = 0; $i < $n; $i++) {
        $cost[$i][$j] -= $min;
    }
}
printMatrix($cost, "After Column Reduction");

/* Step 3: Cover Zeros & Adjust Matrix */
$iteration = 1;
while (true) {
    echo "<h3>Zero Covering Iteration $iteration</h3>";

    $rowCovered = array_fill(0, $n, false);
    $colCovered = array_fill(0, $n, false);

    $zeroCountRow = [];
    for ($i = 0; $i < $n; $i++) $zeroCountRow[$i] = count(array_filter($cost[$i], fn($v) => $v == 0));

    $zeroCountCol = [];
    for ($j = 0; $j < $n; $j++) {
        $zeroCountCol[$j] = 0;
        for ($i = 0; $i < $n; $i++) if ($cost[$i][$j] == 0) $zeroCountCol[$j]++;
    }

    while (max($zeroCountRow) > 0 || max($zeroCountCol) > 0) {
        if (max($zeroCountRow) >= max($zeroCountCol)) {
            $r = array_search(max($zeroCountRow), $zeroCountRow);
            $rowCovered[$r] = true;
            for ($j = 0; $j < $n; $j++) if ($cost[$r][$j] == 0) $zeroCountCol[$j]--;
            $zeroCountRow[$r] = 0;
        } else {
            $c = array_search(max($zeroCountCol), $zeroCountCol);
            $colCovered[$c] = true;
            for ($i = 0; $i < $n; $i++) if ($cost[$i][$c] == 0) $zeroCountRow[$i]--;
            $zeroCountCol[$c] = 0;
        }
    }

    $linesUsed = count(array_filter($rowCovered)) + count(array_filter($colCovered));
    echo "<p><b>Lines used:</b> $linesUsed</p>";

    if ($linesUsed >= $n) { echo "<p><b>Enough lines to make assignment.</b></p>"; break; }

    $minUncovered = PHP_INT_MAX;
    for ($i = 0; $i < $n; $i++)
        for ($j = 0; $j < $n; $j++)
            if (!$rowCovered[$i] && !$colCovered[$j]) $minUncovered = min($minUncovered, $cost[$i][$j]);

    for ($i = 0; $i < $n; $i++)
        for ($j = 0; $j < $n; $j++)
            if (!$rowCovered[$i] && !$colCovered[$j]) $cost[$i][$j] -= $minUncovered;
            elseif ($rowCovered[$i] && $colCovered[$j]) $cost[$i][$j] += $minUncovered;

    printMatrix($cost, "Matrix After Adjustment");
    $iteration++;
}

function printZeroCoverTable($cost, $rowCovered, $colCovered) {
    $n = count($cost);

    echo "<div class='matrix-container'>";
    echo "<h3>Zero Coverage (Minimum Lines)</h3>";
    echo "<table class='matrix-table'>";
    echo "<tr>
            <th>Column</th>
            <th>Rows Having Zero</th>
            <th>Column Covered</th>
          </tr>";

    for ($j = 0; $j < $n; $j++) {
        $rows = [];
        for ($i = 0; $i < $n; $i++) {
            if ($cost[$i][$j] == 0) {
                $rows[] = "R" . ($i + 1);
            }
        }

        echo "<tr>";
        echo "<td>C" . ($j + 1) . "</td>";
        echo "<td>" . (empty($rows) ? "-" : implode(", ", $rows)) . "</td>";
        echo "<td>" . ($colCovered[$j] ? "Yes" : "No") . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}


 $linesUsed = count(array_filter($rowCovered)) + count(array_filter($colCovered));
echo "<p><b>Lines used:</b> $linesUsed</p>";

printZeroCoverTable($cost, $rowCovered, $colCovered);

if ($linesUsed >= $n) {
    echo "<p><b>Enough lines to make assignment.</b></p>";
    
}


/* Back Button */
echo "<a href='solve.php'>⬅ Back to Result</a>";
?>

</body>
</html>



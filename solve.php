<?php
session_start();

/* Get cost matrix */
if (!isset($_POST['cost'])) {
    die("No cost matrix provided.");
}

$originalCost = $_POST['cost'];
$cost = $_POST['cost'];
$n = count($cost);

/* Store matrix for steps page */
$_SESSION['cost'] = $originalCost;

/* =====================
   STEP 1: Row Reduction
   ===================== */
for ($i = 0; $i < $n; $i++) {
    $min = min($cost[$i]);
    for ($j = 0; $j < $n; $j++) {
        $cost[$i][$j] -= $min;
    }
}

/* =======================
   STEP 2: Column Reduction
   ======================= */
for ($j = 0; $j < $n; $j++) {
    $min = min(array_column($cost, $j));
    for ($i = 0; $i < $n; $i++) {
        $cost[$i][$j] -= $min;
    }
}

/* =================================================
   STEP 3: Cover all zeros with minimum number of lines
   ================================================= */
while (true) {

    $rowCovered = array_fill(0, $n, false);
    $colCovered = array_fill(0, $n, false);

    $zeroCountRow = [];
    for ($i = 0; $i < $n; $i++) {
        $zeroCountRow[$i] = count(array_filter($cost[$i], fn($v) => $v == 0));
    }

    $zeroCountCol = [];
    for ($j = 0; $j < $n; $j++) {
        $zeroCountCol[$j] = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($cost[$i][$j] == 0) $zeroCountCol[$j]++;
        }
    }

    while (max($zeroCountRow) > 0 || max($zeroCountCol) > 0) {

        if (max($zeroCountRow) >= max($zeroCountCol)) {
            $r = array_search(max($zeroCountRow), $zeroCountRow);
            $rowCovered[$r] = true;
            for ($j = 0; $j < $n; $j++) {
                if ($cost[$r][$j] == 0) $zeroCountCol[$j]--;
            }
            $zeroCountRow[$r] = 0;
        } else {
            $c = array_search(max($zeroCountCol), $zeroCountCol);
            $colCovered[$c] = true;
            for ($i = 0; $i < $n; $i++) {
                if ($cost[$i][$c] == 0) $zeroCountRow[$i]--;
            }
            $zeroCountCol[$c] = 0;
        }
    }

    $linesUsed = count(array_filter($rowCovered)) + count(array_filter($colCovered));

    if ($linesUsed >= $n) break;

    $minUncovered = PHP_INT_MAX;
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            if (!$rowCovered[$i] && !$colCovered[$j]) {
                $minUncovered = min($minUncovered, $cost[$i][$j]);
            }
        }
    }

    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            if (!$rowCovered[$i] && !$colCovered[$j]) {
                $cost[$i][$j] -= $minUncovered;
            } elseif ($rowCovered[$i] && $colCovered[$j]) {
                $cost[$i][$j] += $minUncovered;
            }
        }
    }
}

/* =====================
   STEP 4: Proper Hungarian Assignment
   ===================== */

$assignedJobs = array_fill(0, $n, -1);   // Row → Column
$assignedCols = array_fill(0, $n, -1);   // Column → Row

function tryAssign($row, &$cost, &$assignedJobs, &$assignedCols, &$visited, $n) {
    for ($col = 0; $col < $n; $col++) {
        if ($cost[$row][$col] == 0 && !$visited[$col]) {
            $visited[$col] = true;

            if ($assignedCols[$col] == -1 ||
                tryAssign($assignedCols[$col], $cost, $assignedJobs, $assignedCols, $visited, $n)) {

                $assignedJobs[$row] = $col;
                $assignedCols[$col] = $row;
                return true;
            }
        }
    }
    return false;
}

for ($i = 0; $i < $n; $i++) {
    $visited = array_fill(0, $n, false);
    tryAssign($i, $cost, $assignedJobs, $assignedCols, $visited, $n);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assignment Problem Result</title>
<style>
/* === YOUR ORIGINAL CSS (UNCHANGED) === */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
:root {
    --primary-color: #7c3aed;
    --primary-hover: #6d28d9;
    --bg-color: #f5f3ff;
    --card-bg: #ffffff;
    --text-main: #1e1b4b;
    --radius: 12px;
    --shadow-md: 0 4px 6px rgba(124, 58, 237, 0.1);
    --shadow-lg: 0 10px 25px rgba(124, 58, 237, 0.08);
}
body {
    background-color: var(--bg-color);
    font-family: 'Inter', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
}
.assignment-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    padding: 1rem 1.5rem;
    margin: 0.5rem 0;
    width: 300px;
    text-align: center;
    font-weight: 600;
}
.total-cost {
    font-size: 1.2rem;
    font-weight: 700;
    margin-top: 1.5rem;
}
</style>
</head>
<body>

<h2>Optimal Assignment</h2>

<?php
$totalCost = 0;

for ($i = 0; $i < $n; $i++) {
    if ($assignedJobs[$i] != -1) {
        $j = $assignedJobs[$i];
        echo "<div class='assignment-card'>Worker W" . ($i + 1) .
             " → Job J" . ($j + 1) . "</div>";
        $totalCost += $originalCost[$i][$j];
    }
}
?>

<div class="total-cost">
    Minimum Total Cost: <?php echo $totalCost; ?>
</div>

<form action='steps.php' method='post'>
    <button type='submit'>View Step-by-Step Process</button>
</form>

</body>
</html>


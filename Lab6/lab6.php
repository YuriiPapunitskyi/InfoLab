<?php

function readDataFromFile($filename) {
    if (!file_exists($filename)) {
        die("File $filename isn't opened. Check the placement of this file!\n");
    }

    $data = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map('floatval', $data);
}

function calculateStatistics($data) {
    $n = count($data);
    $mean = array_sum($data) / $n;

    $sumSquares = array_reduce($data, function ($carry, $value) use ($mean) {
        return $carry + pow($value - $mean, 2);
    }, 0);

    $variance = $sumSquares / ($n - 1);
    return [$mean, $variance, $n];
}

echo "Enter name of file with source data for the group number 1: ";
$filename1 = __DIR__ . '/' . trim(fgets(STDIN));
$data1 = readDataFromFile($filename1);

echo "Enter name of file with source data for the group number 2: ";
$filename2 = __DIR__ . '/' . trim(fgets(STDIN));
$data2 = readDataFromFile($filename2);

echo "Enter name of file for results data: ";
$resultFilename = __DIR__ . '/' . trim(fgets(STDIN));

list($mx, $Dx, $n1) = calculateStatistics($data1);
list($my, $Dy, $n2) = calculateStatistics($data2);

if ($Dx < 0 || $Dy < 0) {
    die("Error: Negative variance detected. Check your input data.\n");
}

$t_criter_stud = abs($mx - $my) / sqrt($Dx / $n1 + $Dy / $n2);

echo "Enter alfa: ";
$alfa = floatval(trim(fgets(STDIN)));

echo "Enter critical value of Student coefficient: ";
$t_alfa = floatval(trim(fgets(STDIN)));

$result = "The results for alfa = $alfa:\n";
$result .= "The coefficient of Student = $t_criter_stud\n";
$result .= "The critical coefficient of Student = $t_alfa\n";

if ($t_criter_stud >= $t_alfa) {
    $result .= "For alfa = $alfa the difference exists.\n";
} else {
    $result .= "For alfa = $alfa the difference doesn't exist.\n";
}

file_put_contents($resultFilename, $result);

echo "Finish! You can see all results in $resultFilename\n";

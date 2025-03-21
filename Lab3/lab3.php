<?php

$x = [];
$y = [];
$sx = $sx2 = $sy = $sy2 = $sxy = 0;

$filename = __DIR__ . "/stat1.dan";
if (!file_exists($filename)) {
    die("File $filename is not opened\n");
}

$file = fopen($filename, "r");
if (!$file) {
    die("Error opening file\n");
}

$N = 0;
while (($line = fgets($file)) !== false) {
    list($x_val, $y_val) = sscanf($line, "%lf %lf");
    $x[] = $x_val;
    $y[] = $y_val;
    $sx += $x_val;
    $sx2 += pow($x_val, 2);
    $sy += $y_val;
    $sy2 += pow($y_val, 2);
    $sxy += $x_val * $y_val;
    $N++;
}

fclose($file);

if ($N < 2) {
    die("Not enough data to calculate statistics\n");
}

$mx = $sx / $N;
$my = $sy / $N;
$Dx = ($sx2 - $sx * $sx / $N) / ($N - 1);
$Dy = ($sy2 - $sy * $sy / $N) / ($N - 1);
$sigx = sqrt($Dx);
$sigy = sqrt($Dy);
$Rxy = ($sxy - $sx * $sy / $N) / ($N - 1);

if ($sigx * $sigy != 0) {
    $rxy = $Rxy / ($sigx * $sigy);
    printf("mx=%lg my=%lg sigx=%lg sigy=%lg rxy=%lg\n", $mx, $my, $sigx, $sigy, $rxy);
} else {
    printf("denominator = 0 for sigx=%lg sigy=%lg\n", $sigx, $sigy);
}

<?php
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "movie";
$sql = "SELECT Frequency, Title FROM movies ORDER BY Frequency DESC LIMIT 10";
$conn = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password);
try {
  $conn = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare($sql);
  $stmt->execute();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}


$result = $conn->query($sql);
$data = array();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $data[$row['Title']] = $row['Frequency'];
}


  
$imageWidth = 1680;
$imageHeight = 1050;

$gridTop = 40;
$gridBottom = 1000;
$gridHeight = $gridBottom - $gridTop;

$gridLeft = 50;
$gridRight = 1100;
$gridWidth = $gridRight - $gridLeft;

$lineWidth = 5;
$barWidth = 50;
$font = 'C:\xampp\htdocs\Project\OpenSans-Regular.ttf';
$fontSize = 10;

$labelMargin = 8;
$yMaxValue = 40;
$yLabelSpan = 5;
$chart = imagecreate($imageWidth, $imageHeight);
$backgroundColor = imagecolorallocate($chart, 255, 255, 255);
$axisColor = imagecolorallocate($chart, 85, 85, 85);
$labelColor = $axisColor;
$gridColor = imagecolorallocate($chart, 212, 212, 212);
$barColor = imagecolorallocate($chart, 47, 133, 217);
imagefill($chart, 0, 0, $backgroundColor);

imagesetthickness($chart, $lineWidth);
for($i = 0; $i <= $yMaxValue; $i += $yLabelSpan) {
    $y = $gridBottom - $i * $gridHeight / $yMaxValue;

    // draw the line
    imageline($chart, $gridLeft, $y, $gridRight, $y, $gridColor);

    // draw right aligned label
    $labelBox = imagettfbbox($fontSize, 0, $font, strval($i));
    $labelWidth = $labelBox[4] - $labelBox[0];

    $labelX = $gridLeft - $labelWidth - $labelMargin;
    $labelY = $y + $fontSize / 2;

    imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, strval($i));
}
imageline($chart, $gridLeft, $gridTop, $gridLeft, $gridBottom, $axisColor);
imageline($chart, $gridLeft, $gridBottom, $gridRight, $gridBottom, $axisColor);
$barSpacing = $gridWidth / count($data);
$itemX = $gridLeft + $barSpacing / 2;

foreach($data as $key => $value) {
   
    $x1 = $itemX - $barWidth / 2;
    $y1 = $gridBottom - $value / $yMaxValue * $gridHeight;
    $x2 = $itemX + $barWidth / 2;
    $y2 = $gridBottom - 1;

    imagefilledrectangle($chart, $x1, $y1, $x2, $y2, $barColor);

  
    $labelBox = imagettfbbox($fontSize, 0, $font, $key);
    $labelWidth = $labelBox[4] - $labelBox[0];

    $labelX = $itemX - $labelWidth / 2;
    $labelY = $gridBottom + $labelMargin + $fontSize;

    imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, $key);

    $itemX += $barSpacing;
}


header('Content-Type: image/png');
imagepng($chart);


?>













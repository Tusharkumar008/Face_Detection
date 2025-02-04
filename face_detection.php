<?php
// Load OpenCV module
use CV\{Mat, CascadeClassifier, Scalar, Rect, Point};
use function CV\{imread, cvtColor, imwrite, rectangle};
use const CV\{COLOR_BGR2GRAY, LINE_8};

// Load the Haar Cascade classifier
$faceCascade = new CascadeClassifier();
$haarPath = '/usr/share/opencv4/haarcascades/haarcascade_frontalface_default.xml';

if (!file_exists($haarPath)) {
    die("Error: Haar cascade file not found at $haarPath\n");
}
$faceCascade->load($haarPath);

// Read the input image
$imagePath = __DIR__.'/tests/input.jpeg';

if (!file_exists($imagePath)) {
    die("Error: Input image not found at $imagePath\n");
}

$image = imread($imagePath);

// Check if the image was loaded correctly
if ($image->empty()) {
    die("Error: Image could not be loaded. Check the file format and permissions.\n");
}

// Convert to grayscale
$grayImage = cvtColor($image, COLOR_BGR2GRAY);

// Detect faces
$faces = null;
$faceCascade->detectMultiScale($grayImage, $faces);

// Draw rectangles around detected faces
foreach ($faces as $face) {
    rectangle(
        $image, 
        $face->x,$face->y,
        $face->width,$face->height,
        new Scalar(0,255,0),
        2,
        LINE_8
    );
}

// Save the output image
$outputPath = __DIR__.'public/hello/output.jpeg';
imwrite($outputPath, $image);

echo "Face detection complete. Check $outputPath\n";
?>
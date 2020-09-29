<?php
$image = imagecreatefromjpeg('image.jpg');

imageflip($image, IMG_FLIP_VERTICAL);

header('Content-Type: image/jpeg');
imagejpeg($image);

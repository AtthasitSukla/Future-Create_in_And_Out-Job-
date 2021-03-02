<?php
$imagick = new Imagick();
$imagick->readImage('test.pdf');
$imagick->writeImages('converted.jpg', false);
?>
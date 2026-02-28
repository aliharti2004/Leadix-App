<?php
$path = 'C:/Users/dell/.gemini/antigravity/scratch/leadix-app/public/images/leadix-logo-invoice.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
echo $base64;

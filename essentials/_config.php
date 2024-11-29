<?php
$hostname="festivelearn-prod.cjgy4g2m2zfy.ap-south-1.rds.amazonaws.com";
$database="rapidPanda";
$username="admin";
$password="F357iv3L34rn0684";
$conn=mysqli_connect($hostname, $username, $password);
$db=mysqli_select_db($conn, $database);

date_default_timezone_set('Asia/Kolkata');
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
$hosturl = null;
// S3 client bucket
$s3Key = 'AKIAU72LGM5QOOI7G7FQ';
$s3Secret = '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';

// RAZORPAY API

$razorApiKey = 'rzp_live_ZGGPvIWtp51sHf';
$razorApiSecret = 'ZuksxgcxCjU5ZmUZ2umNE2lY';


// GEMINI API
$geminiApiKey = 'AIzaSyBd3uFsOOcrVqpZfl7c7COG8PQ7DzI-bpk';

// mailtrap
$MailtrapKey = '484e6cff68db0e9573a14fbe6882752a';


?>
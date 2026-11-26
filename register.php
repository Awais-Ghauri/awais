<?php
declare(strict_types=1);
session_start(['cookie_httponly'=>true,'cookie_samesite'=>'Strict','use_strict_mode'=>true]);
header('X-Content-Type-Options: nosniff'); header('Referrer-Policy: same-origin'); header('Cache-Control: no-store');
function done($title,$msg,$ok=false){http_response_code($ok?200:400);$t=htmlspecialchars($title,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');$m=htmlspecialchars($msg,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');echo '<!doctype html><html lang="en"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.$t.'</title><link rel="stylesheet" href="style.css"><body><main class="shell" style="padding-top:12vh"><section class="panel"><h2>'.$t.'</h2><p>'.$m.'</p><p><a class="btn primary" href="index.html">Back To Registration ↗</a> <a class="btn ghost" href="students.php">Student Directory</a></p></section></main></body></html>';exit;}
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.html',true,303);exit;}
$token=$_POST['csrf_token']??'';
if(!is_string($token)||empty($_SESSION['csrf_token'])||!hash_equals($_SESSION['csrf_token'],$token))done('Security Check Failed','Refresh the form and submit again.');
require 'db.php';
$keys=['roll_number','full_name','father_name','email','phone','gender','date_of_birth','department','program','semester','address'];$d=[];
foreach($keys as $k)$d[$k]=trim((string)($_POST[$k]??''));
foreach(['roll_number','full_name','father_name','phone','department','program','semester','address'] as $k)if($d[$k]==='')done('Required Field Missing','Please complete all required fields.');
if(mb_strlen($d['roll_number'])>50||mb_strlen($d['full_name'])>120||mb_strlen($d['father_name'])>120||mb_strlen($d['email'])>190||mb_strlen($d['phone'])>30||mb_strlen($d['address'])>1000)done('Input Too Long','Please check the length of your entries.');
if($d['email']!==''&&!filter_var($d['email'],FILTER_VALIDATE_EMAIL))done('Invalid Email','Enter a valid email address.');
$semester=filter_var($d['semester'],FILTER_VALIDATE_INT);if(!$semester||$semester<1||$semester>12)done('Invalid Semester','Choose a semester from 1 to 12.');
if($d['date_of_birth']!==''){$date=DateTime::createFromFormat('!Y-m-d',$d['date_of_birth']);if(!$date||$date->format('Y-m-d')!==$d['date_of_birth'])done('Invalid Date','Choose a valid date of birth.');}
if(!in_array($d['gender'],['','Male','Female','Other','Prefer not to say'],true))done('Invalid Option','Choose a valid gender option.');
try{$q=$pdo->prepare('INSERT INTO students (roll_number,full_name,father_name,email,phone,gender,date_of_birth,department,program,semester,address) VALUES (:r,:n,:f,:e,:p,:g,:dob,:dep,:prog,:sem,:a)');$q->execute([':r'=>$d['roll_number'],':n'=>$d['full_name'],':f'=>$d['father_name'],':e'=>$d['email']?:null,':p'=>$d['phone'],':g'=>$d['gender']?:null,':dob'=>$d['date_of_birth']?:null,':dep'=>$d['department'],':prog'=>$d['program'],':sem'=>$semester,':a'=>$d['address']]);unset($_SESSION['csrf_token']);done('Registration Successful','The student record was saved to your local database.',true);}
catch(PDOException $e){if($e->getCode()==='23000')done('Roll Number Already Exists','A student with this roll number is already registered.');done('Could Not Save Record','Check the database configuration and try again.');}
?>
<?php
declare(strict_types=1);
session_start(['cookie_httponly'=>true,'cookie_samesite'=>'Strict','use_strict_mode'=>true]);
header('Content-Type: application/json; charset=utf-8'); header('Cache-Control: no-store');
if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32));
echo json_encode(['token'=>$_SESSION['csrf_token']]);
?>
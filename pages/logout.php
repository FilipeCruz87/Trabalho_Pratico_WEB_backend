<?php require_once __DIR__ . '/../db/Database.php';
session_start();
session_destroy();
header('Location: ?p=simulacoes');

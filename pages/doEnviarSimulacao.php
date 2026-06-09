<?php
require_once __DIR__ . '/../db/Database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$db = new Database();

if (!isset($_SESSION['email'])) {
    header('Location: ../index.php?p=login');
    exit;
}

if (!isset($_POST['simulacao_id'])) {
    header('Location: ../index.php?p=simulacoes');
    exit;
}

$simulacaoId = (int)$_POST['simulacao_id'];

$sql = "SELECT s.*, u.nome, u.email 
        FROM simulacoes s 
        JOIN utilizadores u ON s.utilizador_id = u.id 
        WHERE s.id = :id";

$result = $db->fetchQuery($sql, ['id' => $simulacaoId]);

if ($result['status'] !== 'success' || empty($result['data'])) {
    header('Location: ../index.php?p=simulacoes&res=error');
    exit;
}

$simulacao = $result['data'][0];

$sqlAdmin    = "SELECT email FROM utilizadores WHERE tipo = 'admin' LIMIT 1";
$resultAdmin = $db->fetchQuery($sqlAdmin, []);
$emailAdmin  = 'fcruz.teste.web@gmail.com'; // $resultAdmin['data'][0]['email'];

$mensagem = "
Nova simulação submetida:

Cliente: {$simulacao['nome']} ({$simulacao['email']})
Idioma Origem: {$simulacao['idioma_origem']}
Idioma Destino: {$simulacao['idioma_destino']}
Número de Palavras: {$simulacao['numero_palavras']}
Preço Total: " . number_format($simulacao['preco_total'], 2, ',', '.') . " €
Observações: {$simulacao['observacoes']}
";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fcruz.teste.web@gmail.com';
    $mail->Password   = 'eofn ycgg heuv zwxd';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('fcruz.teste.web@gmail.com', 'Sistema de Simulações');
    $mail->addAddress($emailAdmin);

    $mail->Subject = "Nova Simulação de Orçamento - {$simulacao['nome']}";
    $mail->Body    = $mensagem;

    $mail->send();


    $sqlUpdate = "UPDATE simulacoes SET enviada = true WHERE id = :id";
    $db->executeQuery($sqlUpdate, ['id' => $simulacaoId]);

    header('Location: ../index.php?p=simulacoes&res=enviado');
} catch (Exception $e) {
    header('Location: ../index.php?p=resultado&id=' . $simulacaoId . '&res=erro_email');
}
exit;
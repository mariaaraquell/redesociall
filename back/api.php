
<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Permitir requisições do Go Live
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

// CONEXÃO
require_once __DIR__ . "/config.php";

// MODELS
require_once __DIR__ . "/models/UsuarioModel.php";
require_once __DIR__ . "/models/PublicacaoModel.php";
require_once __DIR__ . "/models/CurtidaModel.php";

// CONTROLLERS
require_once __DIR__ . "/controllers/UsuarioController.php";
require_once __DIR__ . "/controllers/PublicacaoController.php";
require_once __DIR__ . "/controllers/CurtidaController.php";

// ROTAS
require_once __DIR__ . "/routes/rotas.php";

?>

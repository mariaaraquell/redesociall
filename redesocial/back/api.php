
<?php

header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

require_once __DIR__ . "/../config.php";

//MODELS
require_once __DIR__ . "/../models/UsuarioModel.php";
require_once __DIR__ . "/../models/PublicacaoModel.php";
require_once __DIR__ . "/../models/CurtidaModel.php";

//CONTROLLERS
require_once __DIR__ . "/../controllers/UsuarioController.php";
require_once __DIR__ . "/../controllers/PublicacaoController.php";
require_once __DIR__ . "/../controllers/CurtidaController.php";

//ROTAS
require_once __DIR__ . "/../rotas.php";

?>


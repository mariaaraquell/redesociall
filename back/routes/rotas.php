
<?php

$rotas = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

// ROTAS DE USUARIO
if ($rotas === "usuario") {

    switch ($metodo) {

        case "POST":

            // LOGIN
            if (isset($_GET["acao"]) && $_GET["acao"] === "login") {
                loginUsuario($con);
            }

            // CADASTRO
            else {
                createUsuario($con);
            }

            break;

        case "GET":

            // PERFIL DO USUARIO
            if (isset($_GET["acao"]) && $_GET["acao"] === "perfil") {
                readPerfilUsuario($con);
            }

            // LISTAR USUARIOS
            else {
                readUsuario($con);
            }

            break;

        case "PUT":
            updateUsuario($con);
            break;

        case "DELETE":
            deleteUsuario($con);
            break;

        default:
            teste();
            break;
    }
}

// ROTAS DE PUBLICACAO
else if ($rotas === "publicacao") {

    switch ($metodo) {

        case "POST":
            createPublicacao($con);
            break;

        case "GET":
            readPublicacao($con);
            break;

        case "PUT":
            updatePublicacao($con);
            break;

        case "DELETE":
            deletePublicacao($con);
            break;

        default:
            teste();
            break;
    }
}

// ROTAS DE CURTIDA
else if ($rotas === "curtida") {

    switch ($metodo) {

        case "POST":
            createCurtida($con);
            break;

        case "GET":
            readCurtida($con);
            break;

        case "DELETE":
            deleteCurtida($con);
            break;

        default:
            teste();
            break;
    }
}

// CASO A ROTA NAO EXISTA
else {
    teste();
}

?>

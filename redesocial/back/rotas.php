
<?php

$rotas = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

//ROTAS DE USUARIO
if ($rotas === "usuario") {

    switch ($metodo) {

        case "POST":
            createUsuario($con);
            break;

        case "GET":
            readUsuario($con);
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

//ROTAS DE PUBLICACAO
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

//ROTAS DE CURTIDA
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

else {
    teste();
}

?>



<?php

require_once __DIR__ . "/../models/CurtidaModel.php";

//Recebe e valida os dados
function receberDadosCurtida(){

    $dados = json_decode(file_get_contents("php://input"), true);

    if(!is_array($dados)){
        http_response_code(400);
        echo json_encode(["erro" => "Envie os dados da curtida!"]);
        return null;
    }

    foreach(["id_usuario", "id_publicacao"] as $campo){

        if(!isset($dados[$campo]) ||
        !filter_var($dados[$campo], FILTER_VALIDATE_INT) ||
        $dados[$campo] < 1){

            http_response_code(400);
            echo json_encode(["erro" => "O campo $campo é obrigatório e deve ser um número válido!"]);
            return null;
        }
    }

    return $dados;
}

//Recebe o ID da curtida
function receberIdCurtida(){

    $id = filter_var(
        $_GET["id"] ?? null,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if($id === false || $id === null){
        http_response_code(400);
        echo json_encode(["erro" => "Informe um ID de curtida válido!"]);
        return null;
    }

    return $id;
}

//CREATE
function createCurtida($con){

    $dados = receberDadosCurtida();

    if($dados === null){
        return;
    }

    try {
        $id = inserirCurtida($con, $dados);

        http_response_code(201);

        echo json_encode([
            "mensagem" => "Curtida realizada com sucesso!",
            "id" => $id
        ]);

    } catch (PDOException $e) {
        http_response_code(409);
        echo json_encode(["erro" => "Essa publicação já foi curtida por esse usuário!"]);
    }
}

//READ
function readCurtida($con){

    echo json_encode(listarCurtidas($con));

}

//DELETE
function deleteCurtida($con){

    $id = receberIdCurtida();

    if($id === null){
        return;
    }

    removerCurtida($con, $id);

    echo json_encode(["mensagem" => "Curtida removida com sucesso!"]);
}

?>


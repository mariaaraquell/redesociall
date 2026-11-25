
<?php

require_once __DIR__ . "/../models/PublicacaoModel.php";

// Recebe os dados da publicação
function receberDadosPublicacao(){

    $dados = json_decode(file_get_contents("php://input"), true);

    if(!is_array($dados)){
        http_response_code(400);
        echo json_encode(["erro" => "Envie os dados da publicação!"]);
        return null;
    }

    foreach(["id_usuario", "conteudo"] as $campo){

        if(!isset($dados[$campo]) || trim((string)$dados[$campo]) === ""){
            http_response_code(400);
            echo json_encode(["erro" => "O campo $campo é obrigatório!"]);
            return null;
        }
    }

    return $dados;
}

// Recebe o ID
function receberIdPublicacao(){

    $id = filter_var(
        $_GET["id"] ?? null,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 1]]
    );

    if($id === false || $id === null){
        http_response_code(400);
        echo json_encode(["erro" => "Informe um ID válido!"]);
        return null;
    }

    return $id;
}

// CREATE
function createPublicacao($con){

    $idUsuario = $_POST["id_usuario"] ?? "";
    $conteudo = trim($_POST["conteudo"] ?? "");
    $caminhoImagem = null;

    if($idUsuario === "" || !filter_var($idUsuario, FILTER_VALIDATE_INT) || (int)$idUsuario < 1 || $conteudo === ""){
        http_response_code(400);
        echo json_encode(["erro" => "Informe o usuário e o conteúdo da publicação!"]);
        return;
    }

    // Verifica se foi enviada uma imagem
    if(isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] !== UPLOAD_ERR_NO_FILE){

        $arquivo = $_FILES["imagem"];

        if($arquivo["error"] !== UPLOAD_ERR_OK){
            http_response_code(400);
            echo json_encode(["erro" => "Erro ao enviar a imagem!"]);
            return;
        }

        if($arquivo["size"] > 5 * 1024 * 1024){
            http_response_code(400);
            echo json_encode(["erro" => "A imagem deve ter no máximo 5 MB!"]);
            return;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipo = $finfo->file($arquivo["tmp_name"]);

        $tiposPermitidos = [
            "image/jpeg" => "jpg",
            "image/png" => "png",
            "image/gif" => "gif",
            "image/webp" => "webp"
        ];

        if(!isset($tiposPermitidos[$tipo])){
            http_response_code(400);
            echo json_encode(["erro" => "Formato de imagem não permitido!"]);
            return;
        }

        $pastaUploads = dirname(__DIR__, 2) . "/uploads/";

        if(!is_dir($pastaUploads) || !is_writable($pastaUploads)){
            http_response_code(500);
            echo json_encode(["erro" => "A pasta uploads não existe ou não permite gravação!"]);
            return;
        }

        $nomeArquivo = bin2hex(random_bytes(16)) . "." . $tiposPermitidos[$tipo];

        if(!move_uploaded_file($arquivo["tmp_name"], $pastaUploads . $nomeArquivo)){
            http_response_code(500);
            echo json_encode(["erro" => "Não foi possível salvar a imagem!"]);
            return;
        }

        $caminhoImagem = "uploads/" . $nomeArquivo;
    }

    $dados = [
        "id_usuario" => (int)$idUsuario,
        "conteudo" => $conteudo,
        "imagem" => $caminhoImagem
    ];

    $id = inserirPublicacao($con, $dados);

    http_response_code(201);

    echo json_encode([
        "mensagem" => "Publicação criada com sucesso!",
        "id" => $id
    ]);
}

// READ
function readPublicacao($con){

    echo json_encode(listarPublicacao($con));

}

// UPDATE
function updatePublicacao($con){

    $id = receberIdPublicacao();

    if($id === null){
        return;
    }

    $dados = receberDadosPublicacao();

    if($dados === null){
        return;
    }

    atualizarPublicacaoModel($con, $id, $dados);

    echo json_encode(["mensagem" => "Publicação atualizada com sucesso!"]);
}

// DELETE
function deletePublicacao($con){

    $id = receberIdPublicacao();

    if($id === null){
        return;
    }

    removerPublicacao($con, $id);

    echo json_encode(["mensagem" => "Publicação removida com sucesso!"]);
}

?>


<?php

//CREATE
function inserirPublicacao($con, $dados){

    $stmt = $con->prepare(
        "INSERT INTO publicacoes (id_usuario, conteudo)
        VALUES (?, ?)"
    );

    $stmt->execute([
        $dados["id_usuario"],
        $dados["conteudo"]
    ]);

    return $con->lastInsertId();
}

//READ
function listarPublicacao($con){

    $stmt = $con->query("SELECT * FROM publicacoes");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//UPDATE
function atualizarPublicacaoModel($con, $id, $dados){

    $stmt = $con->prepare(
        "UPDATE publicacoes SET conteudo = ? WHERE id_publicacao = ?"
    );

    $stmt->execute([
        $dados["conteudo"],
        $id
    ]);
}

//DELETE
function removerPublicacao($con, $id){

    $stmt = $con->prepare(
        "DELETE FROM publicacoes WHERE id_publicacao = ?"
    );

    $stmt->execute([$id]);
}

?>



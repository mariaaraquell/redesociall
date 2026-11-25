
<?php

// CREATE
function inserirPublicacao($con, $dados){

    $stmt = $con->prepare(
        "INSERT INTO publicacoes (id_usuario, conteudo, imagem)
        VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $dados["id_usuario"],
        $dados["conteudo"],
        $dados["imagem"] ?? null
    ]);

    return $con->lastInsertId();
}

// READ
function listarPublicacao($con){

    $stmt = $con->query(
        "SELECT 
            publicacoes.*,
            usuarios.nome,
            usuarios.username
        FROM publicacoes
        INNER JOIN usuarios
        ON publicacoes.id_usuario = usuarios.id_usuario
        ORDER BY publicacoes.id_publicacao DESC"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// UPDATE
function atualizarPublicacaoModel($con, $id, $dados){

    $stmt = $con->prepare(
        "UPDATE publicacoes SET conteudo = ? WHERE id_publicacao = ?"
    );

    $stmt->execute([
        $dados["conteudo"],
        $id
    ]);
}

// DELETE
function removerPublicacao($con, $id){

    $stmt = $con->prepare(
        "DELETE FROM publicacoes WHERE id_publicacao = ?"
    );

    $stmt->execute([$id]);
}

?>

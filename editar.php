<?php
    require 'controlador_agenda.php';
    $contato = buscarContatoEditar($_GET['id']);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="post" action="controlador_agenda.php?acao=editar">

        <input name="id" readonly  type="text"  value="<?= $contato['id']?>" >
        <input name="nome"     type="text"  value="<?= $contato['nome']?>">
        <input name="email"    type="email" value="<?= $contato['email']?>">
        <input name="telefone" type="text"  value="<?= $contato['telefone']?>">

        <input type="submit" value="editar">
    </form>

</body>
</html>
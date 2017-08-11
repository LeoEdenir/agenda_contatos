<?php

    session_start();

    function login(){
        $lista_usuarios = file_get_contents("usuario.json");
        $lista_usuarios = json_decode($lista_usuarios, true);



            foreach($lista_usuarios as $user){
                if ($_POST['login'] == $user['login'] && $_POST['senha'] == $user['senha']) {

                    $fez_login = true;

                    $_SESSION['nome'] = $_POST['nome'];
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['senha'] = $_POST['senha'];

                    $_SESSION['esta_logado'] = true;


                    //redireciona o usuario para index.php
                    header('Location: index.phtml');

                } else {
                    //deu ruim
                    header('Location: login.php');
                }
            }

            if ($fez_login == false){
                header('Location: login.php');
            }
        }


        function sair(){
            session_destroy();
            header('Location: login.php');
        }


        //rotas

    if($_GET['acao']== 'login'){
            login();
    }elseif ($_GET['acao'] == 'sair'){
            sair();
    }




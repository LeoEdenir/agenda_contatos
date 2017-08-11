<?php


        function json(){

            //pegar arquivo json
            $contatosAuxiliar = file_get_contents('contatos.json');
            //decodificar arquivo json para array
            $contatosAuxiliar = json_decode($contatosAuxiliar, true);

            return $contatosAuxiliar;
        }

        function cadastrar($nome, $email, $telefone){

            $contatos = json();

            $contato = [
                'id' => uniqid(),
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone
            ];

            array_push($contatos, $contato);

            $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);

            file_put_contents('contatos.json', $contatosJson);

            header("Location: index.phtml");
        }


        function buscarContato($buscado){

            $contatos = json();

            $contatosEncontrados = [];

            foreach($contatos as $contato){
                if ($contato['nome'] == $buscado OR $contato['email'] == $buscado){

                    $contatosEncontrados[] = $contato;
                }
            }

            return $contatosEncontrados;

        }

        function excluirContato($id){


            $contatos = json();

            //percorrer array para procurar id e excluir
            foreach ($contatos as $posicao => $contato) {
                if ($id == $contato['id']) {
                    unset($contatos[$posicao]);
                }
            }
            //transforma array em Json
            $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);
            //Manda o array pro arquivo Json
            file_put_contents('contatos.json', $contatosJson);

            //Direciona pro index
            header('Location: index.phtml');
        }


        function buscarContatoEditar($idBuscado){

            $contatos = json();

            foreach ($contatos as $contato) {
                if ($contato['id'] == $idBuscado) {
                    return $contato;
                }
            }
        }

        function salvarContatoEditado($id, $nome, $email, $telefone){

            $contatos = json();

            //percorre o array e verifica se tem id igual, se tiver ele salva as informações editadas
            foreach ($contatos as $posicao => $contato) {
                if ($contato['id'] == $id) {

                    $contatos[$posicao]['nome'] = $nome;
                    $contatos[$posicao]['email'] = $email;
                    $contatos[$posicao]['telefone'] = $telefone;

                    break;
                }
            }

            $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);
            file_put_contents('contatos.json', $contatosJson);

            header('Location: index.phtml');

        }


        //ROTAS
        if ($_GET['acao'] == 'cadastrar') {
            cadastrar($_POST['nome' ], $_POST['email'],$_POST['telefone']);
        } elseif ($_GET['acao'] == 'excluir') {
            excluirContato($_GET['id']);
        } elseif ($_GET['acao'] == 'editar') {
            salvarContatoEditado($_POST['id'],$_POST['nome'], $_POST['email'],$_POST['telefone']);
        }
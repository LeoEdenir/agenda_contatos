<?php


        function json(){

            //pegar arquivo json
            $contatosAuxiliar = file_get_contents('contatos.json');
            //decodificar arquivo json para array
            $contatosAuxiliar = json_decode($contatosAuxiliar, true);

            return $contatosAuxiliar;
        }

        function json2($contatos){
            //codifica o arquivo para json novamente
            $contatosJson = json_encode($contatos, JSON_PRETTY_PRINT);
            
            //recebe os dados do usuário do arquivo json
            file_put_contents('contatos.json', $contatosJson);

            //redireciona pra index.phtml 
            header("Location: index.phtml");
        }

        function cadastrar($nome, $email, $telefone){
            //guarda os contatos do arquivo json na variavel
            $contatos = json();

            $contato = [
                'id' => uniqid(),
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone
            ];
            
            //adicionar contato ao array contatos
            array_push($contatos, $contato);
            
            json2($contatos);
        }


        function buscarContato($buscado){
            //guarda os contatos do arquivo json na variavel
            $contatos = json();

            $contatosEncontrados = [];
            //percorre o array contatos para buscar nome e email iguais
            foreach($contatos as $contato){
                if ($contato['nome'] == $buscado OR $contato['email'] == $buscado){
                    //se o nome ou email buscado for igual aos existentes, o contato é guardado no array
                    $contatosEncontrados[] = $contato;
                }
            }
            //retorna o array com os usuários encontrados iguais
            return $contatosEncontrados;

        }

        function excluirContato($id){

            //guarda os contatos do arquivo json na variavel
            $contatos = json();

            //percorre o array para procurar um id igual ao de um contato  
            foreach ($contatos as $posicao => $contato) {
                if ($id == $contato['id']) {
                    //se o id buscado for igual ao do contato, o contato é excluído com a função unset
                    unset($contatos[$posicao]);
                }
            }
           json2($contatos);
        }


        function buscarContatoEditar($idBuscado){
            //guarda os contatos do arquivo json na variavel
            $contatos = json();
            
            //percorre o array e verifica se algum contato tem o id buscado
            foreach ($contatos as $contato) {
                if ($contato['id'] == $idBuscado) {
                    //retorna o contato com id igual ao buscado para ser usado na função 'salvarContatoEditado'
                    return $contato;
                }
            }
        }

        function salvarContatoEditado($id, $nome, $email, $telefone){
            //guarda os contatos do arquivo json na variavel
            $contatos = json();

            //percorre o array e verifica se tem algum contato com o id igual ao buscado
            foreach ($contatos as $posicao => $contato) {
                if ($contato['id'] == $id) {
                //se houver um id igual ao buscado, são salvas as mudanças naquele contato
                    $contatos[$posicao]['nome'] = $nome;
                    $contatos[$posicao]['email'] = $email;
                    $contatos[$posicao]['telefone'] = $telefone;
                    //para a execução do foreach quando achar o id igual ao buscado e salvar as informações
                    break;
                }
            }
            json2($contatos);
        }


        //ROTAS
        if ($_GET['acao'] == 'cadastrar') {
        //se a ação recebida do link ($_GET) for igual a 'cadastrar', executa a função cadastrar()
            cadastrar($_POST['nome' ], $_POST['email'],$_POST['telefone']);
        } elseif ($_GET['acao'] == 'excluir') {
        //se a ação recebida do link ($_GET) for igual a 'excluir', executa a função excluirContato()
            excluirContato($_GET['id']);
        } elseif ($_GET['acao'] == 'editar') {
        //se a ação recebida do link ($_GET) for igual a 'editar', executa a função salvarContatoEditado()
            salvarContatoEditado($_POST['id'],$_POST['nome'], $_POST['email'],$_POST['telefone']);
        }

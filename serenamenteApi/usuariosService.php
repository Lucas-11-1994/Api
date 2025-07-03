<?php

include 'usuarios.php';

class usuariosService 
{
    //ações / metódos 
           
    //post - Incluir
    public function post()
    {   
        //Pegar os dados em formato JSON para incluir no BD.
        $dados = json_decode(file_get_contents('php://input'), true, 512);
        if ($dados == null) {
            throw new Exception("Falta os dados para incluir!");
        }
        
        // Validar campos obrigatórios
        if (!isset($dados['nome']) || !isset($dados['email']) || !isset($dados['senha'])) {
            throw new Exception("Dados incompletos para cadastro!");
        }
        
        // Definir valor padrão para forma_pagamento se não estiver presente
        if (!isset($dados['forma_pagamento'])) {
            $dados['forma_pagamento'] = null;
        }
        
        return usuarios::insert($dados);              
    }

    //get - Buscar
    public function get($id = null) 
    {
        if ($id) {
            //Buscar os usuarios pelo Id / Código
            return usuarios::select($id);    
        } else {
            //Buscar todos os usuarios da tabela
            return usuarios::selectAll();    
        }
    }

    //put - Alterar
    public function put($id = null) {
        if ($id == null) {
            throw new Exception("Falta o código!");
        }

        //Pegar os dados em formato JSON para alterar no BD.
        $dados = json_decode(file_get_contents('php://input'), true, 512);
        if ($dados == null) {
            throw new Exception("Falta as informações!");
        }

        // Manter o valor atual de forma_pagamento se não for fornecido
        if (!isset($dados['forma_pagamento'])) {
            $usuarioAtual = usuarios::select($id);
            if (!$usuarioAtual['erro'] && !empty($usuarioAtual['dados'])) {
                $dados['forma_pagamento'] = $usuarioAtual['dados']['forma_pagamento'];
            } else {
                $dados['forma_pagamento'] = null;
            }
        }

        //Alterar os dados dos usuarios da tabela
        return usuarios::update($id, $dados);   
    }

    //delete - Deletar
    public function delete($id = null) {
        if ($id == null) {
            throw new Exception("Falta o código!");
        }

        //Excluir os dados dos usuarios na tabela
        return usuarios::delete($id);   
    }
}
?>
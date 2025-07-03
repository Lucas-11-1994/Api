<?php

//inserir o arquivo 'config.php'
require_once 'config.php';

class usuarios 
{
    private static $formasPagamentoValidas = [
        'Cartão de Crédito',
        'Cartão de Débito',
        'PIX',
        'Boleto Bancário',
        'Transferência Bancária'
    ];

    private static function validarFormaPagamento($formaPagamento) {
        if ($formaPagamento !== null && !in_array($formaPagamento, self::$formasPagamentoValidas)) {
            throw new Exception("Forma de pagamento inválida. As opções válidas são: " . 
                             implode(', ', self::$formasPagamentoValidas));
        }
    }

    public static function insert($dados) {      
        self::validarFormaPagamento($dados['forma_pagamento'] ?? null);
        
        $tabela = "usuarios";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "INSERT INTO $tabela (nome, email, senha, data_nascimento, forma_pagamento) 
                VALUES (:nome, :email, :senha, :data_nascimento, :forma_pagamento)";      

        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':nome', $dados['nome']);     
        $stmt->bindValue(':email', $dados['email']);      
        $stmt->bindValue(':senha', $dados['senha']);     
        $stmt->bindValue(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindValue(':forma_pagamento', $dados['forma_pagamento'] ?? null);  
        $stmt->execute();

        if ($stmt->rowCount() > 0) {                     
            return [ 'erro' => false, 
                    'mensagem' => "Dados cadastrados com sucesso!", 
                    'dados' => [] ];
        } else {        
            throw new Exception("Erro ao incluir!");
        }    
    }
    
    public static function select($id) {      
        $tabela = "usuarios";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "SELECT * FROM $tabela WHERE id=:id";      

        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id', $id);     
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return [ 'erro' => false, 
                    'mensagem' => "", 
                    'dados' => $dados ];
        } else {
            return [ 'erro' => false, 
                    'mensagem' => "Código não encontrado!", 
                    'dados' => [] ];
        }
    }

    public static function selectAll() { 
        $tabela = "usuarios";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "SELECT * FROM $tabela";      
        $stmt = $connPdo->prepare($sql);      
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [ 'erro' => false, 
                    'mensagem' => "", 
                    'dados' => $dados ];
        } else {
            return [ 'erro' => false, 
                    'mensagem' => "Tabela vazia!", 
                    'dados' => [] ];
        }
    }

    public static function update($id, $dados) { 
        self::validarFormaPagamento($dados['forma_pagamento'] ?? null);
        
        $tabela = "usuarios";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "UPDATE $tabela SET nome=:nome, email=:email, senha=:senha, 
                data_nascimento=:data_nascimento, forma_pagamento=:forma_pagamento 
                WHERE id=:id";      

        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id', $id);   
        $stmt->bindValue(':nome', $dados['nome']);     
        $stmt->bindValue(':email', $dados['email']);      
        $stmt->bindValue(':senha', $dados['senha']); 
        $stmt->bindValue(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindValue(':forma_pagamento', $dados['forma_pagamento'] ?? null);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [ 'erro' => false, 
                    'mensagem' => "Dados alterados com sucesso!", 
                    'dados' => [] ];
        } else {
            throw new Exception("Erro ao alterar");
        }
    }

    public static function delete($id) { 
        $tabela = "usuarios";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "DELETE FROM $tabela WHERE id=:id";      
        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id', $id);   
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [ 'erro' => false, 
                    'mensagem' => "Dados foram excluídos com sucesso!", 
                    'dados' => [] ];
        } else {
            throw new Exception("Erro ao excluir");
        }
    }
}
?>
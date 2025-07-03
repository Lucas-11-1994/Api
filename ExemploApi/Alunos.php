<?php

//inserir o arquivo 'config.php'
require_once 'config.php' ;

class Alunos 
{
    public static function insert($dados)    {      
        $tabela = "alunos";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "insert into $tabela (nome,email,telefone) values (:nome,:email,:telefone)";      

        $stmt = $connPdo->prepare($sql);      //Mapear os parâmetros para obter os dados de inclusão      
        $stmt->bindValue(':nome', $dados['nome']);     
        $stmt->bindValue(':email', $dados['email']);      
        $stmt->bindValue(':telefone', $dados['telefone']);      
        $stmt->execute() ;

        if ($stmt->rowCount() > 0)      
        {                     
            //return "Dados cadastrados com sucesso!" ;      
            return [ 'erro' => false , 
                        'mensagem' => "Dados cadastrados com sucesso!" , 
                        'dados' => []  ] ;
        }else{        
            //return "Erro" ;      
            throw new Exception("Erro ao incluir!");
        }    
    }
    
    public static function select( $id )    {      
        $tabela = "alunos";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "SELECT * FROM $tabela WHERE codigo=:id";      

        //Mapear os parâmetros para a consulta no BD     
        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id',  $id );     

        $stmt->execute() ;

        if ($stmt->rowCount() > 0) {
            //Achou o código procurado
            $dados = $stmt->fetch( PDO::FETCH_ASSOC ) ;
            //return $dados ;
            return [ 'erro' => false , 
                        'mensagem' => "" , 
                        'dados' => $dados  ] ;
        }else {
            //NÃO Achou o código procurado
            //return "Código não encontrado!";
            return [ 'erro' => false , 
                        'mensagem' => "Código não encontrado!" , 
                        'dados' => []  ] ;
        }

    }

    public static function selectAll(  )    { 
        $tabela = "alunos";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "SELECT * FROM $tabela";      

        //Mapear os parâmetros para a consulta no BD     
        $stmt = $connPdo->prepare($sql);      


        $stmt->execute() ;

        if ($stmt->rowCount() > 0) {
            //Achou o código procurado
            $dados = $stmt->fetchAll( PDO::FETCH_ASSOC ) ;
            //return $dados ;
            return [ 'erro' => false , 
                        'mensagem' => "" , 
                        'dados' => $dados  ] ;
        }else {
            //NÃO Achou nada na tabela
            //return "Tabela vazia!";
            return [ 'erro' => false , 
                        'mensagem' => "Tabela vazia!" , 
                        'dados' => []   ] ;
        }

    }

    public static function update( $id , $dados )    { 
        $tabela = "alunos";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "UPDATE  $tabela SET nome=:nome , email=:email, telefone=:telefone   WHERE codigo=:id";      

        //Mapear os parâmetros para a consulta no BD     
        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id',  $id );   
        $stmt->bindValue(':nome', $dados['nome']);     
        $stmt->bindValue(':email', $dados['email']);      
        $stmt->bindValue(':telefone', $dados['telefone']);      

        $stmt->execute() ;

        if ($stmt->rowCount() > 0) {
            //return "Dados alterados com sucesso!";
            return [ 'erro' => false , 
                        'mensagem' => "Dados alterados com sucesso!" , 
                        'dados' => []  ] ;
        }else {
            throw new Exception("Erro ao alterar") ;
        }

    }

    public static function delete( $id )   { 
        $tabela = "alunos";   
        $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);      
        $sql = "DELETE FROM  $tabela WHERE codigo=:id";      

        //Mapear os parâmetros para a consulta no BD     
        $stmt = $connPdo->prepare($sql);      
        $stmt->bindValue(':id',  $id );   
        

        $stmt->execute() ;

        if ($stmt->rowCount() > 0) {
            //return "Dados foram excluídos com sucesso!";
            return [ 'erro' => false , 
                        'mensagem' => "Dados foram excluídos com sucesso!" , 
                        'dados' => []  ] ;
        }else {
            throw new Exception("Erro ao excluir") ;
        }
    }

}


?>
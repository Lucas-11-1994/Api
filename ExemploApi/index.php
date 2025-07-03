<?php

    include 'AlunosService.php' ;
    include 'util.php' ;

    header( "Content-Type: application/json; charset=UTF-8 " ) ;
    header( "Access-Control-Allow-Origin: *" ) ; //Necessário Localhost
    header( "Access-Control-Allow-Methods: GET,POST,PUT,DELETE" ) ;
    header( "Access-Control: no-cache, no-store, must-revalidate" ) ;
    header( "Access-Control-Allow-Headers: *" ) ;
    header( "Access-Control-Max-Age: 86400" ) ;


    //echo ( @$_GET['url'] . "<br>" ) ;
    if ( @$_GET['url']  ) {
        $url = explode( '/' ,  $_GET['url'] ) ;

        //var_dump(  $url ) ; // Mostra a varial $url
        if ( $url[0]  ===  'api' ) {
            //remover a primeira posição do vetor $url
            array_shift( $url ) ;
            //var_dump(  $url ) ; // Mostra a varial $url
  
            //ucfirst() --> Converte a primeira letra em maiúsculo
            $service =   ucfirst($url[0]) . 'Service'  ;
            //echo "<br>Arquivo: " .$service ;

            $method  = $_SERVER['REQUEST_METHOD'] ;

            //echo "<br>Ação: " .$method ;
            
            //remover a primeira posição do vetor $url
            array_shift( $url ) ;

            try{ 
                //chamar a classe responsavel pelo servico
                $response  = call_user_func_array(  array( new $service , $method ) ,  $url    ) ;
                http_response_code(200) ;
                //echo  json_encode(array('retorno' => $response), JSON_UNESCAPED_UNICODE);
                echo FormatarMensagemJson( false , $response['mensagem'] , $response['dados']) ;
            }
            catch ( Exception $erro ) 
            {
                http_response_code(500) ;
                //echo json_encode(array('erro' => $erro, 'mensagem' => $erro->getMessage() , 'dados' => []) , JSON_UNESCAPED_UNICODE );
                echo FormatarMensagemJson( true , $erro->getMessage() , [] ) ;
            }
            

        }
        else{
            echo 'EndPoint incorreto' ;
        }


    }else {
        echo 'EndPoint incorreto' ;
    }


?>
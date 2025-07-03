<?php
    function FormatarMensagemJson(   $erro = false , 
                                                            $mensagem = null , 
                                                            $dados = []  ) {

        return  json_encode(array('erro' => $erro , 
                                        'mensagem' =>  $mensagem , 
                                        'dados' =>  $dados ) , JSON_UNESCAPED_UNICODE); 
    }
?>
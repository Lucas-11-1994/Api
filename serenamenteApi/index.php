<?php

include 'usuariosService.php';
include 'util.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Necessário para Localhost
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 86400");

// Tratamento para requisições OPTIONS (pré-voo CORS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    if (@$_GET['url']) {
        $url = explode('/', $_GET['url']);

        if ($url[0] === 'api') {
            array_shift($url); // Remove 'api' da URL
            
            if (count($url) == 0) {
                throw new Exception("Endpoint de serviço não especificado");
            }

            $serviceName = ucfirst($url[0]) . 'Service';
            $method = strtolower($_SERVER['REQUEST_METHOD']);
            
            // Verifica se o arquivo de serviço existe
            if (!file_exists($serviceName . '.php')) {
                throw new Exception("Serviço não encontrado");
            }
            
            array_shift($url); // Remove o nome do serviço

            try {
                $service = new $serviceName();
                
                // Verifica se o método existe no serviço
                if (!method_exists($service, $method)) {
                    throw new Exception("Método não permitido");
                }
                
                $response = call_user_func_array(array($service, $method), $url);
                
                http_response_code(200);
                echo FormatarMensagemJson(false, $response['mensagem'] ?? 'Operação realizada com sucesso', $response['dados'] ?? []);
                
            } catch (Exception $e) {
                http_response_code(400); // Bad Request
                echo FormatarMensagemJson(true, $e->getMessage(), []);
            }
            
        } else {
            throw new Exception("Endpoint incorreto - prefixo 'api' não encontrado");
        }
    } else {
        throw new Exception("Endpoint não especificado");
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo FormatarMensagemJson(true, $e->getMessage(), []);
}

?>
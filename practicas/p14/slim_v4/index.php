<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;

    require 'vendor/autoload.php';
    
    $app = AppFactory::create();
    $app->setBasepath("/tecweb/practicas/p14/slim_v4");


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hola Mundo Slim");
    return $response;
});

$app->get("/hola[/{nombre}]", function(Request $request, Response $response, $args){
    $response->getBody()->write("Hola, " . $args["nombre"]);
    return $response;
});

$app->post("/pruebapost", function(Request $request, Response $response, $args){
    $reqPost = $request->getParsedbody();
    $val1 = $reqPost["val1"];
    $val2 = $reqPost["val2"];

    $response->getBody()->write( "Valores: " . $val1 . " ".$val2 );
    return $response;
});

$app->get("/testjson", function(Request $request, Response $response, $args){
    $queryParams = $request->getQueryParams();
    $nombre = $queryParams["nombre"] ?? "Sin nombre";
    $apellidos = $queryParams["apellidos"] ?? "Sin apellidos";
    
    $data = [
        "status" => "success",
        "datos" => [
            "nombre" => $nombre,
            "apellidos" => $apellidos
        ]
    ];
    
    $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>
<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/location/', function (Request $request, Response $response) {

    $data = $request->getQueryParams();

    $location = filter_var($data['location'], FILTER_SANITIZE_STRING);
    $region = filter_var($data['region'], FILTER_SANITIZE_STRING);
    $detail = $data['detail'];

    if(isset($region) && isset($detail)) {
	    $response->getBody()->write(var_export(get_locations_in_region_detail($region), true));
    }
    else if(isset($region)) {
	    $response->getBody()->write(var_export(get_locations_in_region($region), true));
    }
    else if(isset($location)) {
	    $response->getBody()->write(var_export(get_location_detail($location), true));
    }
    else if(isset($detail)) {
	    $response->getBody()->write(var_export(get_all_locations_detail(), true));
    }
    else {
	    $response->getBody()->write(var_export(get_all_locations(), true));
    }
    return $response;

});
$app->run();
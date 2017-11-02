<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";
require_once "../client_obj.php";

$app = new \Slim\App;

//TODO: Allow cross origins
// $app->options('/{routes:.+}', function ($request, $response, $args) {
//     return $response;
// });


// Cross-Origins
$app->add(function ($request, $response, $next) {
		$response = $next($request, $response);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});


// Authorization
$app->add(function ($request, $response, $next) {

	// Can't use keyword 'Authorization' without htaccess changes
	// https://github.com/slimphp/Slim/issues/1616#issuecomment-159621954
	$user = $request->getHeader('PHP_AUTH_USER');
	$pass = $request->getHeader('PHP_AUTH_PW');

	if($user[0] == 'root' && $pass[0] == 'pass')
		$response = $next($request, $response);
	else
    return $response
        ->withStatus(403)
        ->withHeader('Content-Type', 'text/html')
        ->write('Invalid Credentials');

	return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});


// Location API
$app->get('/location/', function (Request $request, Response $response) {

		// Leave this here if I need to debug headers
		// 	$headers = $request->getHeaders();
		// foreach ($headers as $name => $values) {
		//     echo $name . ": " . implode(", ", $values);
		// }

    $data = $request->getQueryParams();

    $location = $data['location'];
    $region = $data['region'];
    $detail = $data['detail'];

    $location_clean = filter_var($data['location'], FILTER_SANITIZE_STRING);
    $region_clean = filter_var($data['region'], FILTER_SANITIZE_STRING);

    if(isset($region) && isset($detail)) {
	    $response->getBody()->write(var_export(get_locations_in_region_detail($region_clean), true));
    }
    else if(isset($region)) {
	    $response->getBody()->write(var_export(get_locations_in_region($region_clean), true));
    }
    else if(isset($location)) {
	    $response->getBody()->write(var_export(get_location_detail($location_clean), true));
    }
    else if(isset($detail)) {
	    $response->getBody()->write(var_export(get_all_locations_detail(), true));
    }
    else {
	    $response->getBody()->write(var_export(get_all_locations(), true));
    }
    return $response;

});


// Client API
$app->get('/client/', function (Request $request, Response $response) {

    $data = $request->getQueryParams();

    $client = $data['JAID'];
    $client_clean = filter_var($data['JAID'], FILTER_SANITIZE_STRING);

    if(isset($client)) {
	    $response->getBody()->write(var_export(get_client_detail($client_clean), true));
    }
    else {
	    $response->getBody()->write(var_export(get_client_list(), true));
    }

    return $response;

});



$app->run();
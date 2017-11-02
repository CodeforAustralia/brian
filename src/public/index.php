<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";

$app = new \Slim\App;

//TODO: Allow cross origins
// $app->options('/{routes:.+}', function ($request, $response, $args) {
//     return $response;
// });

// $app->add(function ($req, $res, $next) {
//     $response = $next($req, $res);
//     return $response
//             ->withHeader('Access-Control-Allow-Origin', '*')
//             ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
//             ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
// });


$app->add(function ($request, $response, $next) {

	// Can't use keyword 'Authorization' without htaccess changes
	// https://github.com/slimphp/Slim/issues/1616#issuecomment-159621954
	$user = $request->getHeader('PHP_AUTH_USER');
	$pass = $request->getHeader('PHP_AUTH_PW');

	if($user[0] == 'root' && $pass[0] == 'pass')
		$response = $next($request, $response);
	else {
    return $response
        ->withStatus(401)
        ->withHeader('Content-Type', 'text/html')
        ->write('Invalid Credentials');
	}

	return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

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
    	// echo 'else';
	    $response->getBody()->write(var_export(get_all_locations(), true));
    }
    return $auth[0];

});
$app->run();
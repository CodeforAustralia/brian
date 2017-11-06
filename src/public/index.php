<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";
require_once "../client_obj.php";

$app = new \Slim\App;


// Cross-Origins
$app->add(function ($request, $response, $next) {
		$response = $next($request, $response);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://ec2-54-66-246-123.ap-southeast-2.compute.amazonaws.com:8080')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "secure" => false,
    "users" => [
        "root" => "pass"
    ],
    "error" => function ($request, $response, $arguments) {
        $data = [];
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    }
]));

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});


// Location API
$app->get('/location', function (Request $request, Response $response) {

		// // Leave this here if I need to debug headers
  //   $headers = $request->getHeaders();
  //   foreach ($headers as $name => $values) {
  //       echo $name . ": " . implode(", ", $values);
  //   }

    $data = $request->getQueryParams();

    $location = $data['location'];
    $region = $data['region'];
    $detail = $data['detail'];

    $location_clean = filter_var($data['location'], FILTER_SANITIZE_STRING);
    $region_clean = filter_var($data['region'], FILTER_SANITIZE_STRING);

    if(isset($region) && isset($detail)) {
        $data = get_locations_in_region_detail($region_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($region)) {
        $data = get_locations_in_region($region_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($location)) {
        $data = get_location_detail($location_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($detail)) {
        $data = get_all_locations_detail();
        $newResponse = $response->withJson($data);
    }
    else {
        $data = get_all_locations();
        $newResponse = $response->withJson($data);
    }
    return $newResponse;

});


// Client API
$app->get('/client', function (Request $request, Response $response) {

    $data = get_client_list();
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// Client API
$app->get('/client/{id}', function (Request $request, Response $response, $args) {
		$JAID = (int)$args['id'];

    $data = $request->getQueryParams();

    $messages = $data['messages'];
    $cw = $data['community_work'];
    $ccs = $data['ccs_location'];
    $staff = $data['staff'];
    $phone = $data['phone'];

    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    if(isset($messages)) {
        $data = get_client_messages($JAID_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($cw)) {
        $data = get_client_community_work($JAID_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($ccs)) {
        $data = get_client_ccs_locations($JAID_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($staff)) {
        $data = get_client_manager($JAID_clean);
        $newResponse = $response->withJson($data);
    }
    else if(isset($phone)) {
        $data = get_client_phone($JAID_clean);
        $newResponse = $response->withJson($data);
    }
    else {
        $data = get_client_detail($JAID_clean);
        $newResponse = $response->withJson($data);
    }

    return $newResponse;

});




$app->run();
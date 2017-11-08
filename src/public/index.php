<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";
require_once "../client_obj.php";
require_once "../region_obj.php";
require_once "../user_obj.php";

$app = new \Slim\App;


// Cross-Origins
$app->add(function ($request, $response, $next) {

    // // Leave this here if I need to debug headers
    // $headers = $request->getHeaders();
    // foreach ($headers as $name => $values) {
    //     echo $name . ": " . implode(", ", $values);
    // }

    // // Sam use this if we need to handle multiple domains
    // $domain = parse_url($_SERVER['HTTP_HOST']);
    // var_dump($domain);


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

// Region API
$app->get('/region', function (Request $request, Response $response) {

    $data = get_all_regions();
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// Region API
$app->get('/region/{id}', function (Request $request, Response $response, $args) {
    $region_id = (int)$args['id'];

    $data = get_all_locations_in_regions($region_id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// Region API
$app->get('/area', function (Request $request, Response $response) {

    $data = get_all_areas();
    $newResponse = $response->withJson($data);

    return $newResponse;

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
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_detail($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});


// Client API
$app->get('/client/{id}/messages', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_messages($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});


// Client API
$app->get('/client/{id}/communitywork', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_community_work($JAID_clean);
    $newResponse = $response->withJson($data);


    return $newResponse;

});
// Client API
$app->get('/client/{id}/location', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_ccs_locations($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
// Client API
$app->get('/client/{id}/staff', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_manager($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
// Client API
$app->get('/client/{id}/phone', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);
    
    $data = get_client_phone($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// User API
$app->get('/user', function (Request $request, Response $response) {

    $data = get_all_users();
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// User API
// Make sure this stays in the correct order
$app->get('/user/type', function (Request $request, Response $response) {

    $data = get_all_types();
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// User API
$app->get('/user/type/{role}', function (Request $request, Response $response, $args) {
    $role = (string)$args['role'];

    $data = get_users_of_type($role);
    $newResponse = $response->withJson($data);

    return $newResponse;

});


// User API
$app->get('/user/location/{id}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];

    $data = get_users_from_location($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});


// User API
$app->get('/user/location/{id}/type/{role}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];
    $role = (string)$args['role'];


    $data = get_typed_users_from_location($id, $role);
    $newResponse = $response->withJson($data);

    return $newResponse;

});

// User API
$app->get('/user/{username}', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];

    $data = get_user($username);
    $newResponse = $response->withJson($data);

    return $newResponse;

});



$app->run();
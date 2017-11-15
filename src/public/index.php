<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";
require_once "../client_obj.php";
require_once "../region_obj.php";
require_once "../user_obj.php";
require_once "../staff_obj.php";

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
$app->get('/region/{id}', function (Request $request, Response $response, $args) {
    $region_id = (int)$args['id'];

    $data = get_all_locations_in_region($region_id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});


// Area API
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


    $data = get_all_locations();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/location/detail', function (Request $request, Response $response) {

    $data = get_all_locations_detail();
    $newResponse = $response->withJson($data);
    
    return $newResponse;

});
$app->get('/location/region/{id}/detail', function (Request $request, Response $response, $args) {
    $region_id = (int)$args['id'];

    $data = get_locations_in_region_detail($region_id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/location/region/{id}', function (Request $request, Response $response, $args) {
    $region_id = (int)$args['id'];
    $data = get_locations_in_region($region_id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/location/{id}', function (Request $request, Response $response, $args) {
    $location_id = (int)$args['id'];

    $data = get_location_detail($location_id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});




// Client API
$app->get('/client', function (Request $request, Response $response) {

    $data = get_client_list();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/location/{id}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];

    $data = get_client_list_in_location($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/region/{id}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];

    $data = get_client_list_in_region($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/{id}', function (Request $request, Response $response, $args) {
	$JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_detail($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/{id}/messages', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_messages($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/{id}/communitywork', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_community_work($JAID_clean);
    $newResponse = $response->withJson($data);


    return $newResponse;

});
$app->get('/client/{id}/location', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_ccs_locations($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/{id}/staff', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);

    $data = get_client_manager($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/client/{id}/phone', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);
    
    $data = get_client_phone($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});



// User API
// Make sure this stays in the correct order
$app->get('/user', function (Request $request, Response $response) {

    $data = get_all_users();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/user/new', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['Password'] = filter_var($body['Password'], FILTER_SANITIZE_STRING);
    $user_data['email'] = filter_var($body['email'], FILTER_SANITIZE_STRING);
    $user_data['Role'] = filter_var($body['Role'], FILTER_SANITIZE_STRING);
    $user_data['Location'] = filter_var($body['Location'], FILTER_SANITIZE_STRING);
    $user_data['FirstName'] = filter_var($body['FirstName'], FILTER_SANITIZE_STRING);
    $user_data['LastName'] = filter_var($body['LastName'], FILTER_SANITIZE_STRING);
    $user_data['Authentication'] = filter_var($body['Authentication'], FILTER_SANITIZE_STRING);

    $data = set_new_user($user_data['Username'], $user_data['Password'], $user_data['email'], $user_data['Role'], $user_data['Location'], $user_data['FirstName'], $user_data['LastName'], $user_data['Authentication']);


    $response->getBody()->write($data);
    
    return $response;

});
$app->get('/user/type', function (Request $request, Response $response) {

    $data = get_all_types();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/user/{username}', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];

    $data = get_user($username);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/user/{username}', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Role'] = filter_var($body['Role'], FILTER_SANITIZE_STRING);

    $data = set_user_role($username, $user_data['Role']);
    $response->getBody()->write($data);
    
    return $response;

});



// Staff API
$app->get('/staff', function (Request $request, Response $response) {

    $data = get_all_staff();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/revoked', function (Request $request, Response $response) {

    $data = get_revoked_staff();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/authenticate', function (Request $request, Response $response) {

    $data = get_waiting_authentication();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/staff/authenticate', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['UserName'] = filter_var($body['UserName'], FILTER_SANITIZE_STRING);
    $user_data['LocationID'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
    $user_data['Status'] = filter_var($body['Status'], FILTER_SANITIZE_STRING);
    // // var_dump($user_data);
    // echo $user_data['UserName'];
    // echo $user_data['LocationID'];

    $data = set_staff_authentication($user_data['UserName'], $user_data['LocationID'], $user_data['Status']);
    $response->getBody()->write($data);

    return $response;

});
$app->get('/staff/location/{id}', function (Request $request, Response $response, $args) {
    $id = (string)$args['id'];

    $data = get_staff_from_location($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/location/{id}/authenticate', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];

    $data = get_waiting_authentication_from_location($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/location/{id}/type/{role}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];
    $role = (string)$args['role'];


    $data = get_typed_staff_from_location($id, $role);
    $newResponse = $response->withJson($data);

    return $newResponse;

});

$app->get('/staff/type/{role}', function (Request $request, Response $response, $args) {
    $role = (string)$args['role'];

    $data = get_staff_of_type($role);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/{username}/client', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];

    $data = get_staff_clients($username);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/staff/{username}/client/location/{id}', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];
    $id = (string)$args['id'];

    $data = get_staff_clients_from_location($username, $id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});




$app->run();
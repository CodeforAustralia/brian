<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require_once "../location_obj.php";
require_once "../client_obj.php";
require_once "../region_obj.php";
require_once "../user_obj.php";
require_once "../staff_obj.php";
require_once "../group_obj.php";
require_once "../mailer_obj.php";
require_once "../authentication.php";

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
        getUsername() => getPassword()
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
$app->get('/client/{id}/order', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);
    
    $data = get_client_orders($JAID_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;
});
$app->get('/client/{id}/condition/order/{order_id}', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $order_id = (int)$args['order_id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);
    $order_id_clean = filter_var($order_id, FILTER_SANITIZE_STRING);
    
    $data = get_client_conditions_from_order($JAID_clean, $order_id_clean);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/client/{id}/condition/order/{order_id}/condition/{condition_id}', function (Request $request, Response $response, $args) {
    $JAID = (int)$args['id'];
    $order_id = (int)$args['order_id'];
    $condition_id = (int)$args['condition_id'];
    $JAID_clean = filter_var($JAID, FILTER_SANITIZE_STRING);
    $order_id_clean = filter_var($order_id, FILTER_SANITIZE_STRING);
    $condition_id_clean = filter_var($condition_id, FILTER_SANITIZE_STRING);
    

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['StartDate'] = filter_var($body['StartDate'], FILTER_SANITIZE_STRING);
    $user_data['EndDate'] = filter_var($body['EndDate'], FILTER_SANITIZE_STRING);
    $user_data['Status'] = filter_var($body['Status'], FILTER_SANITIZE_STRING);
    $user_data['Detail'] = filter_var($body['Detail'], FILTER_SANITIZE_STRING);


    $data = set_client_condition($JAID_clean, $order_id_clean, $condition_id_clean, $user_data['StartDate'], $user_data['EndDate'], $user_data['Status'], $user_data['Detail'] );
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
$app->post('/user/password', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['Password'] = filter_var($body['Password'], FILTER_SANITIZE_STRING);

    $data = set_user_password($user_data['Username'], $user_data['Password']);

    $response->getBody()->write($data);
    
    return $response;

});
$app->get('/user/salt/{username}', function (Request $request, Response $response, $args) {
    $username = (string)$args['username'];

    $data = get_user_salt($username);
    $response->getBody()->write($data);
    
    return $response;

});
$app->post('/user/salt', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['Salt'] = filter_var($body['Salt'], FILTER_SANITIZE_STRING);

    $data = set_user_salt($user_data['Username'], $user_data['Salt']);

    $response->getBody()->write($data);
    
    return $response;

});
$app->post('/user/login', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['Password'] = filter_var($body['Password'], FILTER_SANITIZE_STRING);

    $data = check_user_login($user_data['Username'], $user_data['Password']);

    $response->getBody()->write($data);
    
    return $response;

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
    $user_data['JAID'] = filter_var($body['JAID'], FILTER_SANITIZE_STRING);
    $user_data['OptedIn'] = filter_var($body['OptedIn'], FILTER_SANITIZE_STRING);
    $user_data['AssignedStaff'] = filter_var($body['AssignedStaff'], FILTER_SANITIZE_STRING);

    $data = set_new_user($user_data['Username'], $user_data['Password'], $user_data['email'], $user_data['Role'], $user_data['Location'], $user_data['FirstName'], $user_data['LastName'], $user_data['Authentication'], $user_data['JAID'], $user_data['OptedIn'], $user_data['AssignedStaff']);


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
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['LocationID'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
    $user_data['Status'] = filter_var($body['Status'], FILTER_SANITIZE_STRING);
    $user_data['Admin'] = filter_var($body['Admin'], FILTER_SANITIZE_STRING);

    $data = set_staff_authentication($user_data['Username'], $user_data['LocationID'], $user_data['Status'], $user_data['Admin']);
    $response->getBody()->write($data);

    return $response;

});
// $app->post('/staff/update', function (Request $request, Response $response, $args) {

//     $body = $request->getParsedBody();
//     $user_data = [];
//     $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
//     $user_data['LocationID'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
//     $user_data['Status'] = filter_var($body['Status'], FILTER_SANITIZE_STRING);
//     $user_data['Admin'] = filter_var($body['Admin'], FILTER_SANITIZE_STRING);

//     $data = set_staff_authentication($user_data['Username'], $user_data['LocationID'], $user_data['Status'], $user_data['Admin']);
//     $response->getBody()->write($data);

//     return $response;

// });
$app->post('/staff/delete', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['Username'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['LocationID'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);

    $data = delete_staff($user_data['Username'], $user_data['LocationID']);
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


// Group API
// Make sure this stays in the correct order
$app->get('/group', function (Request $request, Response $response) {

    $data = get_all_groups();
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/staff/{staff}', function (Request $request, Response $response, $args) {
    $staff = (string)$args['staff'];

    $data = get_staff_groups($staff);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/staff/{staff}/type/{type}', function (Request $request, Response $response, $args) {
    $staff = (string)$args['staff'];
    $type = (string)$args['type'];

    $data = get_staff_groups_of_type($staff, $type);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/staff/{staff}/type/{type}/archived', function (Request $request, Response $response, $args) {
    $staff = (string)$args['staff'];
    $type = (string)$args['type'];

    $data = get_archived_staff_groups_of_type($staff, $type);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/type/{type}', function (Request $request, Response $response, $args) {
    $staff = (string)$args['staff'];
    $type = (string)$args['type'];

    $data = get_group_type($type);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/location/{id}', function (Request $request, Response $response, $args) {
    $location = (string)$args['id'];

    $data = get_group_location($location);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/location/{id}/archived', function (Request $request, Response $response, $args) {
    $location = (string)$args['id'];

    $data = get_group_location_archived($location);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/location/{id}/type/{type}', function (Request $request, Response $response, $args) {
    $location = (string)$args['id'];
    $type = (string)$args['type'];

    $data = get_group_location_of_type($location, $type);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->get('/group/location/{id}/type/{type}/archived', function (Request $request, Response $response, $args) {
    $location = (string)$args['id'];
    $type = (string)$args['type'];

    $data = get_group_location_of_type_archived($location, $type);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/group/new', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['GroupName'] = filter_var($body['GroupName'], FILTER_SANITIZE_STRING);
    $user_data['GroupAuthor'] = filter_var($body['GroupAuthor'], FILTER_SANITIZE_STRING);
    $user_data['GroupLocation'] = filter_var($body['GroupLocation'], FILTER_SANITIZE_STRING);
    $user_data['GroupType'] = filter_var($body['GroupType'], FILTER_SANITIZE_STRING);

    $data = set_new_group($user_data['GroupName'], $user_data['GroupAuthor'], $user_data['GroupLocation'], $user_data['GroupType']);
    $response->getBody()->write($data);

    return $response;

});
$app->post('/group/client/add', function (Request $request, Response $response, $args) {
    
    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['JAID'] = filter_var($body['JAID'], FILTER_SANITIZE_STRING);
    $user_data['GroupID'] = filter_var($body['GroupID'], FILTER_SANITIZE_STRING);
    $user_data['LastUpdatedAuthor'] = filter_var($body['LastUpdatedAuthor'], FILTER_SANITIZE_STRING);

    $data = set_new_offender($user_data['GroupID'], $user_data['JAID'], $user_data['LastUpdatedAuthor']);
    $response->getBody()->write($data);

    return $response;

});
$app->post('/group/client/remove', function (Request $request, Response $response, $args) {
    
    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['JAID'] = filter_var($body['JAID'], FILTER_SANITIZE_STRING);
    $user_data['GroupID'] = filter_var($body['GroupID'], FILTER_SANITIZE_STRING);
    $user_data['LastUpdatedAuthor'] = filter_var($body['LastUpdatedAuthor'], FILTER_SANITIZE_STRING);

    $data = delete_offender($user_data['GroupID'], $user_data['JAID'], $user_data['LastUpdatedAuthor']);
    $response->getBody()->write($data);

    return $response;

});
$app->post('/group/archive', function (Request $request, Response $response, $args) {
    
    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['GroupID'] = filter_var($body['GroupID'], FILTER_SANITIZE_STRING);
    $user_data['Archivist'] = filter_var($body['Archivist'], FILTER_SANITIZE_STRING);

    $data = archive_group($user_data['GroupID'], $user_data['Archivist']);
    $response->getBody()->write($data);

    return $response;

});
$app->get('/group/{id}', function (Request $request, Response $response, $args) {
    $id = (int)$args['id'];

    $data = get_group($id);
    $newResponse = $response->withJson($data);

    return $newResponse;

});
$app->post('/mail', function (Request $request, Response $response, $args) {

    $body = $request->getParsedBody();
    $user_data = [];
    $user_data['To'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
    $user_data['ToName'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
    $user_data['From'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['FromName'] = filter_var($body['Username'], FILTER_SANITIZE_STRING);
    $user_data['Subject'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);
    $user_data['Body'] = filter_var($body['LocationID'], FILTER_SANITIZE_STRING);

    $data = send_message($user_data['To'], $user_data['ToName'], $user_data['From'], $user_data['FromName'], $user_data['Subject'], $user_data['Body']);
    $response->getBody()->write($data);

    return $response;

});


$app->run();
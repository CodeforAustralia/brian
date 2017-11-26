<?php
require_once "../db_prod.php";

date_default_timezone_set('Australia/Melbourne');



// // Address Data
// if (file_exists('../data/CDF_Address.xml')) {
//     $xml = simplexml_load_file('../data/CDF_Address.xml');
//  		echo '<pre>';
//     // print_r($xml);
//     echo '</pre>';

//     foreach ($xml->Address as $address) {
//         if($address->SourceSystem->ParentEntity->Type == 'Agency') {
//             echo '<pre>';
//             print_r($address);
//             echo '</pre>';
//             // echo $address->SubNumber . ' ' . $address->StreetNumber . ' ' . $address->StreetName . ' ' . $address->StreetType->Description . ' ' . $address->Suburb . ' ' . $address->State->Description . ' ' . $address->Postcode . '<br />'; 
//         }
//     }
// } else {
//     exit('Failed to open test.xml.');
// }

// // Get JAID from current Orders
// // Order loop
// if (file_exists('../data/CDF_Order.xml')) {
//     $z = new XMLReader;
//     $z->open('../data/CDF_Order.xml');

//     $doc = new DOMDocument;

//     // move to the first <product /> node
//     while ($z->read() && $z->name !== 'Order');
//     $counter = 0;

//     // now that we're at the right depth, hop to the next <product/> until the end of the tree
//     echo '<table>';
//     while ($z->name === 'Order') {
//         // either one should work
//         $order = new SimpleXMLElement($z->readOuterXML());

//         $order_type_code = $order->OrderType->Code;
//         $status_code = $order->OrderStatus->Code;

//         if((($order_type_code == '2') || ($order_type_code == '3') || ($order_type_code == '5') || ($order_type_code == '7') || ($order_type_code == '11') || ($order_type_code == '27') || ($order_type_code == '54')) && (($status_code == 'CON' ) || ($status_code == 'CUR' ) || ($status_code == 'NFA' ) || ($status_code == 'VAR' ) || ($status_code == 'VRD' ))) {
//             foreach($order->SourceSystem->ParentEntity as $entity) {
//                 if($entity->Type == 'PersonProfile')
//                     $JAID = $entity->Id;
//             }

//             $user_sql = "INSERT INTO `orionproddb`.`Offender` (`JAID`, `OptedIn`, `LastUpdated`) VALUES ('" . $JAID . "', '0', '" . date('Y-m-d H:i:s', time()) . "');";

//             returnDB()->query($user_sql);
//         }

//         // echo '<pre>';
//         // print_r($order);
//         // echo '</pre>';

//         // go to next <product />
//         $z->next('Order');
//     }
//     echo '</table>';
//     echo $counter;

// } else {
//     exit('Failed to open test.xml.');
// }


// Get list of locations
// CCS Case
if (file_exists('../data/CDF_CCSCase.xml')) {
    $z = new XMLReader;
    $z->open('../data/CDF_CCSCase.xml');

    $doc = new DOMDocument;

    // move to the first <product /> node
    while ($z->read() && $z->name !== 'CCSCase');
    $counter = 0;

    // now that we're at the right depth, hop to the next <product/> until the end of the tree
    echo '<table>';
    while ($z->name === 'CCSCase') {
        // either one should work
        $order = new SimpleXMLElement($z->readOuterXML());

        $JAID = $order->SourceSystem->ParentEntity->Id;

        $status_code = $order->CaseStatus->Code;
        $status_desc = $order->CaseStatus->Description;

        $location_code = $order->Location->Code;
        $location_desc = $order->Location->Description;

        $apb_location_code = $order->AgencyAPBRegion->Code;
        $apb_location_desc = $order->AgencyAPBRegion->Description;

        // echo '<tr><td>' . $status_code . '</td><td>' . $status_desc . '</td></tr>';

        // if($status_code == 'CUR')
        //     echo '<tr><td>' . $location_code . '</td><td>' . $location_desc . '</td><td>' . $apb_location_code . '</td><td>' . $apb_location_desc . '</td></tr>';

        // $user_sql = "UPDATE `orionproddb`.`Offender` SET `FirstName`='" . $first_name . "', `LastName`='" . $last_name . "' WHERE `JAID`='" . $JAID . "';"; 
        // returnDB()->query($user_sql);

        echo '<pre>';
        print_r($order);
        echo '</pre>';

        // go to next <product />
        $z->next('CCSCase');
    }
    echo '</table>';
    echo $counter;

} else {
    exit('Failed to open test.xml.');
}

// // Get list of locations
// // CCS Case
// if (file_exists('../data/CDF_CaseAssignment.xml')) {
//     $z = new XMLReader;
//     $z->open('../data/CDF_CaseAssignment.xml');

//     $doc = new DOMDocument;

//     // move to the first <product /> node
//     while ($z->read() && $z->name !== 'CaseAssignment');
//     $counter = 0;

//     // now that we're at the right depth, hop to the next <product/> until the end of the tree
//     echo '<table>';
//     while ($z->name === 'CaseAssignment') {
//         // either one should work
//         $order = new SimpleXMLElement($z->readOuterXML());
//         echo '<pre>';
//         print_r($order);
//         echo '</pre>';

//         // go to next <product />
//         $z->next('CaseAssignment');
//     }
//     echo '</table>';
//     echo $counter;

// } else {
//     exit('Failed to open test.xml.');
// }

// // CCS Case
// if (file_exists('data/CCSCase_sample1.xml')) {
//     $xml = simplexml_load_file('data/CCSCase_sample1.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';

// } else {
//     exit('Failed to open test.xml.');
// }


// if (file_exists('data/CCSCase_sample1.xml')) {
//     $xml = simplexml_load_file('data/CCSCase_sample1.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }

// if (file_exists('data/CCSCase_sample2.xml')) {
//     $xml = simplexml_load_file('data/CCSCase_sample2.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }

// if (file_exists('data/Order_sample1.xml')) {
//     $xml = simplexml_load_file('data/Order_sample1.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }

// if (file_exists('data/Order_sample2.xml')) {
//     $xml = simplexml_load_file('data/Order_sample2.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }
// if (file_exists('data/Program_sample1.xml')) {
//     $xml = simplexml_load_file('data/Program_sample1.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }
// if (file_exists('data/Program_sample2.xml')) {
//     $xml = simplexml_load_file('data/Program_sample2.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }
// if (file_exists('data/Program_sample3.xml')) {
//     $xml = simplexml_load_file('data/Program_sample3.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }
// if (file_exists('data/TelephoneContactDetails_sample1.xml')) {
//     $xml = simplexml_load_file('data/TelephoneContactDetails_sample1.xml');
//  		echo '<pre>';
//     print_r($xml);
//     echo '</pre>';
// } else {
//     exit('Failed to open test.xml.');
// }
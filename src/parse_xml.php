<?php

// // Address Data
// if (file_exists('data/CDF_Address.xml')) {
//     $xml = simplexml_load_file('data/CDF_Address.xml');
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

if (file_exists('data/Order_sample1.xml')) {
    $xml = simplexml_load_file('data/Order_sample1.xml');
 		echo '<pre>';
    // print_r($xml);
    echo '</pre>';


    foreach ($xml->Order as $order) {
        if($order->OrderType->Code == 'CCO') {
            $case_ID = $order->SourceSystem->Entity->Id;
            foreach($order->SourceSystem->ParentEntity as $entity) {
                if($entity->Type == 'PersonProfile')
                    $JAID = $entity->Id;
            }
            $last_updated = $order->LastUpdated;
            $order_status = $order->OrderStatus->Code;
            $start_date = $order->StartDate;
            $end_date = $order->EndDate;

            foreach($order->OrderCondition as $condition) {
                
            }
            // echo '<pre>';
            // print_r($order);
            // echo '</pre>';
            echo $address->SubNumber . ' ' . $address->StreetNumber . ' ' . $address->StreetName . ' ' . $address->StreetType->Description . ' ' . $address->Suburb . ' ' . $address->State->Description . ' ' . $address->Postcode . '<br />'; 
        }
    }


} else {
    exit('Failed to open test.xml.');
}

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
?>
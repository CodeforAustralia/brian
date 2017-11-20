<?php
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

// Order loop
if (file_exists('../data/CDF_Order.xml')) {
    $z = new XMLReader;
    $z->open('../data/CDF_Order.xml');

    $doc = new DOMDocument;

    // move to the first <product /> node
    while ($z->read() && $z->name !== 'Order');

    // now that we're at the right depth, hop to the next <product/> until the end of the tree
    while ($z->name === 'Order')
    {
        // either one should work
        $node = new SimpleXMLElement($z->readOuterXML());
        // $node = simplexml_import_dom($doc->importNode($z->expand(), true));

        // echo '1';
        // now you can use $node without going insane about parsing
        echo '<pre>';
        print_r($node);
        echo '</pre>';

        // go to next <product />
        $z->next('Order');
    }

   //  $xml = simplexml_load_file('data/CDF_Order.xml');
 		// echo '<pre>';
   //  print_r($xml);
   //  echo '</pre>';

    // foreach ($xml->Order as $order) {
    // 		$order_type = $order->OrderType->Code;
    //     if($order_type == 'CCO') {
    //         $case_ID = $order->SourceSystem->Entity->Id;
    //         foreach($order->SourceSystem->ParentEntity as $entity) {
    //             if($entity->Type == 'PersonProfile')
    //                 $JAID = $entity->Id;
    //         }
    //         $last_updated = $order->LastUpdated;
    //         $status = $order->OrderStatus->Code;
    //         $start_date = $order->StartDate;
    //         $end_date = $order->EndDate;
    //         $duration = $order->Duration;

				// 		$user_sql = "INSERT INTO testdb.Order (OrderID, JAID, Type, Status, StartDate, EndDate, Duration, LastUpdated) VALUES ('" . $case_ID . "', '" . $JAID . "', '" . $order_type . "', '" . $status . "', '" . $start_date . "', '" . $end_date . "', '" . $ . "', '" . $last_updated . "' );";
				// 		returnDB()->query($user_sql);

    //         foreach($order->OrderCondition as $condition) {
    //           $condition_ID = $condition->ConditionId;
    //           $condition_start_date = $condition->StartDate;
    //           $condition_end_date = $condition->EndDate;
    //           $condition_type = $condition->ConditionType->Description;
    //           $condition_duration = $condition->Duration;
    //           $condition_status = $condition->Status->Code;

				// 			$condition_sql = "INSERT INTO testdb.Order (OrderID, JAID, Type, Status, StartDate, EndDate, Duration, LastUpdated) VALUES ('" . $case_ID . "', '" . $JAID . "', '" . $order_type . "', '" . $status . "', '" . $start_date . "', '" . $end_date . "', '" . $ . "', '" . $last_updated . "' );";
				// 			returnDB()->query($condition_sql);

    //         }
    //     }
    // }
} else {
    exit('Failed to open test.xml.');
}


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
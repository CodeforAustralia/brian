<?php
// The file test.xml contains an XML document with a root element
// and at least an element /[root]/title.

if (file_exists('data/Assessment_sample1.xml')) {
    $xml = simplexml_load_file('data/Assessment_sample1.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}

if (file_exists('data/Assessment_sample2.xml')) {
    $xml = simplexml_load_file('data/Assessment_sample2.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}

if (file_exists('data/CCSCase_sample1.xml')) {
    $xml = simplexml_load_file('data/CCSCase_sample1.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}

if (file_exists('data/CCSCase_sample2.xml')) {
    $xml = simplexml_load_file('data/CCSCase_sample2.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}

if (file_exists('data/Order_sample1.xml')) {
    $xml = simplexml_load_file('data/Order_sample1.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}

if (file_exists('data/Order_sample2.xml')) {
    $xml = simplexml_load_file('data/Order_sample2.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}
if (file_exists('data/Program_sample1.xml')) {
    $xml = simplexml_load_file('data/Program_sample1.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}
if (file_exists('data/Program_sample2.xml')) {
    $xml = simplexml_load_file('data/Program_sample2.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}
if (file_exists('data/Program_sample3.xml')) {
    $xml = simplexml_load_file('data/Program_sample3.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}
if (file_exists('data/TelephoneContactDetails_sample1.xml')) {
    $xml = simplexml_load_file('data/TelephoneContactDetails_sample1.xml');
 		echo '<pre>';
    print_r($xml);
    echo '</pre>';
} else {
    exit('Failed to open test.xml.');
}
?>
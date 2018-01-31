<?php

// $data = "{'mdp':'EN45p0'}";
// $url = "./authorization.php";
//
// $options = array(
//   'http' => array(
//     'method'  => 'POST',
//     'content' => json_encode( $data ),
//     'header'=>  "Content-Type: application/json\r\n" .
//                 "Accept: application/json\r\n"
//     )
// );
//
// $context  = stream_context_create( $options );
// $result = file_get_contents( $url, false, $context );
// $response = json_decode( $result );
//
// var_dump($result);
// var_dump($response);

$options = array(
  'http' => array(
    'method'  => 'POST',
    'header'=>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
    )
);

$data = "{'mdp':'EN45p0'}";
$url = "./authorization.php";
http_post_data ($url, $data, $options);

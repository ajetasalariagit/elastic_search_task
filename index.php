<?php

require ('vendor/autoload.php');
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
// $hosts = [
//     [
//         'host' => '127.0.0.1',
//         'port' => '5601',
//         'user' => 'elastic',
//         'pass' => '6bJML7QcfWSQOjzwofqB'
//     ]
// ];
$client = ClientBuilder::create()
    ->setHosts(['localhost:9200'])
    ->build();
$params = [
    'index' => 'my_index',
    'id'=>'my_index',
    'body'  => [ 'testField' => 'abc']
];
$params = [
    'index' => 'my_index',
    'body'  => [
        'query' => [
            'match' => [
                'testField' => 'abc'
            ]
        ]
    ]
];

//  try {
    $response = $client->search($params);
//  } catch (ClientResponseException $e) {
//    // manage the 4xx error
//    echo"1";
//  } catch (ServerResponseException $e) {
//     echo"2";
//  } catch (Exception $e) {
//     echo"3";
//    // eg. network error like NoNodeAvailableException
//  }

printf("Total docs: %d\n", $response['hits']['total']['value']);
printf("Max score : %.4f\n", $response['hits']['max_score']);
printf("Took      : %d ms\n", $response['took']);
echo"<pre>";
print_r($response['hits']['hits']);

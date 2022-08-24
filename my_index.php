<?php

require('D:elastic_new\vendor\autoload.php');

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

$mongo = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongo->json_task;
$collection = $db->corp_comp;
$data = $collection->find(['status'=>"3"]);
 $data_arr = current($data->toarray());
 unset($data_arr['_id']);
 unset($data_arr['status']);
 unset($data_arr['created']);
 unset($data_arr['udpated']);
 $id = $data_arr['company_cin'];

$client = ClientBuilder::create()
    ->setHosts(['localhost:9200'])
    ->build();
    $params = [
        'index' => 'corp_comp',
        'id' => $id,
        'body'  => $data_arr
           
    ];
$response = $client->index($params);

$updated = date('Y-m-d h:i:s');

if($response){
$data = $collection->updateOne(
    ['company_cin' => $id ],
    ['$set' => ['status' => '4','udpated'=>$updated]]
  );
}else{
    $data = $collection->updateOne(
        ['company_cin' => $id ],
        ['$set' => ['status' => '5']]
      );  
}
print_r($data);
 

//mongo query update

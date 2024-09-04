<?php
//headers
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/ordini.php';

$database = new Database();
$db = $database->getConnection();
$ordini = new Ordini($db);
$data = json_decode(file_get_contents("php://input"));
if (
  !empty($data->id_ordine) ||
  !empty($data->data_vendita) ||
  !empty($data->dest_paese)

) {
  $ordini->id_ordine = $data->id_ordine;
  $ordini->data_vendita = $data->data_vendita;
  $ordini->dest_paese = $data->dest_paese;


  if ($ordini->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Ordine creato correttamente"));
  } else {
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile creare l' ordine"));
  }
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Impossibile creare l'ordine i dati sono incompleti"));
}

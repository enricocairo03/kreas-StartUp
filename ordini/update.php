<?php
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

$ordini->id_ordine = $data->id_ordine;
$ordini->data_vendita = $data->data_vendita;
$ordini->dest_paese = $data->dest_paese;


if ($ordini->update()) {
  http_response_code(200);
  echo json_encode(array("risposta" => "Ordine aggiornato"));
} else {
  // 503 service unavailable
  http_response_code(503);
  echo json_encode(array("risposta" => "Impossibile aggiornare l' ordine"));
}

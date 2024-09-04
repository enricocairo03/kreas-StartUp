<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/prodotti.php';

$database = new Database();
$db = $database->getConnection();

$prodotti = new Prodotti($db);

$data = json_decode(file_get_contents("php://input"));

$prodotti->id_prodotto = $data->id_prodotto;

if ($prodotti->delete()) {
  http_response_code(200);
  echo json_encode(array("risposta" => "Il prodotto è stato eliminato"));
} else {
  //503 service unavailable
  http_response_code(503);
  echo json_encode(array("risposta" => "Impossibile eliminare il prodotto"));
}

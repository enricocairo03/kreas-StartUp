<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../models/ordini_items.php';

$database = new Database();
$db = $database->getConnection();

$ordini_items = new Ordini_items($db);

$data = json_decode(file_get_contents("php://input"));

$ordini_items->id_ordine_prodotti = $data->id_ordine_prodotti;
$ordini_items->id_ordini = $data->id_ordini;
$ordini_items->id_prodotto = $data->id_prodotto;
$ordini_items->quantita = $data->quantita;

if ($ordini_items->update()) {
  http_response_code(200);
  echo json_encode(array("risposta" => "Ordine_items aggiornato"));
} else {
  // 503 service unavailable
  http_response_code(503);
  echo json_encode(array("risposta" => "Impossibile aggiornare l' ordine_items"));
}

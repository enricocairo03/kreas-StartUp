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
$prodotti->nome = $data->nome;
$prodotti->co2_salvata = $data->co2_salvata;


if ($prodotti->update()) {
  http_response_code(200);
  echo json_encode(array("risposta" => "Prodotto aggiornato"));
} else {
  // 503 service unavailable
  http_response_code(503);
  echo json_encode(array("risposta" => "Impossibile aggiornare il prodotto"));
}

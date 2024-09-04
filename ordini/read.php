<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// includiamo database.php e ordini.php per poterli usare
include_once '../config/database.php';
include_once '../models/ordini.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();
// Creiamo un nuovo oggetto Ordini
$ordini = new Ordini($db);
// query products
$stmt = $ordini->read();
$num = $stmt->rowCount();
// se vengono trovati degli ordini
if ($num > 0) {
  //array ordini
  $ordini_arr = array();
  $ordini_arr["records"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $ordini_item = array(
      "id_ordine" => $id_ordine,
      "data_vendita" => $data_vendita,
      "dest_paese" => $dest_paese

    );
    array_push($ordini_arr["records"], $ordini_item);
  }
  echo json_encode($ordini_arr);
} else {
  echo json_encode(
    array("message" => "Nessun ordine trovato")
  );
}

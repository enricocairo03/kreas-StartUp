<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// includiamo database.php e ordini.php per poterli usare
include_once '../config/database.php';
include_once '../models/ordini_items.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();
// Creiamo un nuovo oggetto Ordini_items
$ordini_items = new Ordini_items($db);
// query products
$stmt = $ordini_items->read();
$num = $stmt->rowCount();
// se vengono trovati degli ordini_items
if ($num > 0) {
  //array ordini
  $ordini_items_arr = array();
  $ordini_items_arr["records"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $ordini_items_item = array(
      "id_ordine_prodotti" => $id_ordine_prodotti,
      "id_ordini" => $id_ordini,
      "id_prodotto" => $id_prodotto,
      "quantita" => $quantita
    );
    array_push($ordini_items_arr["records"], $ordini_items_item);
  }
  echo json_encode($ordini_items_arr);
} else {
  echo json_encode(
    array("message" => "Nessun ordine_items trovato")
  );
}

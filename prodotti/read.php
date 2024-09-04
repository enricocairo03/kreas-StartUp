<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// includiamo database.php e ordini.php per poterli usare
include_once '../config/database.php';
include_once '../models/prodotti.php';

// creiamo un nuovo oggetto Database e ci colleghiamo al nostro database
$database = new Database();
$db = $database->getConnection();
// Creiamo un nuovo oggetto prodotti
$prodotti = new Prodotti($db);
// query products
$stmt = $prodotti->read();
$num = $stmt->rowCount();
// se vengono trovati degli ordini
if ($num > 0) {
  // array ordini
  $prodotti_arr = array();
  $prodotti_arr["records"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $prodotti_item = array(
      "id_prodotto" => $id_prodotto,
      "nome" => $nome,
      "co2_salvata" => $co2_salvata
    );
    array_push($prodotti_arr["records"], $prodotti_item);
  }
  echo json_encode($prodotti_arr);
} else {
  echo json_encode(
    array("message" => "Nessun prodotto trovato")
  );
}

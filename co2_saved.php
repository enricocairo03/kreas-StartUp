<?php

header('Content-Type: application/json');

include_once '../config/database.php';


$database = new Database();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"), true);


$data_inizio = $data['data_inizio'] ?? null;
$data_fine = $data['data_fine'] ?? null;
$dest_paese = $data['dest_paese'] ?? null;
$nome_prodotto = $data['nome_prodotto'] ?? null;


if ($data_inizio && $data_fine && $dest_paese && $nome_prodotto) {
  $query = "SELECT
  SUM(prodotti.co2_salvata * ordine_items.quantita) AS totale_co2
FROM
ordine
JOIN
 ordine_items ON ordine.id_ordine = ordine_items.id_ordini
 JOIN
 prodotti ON ordine_items.id_prodotto = prodotti.id_prodotto
 WHERE
 ordine.data_vendita BETWEEN :data_inizio AND :data_fine
    AND ordine.dest_paese = :dest_paese
    AND prodotti.nome = :nome_prodotto ";
  $stmt = $conn->prepare($query);

  $stmt->bindParam(":data_inizio", $data_inizio);
  $stmt->bindParam(":data_fine", $data_fine);
  $stmt->bindParam(":dest_paese", $dest_paese);
  $stmt->bindParam(":nome_prodotto", $nome_prodotto);

  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode($result);
} else {
  // Risposta di errore se i parametri mancano
  echo json_encode(['error' => 'Parametri mancanti. Si prega di fornire data_inizio, data_fine e dest_paese e nome_prodotto.']);
}

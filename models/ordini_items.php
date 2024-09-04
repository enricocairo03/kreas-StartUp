<?php
class Ordini_items
{
  private $conn;
  private $table_name = "ordine_items";

  // Proprietà di un ordine
  public $id_ordine_prodotti;
  public $id_ordini;
  public $id_prodotto;
  public $quantita;

  // Cosstruttore
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Leggere ordini
  function read()
  {
    $query = "SELECT
                   a.id_ordine_prodotti, a.id_ordini, a.id_prodotto, a.quantita
                   FROM 
                   " . $this->table_name . " a ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  // Creare Ordine
  function create()
  {
    $query = "INSERT INTO
    " . $this->table_name . "
     SET
     id_ordine_prodotti=:id_ordine_prodotti, id_ordini=:id_ordini, id_prodotto=:id_prodotto, quantita=:quantita ";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione dei dati
    $this->id_ordine_prodotti = htmlspecialchars(strip_tags($this->id_ordine_prodotti));
    $this->id_ordini = htmlspecialchars(strip_tags($this->id_ordini));
    $this->id_prodotto = htmlspecialchars(strip_tags($this->id_prodotto));
    $this->quantita = htmlspecialchars(strip_tags($this->quantita));

    $stmt->bindParam(":id_ordine_prodotti", $this->id_ordine_prodotti);
    $stmt->bindParam(":id_ordini", $this->id_ordini);
    $stmt->bindParam(":id_prodotto", $this->id_prodotto);
    $stmt->bindParam(":quantita", $this->quantita);

    // Esecuzione query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // Aggiornare Ordini_items
  function update()
  {
    $query = "UPDATE
                 " . $this->table_name . "
                 SET
                    id_ordini = :id_ordini,
                    id_prodotto = :id_prodotto,
                    quantita = :quantita
                 WHERE
                      id_ordine_prodotti = :id_ordine_prodotti";

    $stmt =  $this->conn->prepare($query);

    // Sanitazzazione dei dati
    $this->id_ordine_prodotti = htmlspecialchars(strip_tags($this->id_ordine_prodotti));
    $this->id_ordini = htmlspecialchars(strip_tags($this->id_ordini));
    $this->id_prodotto = htmlspecialchars(strip_tags($this->id_prodotto));
    $this->quantita = htmlspecialchars(strip_tags($this->quantita));

    // Binding dei parametri

    $stmt->bindParam(":id_ordine_prodotti", $this->id_ordine_prodotti);
    $stmt->bindParam(":id_ordini", $this->id_ordini);
    $stmt->bindParam(":id_prodotto", $this->id_prodotto);
    $stmt->bindParam(":quantita", $this->quantita);


    // Esecuzione query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // Cancellare ordini_itmes
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id_ordine_prodotti = ?";

    $stmt = $this->conn->prepare($query);

    $this->id_ordine_prodotti = htmlspecialchars(strip_tags($this->id_ordine_prodotti));

    // Binding del parametro

    $stmt->bindParam(1, $this->id_ordine_prodotti);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}

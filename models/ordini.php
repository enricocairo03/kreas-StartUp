<?php
class Ordini
{
  private $conn;
  private $table_name = "ordine";

  // Proprietà di un ordine
  public $id_ordine;
  public $data_vendita;
  public $dest_paese;




  // Costruttore
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Leggere ordini
  function read()
  {
    $query = "SELECT
                      a.id_ordine, a.data_vendita, a.dest_paese
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
    id_ordine=:id_ordine, data_vendita=:data_vendita, dest_paese=:dest_paese";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione dei dati
    $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));
    $this->data_vendita = htmlspecialchars(strip_tags($this->data_vendita));
    $this->dest_paese = htmlspecialchars(strip_tags($this->dest_paese));


    // Binding dei parametri
    $stmt->bindParam(":id_ordine", $this->id_ordine);
    $stmt->bindParam(":data_vendita", $this->data_vendita);
    $stmt->bindParam(":dest_paese", $this->dest_paese);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }



  // Aggiornare Ordine
  function update()
  {
    $query = "UPDATE
                  " . $this->table_name . "
                  SET
                      data_vendita = :data_vendita,
                      dest_paese = :dest_paese
                     
                  WHERE
                      id_ordine = :id_ordine";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione dei dati
    $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));
    $this->data_vendita = htmlspecialchars(strip_tags($this->data_vendita));
    $this->dest_paese = htmlspecialchars(strip_tags($this->dest_paese));

    // Binding dei parametri
    $stmt->bindParam(":id_ordine", $this->id_ordine);
    $stmt->bindParam(":data_vendita", $this->data_vendita);
    $stmt->bindParam(":dest_paese", $this->dest_paese);


    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // Cancellare Ordine
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id_ordine = ?";

    $stmt = $this->conn->prepare($query);

    $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));

    // Binding del parametro
    $stmt->bindParam(1, $this->id_ordine);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}

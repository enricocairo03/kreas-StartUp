<?php
class Prodotti
{
  private $conn;
  private $table_name = "prodotti";
  // proprietà di un prodotto
  public $id_prodotto;
  public $nome;
  public $co2_salvata;
  // costruttore
  public function __construct($db)
  {
    $this->conn = $db;
  }
  // read ordini
  function read()
  {
    //select all
    $query = "SELECT
                     a.id_prodotto, a.nome, a.co2_salvata
                  FROM
                  " . $this->table_name . " a   ";
    $stmt = $this->conn->prepare($query);
    //execute query
    $stmt->execute();
    return $stmt;
  }
  // Creare prodotto
  function create()
  {
    $query = "INSERT INTO
    " . $this->table_name . "
    SET
    id_prodotto=:id_prodotto, nome=:nome, co2_salvata=:co2_salvata";
    $stmt = $this->conn->prepare($query);


    $this->id_prodotto = htmlspecialchars(strip_tags($this->id_prodotto));
    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->co2_salvata = htmlspecialchars(strip_tags($this->co2_salvata));

    //binding
    $stmt->bindParam(":id_prodotto", $this->id_prodotto);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":co2_salvata", $this->co2_salvata);

    //execute query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  // aggiornare Prodotto
  function update()
  {
    $query = "UPDATE
              " . $this->table_name . "
           SET
               nome= :nome,
               co2_salvata= :co2_salvata
           WHERE
              id_prodotto= :id_prodotto";
    $stmt = $this->conn->prepare($query);

    $this->id_prodotto = htmlspecialchars(strip_tags($this->id_prodotto));
    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->co2_salvata = htmlspecialchars(strip_tags($this->co2_salvata));

    //binding
    $stmt->bindParam(":id_prodotto", $this->id_prodotto);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":co2_salvata", $this->co2_salvata);

    //execute query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
  // CANCELLARE PRODOTTO
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id_prodotto = ?";

    $stmt = $this->conn->prepare($query);

    $this->id_prodotto = htmlspecialchars(strip_tags($this->id_prodotto));

    $stmt->bindParam(1, $this->id_prodotto);

    //execute query
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}

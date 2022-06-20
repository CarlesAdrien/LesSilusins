<?php

class FamilleDAO extends DAO {
    
  /**
  * Constructeur
  */
  function __construct() {
      parent::__construct();
  }

  function findAll() {
      $sql = "SELECT * FROM famille";
      try {
        $sth=$this->executer($sql); 
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
      }
      $familles = array();
      foreach ($rows as $row) {
        $familles[] = new Famille($row);
      }
      return $familles;
  } // function findAll() 

  function findAll_order_by_promo() {
    $sql = "SELECT * FROM famille WHERE promo_famille < 2 ORDER BY promo_famille DESC";
    try {
      $sth=$this->executer($sql); 
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $familles = array();
    foreach ($rows as $row) {
      $familles[] = new Famille($row);
    }
    return $familles;
} // function findAll() 

  function find($id_famille) {
    $sql = "SELECT * FROM famille WHERE id_famille= :id_famille";
    try {
      $params = array(":id_famille" => $id_famille);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $famille = null;
    if ($row) {
      $famille = new Famille($row);
    }
    return $famille;
  } // function find

  function find_by_lib($lib_famille) {
    $sql = "SELECT * FROM famille WHERE lib_famille= :lib_famille";
    try {
      $params = array(":lib_famille" => $lib_famille);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $famille = null;
    if ($row) {
      $famille = new Famille($row);
    }
    return $famille;
  } // function find

  function insert(Famille $famille)
    {
      $sql = "INSERT INTO `famille`(`lib_famille`, `promo_famille`) 
              VALUES 
              (:lib_famille, :promo_famille)";
      $params = array(
        ":lib_famille" => $famille->get_lib_famille(),
        ":promo_famille" => $famille->get_promo_famille(),
      );
      try {
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
      } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
      }
    } // insert()

    function update_promo_famille(Famille $famille) {
      $sql = "UPDATE famille SET promo_famille = :promo_famille WHERE id_famille = :id_famille";
      $params = array(
        ":id_famille" => $famille->get_id_famille(),
        ":promo_famille" => $famille->get_promo_famille(),
      );
      try {
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
      } catch (PDOException $e) {
        throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
      }
    } // update()

    function delete($id_famille) {
      $sql = "DELETE FROM famille WHERE id_famille=:id_famille";
      $params = array(
        ":id_famille" => $id_famille
      );
      try {
        $sth = $this->executer($sql, $params); // On passe par la méthode de la classe mère
        $nb = $sth->rowcount();
      } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
      }
    } // delete()
}

<?php
class Artikkel
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    public function getArtikkler()
    {
    try
        {
            $stmt = $this->db->prepare("SELECT * FROM Artikkel");
            $stmt->execute();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
}
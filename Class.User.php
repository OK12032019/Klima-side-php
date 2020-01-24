<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    
    public function register($bnavn,$epost,$pw,$btype)
    {
       try
       {
         $btype ='1';
         $salt = 'IT2_2020';
         $new_password = sha1($salt.$pw);

         $stmt = $this->db->prepare("INSERT INTO bruker(brukernavn,passord,fnavn,enavn,epost,telefon,brukertype) 
                                                      VALUES(:bnavn, :pw, 'Fornavn', 'Etternavn', :epost, 'telefonnr', :btype)");
            
         $stmt->bindparam(":bnavn", $bnavn);
         $stmt->bindparam(":epost", $epost);
         $stmt->bindparam(":pw", $new_password);
         $stmt->bindparam(":btype", $btype);            
         $stmt->execute(); 

         return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
    public function PassordReset($bnavn,$pw,$npw)
    {
       try
       {
           $stmt = $this->db->prepare('SELECT * FROM bruker WHERE brukernavn=:bnavn LIMIT 1');
           $stmt->execute(array(':bnavn'=>$bnavn));
           $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
           if($stmt->rowCount() > 0)
           {
              $salt ='IT2_2020';
              $pw = sha1($salt.$pw);
              $npw =sha1($salt,$npw);
              if($userRow['passord']==$pw)
              {
                 $stmt = $this->db->prepare('UPDATE bruker SET passord = :npassord WHERE brukernavn =:bnavn');
                 $stmt->execute(array(':npassord'=>$npw,':bnavn'=>$bnavn));
                 return true;
              }
              else
              {
                 return false;
              }
           }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($bnavn,$pw)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn=:bnavn LIMIT 1");
          $stmt->execute(array(':bnavn'=>$bnavn,));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             $salt ='IT2_2020';
             $pw = sha1($salt.$pw);
             if($userRow['passord']==$pw)
             {
                $_SESSION['user_session'] = $userRow['idbruker'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>
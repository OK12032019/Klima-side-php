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
    public function sjekkOgNullstill($bnavn)
    {
      try
      {
         $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn=:bnavn LIMIT 1");
         $stmt->execute(array(':bnavn'=>$bnavn,));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

         if (strtotime($userRow['feillogginnsiste']) < time()-(5*60))
         {
            $null = '0';
            $stmt = $this->db->prepare("UPDATE bruker SET feillogginnteller = :nopp WHERE brukernavn =:bnavn");
            $stmt->execute(array(':bnavn'=>$bnavn, ':nopp'=>$null));
            return True;
         }
         else
         {
            return False;
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
      
    }
    public function feilLoginAntall($bnavn)
    {
       try
       {
         $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn=:bnavn LIMIT 1");
         $stmt->execute(array(':bnavn'=>$bnavn,));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         if($userRow['feillogginnteller']=5)
         {
            return True;
         }
         else
         {
            $_SESSION['feilAntall']=$userRow['feillogginnteller'];
            return False;
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
    }
/*    public function feilLoginTeller($bnavn)
    {
       try
       {
         $nyAntall = $_SESSION['feilAntall'];
         $stmt = $this->db->prepare("UPDATE bruker SET feillogginnteller = :nyAntall WHERE brukernavn =:bnavn");
         $stmt->execute(array(':bnavn'=>$bnavn, ':nyAntall'=>$nyAntall));
       }
       catch(PDOException $e)
         {
            echo $e->getMessage();
         } 
    }
*/
    public function getFeilLoginSiste($bnavn)
    {
       try
       {
         $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn =:bnavn");
         $stmt->execute(array(':bnavn'=>$bnavn));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         if($stmt->rowCount() > 0)
          {
            try
            {
               $nyAntall = "1";
               $nyAntall = $nyAntall + $userRow['feillogginnteller'];
               $stmt = $this->db->prepare("UPDATE bruker SET feillogginnteller = :nyAntall WHERE brukernavn =:bnavn");
               $stmt->execute(array(':bnavn'=>$bnavn, ':nyAntall'=>$nyAntall));
            }
            catch(PDOException $e)
            {
               echo $e->getMessage();
            } 
            return True;
          }
          else
          {
             return False;
          }

       }
       catch(PDOException $e)
         {
            echo $e->getMessage();
         } 
    }
    public function setFeilLoginSiste($bnavn)
    {
      try
      {
         $timeNow = time();
         $stmt = $this->db->prepare("UPDATE bruker SET feillogginnsiste = :timeNow WHERE brukernavn =:bnavn");
         $stmt->execute(array(':bnavn'=>$bnavn, ':timeNow'=>$timeNow));
         return True;
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
                $_SESSION['fnavn'] = $userRow['fnavn'];
                $_SESSION['enavn'] = $userRow['enavn'];
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
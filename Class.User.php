<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    
    public function register($bnavn,$epost,$pw,$btype,$fnavn,$enavn,$telefon)
    {
       try
       {
         $salt = 'IT2_2020';
         $beskrivelse = 'eksempel';
         $new_password = sha1($salt.$pw);

         $stmt = $this->db->prepare("INSERT INTO bruker(brukernavn,passord,fnavn,enavn,epost,telefonnummer,beskrivelse,brukertype) 
                                                VALUES(:bnavn, :pw, :fnavn, :enavn, :epost, :telefonnummer,:beskrivelse, :brukertype)");
            
         $stmt->bindparam(":bnavn", $bnavn);
         $stmt->bindparam(":pw", $new_password);
         $stmt->bindparam(":fnavn", $fnavn); 
         $stmt->bindparam(":enavn", $enavn);
         $stmt->bindparam(":epost", $epost);
         $stmt->bindparam(":telefonnummer", $telefon);
         $stmt->bindparam(":brukertype", $btype);      
         $stmt->bindparam(":beskrivelse", $beskrivelse);          
         $stmt->execute(); 

         return true; 
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

         if (strtotime($userRow['feilloginnsiste']) < time()-(5*60))
         {
            $null = '0';
            $stmt = $this->db->prepare("UPDATE bruker SET feilloginnteller = :nopp WHERE brukernavn =:bnavn");
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
         if($userRow['feilloginnteller']=5)
         {
            return True;
         }
         else
         {
            $_SESSION['feilAntall']=$userRow['feilloginnteller'];
            return False;
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
    }

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
               $nyAntall = $nyAntall + $userRow['feilloginnteller'];
               $stmt = $this->db->prepare("UPDATE bruker SET feilloginnteller = :nyAntall WHERE brukernavn =:bnavn");
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
         $stmt = $this->db->prepare("UPDATE bruker SET feilloginnsiste = :timeNow WHERE brukernavn =:bnavn");
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
                $_SESSION['brukerid'] = $userRow['idbruker'];
                $_SESSION['btype'] = $userRow['brukertype'];
                $_SESSION['bnavn'] = $userRow['brukernavn'];
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

   public function InteresseFinnes($input)
   {
      try
      {
         $stmt = $this->db->prepare("SELECT * FROM interesse WHERE interessenavn = :interessenavn");
         $stmt->execute(array('interessenavn'=>$input));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         if ($userRow !="")
         {
            return true;
            $_SESSION['interesseid'] = $userRow['idinteresse'];
            $error2 = 'InteresseFinnes True';
            $error2 = $_SESSION['error2'];
            
         }
         else
         {
            return false;
            $error2 = 'InteresseFinnes false';
            $error2 = $_SESSION['error2'];
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
   }
   public function nyInteresse($input)
   {
      try
      {
         $error2 = 'nyInteresse1';
         $stmt = $this->db->prepare("INSERT INTO interesse (interessenavn) 
                                                   VALUES(:interessenavn)");
         $stmt->execute(array(':interessenavn'=>$input,));
         $stmt = $this->db->prepare("SELECT * FROM interesse WHERE interessenavn = :interessenavn");
         $stmt->execute(array('interessenavn'=>$input));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         $_SESSION['interesseid'] = $userRow['idinteresse'];
         return true;
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
          return false;
      }
   }
   public function SubmitButton1($interesseid,$brukerid)
   {
      
      try
      {
         $stmt = $this->db->prepare("INSERT INTO brukerinteresse (bruker,interesse) 
                                                   VALUES(:bruker, :interesse)");
         $stmt->execute(array(':interesse'=>$interesseid, ':bruker'=>$brukerid));
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
   }

   public function SubmitButton2($username,$input)
   {
      //echo ('$username: ');
      //echo $username;
      //echo ('<br>');
      //echo ('$input: ');
      //echo $input;
      //echo ('<br>');
      try
      {
         $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn=:bnavn LIMIT 1");
         $stmt->execute(array(':bnavn'=>$username));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         $brukerid = $userRow['idbruker'];
         //echo $username;
         //echo ('idbruker: ');
         //echo $brukerid;
      }
      catch(PDOException $e)
      {
      echo $e->getMessage();
      }
      try
      {
         $stmt = $this->db->prepare("SELECT idinteresse FROM interesse WHERE interessenavn = :input");
         $stmt->execute(array(':input'=>$input));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         $interesseid = $userRow['idinteresse'];
         
         $stmt = $this->db->prepare("INSERT INTO brukerinteresse (bruker,interesse) 
                                                         VALUES(:bruker, :interesse)");
         $stmt->execute(array(':interesse'=>$interesseid, ':bruker'=>$brukerid)); 
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
      }
      }
   }   

?>
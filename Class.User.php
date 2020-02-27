<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    public function sletteInteresse($userid, $interesseid)
    {
       try
       {
      echo ('test69');
      $stmt = $this->db->prepare("DELETE FROM brukerinteresse WHERE bruker = :userid AND interesse = :interesseid"); 
      $stmt->execute(array(':userid'=>$userid, ':interesseid'=>$interesseid));
      
      return true;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       } 
    }
    public function artikkel($forrigeArtikkelID)
    {
      $stmt = $this->db->prepare("SELECT * FROM artikkel WHERE idartikkel < :forrigeArtikkelID ORDER BY idartikkel DESC"); 
      $stmt->execute(array(':forrigeArtikkelID'=>$forrigeArtikkelID));
      $result=($stmt->fetch(PDO::FETCH_ASSOC));
      return $result;
    }
    public function artikkelsOk()
    {
      try{
         $stmt = $this->db->prepare('SELECT * FROM artikkel');
         $stmt->execute();
         $count = $stmt->rowCount();
         return $count;
      }
      catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
    public function largeArtikkel($tittel, $artikkel, $brukerid)
    {
      try{
         $artinngress = ('test');
         $stmt = $this->db->prepare("INSERT INTO artikkel (artnavn, artinngress, arttekst, bruker)
         VALUES(:artnavn, :artinngress, :arttekst, :bruker)");

         $stmt->bindparam(":artnavn", $tittel);
         $stmt->bindparam(":artinngress", $artinngress);
         $stmt->bindparam(":arttekst", $artikkel);
         $stmt->bindparam(":bruker", $brukerid);
         $stmt->execute(); 

            return true; 
      }
      catch(PDOException $e)
      {
            echo $e->getMessage();
      } 
    }
    public function artikkelKommentar($ingress, $tekst, $tid, $artikkleid, )
    { 
      try
      {
        
         $stmt = $this->db->prepare("INSERT INTO kommentar (ingress, tekst, tid, artikkelid)
         VALUES(:ingress, :tekst, :tid, :artikkelid)");

         $stmt->bindparam(":ingress", $ingress);
         $stmt->bindparam(":tekst", $tekst);
         $stmt->bindparam(":tid", $tid);
         $stmt->bindparam(":artikkelid", $artikkelid);
         $stmt->execute(); 

            return true; 
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
      } 
    }
    public function sOk($brukersOk)
    {
      try{
         $stmt = $this->db->prepare("SELECT brukernavn FROM bruker WHERE brukernavn = :brukersOk LIMIT 1"); 
         $stmt->execute(array(':brukersOk'=>$brukersOk));
         $result=($stmt->fetch(PDO::FETCH_ASSOC));
         return $result;
      }
      catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
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

    public function antallBrukere()
    {
      try
      {
         $stmt = $this->db->prepare('SELECT * FROM bruker ORDER BY idbruker ASC');
         $stmt->execute();
         $count = $stmt->rowCount();
         return $count;
      }
      catch(PDOException $e)
       {
           echo $e->getMessage();
       }  
    }
    public function brukerListe()
    {
       try
       {
         $stmt = $this->db->prepare('SELECT * FROM bruker ORDER BY idbruker ASC');
         $stmt->execute();
         $result=($stmt->fetch(PDO::FETCH_ASSOC));
         return $result;
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
         $stmt = $this->db->prepare("SELECT * FROM bruker WHERE brukernavn=':bnavn' LIMIT 1");
         $stmt->execute(array(':bnavn'=>$bnavn,));
         $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
         if($userRow['feillogginnteller']==5)
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

    public function feilLoginTeller($bnavn)
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
         $timeNow = date("Y-m-d H:i:s");
         $stmt = $this->db->prepare("UPDATE bruker SET feillogginnsiste = :timeNow WHERE brukernavn =:bnavn");
         $stmt->execute(array(':timeNow'=>$timeNow, ':bnavn'=>$bnavn));
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
<?php
class USER
{
   private $db;
 
   public function __construct($DB_con)
   {
     $this->db = $DB_con;
   }
   public function epostFinnes($email)
   {
      try{
         $stmt = $this->db->prepare("SELECT idbruker, epost FROM bruker WHERE epost = :epost LIMIT 1;");

         $stmt->execute(array(':epost'=>$email));
         $epost=($stmt->fetchAll());
         if(!empty($epost))
         {
            return true; 
         }
         else
         {
            return false;
         }
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function updateBrukertype($brukeridUppdate, $brukertype)
   {
      try{
         $stmt = $this->db->prepare('UPDATE bruker SET brukertype = :brukertype WHERE idbruker =:brukerid');
         $stmt->execute(array(':brukertype'=>$brukertype,':brukerid'=>$brukeridUppdate));
         return true;
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function getBrukere()
   {
      try{
         $stmt = $this->db->prepare("SELECT idbruker, brukernavn FROM bruker WHERE brukertype = '3' OR brukertype = '2';");
         $stmt->execute();
         $brukere=($stmt->fetchAll());
         return $brukere; 
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function getFylkeNavn($fylke)
   {
      try{
         $stmt = $this->db->prepare("SELECT fylkenavn FROM fylke WHERE idfylke = :idfylke");
         $stmt->execute(array(':idfylke'=>$fylke));
         $fylkeNavn=($stmt->fetchAll());
         return $fylkeNavn; 
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function getEventBilde($eventID)
   {
      $stmt = $this->db->prepare("SELECT * FROM eventbilde WHERE event = :event LIMIT 1");
         $stmt->execute(array(':event'=>$eventID));
         $Bilde=($stmt->fetchAll());
         if(!empty($Bilde)){
         foreach($Bilde as $row){
         $bildeID = $row["bilde"];}
         
         

         $stmt = $this->db->prepare("SELECT hvor FROM bilder WHERE idbilder = :idbilde LIMIT 1");
         $stmt->execute(array(':idbilde'=>$bildeID));
         $Bilde=($stmt->fetchAll());
         return $Bilde; 
         }
   }
   public function getEvent($eventID)
    {
       try{
         $stmt = $this->db->prepare("SELECT * FROM event WHERE idevent = :idevent LIMIT 1");
         $stmt->execute(array(':idevent'=>$eventID));
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
   public function getEvents($date, $nextMonth)
    {
    try
        {
            $stmt = $this->db->prepare('SELECT * FROM Event WHERE tidspunkt BETWEEN :tidspunkt AND :nextMonth');
            $stmt->bindparam(":tidspunkt", $date);
            $stmt->bindparam(":nextMonth", $nextMonth);
            $stmt->execute();
            $result=$stmt->fetchAll();
            return $result;
        }
    catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
   public function uploadEventBilde($fileDestination, $InsertID)
   {
      try{
         $stmt = $this->db->prepare("INSERT INTO bilder (hvor) VALUES (:bilde)");
         $stmt->bindparam(":bilde", $fileDestination);
         $stmt->execute();
         
         $bildeInsertID = $this->db->lastInsertId();
         $stmt = $this->db->prepare("INSERT INTO eventbilde (event, bilde) VALUES (:event, :bilde);");
         $stmt->bindparam(":event", $InsertID);
         $stmt->bindparam(":bilde", $bildeInsertID);
         $stmt->execute();
         return true;
   }
   catch(PDOException $e)
   {
       echo $e->getMessage();
       return false;
   }
}
   public function setEvent($eventnavn, $eventtekst, $tidspunkt, $veibeskrivelse, $brukerid, $fylke)
   {
      $stmt = $this->db->prepare("SELECT * FROM fylke");
      $stmt->execute();
      $fylkerReturn=($stmt->fetchAll());
      if(empty($fylkerReturn)){
         $stmt = $this->db->prepare("INSERT INTO fylke (fylkenavn) VALUES ('testdal'),
         ('Oslo'),
         ('Rogaland'),
         ('Møre og Romsdal'),
         ('Norland'),
         ('Viken'),
         ('Innland'),
         ('Vestfold og Telemark'), 
         ('Agder'), 
         ('Vestland'), 
         ('Trøndelag'),
         ('Troms og Finnmark');");
         $stmt->execute();
      }
      $stmt = $this->db->prepare("INSERT INTO event (eventnavn, eventtekst, tidspunkt, veibeskrivelse, idbruker, fylke)
         VALUES(:eventnavn, :eventtekst, :tidspunkt, :veibeskrivelse, :idbruker, :fylke)");

         $stmt->bindparam(":eventnavn", $eventnavn);
         $stmt->bindparam(":eventtekst", $eventtekst);
         $stmt->bindparam(":tidspunkt", $tidspunkt);
         $stmt->bindparam(":veibeskrivelse", $veibeskrivelse);
         $stmt->bindparam(":idbruker", $brukerid);
         $stmt->bindparam(":fylke", $fylke);
         $stmt->execute();
         $InsertID = $this->db->lastInsertId();
         return $InsertID;

   }
   public function setRegel($regel,$brukerid)
   {
      $goAhead = False;
      try{
         if(is_dir('./regler') === false)
         {
            mkdir('C:\xampp\htdocs\loggintest\regler');
         }

         $path = ('regler/regler.php');
         $filename = ('/regler.php');
         if(file_exists($path))
         {
            $_SESSION['debug'] = ('Funka');
            $file = fopen($path,"r+");
            $goAhead = True;
         }
         else{
            try{
               $head = ('<!DOCTYPE html>
               <html>
                  <head>
                     <meta charset ="UTF-8">
                     <?php include "../minmeny.php"; ?>
                     <!--Import Google Icon Font-->
                     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                     <link type="text/css" rel="stylesheet" href="../css/Flat.css"  media="screen,projection"/>
                     <!--Let browser know website is optimized for mobile-->
                     <meta name="viewport" content="width=device-width, initial-scale=1.0"/></head>');
               $file = fopen($path,"x+");
               
               fwrite($file,$head);
               fwrite($file,"\t<body><div class='container'><h1>Regler:</h1>\n");
               try
            {
               $result = $this->getRegler();
               fwrite($file, "\n<ol>");
               foreach($result as $row)
               {
                  $_SESSION['debug'] = $row;
                  fwrite($file,"<li><p>");
                  fwrite($file, $row['regeltekst']);
                  fwrite($file,"</p></li>\n");
               }
               fwrite($file,"</ol>\n");
            }
            catch(PDOException $e)
            {
               echo $e->getMessage();
            }
               fwrite($file,'</div><footer class="background-color ">
               <div class ="row">
               <section class="col m6 s12 center-align">
               <a href="">Om oss</a>
               <a href="">Sidekart</a>
               <a href="">Kariarre</a>
               <a href="">Støtt oss</a>
               <a href="">In English</a>
               </section>
               <section class="col m6 s12 center-align">Gruppe 30 | copyright 2019</section>
               </footer>
               </div>
               </body>
               </html>');
               $goAhead = True;
            }
            catch(PDOException $e)
            {
                  echo $e->getMessage();
            }
         }
         if($goAhead == True)
         {
            
            try
            {
               fseek($file, -557, SEEK_END);
               $endcopy = fread($file, 9999);
               fseek($file, -557, SEEK_END);
               fwrite($file,"<li><p>");
               fwrite($file, $regel);
               fwrite($file,"</li></p>\n");
               fwrite($file, $endcopy);
               $regeltekst=$regel;
               $this->setRegler($regeltekst, $brukerid);
            }
            catch(PDOException $e)
            {
               echo $e->getMessage();
            }
         }
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
   }
   public function setBeskrivelse($brukerid, $Bio)
   {
      try{
         $stmt = $this->db->prepare('UPDATE bruker SET beskrivelse = :beskrivelse WHERE idbruker =:brukerid');
         $stmt->execute(array(':beskrivelse'=>$Bio,':brukerid'=>$brukerid));
         return true;
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
   }
   public function lastInsertId()
   {
      return $this->db->lastInsertId();
   }
   public function getProfilBilde($brukerid)
   {
      try{
        $stmt = $this->db->prepare("SELECT bilde FROM brukerbilde WHERE bruker= :brukerid");
        $stmt->bindparam(':brukerid', $brukerid);
        $stmt->execute();
        $bildeID=($stmt->fetchAll());
        $stmt = $this->db->prepare("SELECT * FROM bilder WHERE idbilder= :bildeid");
        $stmt->bindparam(':bildeid', $bildeID[0]['bilde']);
        $stmt->execute();
        $profilBilde=($stmt->fetchAll());
        return $profilBilde;
      }
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
   }
   public function uploadProfilBilde($fileDestination, $brukerid)
    {
      try{
      $stmt = $this->db->prepare("SELECT * FROM brukerbilde WHERE bruker= :brukerid");
      $stmt->bindparam(':brukerid', $brukerid);
      $stmt->execute();
      $bildeID=($stmt->fetchAll());
      if($bildeID!= 0){
         $stmt = $this->db->prepare("DELETE FROM brukerbilde WHERE bruker = :brukerid");
         $stmt->bindparam(":brukerid", $brukerid);
         $stmt->execute();
      }
      $stmt = $this->db->prepare("INSERT INTO bilder (hvor) VALUES (:bilde)");
      $stmt->bindparam(":bilde", $fileDestination);
      $stmt->execute();
      
      $InsertID = $this->db->lastInsertId();
      $stmt = $this->db->prepare("INSERT INTO brukerbilde (bruker, bilde) VALUES (:bruker, :bilde);");
      $stmt->bindparam(":bruker", $brukerid);
      $stmt->bindparam(":bilde", $InsertID);
      $stmt->execute();
      return true;
    }
    catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function getBio($brukerid)
   {
      $stmt = $this->db->prepare("SELECT beskrivelse FROM bruker WHERE idbruker= :brukerid");
      $stmt->bindparam(':brukerid', $brukerid);
      $stmt->execute();
      $Bio=($stmt->fetchAll(PDO::FETCH_ASSOC));
      return $Bio;
   }
   public function getBrukersInterreser($brukerid)
   {
      try{
         $stmt = $this->db->prepare("SELECT * FROM brukerinteresse WHERE bruker = :brukerid;");
         $stmt->bindparam(":brukerid", $brukerid);
         $stmt->execute();
         $result=($stmt->fetchAll());
         $interesseNavnArray = [];
         foreach($result as $row){
            $stmt = $this->db->prepare("SELECT * FROM interesse WHERE idinteresse = :interesse;");
            $stmt->bindparam(":interesse", $row['interesse']);
            $stmt->execute();
            $interesseNavn=($stmt->fetchAll(PDO::FETCH_ASSOC));
            array_push($interesseNavnArray, $interesseNavn);
         }
         return $interesseNavnArray;
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function setInteresse($interessenavn)
   {
      try{
         #$interessenavn = 'testdata';
         $stmt = $this->db->prepare("INSERT INTO interesse (interessenavn) VALUES (:interessenavn);");
         $stmt->bindparam(":interessenavn", $interessenavn);
         $stmt->execute(); 

            return true;
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function sjekkOmInteresseEksisterer($interessenavn)
   {
      try{
         $stmt = $this->db->prepare("SELECT * FROM interesse WHERE interessenavn = :interessenavn; ");
         $stmt->bindparam(":interessenavn", $interessenavn);
         $stmt->execute();
         $result=($stmt->fetchAll());
         if(empty($result)){
            return false;
         }
         else{
            return true;
         }
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function setEksisterendeInteresse($brukerid, $interesseid)
   {
      try{
         $stmt = $this->db->prepare("INSERT INTO brukerinteresse (bruker, interesse) VALUES (:bruker, :interesse)");
         $stmt->bindparam(":bruker", $brukerid);
         $stmt->bindparam(":interesse", $interesseid);
         $stmt->execute(); 

            return true;
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
   public function getInterreser()
   {
      try{
         $stmt = $this->db->prepare("SELECT * FROM interesse; ");
         $stmt->execute();
         $result=($stmt->fetchAll());
         return $result;
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
         return false;
      }
   }
    public function getArtikkel($artID)
    {
       try{
         $stmt = $this->db->prepare("SELECT * FROM Artikkel WHERE idartikkel = :idartikkel LIMIT 1");
         $stmt->execute(array(':idartikkel'=>$artID));
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
    public function getArtikkler()
    {
    try
        {
            $stmt = $this->db->prepare("SELECT * FROM Artikkel");
            $stmt->execute();
            $result=$stmt->fetchAll();
            return $result;
        }
    catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
    public function uploadBilde($ArtikkelIDtilBilde, $fileDestination)
    {
      $stmt = $this->db->prepare("INSERT INTO bilder (idbilder, hvor) VALUES (:idbilder, :hvor)");
      $stmt->bindparam(":idbilder", $ArtikkelIDtilBilde);
      $stmt->bindparam(":hvor", $fileDestination);
      $stmt->execute(); 

         return true;
    }
    public function getBilde($artID)
    {
       try{
         $stmt = $this->db->prepare("SELECT * FROM bilder WHERE idBilder= :idBilder");
         $stmt->bindparam(':idBilder', $artID);
         $stmt->execute();
         $Bilde=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $Bilde;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function getidArtikkel($tittel)
{
    try{
      $stmt = $this->db->prepare("SELECT * FROM artikkel WHERE artnavn= :artnavn;");
      $stmt->bindparam(":artnavn", $tittel); 
      $stmt->execute();
      $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
      return $result;
    }
    catch(PDOException $e)
       {
           echo $e->getMessage();
       }
      }
    public function getRegler()
    {
       try
       {
         $stmt = $this->db->prepare("SELECT * FROM regel;"); 
         $stmt->execute();
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function setRegler($regeltekst, $brukerid)
    {
    try{
         $stmt = $this->db->prepare("INSERT INTO regel (regeltekst, idbruker)
         VALUES(:regeltekst, :idbruker)");

         $stmt->bindparam(":regeltekst", $regeltekst);
         $stmt->bindparam(":idbruker", $brukerid);
         $stmt->execute(); 

            return true; 
      }      
      catch(PDOException $e)
      {
          echo $e->getMessage();
      }
    }
    public function getAdvarsel($brukerid)
    {
       try{
         $stmt = $this->db->prepare("SELECT * FROM advarsel WHERE bruker= :idbruker;");
         $stmt->bindparam(":idbruker", $brukerid); 
         $stmt->execute();
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function getAdvarselAdmin()
    {
       try
       {
         $stmt = $this->db->prepare("SELECT * FROM advarsel;"); 
         $stmt->execute();
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }
    public function setAdvarsel($advarseltekst, $brukerid, $mottaker)
    {
       try
       {
         $stmt = $this->db->prepare("INSERT INTO advarsel (advarseltekst, bruker, administrer)
         VALUES(:advarseltekst, :bruker, :administrer)");
   
         $stmt->bindparam(":advarseltekst", $advarseltekst);
         $stmt->bindparam(":bruker", $mottaker);
         $stmt->bindparam(":administrer", $Brukerid);
         $stmt->execute(); 
   
            return true; 
       }      
       catch(PDOException $e)
       {
            echo $e->getMessage();
       }
    }
    public function deleteEkskludering($brukerid)
    {
       try
       {
         $stmt = $this->db->prepare("DELETE FROM eksklusjon WHERE bruker = :bruker");
         $stmt->bindparam(":bruker", $brukerid);
         $stmt->execute();
         return true;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       } 
    }
    public function getEkskludering($brukerid)
    {
       try
       {
         $stmt = $this->db->prepare("SELECT * FROM eksklusjon WHERE bruker = :bruker;");
         $stmt->bindparam(":bruker", $brukerid);
         $stmt->execute();
         $result=($stmt->fetchAll(PDO::FETCH_ASSOC));
         return $result;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       } 
    }
    public function setEkskludering($grunnlag, $datofra, $datotil, $mottaker, $brukerid)
    {
       try
       {
         $stmt = $this->db->prepare("INSERT INTO eksklusjon (grunnlag, datofra, datotil, bruker, administrator)
         VALUES(:grunnlag, :datofra, :datotil, :bruker, :administrator)");

         $stmt->bindparam(":grunnlag", $grunnlag);
         $stmt->bindparam(":datofra", $datofra);
         $stmt->bindparam(":datotil", $datotil);
         $stmt->bindparam(":bruker", $mottaker);
         $stmt->bindparam(":administrator", $brukerid);
         $stmt->execute();

         return true;
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       } 
    }
    public function sletteInteresse($userid, $interesseid)
    {
       try
       {
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
    public function getKommentar($artID)
    {
       try{
         $stmt = $this->db->prepare("SELECT * FROM kommentar WHERE artikkel = :artikkel"); 
         $stmt->execute(array(':artikkel'=>$artID));
         $result=($stmt->fetchAll());
         return $result;
       }
       catch(PDOException $e)
      {
         echo $e->getMessage();
      }
    }
    public function artikkelKommentar($ingress, $tekst, $tid, $artikkelid, $bruker)
    { 
      try
      {
        
         $stmt = $this->db->prepare("INSERT INTO kommentar (komingress, komtekst, tid, artikkel, bruker)
         VALUES(:komingress, :komtekst, :tid, :artikkel, :bruker)");

         $stmt->bindparam(":komingress", $ingress);
         $stmt->bindparam(":komtekst", $tekst);
         $stmt->bindparam(":tid", $tid);
         $stmt->bindparam(":artikkel", $artikkelid);
         $stmt->bindparam(":bruker", $bruker);
         $stmt->execute(); 

            return true; 
      }
      catch(PDOException $e)
      {
         echo $e->getMessage();
      } 
    }
    public function sOk($interesseId)
    {
      try{
         $stmt = $this->db->prepare("SELECT * FROM brukerinteresse WHERE interesse = :interesseId"); 
         $stmt->execute(array(':interesseId'=>$interesseId));
         $result=($stmt->fetchAll());
         $BrukereArray = [];
         foreach($result as $row){
            $stmt = $this->db->prepare("SELECT brukernavn FROM bruker WHERE idbruker = :brukerID"); 
            $stmt->execute(array(':brukerID'=>$row['bruker']));
            $result=($stmt->fetchAll());

            array_push($BrukereArray, $result);
         }
         return $BrukereArray;
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
    public function PassordReset($brukerid,$pw,$npw)
    {
       try
       {
           $stmt = $this->db->prepare('SELECT * FROM bruker WHERE idbruker=:bid LIMIT 1');
           $stmt->execute(array(':bid'=>$brukerid));
           $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
           if($stmt->rowCount() > 0)
           {
              $salt ='IT2_2020';
              $pw = sha1($salt.$pw);
              $npw =sha1($salt,$npw);
              if($userRow['passord']==$pw)
              {
                 $stmt = $this->db->prepare('UPDATE bruker SET passord = :npassord WHERE idbruker =:bid');
                 $stmt->execute(array(':npassord'=>$npw,':bid'=>$brukerid));
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
                $_SESSION['date'] = date("Y-m-d");
                $_SESSION['debug'] = '';
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

   public function nyMelding($meldingtittel, $meldingtekst, $tid, $sender, $mottaker) {
      try
      {
         $stmt = $this->db->prepare("INSERT INTO melding (tittel, tekst, tid, lest, papirkurv, sender, mottaker)
         VALUES(:tittel, :tekst, :tid, 0, 0, :sender, :mottaker)");

         $stmt->bindparam(":tittel", $meldingtittel);
         $stmt->bindparam(":tekst", $meldingtekst);
         $stmt->bindparam(":tid", $tid);
         $stmt->bindparam(":sender", $sender);
         $stmt->bindparam(":mottaker", $mottaker);
         $stmt->execute();
         
      }
      catch(PDOException $e) 
      {
         echo $e->getMessage();
      }
   }

   public function nyRapport($rapporttekst, $dato, $rapportertbruker, $rapportertav) {
      try
      {
         $stmt = $this->db->prepare("INSERT INTO brukerrapport (tekst, dato, rapportertbruker, rapportertav)
         VALUES(:tekst, :dato, :rapportert, :av)");

         $stmt->bindparam(":tekst", $rapporttekst);
         $stmt->bindparam(":dato", $dato);
         $stmt->bindparam(":rapportert", $rapportertbruker);
         $stmt->bindparam(":av", $rapportertav);
         $stmt->execute();
      }
      catch(PDOException $e) 
      {
         echo $e->getMessage();
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
/* INSERT INTO fylke (fylkenavn) VALUES ('testdal'),
('Oslo'),
('Rogaland'),
('Møre og Romsdal'),
('Norland'),
('Viken'),
('Innland'),
('Vestfold og Telemark'), 
('Agder'), 
('Vestland'), 
('Trøndelag'),
('Troms og Finnmark');
*/
?>

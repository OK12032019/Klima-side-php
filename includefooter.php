<?php
require_once 'PDO.php';

if($user->is_loggedin()=="True")
{
$btype = $_SESSION['btype'];


}
else{
    $btype = 0;
}

if($btype == 1){

   ?>
  
     <footer class="hovedfooter">

        <section class="lenker_footer">


        <a href="">Om oss</a>
        <a href="">Sidekart</a>
        <a href="">Kariarre</a>
        <a href="">Støtt oss</a>
        <a href="">In English</a>
        </section>
    <section class="copyright">Gruppe 30 | copyright 2019</section>
	        

    </footer>
	<?php
   }
else if($btype == 2){

   
    ?>
	
    <footer class="hovedfooter">

        <section class="lenker_footer">

        <a href="">Om oss</a>
        <a href="">Sidekart</a>
        <a href="">Kariarre</a>
        <a href="">Støtt oss</a>
        <a href="">In English</a>
        </section>
    <section class="copyright">Gruppe 30 | copyright 2019</section>
    </footer>
		<?php 
   }
 else if($btype== 3){

     ?>
    <footer class="hovedfooter">

        <section class="lenker_footer">

        <a href="">Om oss</a>
        <a href="">Sidekart</a>
        <a href="">Kariarre</a>
        <a href="">Støtt oss</a>
        <a href="">In English</a>
        </section>
    <section class="copyright">Gruppe 30 | copyright 2019</section>
    </footer>
	 <?php
   }

   
else{
   echo "Du er ikke logget inn";
   ?>
    <footer class="hovedfooter">

        <section class="lenker_footer">

        <a href="">Om oss</a>
        <a href="">Sidekart</a>
        <a href="">Kariarre</a>
        <a href="">Støtt oss</a>
        <a href="">In English</a>
        </section>
    <section class="copyright">Gruppe 30 | copyright 2019</section>
    </footer>
	 <?php
   }
    ?>

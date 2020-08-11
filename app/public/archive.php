<!DOCTYPE html>
<html lang="ro">
  <link rel="stylesheet" type="text/css" href="style.css">
  <?php include('header.php'); ?>
  <body>
    <h1>A list with some of the best movies released in 2000 or after</h1>

    <?php     
      $movies = json_decode(file_get_contents('https://raw.githubusercontent.com/yegor-sytnyk/movies-list/master/db.json'))->movies;
    ?>

    <div class="row">
      <div class="column">
        <?php
          $duratele_filmelor=array();
          foreach($movies as $film){
            if($film->year >= 2000)$duratele_filmelor[]=$film->runtime;
          }
          $durataMax=max($duratele_filmelor);
          $toti_actorii=array();
        ?>
        <ul class="a">
          <?php
            foreach($movies as $film_cur)
            {
              $an=$film_cur->year;
              if($an < 2000) continue;
          ?>
          <li>           
            <h2><?php echo $film_cur->title; ?></h2>
            <div class="info-film">
              <?php  
                
              ?>
              <div class="imagine">
                <img 
                  src="
                  <?php 
                    if( @getimagesize($film_cur->posterUrl) )echo $film_cur->posterUrl;
                    else echo 'https://media3.picsearch.com/is?EHXO7tKx0v5nFBbKvNm3jCcV4SthoKj7xVz-_mK7o48&height=304';
                  ?>"
                >
            
              </div>          
              <ul class="b"> <!--inceputul listei (una pt fiecare film) cu detalii despre film-->                  
                <li>               
                  <?php 
                  echo "Released in ";
                  if($an >= 2010){ ?>
                  <strong><?php echo $an; ?> </strong>
                  <?php }else {echo $an;}?>
                </li>
                <?php $descriere=$film_cur->plot; ?>

                <li>
                  <div class="plot">
                    <?php echo 'Plot: ' ;

                      if(strlen($descriere)>100){
                        echo substr($descriere, 0, 100) . '...';
                      }else echo $descriere;
                    ?>
                  </div>
                </li>
                
                <li>
                  <div class="genuri">
                    <?php
                      echo "Genres: ";
                      for($w = 0 ; $w < count($film_cur->genres)-1 ; $w++)echo "{$film_cur->genres[$w]}, ";
                      
                      echo $film_cur->genres[$w]; 
                    ?>              
                  </div>
                </li>

                <li>
                  <div class="actori">
                    <?php echo "Main actors:"; ?>
                    <ol>
                      <?php
                        $actors=$film_cur->actors;
                        $actors_list=explode(', ' , $actors);
                        
                        for($l = 0 ; $l < count($actors_list) ; $l++){
                        $toti_actorii[]=$actors_list[$l];
                      ?>
                      <li>
                        <?php
                          echo $actors_list[$l];
                        ?>
                      </li>
                      <?php } ?>
                    </ol>
                  </div>
                </li>
              
                <li>
                  <div class="runtime">
                    <div class="timp">
                      <?php
                        //afiseaza durata filmului in ore si minute
                        echo "Runtime: ";
                        $ore=floor($film_cur->runtime / 60);
                        $minute=$film_cur->runtime % 60;
                        echo $ore , " hour";

                        if($ore > 1)echo 's'; //daca dureaza mai mult sau egal cu 2 ore adauga 's' la 'hour'
      
                        if($minute >= 1){
                        echo " and ", $minute , " minute";
                        if($minute > 1)echo 's';
                        } //0 minute -> nu afiseaza; mai mult de 1 min -> afiseaza 'minute' la plural
                      ?>
                    </div>
                    <div class="runtime-bar">
                      <div class="bara" style="width: <?php echo $film_cur -> runtime * 100 / $durataMax; ?>%;">

                      </div>  
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </li>
         <?php } ?> 
        </ul>
      </div>
      <div class="column">
        <div class="fixed-sidebar-text">
          <ul>
            <?php
              $toti_actorii=array_unique($toti_actorii);
              sort($toti_actorii);
              foreach($toti_actorii as $d){
            ?>
            <li>
              <?php echo $d . "<br>";} ?>
            </li>
          </ul>
        </div>
      </div>
    </div>
<?php include('footer.php'); ?>
  
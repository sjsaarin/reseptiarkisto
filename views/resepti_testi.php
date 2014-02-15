<h1>reseptien lisäys-lomakkeen testaussivu</h1>

<ul>

    <li>Nimi: <?php echo $data->nimi; ?></li>
    <li>Kategoria: <?php echo $data->kategoria; ?></li> 
    <li>Raaka-aineet (id): <?php echo implode($data->raakaaine); ?></li>
    <li>Määrät: <?php echo implode($data->maara); ?></li>
    <li>Yksiköt: <?php echo implode($data->yksikko); ?></li>
    <li>Pääraaka-aine: <?php echo $data->paaraakaaine; ?></li>
    <li>Annoksia: <?php echo $data->annoksia; ?></li>
    <li>Ohje: <?php echo $data->ohje; ?></li>
    <li>Juomasuositus<?php echo $data->juomasuositus; ?></li> 
    <li>Lähde: <?php echo $data->lahde; ?></li>

</ul>
    
    <pre><?php echo $data->ohje; ?></pre>
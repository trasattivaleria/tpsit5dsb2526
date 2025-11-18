<?php
if (isset($_POST['expJson'])) {
    $xmlFile = 'xml/menu.xml';
    $menu = simplexml_load_file($xmlFile);
    $json = json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // Impostiamo gli header per forzare il download del file JSON
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="piatti.json"');
    
    // Esportiamo il JSON come download
    echo $json;  
    exit; 
}
?>

<!DOCTYPE html>   
<html>
    <head>
        <title>Trasatti Valeria TPSIT</title>
        <link href="css/bootstrap.css" rel="stylesheet" >
        
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="bg-dark text-white text-center py-4">
                    <h1><?php require 'inc/header.php';?></h1>
                </div> 
                 
            </div>
            
            <div class="row ">
                <div class="col-md-3 p-3">
                     <?php require 'inc/menu.php';?>
                </div>

                <div class="col-sm-9 p-3">
                    <form action="export_xml_json.php" method="POST">
                        <h1>Esportazione JSON file menu.xml</h1>
                        <button type="submit" class="btn btn-primary" name="json">JSON</button>
                        <button type="submit" class="btn btn-primary" name="expJson">Exp JSON</button>
                    </form>

                    
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-12">
                                  <?php
                                if (isset($_POST['json'])) {
                                    // Visualizza il JSON in formato leggibile
                                    $xmlFile = 'xml/menu.xml';
                                    if (file_exists($xmlFile)) {
                                        $menu = simplexml_load_file($xmlFile);  
                                        $json = json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);  // Converte in JSON
                                        echo "<pre>$json</pre>";  // Visualizza il JSON formattato
                                    } else {
                                        echo "Errore: file XML non trovato.";
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    
                  
                    
                </div>
            </div>

            <div class="row">
                <div class="bg-dark text-white text-center py-4">
                    <?php require 'inc/footer.php';?>
                </div> 

         </div>
        
    </body>
</html>

                    

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
                    <form action="xml_gest.php" method="POST">
                        <div class="form-group">
                            <label class="form-label">Nome</label>
                            <input type="text" class="form-control w-50" name="nome"><br>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipologia</label>
                            <input type="text" class="form-control w-50" name="tipologia"><br>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Descrizione</label>
                            <input type="text" class="form-control w-50" name="descrizione"><br>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prezzo</label>
                            <input type="number" class="form-control w-50" name="prezzo"><br>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">Vegano</label>
                            <!-- checkbox per vegano -->
                            <input type="checkbox" class="form-check-input" name="vegano" value="vegano" checked>
                            
                        </div>
                        <div class="form-check pb-4">
                            <label class="form-check-label">Vegetariano</label>
                            <!-- checkbox per vegetariano -->
                            <input type="checkbox" class="form-check-input"  name="vegetariano" value="vegetariano" checked> 
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Invia</button>
                        <!-- checkbox in versione swich per attivare la convalida con xsd -->
                        <div class="form-check form-switch pt-3">
                            <label class="form-check-label fw-medium" for="flexSwitchCheckDefault">Convalida con XSD</label>
                            <input class="form-check-input shadow-sm border" type="checkbox" id="flexSwitchCheckDefault">
                        </div>
                    </form>
                    
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-center mb-4">MENU</h3>
                                <?php
                                
                                $xmlFile = 'xml/menu.xml';

                                if (file_exists($xmlFile)) {
                                    //carico il menu dal file xml
                                    $menu = simplexml_load_file($xmlFile);
                                    //creo una tabella reponsive con bootstrap dove salvare i piatti del file xml
                                    if ($menu && count($menu->piatto) > 0) {
                                        echo '<div class="table-responsive">';
                                        echo '<table class="table table-striped table-bordered table-hover">';
                                        echo '<thead class=".thead-dark">';
                                        echo '<tr>';
                                        echo '<th>Nome</th>';
                                        echo '<th>Tipologia</th>';
                                        echo '<th>Descrizione</th>';
                                        echo '<th>Prezzo (€)</th>';
                                        echo '<th>Vegetariano</th>';
                                        echo '<th>Vegano</th>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        //per ogni piatto del menù aggiungo una row alla tabella con le info del file xml
                                        foreach ($menu->piatto as $piatto) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($piatto->nome) . '</td>';
                                            echo '<td>' . htmlspecialchars($piatto->tipologia) . '</td>';
                                            echo '<td>' . htmlspecialchars($piatto->descrizione) . '</td>';
                                            echo '<td>' . htmlspecialchars($piatto->prezzo) . '</td>';
                                            echo '<td>' . htmlspecialchars($piatto->vegano) . '</td>';
                                            echo '<td>' . htmlspecialchars($piatto->vegetariano) . '</td>';
                                            echo '</td>';
                                            echo '</tr>';
                                        }

                                        echo '</tbody>';
                                        echo '</table>';
                                        echo '</div>';
                                    } else {
                                        //se il file xml è vuoto mando un alert
                                        echo '<div class="alert alert-warning text-center">Nessun piatto disponibile nel menu.</div>';
                                    }
                                } else {
                                    //se il file xml non esiste mando un alert
                                    echo '<div class="alert alert-danger text-center">File menu.xml non trovato.</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        if (isset($_POST['submit']) ) {
                            //prendo i valori dal form
                            $nome = $_POST['nome'];
                            $tipologia = $_POST['tipologia'];
                            $descrizione = $_POST['descrizione'];
                            $prezzo = $_POST['prezzo'];
                            //controllo il value passato a vegano e vegetariano ed assegno si o no in base alla checkbox
                            $vegano = isset($_POST['vegano']) ? 'si' : 'no';
                            $vegetariano = isset($_POST['vegetariano']) ? 'si' : 'no';

                            //controllo che il form non sia vuoto
                            if (!empty($nome) && !empty($tipologia) && !empty($descrizione) && !empty($prezzo)) {
                            //riprendo il file xml per modificarlo
                            $xmlFile = 'xml/menu.xml';
                            $menu = simplexml_load_file($xmlFile);

                            //aggiungo il nuovo piatto con le info del form post
                            $nuovoPiatto = $menu->addChild('piatto');
                            $nuovoPiatto->addChild('nome', htmlspecialchars($nome));
                            $nuovoPiatto->addChild('tipologia', htmlspecialchars($tipologia));
                            $nuovoPiatto->addChild('descrizione', htmlspecialchars($descrizione));
                            $nuovoPiatto->addChild('prezzo', htmlspecialchars($prezzo));
                            $nuovoPiatto->addChild('vegetariano', $vegetariano);
                            $nuovoPiatto->addChild('vegano', $vegano);
            
                            if ($menu->asXML($xmlFile)) {
                                echo 'Modifiche avvenute con successo, aggiorna la pagina per visualizzare le modifiche';
                            }
                            }
                        }        
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="bg-dark text-white text-center py-4">
                    <?php require 'inc/footer.php';?>
                </div> 

         </div>
        
    </body>
</html>


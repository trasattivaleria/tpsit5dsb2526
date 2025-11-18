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
            
            <div class="row">
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
                            <input type="checkbox" class="form-check-input" name="vegano" value="vegano" checked>
                        </div>
                        <div class="form-check pb-4">
                            <label class="form-check-label">Vegetariano</label>
                            <input type="checkbox" class="form-check-input" name="vegetariano" value="vegetariano" checked> 
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Invia</button>

                        <!-- Checkbox per attivare la convalida XSD -->
                        <div class="form-check form-switch pt-3">
                            <label class="form-check-label fw-medium" for="flexSwitchCheckDefault">Convalida con XSD</label>
                            <input class="form-check-input shadow-sm border" type="checkbox" id="flexSwitchCheckDefault" name="convalida_xsd">
                        </div>
                    </form>
                    
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-center mb-4">MENU</h3>
                                <?php
                                    $xmlFile = 'xml/menu.xml';

                                    if (file_exists($xmlFile)) {
                                        $menu = simplexml_load_file($xmlFile);
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
                                            foreach ($menu->piatto as $piatto) {
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($piatto->nome) . '</td>';
                                                echo '<td>' . htmlspecialchars($piatto->tipologia) . '</td>';
                                                echo '<td>' . htmlspecialchars($piatto->descrizione) . '</td>';
                                                echo '<td>' . htmlspecialchars($piatto->prezzo) . '</td>';
                                                echo '<td>' . htmlspecialchars($piatto->vegano) . '</td>';
                                                echo '<td>' . htmlspecialchars($piatto->vegetariano) . '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                            echo '</div>';
                                        } else {
                                            echo '<div class="alert alert-warning text-center">Nessun piatto disponibile nel menu.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger text-center">File menu.xml non trovato.</div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    // Funzione di convalida XML
                    function validaXML($xmlFile, $xsdFile) {
                        $dom = new DOMDocument();
                        $dom->loadXML($xmlFile->asXML());
                        if (!$dom->schemaValidate($xsdFile)) {
                            echo '<div class="alert alert-danger text-center">Errore di validazione: Il file XML non è valido secondo lo schema XSD.</div>';
                            return false; // Restituisce false se la convalida fallisce
                        }
                        return true; // Restituisce true se la convalida è riuscita
                    }

                    if (isset($_POST['submit'])) {
                        // Prendo i valori dal form
                        $nome = $_POST['nome'];
                        $tipologia = $_POST['tipologia'];
                        $descrizione = $_POST['descrizione'];
                        $prezzo = $_POST['prezzo'];
                        $vegano = isset($_POST['vegano']) ? 'si' : 'no';
                        $vegetariano = isset($_POST['vegetariano']) ? 'si' : 'no';

                        // Verifica se il form non è vuoto
                        if (!empty($nome) && !empty($tipologia) && !empty($descrizione) && !empty($prezzo)) {
                            $xmlFile = 'xml/menu.xml';
                            $xsdFile = 'xml/schema.xsd'; // Percorso del file XSD

                            // Verifica se la convalida XSD è attivata
                            if (isset($_POST['convalida_xsd']) && $_POST['convalida_xsd'] == 'on') {
                                // Se la convalida fallisce, interrompi l'esecuzione
                                if (!validaXML($xmlFile, $xsdFile)) {
                                    return; // Esci dalla funzione se la convalida fallisce
                                } else {
                                    echo '<div class="alert alert-success text-center">File XML convalidato con successo.</div>';
                                }
                            }

                            // Aggiungi un nuovo piatto all'XML
                            $menu = simplexml_load_file($xmlFile);
                            $nuovoPiatto = $menu->addChild('piatto');
                            $nuovoPiatto->addChild('nome', htmlspecialchars($nome));
                            $nuovoPiatto->addChild('tipologia', htmlspecialchars($tipologia));
                            $nuovoPiatto->addChild('descrizione', htmlspecialchars($descrizione));
                            $nuovoPiatto->addChild('prezzo', htmlspecialchars($prezzo));
                            $nuovoPiatto->addChild('vegetariano', $vegetariano);
                            $nuovoPiatto->addChild('vegano', $vegano);

                            // Salva l'XML aggiornato
                            if ($menu->asXML($xmlFile)) {
                                echo 'Modifiche avvenute con successo, aggiorna la pagina per visualizzare le modifiche.';
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
        
        </div>
    </body>
</html>

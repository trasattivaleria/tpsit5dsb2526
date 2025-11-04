<!DOCTYPE html>
<html>

<head>
    <title>Trasatti Valeria TPSIT</title>
    <link href="css/bootstrap.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="bg-dark text-white text-center py-4">
                <h1><?php require 'inc/header.php'; ?></h1>
            </div>

        </div>

        <div class="row ">
            <div class="col-md-3 p-3">
                <?php require 'inc/menu.php'; ?>
            </div>

            <div class="col-sm-9 p-3">

                <form action="formget_receive.php" method="GET">
                    <div class="form-group">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control w-50" name="nome"><br>
                    </div>
                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control w-50" name="cognome"><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Invia</button>
                </form>


            </div>
        </div>

        <div class="row">
            <div class="bg-dark text-white text-center py-4">
                <?php require 'inc/footer.php'; ?>
            </div>

        </div>

</body>

</html>
<?php 
    include_once '../api/classes/db.php';
    include_once '../api/classes/users.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>Bank App</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="input-group">
            <select class="custom-select" id="personInput">
                <option selected>Välj konto...</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" id="personBtn" type="button">Ändra</button>
            </div>
        </div>
    </nav>

    <div id="balance">
        <h3>Kontobalans:</h3>
        <div id="balanceOutput"></div>
    </div>

    <form action="" method="Post">
        <h3>Överföring</h3>
        <div class="form-group">
            <label for="from_account">Från konto:</label>
            <input disabled class="form-control" type="text" id="from_account">
         </div>
        <div class="form-group">
            <label for="to_account">Till konto med konto-id:</label>
            <select class="form-control" id="to_account">
                <option selected>Välj konto...</option>
            </select>
        </div>
        <label for="amountInput">Belopp:</label>
        <input type="number" class="form-control" id="amountInput">
        <button type="submit" class="btn btn-dark" id="transferBtn">Överför</button>
        <div id="transMessage"></div>
    </form>

    <script src="scripts/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

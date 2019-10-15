<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>
<?php require_once '../connec.php' ?>>
<?php include 'header.php'; ?>
<?php
$pdo = new \PDO(DSN, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$errors = 0;
if ($_POST) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "name is required";
            $errors++;
        }

        if (empty($_POST["payment"]) || $_POST["payment"] === 0) {
            $paymentErr = "Payment is required and must be superior to 0";
            $errors++;
        }

    }
}
if (isset($_POST["name"]) && isset($_POST["payment"])) {
    $name = trim($_POST["name"]);
    $payment = trim($_POST["payment"]);
    $query = "INSERT INTO bribe (name, payment) VALUES(:name, :payment)";

    $statement = $pdo->prepare($query);

    $statement->bindvalue(':name', $name, \PDO::PARAM_STR);

    $statement->bindvalue(':payment', $payment, \PDO::PARAM_INT);
    if ($errors === 0) {
        $statement->execute();
    }
}

$query = 'SELECT * FROM bribe';
$statement = $pdo->query($query);
$bribes = $statement->fetchAll(PDO::FETCH_ASSOC);
$summary = array_column($bribes, 'payment');
$totalPayment = array_sum($summary);

?>

<main class="container">

    <section class="desktop">
        <div class="flex_container">
            <div class="img_container">
                <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
                <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>
            </div>

            <div class="pages">
                <div class="page leftpage">
                    Add a bribe
                    <?php
                    if ($errors != 0) {
                        if (isset($nameErr)) {
                            echo '<br>' . $nameErr;
                        }
                        if (isset($paymentErr)) {
                            echo '<br>' . $paymentErr;
                        }
                    }
                    ?>
                    <form method="post" action="book.php">
                        <div>
                            <label for="name">Add new name</label>
                            <input type="text" name="name" id="name">
                        </div>
                        <div>
                            <label for="payment">Add new payment</label>
                            <input type="number" name="payment" id="payment">
                        </div>
                        <div>
                            <input type="submit" value="submit">
                        </div>
                    </form>
                </div>

                <div class="page rightpage">
                    <table>
                        <thead>
                        <tr>
                            <th colspan="2">Bribes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($bribes as $bribe) {
                            echo '<tr>
                                   <td>' . $bribe['name'] . '</td>
                                   <td>' . $bribe['payment'] . '</td>
                                 </tr>';
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <td><<?php echo $totalPayment ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
        </div>
    </section>
</main>
</body>
</html>

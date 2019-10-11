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
$query = 'SELECT * FROM bribe';
$statement = $pdo->query($query);
$bribes = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($bribes);
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
                    <!-- TODO : Form -->
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

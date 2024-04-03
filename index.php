<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>

<style>

    .login-box{
        margin-top:20px;
        margin-bottom:20px;
        width:800px;
        height: 400px;
        /* border: solid 1px; */
        box-sizing:border-box;
        border-radius:10px;
    }
</style>

    <div class=" mt- 3 d-flex justify-content-center align-items-center flex-column">
    <div class="login-box p-5 shadow">
    <h1 style="text-align:center">Mesin Kasir</h1>
        <form  method="POST" action="" class="form-inline">
            <div class="form-group">
                <label for ="nama" class="sr-only"></label>
                <input type="text" name="nama" class="form-control btn-lg" placeholder="Nama Barang">
            </div>
            <div class="form-group">
                <label for ="harga" class="sr-only"></label>
                <input type="number" name="harga" class="form-control btn-lg" placeholder="Harga">
            </div>
            <div class="form-group">
                <label for ="jumlah" class="sr-only"></label>
                <input type="number" name="jumlah" class="form-control btn-lg" placeholder="Jumlah Barang">
            </div>
            <input  class="btn btn-primary mt-3" type="submit" name="add" value="Add To Data" >
            <input class="btn btn-danger mt-3" type="submit" name="Reset" value="Reset">  
    </form>
    </div>
    </div>
    <?php
    session_start();

    if(!isset($_SESSION['Data'])){
        $_SESSION['Data'] = array();
    }

    if(isset($_POST['Reset'])){
        session_unset();
    }

    if(isset($_GET['hapus'])){ 
        $index = $_GET['hapus'];
        unset($_SESSION['Data'][$index]);
    }

    if(isset($_POST['add'])){
    if(@$_POST['nama'] && @$_POST['harga'] && @$_POST['jumlah']){
    if(isset($_SESSION['Data'])){
        $data = [
            'nama' => $_POST['nama'],
            'harga' => $_POST['harga'],
            'jumlah' => $_POST['jumlah'],
        ];
        array_push($_SESSION['Data'], $data);
        header('Location: index.php');

    }else {
        echo "<p>lengkapi data!!</p>";
    }
}
}

    // var_dump($_SESSION);
    if(!empty($_SESSION['Data'])){
        echo "<table class='table table-striped'>";
        echo  "<tr>";
        echo "<td>Nama Barang</td>";
        echo "<td>Harga</td>";
        echo "<td>Jumlah Barang</td>";
        echo "<td>Action</td>";
        echo "</tr>";
    
    foreach($_SESSION['Data'] as $index => $value){
        echo "<tr>";
        echo "<td>".$value['nama']."</td>";
        echo "<td>".$value['harga']*$value['jumlah']."</td>";
        echo "<td>".$value['jumlah']."</td>";
        echo '<td> <a class = "btn btn-danger" href="?hapus=' . $index .' ">Hapus</a></td>';
        echo "</tr>";
    }
    echo "</table>";
    echo '<a class = "btn btn-primary mt-3 " href="checkout.php">Checkout</a>';
}else {
    echo "<p class= text-center mt-1>Silahkan Masukan Data Terlebih Dahulu!!</p>";
}

$total_price = 0;
foreach (@$_SESSION['Data'] as $item) {
    $total_price += $item['harga'] * $item['jumlah'];
}
if (isset($_POST['make_payment'])) {
    $payment_amount = $_POST['payment_amount'];
    if ($payment_amount < $total_price) {
        echo "<script>alert('Payment amount is less than the total harga.');</script>";
    } else {
        // Generate receipt
        echo "<h2>Receipt</h2>";
        echo "<p>Data list: <br>";
        foreach ($_SESSION['Data'] as $item) {
            echo "- {$item['nama']} ({$item['harga']} x {$item['jumlah']})<br>";
        }
        echo "Total harga: {$total_price}<br>";
        echo "Payment amount: {$payment_amount}<br>";
        $change = $payment_amount - $total_price;
        echo "Change: {$change}<br>";

        // Reset Data
        session_destroy();
        session_start();
    }
}
    ?>
</body>
</html>
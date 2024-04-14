<?php

session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: /get_login.php");
} else {
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", "dbuser", "dbpwd");
    $stmt = $pdo->query("SELECT * FROM products");
    $result = $stmt->fetchAll();
    ?>

    <div class="container">
  <h3>Catalog</h3>
  <div class="card-deck">
      <?php foreach ($result as $product):?>
    <div class="card text-center">
      <a href="#">
        <div class="card-header">
    <?php echo $product['name']; ?>
        </div>
        <img class="card-img-top" src=<?php $product['images']; ?> alt="Card image">
        <div class="card-body">
          <p class="card-text text-muted"> <?php echo $product['category'];?></p>
          <a href="#"><h5 class="card-title"><?php echo $product['description'];?></h5></a>
          <div class="card-footer">
    <?php echo $product['price'];?>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach;?>
  </div>
</div>
<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 100rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 20px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 15px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>

    <?php
}
?>

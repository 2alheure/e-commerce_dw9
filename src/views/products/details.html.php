<?php include view('parts/header'); ?>
<h1><?= $produit->nom ?></h1>

<div class="grid grid-cols-2">
    <img src="<?= asset('img/products/' . $produit->image) ?>" alt="" class="h-64 bg-gray-400">
    <p>
        <?= $produit->description ?>
        <br><br>

        Prix : <?= $produit->prix ?> € (<?= $produit->stock ?> en stock)
    </p>
</div>



<?php include view('parts/footer'); ?>
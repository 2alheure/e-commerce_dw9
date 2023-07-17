<?php include view('parts/header'); ?>

<?php if (has_role('ADMIN')) : ?>
    <p class="text-center">
        <a href="<?= url('/products/create') ?>" class="bg-green-500 text-white p-2 rounded">Créer</a>
    </p>
<?php endif; ?>

<div class="grid grid-cols-3 gap-8">
    <?php foreach ($produits as $p) : ?>
        <div>
            <h2><?= $p->nom ?></h2>
            <img src="<?= asset('img/products/' . $p->image) ?>" alt="" class="w-full h-64 bg-gray-400">
            <p class="flex gap-4">
                <a href="<?= url('/products/details?id=' . $p->id) ?>" class="bg-blue-500 text-white p-2 rounded">Détails</a>

                <?php if (has_role('ADMIN')) : ?>
                    <a href="<?= url('/products/update?id=' . $p->id) ?>" class="bg-yellow-500 text-white p-2 rounded">Modifier</a>
                    <a href="<?= url('/products/delete?id=' . $p->id) ?>" class="bg-red-500 text-white p-2 rounded" onclick="return confirm('Êtes-vus sûr ?')">Supprimer</a>
                <?php endif; ?>
            </p>

            <form action="<?= url('/cart/add?id=' . $p->id) ?>" method="post">
                <input type="number" name="qtte">
                <button type="submit" class="bg-gray-800 text-white"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php include view('parts/footer'); ?>
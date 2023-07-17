<?php include view('parts/header'); ?>

<h1>Mon panier</h1>

<table>
    <thead>
        <tr class="font-bold">
            <td class="border border-black px-8">Nom</td>
            <td class="border border-black px-8">Prix unitaire</td>
            <td class="border border-black px-8">Quantité</td>
            <td class="border border-black px-8">Sous-total</td>
            <td class="border border-black px-8">Actions</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($panier['cart'] as $ligne) : ?>
            <tr>
                <td class="border border-black px-8"><?= $ligne['product']->nom ?></td>
                <td class="border border-black px-8"><?= money($ligne['product']->prix) ?></td>
                <td class="border border-black px-8">
                    <form action="<?= url('/cart/update?id=' . $ligne['product']->id) ?>" method="post">
                        <input type="number" name="qtte" value="<?= $ligne['quantity'] ?>">
                        <input type="submit" value="Modifier">
                    </form>
                </td>
                <td class="border border-black px-8"><?= money($ligne['product']->prix * $ligne['quantity']) ?></td>
                <td class="border border-black px-8 text-red-500">
                    <a href="<?= url('/cart/remove?id=' . $ligne['product']->id) ?>">Retirer du panier</a>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr></tr>
        <tr class="text-center">
            <td colspan="3" class="font-bold border border-black">TOTAL</td>
            <td class="border border-black"><?= money($panier['total']) ?></td>
        </tr>
    </tbody>
</table>

<p class="text-center text-red-500">
<a href="<?= url('/cart/empty') ?>">Vider le panier</a>
</p>

<?php include view('parts/footer'); ?>
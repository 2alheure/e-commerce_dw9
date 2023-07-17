<?php include view('parts/header'); ?>

<form action="<?= url('/products/' . ($isUpdate ? 'update' : 'create') . '-handler' . ($isUpdate ? '?id=' . $_GET['id'] : '')) ?>" method="post" class="flex flex-col md:w-1/2 w-full border-2 mt-8 shadow-xl rounded-lg mx-auto p-8" enctype="multipart/form-data">
    <label for="nom">Nom</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="nom" id="nom" placeholder="Nom" value="<?= $_POST['nom'] ?? $produit->nom ?? '' ?>">

    <label for="prix">Prix</label>
    <input type="number" min="0.01" step="0.01" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="prix" id="prix" placeholder="Prix" value="<?= $_POST['prix'] ?? $produit->prix ?? '' ?>">

    <label for="stock">Stock</label>
    <input type="number" min="0" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="stock" id="stock" placeholder="Stock" value="<?= $_POST['stock'] ?? $produit->stock ?? '' ?>">

    <div class="grid grid-cols-6 gap-4">
        <?php if ($isUpdate) : ?>
            <img src="<?= $produit->image ? asset('img/products/' . $produit->image) : 'https://placehold.jp/500x500' ?>" alt="">
        <?php endif; ?>

        <div class="col-span-<?= $isUpdate ? 5 : 6 ?> flex flex-col justify-center">
            <label for="image">Image de profil</label>
            <input type="file" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="image" id="image" placeholder="Image de profil">
        </div>
    </div>

    <label for="description">Description</label>
    <textarea class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="description" id="description" placeholder="Description" rows="5"><?= $_POST['description'] ?? $produit->description ?? '' ?></textarea>

    <select name="tva_id" id="tva_id">
        <?php foreach ($tvas as $tva) : ?>
            <option value="<?= $tva->id ?>">
                <?= $tva->nom ?> (<?= $tva->taux ?> %)
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="<?= $isUpdate ? 'Modifier' : 'Créer' ?> le produit" class="cursor-pointer rounded bg-gray-800 text-white hover:bg-gray-600 w-1/2 p-2 mx-auto">
</form>

<?php include view('parts/footer'); ?>
<?php include view('parts/footer'); ?>
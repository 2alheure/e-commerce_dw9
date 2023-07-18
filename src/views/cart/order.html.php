<?php include view('parts/header'); ?>

<h1 class="text-center text-xl font-bold">Passer une commande</h1>

<form action="<?= url('/order-handler') ?>" method="post" class="flex flex-col md:w-1/2 w-full border-2 mt-8 shadow-xl rounded-lg mx-auto p-8">
    <label for="nom">Votre nom</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="nom" id="nom" placeholder="Votre nom" value="<?= $_POST['nom'] ?? user('nom') ?? '' ?>">
    
    <label for="prenom">Votre prénom</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="prenom" id="prenom" placeholder="Votre prénom" value="<?= $_POST['prenom'] ?? user('prenom') ?? '' ?>">

    <label for="tel">Numéro de téléphone</label>
    <input type="tel" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2" name="tel" id="tel" placeholder="Numéro de téléphone" value="<?= $_POST['tel'] ?? user('telephone') ?? '' ?>">
    <small class="mb-8 text-gray-500">Ce numéro ne sera utilisé que pour vous communiquer sur votre commande.</small>

    <label for="adresse_facturation">Adresse de facturation</label>
    <textarea class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="adresse_facturation" id="adresse_facturation" placeholder="Adresse de facturation" rows="5"><?= $_POST['adresse_facturation'] ?? '' ?></textarea>

    <label for="adresse_livraison">Adresse de livraison</label>
    <textarea class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" rows="5"><?= $_POST['adresse_livraison'] ?? '' ?></textarea>

    <label for="mode_livraison_id">Choisissez votre mode de livraison</label>
    <select name="mode_livraison_id" id="mode_livraison_id" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8">
        <?php foreach ($modes_livraison as $mode) : ?>
            <option value="<?= $mode->id ?>">
                <?= $mode->nom ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="mode_paiement_id">Choisissez votre moyen de paiement</label>
    <select name="mode_paiement_id" id="mode_paiement_id" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8">
        <?php foreach ($moyens_paiement as $moyen) : ?>
            <option value="<?= $moyen->id ?>">
                <?= $moyen->nom ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Payer" class="cursor-pointer rounded bg-gray-800 text-white hover:bg-gray-600 w-1/2 p-2 mx-auto">
</form>

<?php include view('parts/footer'); ?>
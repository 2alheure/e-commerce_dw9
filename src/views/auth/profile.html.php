<?php include view('parts/header'); ?>

<form action="<?= url('/me/update') ?>" method="post" class="flex flex-col md:w-1/2 w-full border-2 mt-8 shadow-xl rounded-lg mx-auto p-8">
    <label for="email">Votre email</label>
    <input type="email" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="email" id="email" placeholder="Votre email" value="<?= $_POST['email'] ?? user('email') ?>">

    <label for="password">Mot de passe</label>
    <input type="password" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="password" id="password" placeholder="Mot de passe">

    <label for="confirm">Confirmation du mot de passe</label>
    <input type="password" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="confirm" id="confirm" placeholder="Confirmation du mot de passe">

    <label for="prenom">Prénom</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="prenom" id="prenom" placeholder="Prénom" value="<?= $_POST['prenom'] ?? user('prenom') ?>">

    <label for="nom">Nom</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="nom" id="nom" placeholder="Nom" value="<?= $_POST['nom'] ?? user('nom') ?>">

    <label for="telephone">Numéro de téléphone</label>
    <input type="tel" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="telephone" id="telephone" placeholder="Numéro de téléphone" value="<?= $_POST['telephone'] ?? user('telephone') ?>">

    <div class="grid grid-cols-6 gap-4">
        <img src="<?= user('image') ?? asset('/img/user.png') ?>" alt="">
        <div class="col-span-5 flex flex-col justify-center">
            <label for="avatar">Image de profil</label>
            <input type="file" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="avatar" id="avatar" placeholder="Image de profil">
        </div>
    </div>

    <div class="flex gap-8 text-center mt-8">
        <a href="<?= url('/me/delete') ?>"  class="cursor-pointer rounded bg-red-600 text-white hover:bg-red-500 w-1/2 p-2 mx-auto" onclick="return confirm('Êtes-vous sûr ? Cette action est irréversible.')">Supprimer</a>
        <input type="submit" value="Modifier mon profil" class="cursor-pointer rounded bg-gray-800 text-white hover:bg-gray-600 w-1/2 p-2 mx-auto">
    </div>
</form>

<?php include view('parts/footer'); ?>
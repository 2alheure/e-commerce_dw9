<?php include view('parts/header'); ?>

<form action="<?= url('/register-handler') ?>" method="post" class="flex flex-col md:w-1/2 w-full border-2 mt-8 shadow-xl rounded-lg mx-auto p-8">
    <label for="email">Votre email</label>
    <input type="email" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="email" id="email" placeholder="Votre email">

    <label for="password">Mot de passe</label>
    <input type="password" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="password" id="password" placeholder="Mot de passe">

    <label for="confirm">Confirmation du mot de passe</label>
    <input type="password" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="confirm" id="confirm" placeholder="Confirmation du mot de passe">

    <div>
        <input type="checkbox" class="p-1 outline-1 rounded-sm mt-2 mb-8" name="cgu" id="cgu" value="true">
        <label for="cgu">
            Je reconnais avoir 13 ans révolus et avoir lu et approuvé les
            <a href="<?= url('/terms/cgu') ?>">CGU</a>
        </label>
    </div>

    <input type="submit" value="Créer un compte" class="cursor-pointer rounded bg-gray-800 text-white hover:bg-gray-600 w-1/2 p-2 mx-auto">

    <p>
        Vous avez déjà compte ?
        <a href="<?= url('/login') ?>" class="hover:underline">Connectez-vous !</a>
    </p>
</form>

<?php include view('parts/footer'); ?>
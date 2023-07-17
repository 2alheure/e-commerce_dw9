<?php include view('parts/header'); ?>

<h1>Me contacter</h1>

<p>
    Vous pouvez me contacter à l'adresse email suivante : <br>
    <span class="block text-center">
        <a href="mailto:<?= env('MAIL_CONTACT') ?>"><?= env('MAIL_CONTACT') ?></a>
    </span> <br>
    <br>
    Vous pouvez sinon utiliser le formulaire ci-dessous.
</p>

<form action="<?= url('/contact-handler') ?>" method="post" class="flex flex-col md:w-1/2 w-full border-2 mt-8 shadow-xl rounded-lg mx-auto p-8">

    <label for="email">Votre email</label>
    <input type="email" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="email" id="email" placeholder="Votre email">
    
    <label for="subject">Sujet</label>
    <input type="text" class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="subject" id="subject" placeholder="Sujet">
    
    <label for="message">Votre message</label>
    <textarea class="outline outline-gray-500 p-1 outline-1 rounded-sm mt-2 mb-8" name="message" id="message" placeholder="Votre message" rows="5"></textarea>

    <input type="submit" value="Envoyer" class="cursor-pointer rounded bg-gray-800 text-white hover:bg-gray-600 w-1/2 p-2 mx-auto">
</form>

<?php include view('parts/footer'); ?>
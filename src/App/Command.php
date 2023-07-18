<?php

namespace App;

class Command {
    const
        ETAT_PANIER = 1,
        ETAT_PAYEE = 2,
        ETAT_EXPEDIEE = 3,
        ETAT_LIVREE = 4,
        ETAT_RETOURNEE = 5,
        ETAT_REMBOURSEE = 6;

    const
        PAYMENT_CB = 1,
        PAYMENT_PAYPAL = 2,
        PAYMENT_VIREMENT = 3,
        PAYMENT_CHEQUE = 4,
        PAYMENT_ESPECES = 5;

    const
        LIVRAISON_LETTRE_SUIVIE = 1,
        LIVRAISON_POINT_RELAI = 2,
        LIVRAISON_DPD = 3,
        LIVRAISON_UPS = 4;
}

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Abonnements vendeurs (NexShop Djibouti)
    |--------------------------------------------------------------------------
    */
    'seller_subscription' => [
        /** Portail officiel D‑Money (connexion / paiement) — Djibouti */
        'dmoney_portal_login_url' => 'https://www.payment.d-money.dj/login',
        /** Numéro D‑Money / contact pour versements abonnement vendeur */
        'payment_recipient_phone' => '+253 77 44 78 73',
        'free_monthly_order_limit' => 10,
        'billing_period_days' => 30,
        /**
         * Fonctionnalités affichées et appliquées par formule (référence unique).
         * :limit = free_monthly_order_limit (remplacé en vue).
         */
        'plan_features' => [
            'free' => [
                'Jusqu’à :limit commandes / mois',
                'Visibilité standard',
                'Sans badge vérifié',
            ],
            'pro' => [
                'Commandes illimitées',
                'Badge vendeur vérifié',
                'Statistiques de base',
                'Support standard',
            ],
            'premium' => [
                'Tout le plan Pro',
                'Mise en avant dans le catalogue',
                'Statistiques avancées',
                'Support VIP',
            ],
        ],
        'charter' => [
            'title' => 'Engagements NexShop & obligations vendeur',
            'platform' => 'NexShop applique sur la plateforme les limites et avantages décrits pour chaque formule : comptage mensuel des commandes, accès messagerie et catalogue, statistiques (de base ou avancées), visibilité et badge « vendeur vérifié » selon le plan actif ou expiré.',
            'seller' => 'Chaque vendeur s’engage à respecter les fonctionnalités et limites de sa formule, les conditions générales d’utilisation, l’exactitude des informations boutique et produits, et à ne pas contourner les règles (ex. plafond Free, usage abusif).',
        ],
        'plans' => [
            'free' => [
                'label' => 'Free',
                'price_fdj' => 0,
                'order_limit_per_month' => 10,
            ],
            'pro' => [
                'label' => 'Pro',
                'price_fdj' => 5000,
            ],
            'premium' => [
                'label' => 'Premium',
                'price_fdj' => 10000,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livraison (NexShop Djibouti)
    |--------------------------------------------------------------------------
    */
    'delivery' => [
        'city_fee_fdj' => 500,
        'region_fee_fdj' => 1000,
        'free_delivery_subtotal_fdj' => 10000,
    ],
];

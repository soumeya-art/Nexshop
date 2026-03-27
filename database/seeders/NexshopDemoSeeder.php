<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NexshopDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Assurer l'existence d'un vendeur de démonstration
        $vendeur = User::firstOrCreate(
            ['email' => 'vendeur-demo@nexshop.test'],
            [
                'nom'         => 'Vendeur Démo',
                'telephone'   => '0600000000',
                'password'    => Hash::make('password'),
                'type_compte' => 'vendeur',
                'statut'      => 'actif',
            ]
        );

        // Catégories de base
        $categoriesData = [
            ['nom' => 'Électronique', 'description' => 'Appareils et gadgets', 'icone' => 'fa-microchip'],
            ['nom' => 'Mode',         'description' => 'Vêtements et accessoires', 'icone' => 'fa-shirt'],
            ['nom' => 'Maison',       'description' => 'Articles pour la maison', 'icone' => 'fa-house'],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['nom']] = Categorie::firstOrCreate(
                ['nom' => $data['nom']],
                [
                    'description' => $data['description'],
                    'icone'       => $data['icone'],
                    'image_url'   => null,
                ]
            );
        }

        // Produits de démonstration
        $produits = [
            [
                'nom'        => 'Casque Bluetooth Sans Fil',
                'categorie'  => 'Électronique',
                'prix'       => 59.90,
                'stock'      => 25,
                'image'      => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',
                'description'=> 'Casque confortable avec réduction de bruit active et autonomie de 30 heures.',
            ],
            [
                'nom'        => 'Montre Connectée Sport',
                'categorie'  => 'Électronique',
                'prix'       => 129.00,
                'stock'      => 15,
                'image'      => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80',
                'description'=> 'Suivi cardio, sommeil, GPS intégré et notifications smartphone.',
            ],
            [
                'nom'        => 'Veste Cuir Homme',
                'categorie'  => 'Mode',
                'prix'       => 199.00,
                'stock'      => 8,
                'image'      => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&q=80',
                'description'=> 'Veste en cuir véritable, coupe moderne, parfaite pour la mi-saison.',
            ],
            [
                'nom'        => 'Robot Aspirateur Intelligent',
                'categorie'  => 'Maison',
                'prix'       => 249.00,
                'stock'      => 5,
                'image'      => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=800&q=80',
                'description'=> 'Robot aspirateur programmable avec retour automatique à la base.',
            ],
        ];

        foreach ($produits as $data) {
            $categorie = $categories[$data['categorie']] ?? null;

            if (! $categorie) {
                continue;
            }

            Produit::firstOrCreate(
                ['nom' => $data['nom'], 'vendeur_id' => $vendeur->id],
                [
                    'categorie_id'         => $categorie->id,
                    'description'          => $data['description'],
                    'prix'                 => $data['prix'],
                    'stock'                => $data['stock'],
                    'image_principale'     => $data['image'],
                    'images_supplementaires' => null,
                    'statut'               => 'actif',
                ]
            );
        }
    }
}


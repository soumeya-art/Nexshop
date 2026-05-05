<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NexshopDemoSeeder extends Seeder
{
    public function run(): void
    {

        // Assurer l'existence d'admin de démonstration
        $admin = User::updateOrCreate(
            ['email' => 'nexshop.dj@gmail.com'],
            [
                'nom' => 'Admin',
                'telephone' => '77 44 78 73',
                'password' => Hash::make('password'),
                'type_compte' => 'admin',
                'statut' => 'actif',
            ]
        );

        // Anciennes 11 catégories de base
        $categoriesData = [
            ['nom' => 'Électronique', 'description' => 'Appareils et gadgets', 'icone' => 'fa-microchip'],
            ['nom' => 'Mode', 'description' => 'Vêtements et accessoires', 'icone' => 'fa-shirt'],
            ['nom' => 'Maison', 'description' => 'Articles pour la maison', 'icone' => 'fa-house'],
            ['nom' => 'Beauté', 'description' => 'Soins, cosmétiques et bien-être', 'icone' => 'fa-spa'],
            ['nom' => 'Sports', 'description' => 'Équipements et accessoires sportifs', 'icone' => 'fa-dumbbell'],
            ['nom' => 'Informatique', 'description' => 'Ordinateurs et accessoires IT', 'icone' => 'fa-laptop-code'],
            ['nom' => 'Téléphonie', 'description' => 'Smartphones et accessoires mobiles', 'icone' => 'fa-mobile-screen-button'],
            ['nom' => 'Bébé & Enfants', 'description' => 'Produits pour bébés et enfants', 'icone' => 'fa-baby'],
            ['nom' => 'Automobile', 'description' => 'Pièces, entretien et accessoires auto', 'icone' => 'fa-car-side'],
            ['nom' => 'Jeux & Loisirs', 'description' => 'Jouets, jeux et divertissements', 'icone' => 'fa-puzzle-piece'],
            ['nom' => 'Alimentation', 'description' => 'Épicerie et produits alimentaires', 'icone' => 'fa-basket-shopping'],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['nom']] = Categorie::firstOrCreate(
                ['nom' => $data['nom']],
                [
                    'description' => $data['description'],
                    'icone' => $data['icone'],
                    'image_url' => null,
                ]
            );
        }

    }
}

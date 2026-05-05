<?php

/**
 * Images par défaut pour les catégories lorsque image_url est vide en base.
 * Correspondance par sous-chaîne sur le nom (sans accents, minuscules).
 * Le premier motif qui matche gagne — ordre du plus précis au plus général.
 * Valeurs : URL https ou chemin relatif à public/ (ex. images/photo.png).
 */

return [

    'fallback' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=700&q=80',

    'patterns' => [
        ['keywords' => ['bebe', 'nourrisson', 'puericulture', 'enfant'], 'image' => 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=700&q=80'],
        ['keywords' => ['scolaire', 'bureau', 'fourniture'], 'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=700&q=80'],
        ['keywords' => ['sante', 'bien-etre', 'bien etre', 'pharmacie', 'medical'], 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=700&q=80'],
        ['keywords' => ['montre', 'bijou', 'accessoire'], 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=700&q=80'],
        ['keywords' => ['telephone', 'telephonie', 'mobile', 'smartphone'], 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=700&q=80'],
        ['keywords' => ['electronique', 'tv', 'audio'], 'image' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=700&q=80'],
        ['keywords' => ['informatique', 'ordinateur', 'pc', 'laptop'], 'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=700&q=80'],
        ['keywords' => ['gaming', 'jeu video', 'console', 'gamer'], 'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=700&q=80'],
        ['keywords' => ['voiture', 'auto', 'automobile', 'moto'], 'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=700&q=80'],
        ['keywords' => ['sport', 'fitness', 'velo', 'cyclisme'], 'image' => 'https://images.unsplash.com/photo-1461896836934-bd45ba8fcf9b?w=700&q=80'],
        ['keywords' => ['beaute', 'cosmetique', 'maquillage', 'parfum'], 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=700&q=80'],
        ['keywords' => ['maison', 'deco', 'meuble', 'linge', 'cuisine equipee'], 'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=700&q=80'],
        ['keywords' => ['jardin', 'bricolage', 'outil'], 'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=700&q=80'],
        ['keywords' => ['jouet', 'jeu', 'loisir'], 'image' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=700&q=80'],
        ['keywords' => ['livre', 'papeterie', 'culture'], 'image' => 'https://images.unsplash.com/photo-1524995997946-f1fe4a0a133b?w=700&q=80'],
        ['keywords' => ['animal', 'animalerie', 'chien', 'chat'], 'image' => 'https://images.unsplash.com/photo-1425082661705-1834bfd09dca?w=700&q=80'],
        ['keywords' => ['alimentation', 'alimentaire', 'epicerie', 'boisson', 'gourmet'], 'image' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=700&q=80'],
        ['keywords' => ['musique', 'instrument'], 'image' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=700&q=80'],
        ['keywords' => ['photo', 'camera', 'appareil photo'], 'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=700&q=80'],
        ['keywords' => ['voyage', 'bagage', 'valise'], 'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=700&q=80'],
        ['keywords' => ['mode', 'vetement', 'vetements', 'chaussure', 'textile', 'fashion'], 'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=700&q=80'],
    ],

];

<?php

use App\Http\Controllers\Admin\KycAdminController;
use App\Http\Controllers\Vendeur\InscriptionVendeurController;
use App\Http\Controllers\Web\Admin\AdminCategoryController;
use App\Http\Controllers\Web\Admin\AdminContactMessageController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Admin\AdminModerationController;
use App\Http\Controllers\Web\Admin\AdminProductModerationController;
use App\Http\Controllers\Web\Admin\AdminReturnController;
use App\Http\Controllers\Web\Admin\AdminSellerSubscriptionController;
use App\Http\Controllers\Web\Admin\AdminUserController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\Buyer\BuyerController;
use App\Http\Controllers\Web\Buyer\BuyerNotificationController;
use App\Http\Controllers\Web\Buyer\CartController;
use App\Http\Controllers\Web\Buyer\FavoriteController;
use App\Http\Controllers\Web\Buyer\InfoPageController;
use App\Http\Controllers\Web\Buyer\OrderController;
use App\Http\Controllers\Web\Buyer\PlatformFeedbackController;
use App\Http\Controllers\Web\Buyer\ReturnRequestController;
use App\Http\Controllers\Web\Buyer\ProductController;
use App\Http\Controllers\Web\Buyer\ProfileController;
use App\Http\Controllers\Web\Buyer\SellerFollowController;
use App\Http\Controllers\Web\MessagingController;
use App\Http\Controllers\Web\PublicProductController;
use App\Http\Controllers\Web\Seller\SellerBoutiqueController;
use App\Http\Controllers\Web\Seller\SellerController;
use App\Http\Controllers\Web\Seller\SellerNotificationController;
use App\Http\Controllers\Web\Seller\SellerOrderController;
use App\Http\Controllers\Web\Seller\SellerProductController;
use App\Http\Controllers\Web\Seller\SellerSubscriptionController;
use App\Models\Categorie;
use App\Models\PlateformeTemoignage;
use App\Models\Produit;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    $categories = Categorie::withCount([
        'produits as actifs_count' => fn ($q) => $q->actif(),
    ])->orderBy('nom')->get();

    $featuredProducts = Produit::with(['categorie'])
        ->actif()
        ->withCount(['avis as approved_reviews_count' => fn ($q) => $q->where('statut', 'approuve')])
        ->withAvg(['avis as note_moyenne' => fn ($q) => $q->where('statut', 'approuve')], 'note')
        ->orderBySellerSubscriptionPriority()
        ->limit(72)
        ->get();

    $filterCategories = $featuredProducts->pluck('categorie')->filter()->unique('id')->sortBy('nom')->values();

    $plateformeTemoignages = PlateformeTemoignage::query()
        ->where('statut', 'approuve')
        ->with(['user:id,nom,ville,email'])
        ->latest()
        ->take(9)
        ->get();

    return view('welcome', compact('categories', 'featuredProducts', 'filterCategories', 'plateformeTemoignages'));
})->name('home');

Route::get('/p/{product}', [PublicProductController::class, 'show'])->name('public.products.show');

Route::post('/newsletter', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email|max:255']);
    \App\Models\Newsletter::firstOrCreate(['email' => $request->email]);

    return response()->json(['message' => 'Merci ! Vous êtes inscrit à la newsletter NexShop.']);
})->name('newsletter.store');

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'nom'     => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'sujet'   => 'nullable|string|max:255',
        'message' => 'required|string|max:5000',
    ]);
    \App\Models\ContactMessage::create(\Illuminate\Support\Arr::only($data, ['nom', 'email', 'sujet', 'message']));

    return response()->json(['message' => 'Message envoyé avec succès.']);
})->name('contact.store');

Route::redirect('/seller', '/vendeur', 301);

// Authentification (invités uniquement)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    })->name('login');

    Route::get('/register', function () {
        return response()
            ->view('auth.register')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    })->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Déconnexion (GET + POST : certains navigateurs/extensions bloquaient uniquement POST)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Broadcast::routes(['middleware' => ['web', 'auth']]);

Route::middleware('auth')->group(function () {
    Route::post('/messaging/heartbeat', [MessagingController::class, 'heartbeat'])->name('messaging.heartbeat');
    Route::get('/messaging/unread-count', [MessagingController::class, 'unreadCount'])->name('messaging.unread');
    Route::get('/messaging/attachments/{message}', [MessagingController::class, 'showAttachment'])
        ->name('messaging.attachment');
});

// ── Inscription vendeur en 3 étapes ─────────────────────────
Route::prefix('vendeur/inscription')->name('vendeur.inscription.')->group(function () {
    Route::get('/', [InscriptionVendeurController::class, 'showEtape1'])->name('index');
    Route::post('/compte', [InscriptionVendeurController::class, 'soumettreEtape1'])->name('compte');

    Route::middleware('auth')->group(function () {
        Route::get('/kyc', [InscriptionVendeurController::class, 'showKyc'])->name('kyc');
        Route::post('/kyc', [InscriptionVendeurController::class, 'soumettreKyc'])->name('kyc.post');
        Route::get('/boutique', [InscriptionVendeurController::class, 'showBoutique'])->name('boutique');
        Route::post('/boutique', [InscriptionVendeurController::class, 'soumettreBoutique'])->name('boutique.post');
        Route::get('/confirmation', [InscriptionVendeurController::class, 'confirmation'])->name('confirmation');
    });
});

Route::middleware('auth')
    ->get('/vendeur/attente', [InscriptionVendeurController::class, 'attente'])
    ->name('vendeur.attente');

// ── Interface Admin (admin uniquement) ─────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('home');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications.index');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users/{user}/toggle-ban', [AdminUserController::class, 'toggleBan'])->name('users.toggleBan');

    Route::get('/moderation', [AdminModerationController::class, 'index'])->name('moderation');
    Route::post('/moderation/{avi}/approve', [AdminModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{avi}/reject', [AdminModerationController::class, 'reject'])->name('moderation.reject');

    Route::get('/produits-moderation', [AdminProductModerationController::class, 'index'])->name('produits.moderation');
    Route::post('/produits/{product}/approuver', [AdminProductModerationController::class, 'approve'])->name('produits.approve');
    Route::post('/produits/{product}/rejeter', [AdminProductModerationController::class, 'reject'])->name('produits.reject');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/kyc', [KycAdminController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/{user}', [KycAdminController::class, 'show'])->name('kyc.show');
    Route::post('/kyc/{user}/valider', [KycAdminController::class, 'valider'])->name('kyc.valider');
    Route::post('/kyc/{user}/rejeter', [KycAdminController::class, 'rejeter'])->name('kyc.rejeter');
    Route::get('/kyc/{user}/document/{type}', [KycAdminController::class, 'document'])->name('kyc.document');

    Route::get('/abonnements', [AdminSellerSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/abonnements/{payment}/approuver', [AdminSellerSubscriptionController::class, 'approve'])->name('subscriptions.approve');
    Route::post('/abonnements/{payment}/rejeter', [AdminSellerSubscriptionController::class, 'reject'])->name('subscriptions.reject');

    Route::get('/messages-contact', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/messages-contact/{contact_message}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');

    Route::get('/retours', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::get('/retours/{retour}', [AdminReturnController::class, 'show'])->name('returns.show');
    Route::post('/retours/{retour}/contact', [AdminReturnController::class, 'contactVendeur'])->name('returns.contact');
    Route::post('/retours/{retour}/accepter', [AdminReturnController::class, 'accept'])->name('returns.accept');
    Route::post('/retours/{retour}/refuser', [AdminReturnController::class, 'reject'])->name('returns.reject');
});

// ── Interface Vendeur (vendeur uniquement) ──────────────────
Route::middleware(['auth', 'role:vendeur', 'vendeur.valide', 'seller.subscription'])->prefix('vendeur')->name('vendeur.')->group(function () {
    Route::get('/', [SellerController::class, 'dashboard'])->name('home');

    Route::get('/abonnement', [SellerSubscriptionController::class, 'index'])->name('abonnement.index');
    Route::get('/abonnement/paiement', [SellerSubscriptionController::class, 'checkout'])->name('abonnement.checkout');
    Route::post('/abonnement', [SellerSubscriptionController::class, 'store'])->name('abonnement.store');

    Route::get('/products', [SellerProductController::class, 'index'])->name('products');
    Route::get('/products/creer', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders');
    Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.status');

    Route::get('/boutique/modifier', [SellerBoutiqueController::class, 'edit'])->name('boutique.edit');
    Route::put('/boutique', [SellerBoutiqueController::class, 'update'])->name('boutique.update');

    Route::get('/notifications', [SellerNotificationController::class, 'index'])->name('notifications.index');

    Route::get('/messages', [MessagingController::class, 'sellerIndex'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessagingController::class, 'sellerShow'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessagingController::class, 'storeMessage'])->name('messages.send');
    Route::post('/messages/{conversation}/read', [MessagingController::class, 'markRead'])->name('messages.read');
});

// ── Interface Acheteur (client uniquement) ─────────────────────
Route::middleware(['auth', 'role:client'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/', [BuyerController::class, 'home'])->name('home');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/stores/{seller}', [ProductController::class, 'store'])->name('stores.show');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/review', [ProductController::class, 'storeReview'])->name('products.review');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/returns', [ReturnRequestController::class, 'index'])->name('returns.index');
    Route::get('/returns/{order}/create', [ReturnRequestController::class, 'create'])->name('returns.create');
    Route::post('/returns/{order}', [ReturnRequestController::class, 'store'])->name('returns.store');

    Route::post('/platform-feedback', [PlatformFeedbackController::class, 'store'])->name('platform-feedback.store');
    Route::post('/platform-feedback/dismiss', [PlatformFeedbackController::class, 'dismiss'])->name('platform-feedback.dismiss');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::post('/sellers/{seller}/follow', [SellerFollowController::class, 'toggle'])->name('sellers.follow');

    Route::get('/notifications', [BuyerNotificationController::class, 'index'])->name('notifications.index');

    Route::get('/messages', [MessagingController::class, 'buyerIndex'])->name('messages.index');
    Route::get('/messages/start/{seller}', [MessagingController::class, 'buyerStart'])->name('messages.start');
    Route::get('/messages/{conversation}', [MessagingController::class, 'buyerShow'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessagingController::class, 'storeMessage'])->name('messages.send');
    Route::post('/messages/{conversation}/read', [MessagingController::class, 'markRead'])->name('messages.read');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/a-propos', [InfoPageController::class, 'about'])->name('pages.about');
    Route::get('/livraison', [InfoPageController::class, 'livraison'])->name('pages.livraison');
    Route::get('/cgv', [InfoPageController::class, 'cgv'])->name('pages.cgv');
    Route::get('/confidentialite', [InfoPageController::class, 'confidentialite'])->name('pages.confidentialite');
});

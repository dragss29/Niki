<?php
require __DIR__ . '/../vendor/autoload.php';  // Assure-toi que le chemin est correct pour inclure l'autoloader de Composer
include __DIR__ . '/../includes/db.php';

// Configurer la clé API Stripe
\Stripe\Stripe::setApiKey('sk_test_your_stripe_secret_key'); // Remplace par ta clé secrète Stripe

// Fonction pour vérifier l'abonnement de l'utilisateur avec Stripe
function checkSubscription($userId) {
    global $conn;

    try {
        // Récupérer l'utilisateur depuis la base de données
        $query = $conn->prepare('SELECT stripe_customer_id, stripe_subscription_id FROM users WHERE id = :id');
        $query->execute(['id' => $userId]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception('Utilisateur non trouvé.');
        }

        // Vérifier l'abonnement avec Stripe
        $stripeCustomerId = $user['stripe_customer_id'];
        $stripeSubscriptionId = $user['stripe_subscription_id'];

        if (!$stripeCustomerId || !$stripeSubscriptionId) {
            throw new Exception('Aucun abonnement trouvé pour cet utilisateur.');
        }

        $subscription = \Stripe\Subscription::retrieve($stripeSubscriptionId);
        
        // Le statut de l'abonnement est 'active' ou 'past_due' pour un abonnement en cours
        if ($subscription->status === 'active' || $subscription->status === 'past_due') {
            $newSubscription = 'premium'; // Remplace avec le niveau d'abonnement correct basé sur ta logique
        } else {
            $newSubscription = 'free';
        }

        // Met à jour l'abonnement dans la base de données
        $updateQuery = $conn->prepare('UPDATE users SET subscription = :subscription WHERE id = :id');
        $updateQuery->execute([
            'subscription' => $newSubscription,
            'id' => $userId
        ]);

        echo '<p class="text-green-500 text-center mt-4">Subscription updated to ' . htmlspecialchars($newSubscription) . '.</p>';

    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo '<p class="text-red-500 text-center mt-4">Stripe API error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    } catch (Exception $e) {
        echo '<p class="text-red-500 text-center mt-4">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
}

// Appeler la fonction pour l'utilisateur connecté
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    checkSubscription($userId);
}

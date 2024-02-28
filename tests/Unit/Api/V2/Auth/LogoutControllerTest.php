<?php

namespace Tests\Unit\Api\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test logout endpoint with valid user.
     *
     * @return void
     */
    public function testLogoutWithValidUser()
    {
        // Créer un utilisateur pour le test
        $user = User::factory()->create();

        // Authentifier l'utilisateur avec Sanctum
        Sanctum::actingAs($user);

        // Appeler l'endpoint de déconnexion
        $response = $this->postJson('/api/auth/logout');

        // Vérifier que la réponse est un succès et retourne un statut 204 (pas de contenu)
        $response->assertStatus(204);
    }

    /**
     * Test logout endpoint when user is not authenticated.
     *
     * @return void
     */
    public function testLogoutWhenUserIsNotAuthenticated()
    {
        // Appeler l'endpoint de déconnexion sans authentifier l'utilisateur
        $response = $this->postJson('/api/auth/logout');

        // Vérifier que la réponse est un échec et retourne un statut 401 (non authentifié)
        $response->assertStatus(401);
    }
}

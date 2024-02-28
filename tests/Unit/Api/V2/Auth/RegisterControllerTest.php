<?php

namespace Tests\Unit\Api\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration with valid data.
     *
     * @return void
     */
    public function testUserRegistrationWithValidData()
    {
        // Créer des données valides pour l'utilisateur
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123', // Champ de confirmation du mot de passe
        ];

        // Appeler l'endpoint d'enregistrement avec les données valides
        $response = $this->postJson('/api/auth/register', $userData);

        // Vérifier que la réponse est un succès et retourne un statut 201 (créé)
        $response->assertStatus(201);

        // Vérifier que la réponse contient un utilisateur et un jeton d'accès
        $response->assertJsonStructure(['user', 'token']);
    }

    /**
     * Test user registration with invalid data.
     *
     * @return void
     */
    public function testUserRegistrationWithInvalidData()
    {
        // Créer des données invalides pour l'utilisateur (par exemple, email manquant)
        $userData = [
            'name' => 'John Doe',
            'password' => 'password123',
        ];

        // Appeler l'endpoint d'enregistrement avec les données invalides
        $response = $this->postJson('/api/auth/register', $userData);

        // Vérifier que la réponse est un échec et retourne un statut 422 (non traitable)
        $response->assertStatus(422);
    }
}

<?php
// src/Controller/Api/LoginController.php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]
    public function check(): void
    {
        // Этот метод НЕ должен быть вызван — управление передаётся LexikJWT
        throw new \LogicException('This should never be reached');
    }

    #[Route('/api/profile', name: 'api_profile', methods: ['GET'])]
    public function profile(#[CurrentUser] ?object $user): JsonResponse
    {
        if (!$user instanceof \App\Entity\User) {
            return $this->json(['error' => 'Not authenticated'], 401);
        }

        return $this->json([
            'id' => (string) $user->getId(),
            'email' => $user->getEmail(),
            'fullName' => $user->getFullName(),
            'role' => $user->getRole()->value,
        ]);
    }
}
<?php
// src/Controller/OAuthController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRole;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OAuthController extends AbstractController
{
    #[Route('/login/oauth/{service}', name: 'oauth_login')]
    public function login(ClientRegistry $clientRegistry, string $service)
    {
        $client = $clientRegistry->getClient($service);

        // Передаём scopes ДИНАМИЧЕСКИ при редиректе
        if ($service === 'google') {
            // Google: email + profile
            return $client->redirect(['email', 'profile']);
        }

        if ($service === 'github') {
            // GitHub: user:email (чтобы получить email)
            return $client->redirect(['user:email']);
        }

        // fallback
        return $client->redirect();
    }

    #[Route('/login/oauth/check', name: 'oauth_check')]
    public function check(
        Request $request,
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em
    ): JsonResponse {
        $service = $request->query->get('service', 'google');
        $client = $clientRegistry->getClient($service);

        // Получаем access token и данные
        $token = $client->getAccessToken();
        $userOauth = $client->fetchUserFromToken($token);

        $email = $userOauth->getEmail();
        if (!$email) {
            return $this->json(['error' => 'Email not provided'], 400);
        }

        $userRepo = $em->getRepository(User::class);
        $user = $userRepo->findOneBy(['email' => $email]);

        if (!$user) {
            $user = (new User())
                ->setEmail($email)
                ->setFullName($userOauth->getFullName() ?: $email)
                ->setPassword('') // OAuth — no password
                ->setOauthProvider($service)
                ->setRole(UserRole::SALES_MANAGER);
            $em->persist($user);
        } else {
            $user->setOauthProvider($service);
        }
        $em->flush();

        // Генерация JWT (временно — можно вызвать /api/login_check)
        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $tokenJwt = $jwtManager->create($user);

        return $this->json([
            'token' => $tokenJwt,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'fullName' => $user->getFullName(),
                'role' => $user->getRole()->value,
            ]
        ]);
    }
}
<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(private UserRepository $repo) {}

    #[Route('/api/user', methods:'GET')]
    public function all(): JsonResponse
    {
        return $this->json($this->repo->findAll());
    }
    #[Route('/api/user/{email}/promote', methods: 'PATCH')]
    public function promote(string $email, Request $request, SerializerInterface $serializer) {

        $user = $this->repo->findByEmail($email);
        if($user == null) {
            return $this->json('Resource Not found', 404);
        }
        $user->setRole('ROLE_ADMIN');
        $this->repo->update($user);
        return $this->json($user);
    }
}

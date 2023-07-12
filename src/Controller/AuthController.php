<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    #[Route('/api/user', methods: 'POST')]
    public function index(UserRepository $repo, Request $request, SerializerInterface $serializer, UserPasswordHasherInterface $hasher, ValidatorInterface $validator): JsonResponse
    {
        try {
            $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        } catch (\Exception $e) {
            return $this->json('Invalid body', 400);
        }

        $errors = $validator->validate($user);
        if($errors->count() > 0) {
            return $this->json(['errors' => $errors], 400);
        }

        if ($repo->findByEmail($user->getEmail())) {
            return $this->json('User Already exists', 400);
        }

        $hash = $hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hash);
        $user->setRole('ROLE_USER'); //On lui assigne le role user par défaut

        $repo->persist($user);

        return $this->json($user, 201);

    }

    #[Route('/api/protected', methods: 'GET')]
    public function protectedRoute() {
        return $this->json($this->getUser());
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('_username');
            $password = $request->request->get('_password');

            // Buscar el usuario por su email
            $userRepository = $this->entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            // Verificar la existencia del usuario y la contraseña
            if (!$user || !password_verify($password, $user->getPassword())) {
                $error = new AuthenticationException('Invalid email or password');
            } else {
                // Autenticar al usuario
                // Esto se hace automáticamente en Symfony cuando se usa el sistema de autenticación

                // Redirigir a la página de inicio o a otra página deseada después de iniciar sesión
                return $this->redirectToRoute('app_inicio');
            }
        }

        return $this->render('login/index.html.twig', [
            'error' => $error,
        ]);
    }
}


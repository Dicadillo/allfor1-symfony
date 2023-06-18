<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function registerForm(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $repeatPassword = $request->request->get('repeat_password');
            $lastname = $request->request->get('lastname');
            $phone = $request->request->get('phone');

            // Validar que los campos no estén vacíos
            if (empty($name) || empty($email) || empty($password) || empty($repeatPassword)) {
                // Manejar el error de campos vacíos
                // Puedes agregar un mensaje flash o retornar una respuesta de error
                return $this->redirectToRoute('app_register');
            }

            // Validar que las contraseñas coincidan
            if ($password !== $repeatPassword) {
                // Manejar el error de contraseñas no coincidentes
                // Puedes agregar un mensaje flash o retornar una respuesta de error
                return $this->redirectToRoute('app_register');
            }

            // Crear una nueva instancia de la entidad User
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setlastname($lastname);
            $user->setPhone($phone);

            // Codificar la contraseña antes de almacenarla en la base de datos
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);

            // Guardar el usuario en la base de datos
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Redirigir a la página de inicio de sesión o mostrar un mensaje de éxito
            // Puedes agregar un mensaje flash o personalizar la redirección según tus necesidades
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }
}

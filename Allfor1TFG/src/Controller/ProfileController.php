<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request): Response
    {
        // Obtener el usuario actualmente autenticado
        $user = $this->getUser();

        // Procesar el formulario de actualización de datos del usuario
        if ($request->isMethod('POST')) {
            $newData = $request->request->all();

            // Actualizar los datos del usuario con los nuevos valores
            $user->setName($newData['name']);
            $user->setEmail($newData['email']);

            // Guardar los cambios en la base de datos
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirigir a la página de perfil con un mensaje de éxito
            $this->addFlash('success', 'Los datos del usuario se han actualizado correctamente.');
            return $this->redirectToRoute('app_profile');
        } 

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
}

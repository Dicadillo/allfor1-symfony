<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contactForm(Request $request): Response
    {    
        // Procesar el formulario solo si se ha enviado por POST
        if ($request->isMethod('POST')) {
            // Crear una nueva instancia de la entidad Contact
            $contact = new Contact();
            $name = $request->request->get('name');
            if ($name !== null && $name !== '') {
                $contact->setName($name);
            } else {
                // Manejo de error o asignación de un valor predeterminado
            }

            $email = $request->request->get('email');
            if ($email !== null && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $contact->setEmail($email);
            } else {
                // Manejo de error o asignación de un valor predeterminado
            }

            $contact->setPhone($request->request->get('phone'));
            $contact->setMessage($request->request->get('message'));

            // Guardar la entidad en la base de datos
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            // Renderizar la página de contacto con el mensaje de éxito en el flash bag
            return $this->render('contact/index.html.twig', [
                'successMessage' => '¡El formulario se ha enviado correctamente!'
            ]);
        }

        // Renderizar la página de contacto sin el mensaje de éxito
        return $this->render('contact/index.html.twig');
    }
}

<?php

// src/Controller/InicioController.php

namespace App\Controller;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    

    #[Route('/inicio', name: 'app_inicio')]
    public function index(): Response
    {
        // Obtén todas las instancias de Activity desde algún repositorio o base de datos
        $activities = $this->entityManager->getRepository(Activity::class)->findAll();

        return $this->render('inicio/index.html.twig', [
            'activities' => $activities,
            'successMessage' => '',
        ]);
    }
}

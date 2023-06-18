<?php

// src/Controller/InicioController.php

namespace App\Controller;

use App\Entity\Activity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }

    #[Route('/inicio', name: 'app_inicio')]
    public function index(): Response
    {
        // Obtén una instancia de Activity desde algún repositorio o base de datos
        $activity = $this->entityManager->getRepository(Activity::class)->find(1);

        return $this->render('inicio/index.html.twig', [
            'activity' => $activity,
        ]);
    }
}

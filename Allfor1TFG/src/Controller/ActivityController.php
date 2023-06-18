<?php

namespace App\Controller;
use App\Entity\Activity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $registry->getManager();
    }

    /**
    * @Route("/activities", name="app_activities")
    */
    public function activities(): Response
    {
        $activities = $this->entityManager->getRepository(Activity::class)->findAll();

        return $this->render('activities/index.html.twig', [
            'activities' => $activities,
        ]);
    }
}

<?php

// src/Controller/ImageController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route("/images/{imageName}", name="app_show_image")
     */
    public function show(string $imageName): Response
    {
        // Obtén la ruta completa del archivo de imagen
        $imagePath = $this->getParameter('app_images_directory').'/'.$imageName;

        // Verifica si el archivo existe
        if (!file_exists($imagePath)) {
            throw $this->createNotFoundException('La imagen no se encontró.');
        }

        // Crea una respuesta con el archivo de imagen binario
        $response = new BinaryFileResponse($imagePath);

        // Establece el tipo MIME correcto para la respuesta
        $response->headers->set('Content-Type', 'image/jpeg'); // Ajusta el tipo MIME según el tipo de imagen

        return $response;
    }
}

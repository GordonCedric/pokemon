<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScreenController extends AbstractController
{
    #[Route('/screen', name: 'app_screen')]
    public function index(): Response
    {
        return $this->render('screen/index.html.twig', [
            'controller_name' => 'ScreenController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\QRCodes;
use App\Entity\Pokemons;
use Symfony\Component\HttpFoundation\RequestStack;

class ManagementController extends AbstractController
{
    #[Route('/pokemon/management', name: 'app_management')]
    public function index(): Response
    {
        return $this->render('management/index.html.twig', [
            'controller_name' => 'ManagementController',
        ]);
    }
    #[Route('/pokemon/management/newQR', name: 'app_new_qr')]
    public function newQR(ManagerRegistry $doctrine, RequestStack $requestStack): Response
    {
        $entityManager = $doctrine->getManager();
        $pokemons = $doctrine->getRepository(Pokemons::class);
        $pokecount = $pokemons->count([]);
        $genpokemon = rand(1, $pokecount);
        $pokemon = $doctrine->getRepository(Pokemons::class)->find($genpokemon);
        $qrcode = new QRCodes();
        $qrcode->setPokemon($pokemon);
        $qrcode->setUsed(0);
        

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($qrcode);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        $qrid = $qrcode->getId();
        $redeemurl = urlencode("http://localhost/pokemon/redeem/$qrid");
        $qrurl = "https://chart.googleapis.com/chart?cht=qr&chl=$redeemurl&chs=512x512";
        $qrcode->setQr($qrurl);
        $entityManager->persist($qrcode);
        $entityManager->flush();
        return $this->json(['id' => $qrid, 'qrurl' => $qrurl]);
    }
    #[Route('/pokemon/management/checkQR', name: 'app_check_qr')]
    public function checkQR(ManagerRegistry $doctrine, RequestStack $requestStack): Response
    {
        $entityBody = file_get_contents('php://input');
        $data = json_decode($entityBody);
        $qr = $doctrine->getRepository(QRCodes::class)->find($data->id);
        return $this->json(['used' => $qr->getUsed()]);
    }
    
    
}

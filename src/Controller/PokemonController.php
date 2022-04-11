<?php

namespace App\Controller;

use App\Entity\Trainers;
use App\Entity\Pokemons;
use App\Entity\QRCodes;
use App\Entity\TrainerHasPokemon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class PokemonController extends AbstractController
{
    #[Route('/pokemon/pokemons', name: 'app_pokemon')]
    public function index(RequestStack $requestStack): Response
    {
        if($requestStack->getSession()->get('uid')){
            return $this->render('pokemon/index.html.twig');
        } else {
            return $this->redirectToRoute('new_user');
        }
        
    }

    #[Route('/pokemon/newuser', name: 'new_user')]
    public function newuser(RequestStack $requestStack): Response
    {
        if(!$requestStack->getSession()->get('uid')){
            return $this->render('pokemon/newuser.html.twig');
        } else {
            return $this->redirectToRoute('app_pokemon');
        }
    }
    #[Route('/pokemon/sendname', name: 'send_user')]
    public function senduser(RequestStack $requestStack, ManagerRegistry $doctrine): Response
    {
        $name = $_POST['trainername'];
        $gender = $_POST['gender'];
        $entitymanager = $doctrine->getManager();
        $trainer = new Trainers();
        $trainer->setName($name);
        $trainer->setGender($gender);
        $entitymanager->persist($trainer);
        $entitymanager->flush();
        $requestStack->getSession()->set('uid', $trainer->getId());
        return $this->redirectToRoute('app_pokemon', array("firsttime" => 1));
    }
    #[Route('/pokemon/stopsession', name: 'stop_session')]
    public function stopsession(RequestStack $requestStack): Response
    {
        $requestStack->getSession()->clear();
        return $this->redirectToRoute('app_pokemon');
    }

    /**
     * REDEEM POKEMONS
     */

    #[Route('/pokemon/redeem/{id}', name: 'app_redeem_qr')]
    public function redeemQR($id, ManagerRegistry $doctrine, RequestStack $requestStack): Response
    {
        $serializer = new Serializer();
        $entitymanager = $doctrine->getManager();
        $qr = $doctrine->getRepository(QRCodes::class)->find($id);
        $pokemon = $doctrine->getRepository(Pokemons::class)->find($qr->getPokemon());
        $uid = $requestStack->getSession()->get('uid');
        $trainer = $doctrine->getRepository(Trainers::class)->find($uid);
        $thp = new TrainerHasPokemon();
        $thp->setPokemon($pokemon);
        $thp->setTrainer($trainer);
        $entitymanager->persist($thp);
        $entitymanager->flush();
        $pokelist = [];
        foreach($trainer->getTrainerHasPokemon() as $entry){
            foreach($entry->getPokemon() as $pokemon){
                $pokelist[] = $pokemon->getName();
            }
        }
        return $this->json($pokelist);
    }
}

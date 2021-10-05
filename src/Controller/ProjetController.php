<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projets", name="projets")
     */
    public function projets(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findBy(['portfolio' => '1'], ['id' => 'DESC'])
        ]);
    }
}

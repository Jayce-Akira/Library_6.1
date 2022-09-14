<?php

namespace App\Controller;

use App\Form\NatureLivreType;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search', methods:['GET', 'POST'])]
    public function searchType(Request $request, TypeRepository $typeRepository): Response
    {

              
                
                $form = $this->createForm(NatureLivreType::class);
        
                // SELECT * FROM type LEFT JOIN book ON type.id = book.type_id WHERE type.id = 1
                if($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
                    
                    $search = $form->getData();
                    dd($search);
                    $types = $typeRepository->searchType($search);


                }

        return $this->render('search/index.html.twig', [
            'searchForm' => $form->createView(),
        ]);
    }
}

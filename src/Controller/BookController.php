<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', methods:['GET', 'POST'])]
    public function index(Request $request,TypeRepository $typeRepository, BookRepository $bookRepository, $id): Response
    {

        $book = $bookRepository->find($id);

        $idType = $book->getType()->getId();

        return $this->render('book/index.html.twig', [
            'book' => $book,
            'books' => $bookRepository->typeOf($idType),
        ]);
    }
}

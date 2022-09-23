<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoanController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/loan', name: 'app_loan', methods:['GET', 'POST'])]
    public function index(UserInterface $user, LoanRepository $loanRepository, BookRepository $bookRepository): Response
    {
        // $idUser = $this->getUser()->getId();

        $loanUser = $loanRepository->loanUser($user);

        $loanUserConfirmed = $loanRepository->loanUserConfirmed($user);

        return $this->render('loan/index.html.twig', [
            'loanUser' => $loanUser,
            'loanUserConfirmed' => $loanUserConfirmed,
            'books' => $bookRepository->lastTree(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/loan/delete/{id}', name: 'delete_loan', methods:['GET', 'POST'])]
    public function delete(Loan $loan, EntityManagerInterface $manager): Response
    {
        if(!$loan){
            $this->addFlash(
                'danger',
                'Votre réservation n\' pas pue être supprimé !'
            );
            return $this->redirectToRoute('app_loan');
        }
        
        // Incremente le nb de book + 1
        $book = $loan->getBook();
        $addBook = $book->setNbOfBook($book->getNbOfBook() +1 );
        $manager->persist($addBook);
        $manager->flush();

        // Supprime la réservation
        $manager->remove($loan);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre réservation a été supprimé avec succés !'
        );

        return $this->redirectToRoute('app_loan');
    }
}

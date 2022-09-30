<?php

namespace App\Controller;

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
    public function index(UserInterface $user, LoanRepository $loanRepository, BookRepository $bookRepository, EntityManagerInterface $manager): Response
    {

        $loanUser = $loanRepository->loanUser($user);

        $loanUserConfirmed = $loanRepository->loanUserConfirmed($user);

        // Suppression des livres réservés non récupérés
        $filterDateReserved = $loanRepository->loanUser($user);
        $daysSeconde3days = 60 * 60 * 24 * 4; // je rajoute + 1 afin d'avoir je jour J
        $timestampPresent = time();
        $i = 0;
        foreach($filterDateReserved as $laonDateReserved)
        {
            $value[$i]['date_reserved'] = $laonDateReserved->getDateReserved();
            $value[$i]['id'] = $laonDateReserved->getId();
            $value[$i]['book'] = $laonDateReserved->getBook();
            // dd($value[$i]);
            if( ($value[$i]['date_reserved']->getTimestamp() + $daysSeconde3days) < $timestampPresent ){
                // Suppression des date de réservation qui dépassent les 3 jours;
                $loanRepository->deleteLoanDateReserved($value[$i]['date_reserved']);
                // Incremente le nb de book + 1
                $book = $value[$i]['book'];
                $addBook = $book->setNbOfBook($book->getNbOfBook() +1 );
                $manager->persist($addBook);
                $manager->flush();

                $this->addFlash(
                    'warning',
                    'Vos réservations qui ont dépassé les 3 jours ont été supprimées !'
                );

            }
            $i++;
        }


        // Message flash pour l'utilisateur qui n'a pas rendu les livres 
        $filterDateConfirmed = $loanRepository->loanUserConfirmed($user);
        $i = 0;
        foreach($filterDateConfirmed as $laonDateConfirmed)
        {
            $value[$i]['id'] = $laonDateConfirmed->getId();
            $value[$i]['date_return'] = $laonDateConfirmed->getDateReturn();
            $value[$i]['is_late'] = $laonDateConfirmed->isIsLate();

            if(  $value[$i]['date_return'] != null AND (($value[$i]['date_return']->getTimestamp()) < time()) AND $value[$i]['is_late'] != 1){

                $loanRepository->updateLateReturn($value[$i]['date_return']);

                $this->addFlash(
                    'danger',
                    'Vos prêt doit être rendu au plus vite !'
                );
                return $this->redirectToRoute('app_loan');
            }
            $i++;
        }



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

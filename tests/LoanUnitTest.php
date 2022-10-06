<?php

namespace App\Tests;

use DateTime;
use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class LoanUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $loan = new Loan();
        $datetime = new DateTime();
        $book = new Book();
        $user = new User();

        $loan->setDateReserved($datetime)
        ->setDateLoan($datetime)
        ->setDateReturn($datetime)
        ->setStatus('status')
        ->setIsLate(true)
        ->setBook($book)
        ->setUsers($user);

        $this->assertTrue($loan->getDateReserved() === $datetime);
        $this->assertTrue($loan->getDateLoan() === $datetime);
        $this->assertTrue($loan->getDateReturn() === $datetime);
        $this->assertTrue($loan->getStatus() === 'status');
        $this->assertTrue($loan->isIsLate() === true);
        $this->assertTrue($loan->getBook() === $book);
        $this->assertTrue($loan->getUsers() === $user);
    }

    public function testIsFalse()
    {
        $loan = new Loan();
        $datetime = new DateTime();
        $book = new Book();
        $user = new User();

        $loan->setDateReserved($datetime)
        ->setDateLoan($datetime)
        ->setDateReturn($datetime)
        ->setStatus('status')
        ->setIsLate(true)
        ->setBook($book)
        ->setUsers($user);

        $this->assertFalse($loan->getDateReserved() === new DateTime());
        $this->assertFalse($loan->getDateLoan() === new DateTime());
        $this->assertFalse($loan->getDateReturn() === new DateTime());
        $this->assertFalse($loan->getStatus() === 'false');
        $this->assertFalse($loan->isIsLate() === false);
        $this->assertFalse($loan->getBook() === new Book());
        $this->assertFalse($loan->getUsers() === new User());
    }

    public function testIsEmpty()
    {
        $loan = new Loan();

        $this->assertEmpty($loan->getDateReserved() === new DateTime());
        $this->assertEmpty($loan->getDateLoan());
        $this->assertEmpty($loan->getDateReturn());
        $this->assertEmpty($loan->getStatus());
        $this->assertEmpty($loan->isIsLate());
        $this->assertEmpty($loan->getBook());
        $this->assertEmpty($loan->getUsers());

    }
}

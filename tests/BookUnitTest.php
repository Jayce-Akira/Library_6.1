<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\Type;
use DateTime;
use PHPUnit\Framework\TestCase;

class BookUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $book = new Book();
        $datetime = new DateTime();
        $type = new Type();
        $loan = new Loan();

        $book->setTitle('title')
        ->setImgCover('image')
        ->setDescription('description')
        ->setAuthor('auteur')
        ->setDatePublished($datetime)
        ->setNbOfBook(1)
        ->setEditor('editeur')
        ->setType($type)
        ->addLoan($loan);


        $this->assertTrue($book->getTitle() === 'title');
        $this->assertTrue($book->getImgCover() === 'image');
        $this->assertTrue($book->getDescription() === 'description');
        $this->assertTrue($book->getAuthor() === 'auteur');
        $this->assertTrue($book->getDatePublished() === $datetime);
        $this->assertTrue($book->getNbOfBook() === 1);
        $this->assertTrue($book->getEditor() === 'editeur');
        $this->assertTrue($book->getType() === $type);
        $this->assertContains($loan, $book->getLoans());

    }

    public function testIsFalse()
    {
        $book = new Book();
        $datetime = new DateTime();
        $type = new Type();
        $loan = new Loan();

        $book->setTitle('title')
        ->setImgCover('image')
        ->setDescription('description')
        ->setAuthor('auteur')
        ->setDatePublished($datetime)
        ->setNbOfBook(1)
        ->setEditor('editeur')
        ->setType($type)
        ->addLoan($loan);


        $this->assertFalse($book->getTitle() === 'false');
        $this->assertFalse($book->getImgCover() === 'false');
        $this->assertFalse($book->getDescription() === 'false');
        $this->assertFalse($book->getAuthor() === 'false');
        $this->assertFalse($book->getDatePublished() === new DateTime());
        $this->assertFalse($book->getNbOfBook() === 'false');
        $this->assertFalse($book->getEditor() === 'false');
        $this->assertFalse($book->getType() === new Type());
        $this->assertNotContains(new Loan(), $book->getLoans());
    }

    public function testIsEmpty()
    {
        $book = new Book();

        $this->assertEmpty($book->getTitle());
        $this->assertEmpty($book->getImgCover());
        $this->assertEmpty($book->getDescription());
        $this->assertEmpty($book->getAuthor());
        $this->assertEmpty($book->getDatePublished());
        $this->assertEmpty($book->getNbOfBook());
        $this->assertEmpty($book->getEditor());
        $this->assertEmpty($book->getType());
        $this->assertEmpty($book->getLoans());
    }
}

<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Type;
use PHPUnit\Framework\TestCase;

class TypeUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $type = new Type();
        $book = new Book();

        $type->setName('test')
        ->addBook($book);


        $this->assertTrue($type->getName() === 'test');
        $this->assertContains($book, $type->getBooks());

    }

    public function testIsFalse()
    {
        $type = new Type();
        $book = new Book();

        $type->setName('test')
        ->addBook($book);

        $this->assertFalse($type->getName() === 'false');
        $this->assertNotContains(new Book(), $type->getBooks());
    }

    public function testIsEmpty()
    {
        $type = new Type();

        $this->assertEmpty($type->getName());
        $this->assertEmpty($type->getBooks());

    }
}

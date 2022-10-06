<?php

namespace App\Tests;

use App\Entity\Loan;
use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $datetime = new DateTime();
        $dateimmu = new DateTimeImmutable();
        $loan = new Loan();

        $user->setEmail('true@test.com')
        ->setLastname('lastname')
        ->setFirstname('firstname')
        ->setPassword('password')
        ->setAddress('address')
        ->setZipcode('12345')
        ->setCity('city')
        ->setRoles(['role'])
        ->setDateOfBirth($datetime)
        ->setIsConfirmed(true)
        ->setCreatedAt($dateimmu)
        ->setPhone('123')
        ->setMobilePhone('456')
        ->addLoan($loan);

        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getLastname() === 'lastname');
        $this->assertTrue($user->getFirstname() === 'firstname');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getAddress() === 'address');
        $this->assertTrue($user->getZipcode() === '12345');
        $this->assertTrue($user->getCity() === 'city');
        $this->assertTrue($user->getRoles() === ['role']);
        $this->assertTrue($user->getDateOfBirth() === $datetime);
        $this->assertTrue($user->isIsConfirmed() === true);
        $this->assertTrue($user->getCreatedAt() === $dateimmu);
        $this->assertTrue($user->getPhone() === '123');
        $this->assertTrue($user->getMobilePhone() === '456');
        $this->assertContains($loan, $user->getLoans());
    }

    public function testIsFalse()
    {
        $user = new User();
        $datetime = new DateTime();
        $dateimmu = new DateTimeImmutable();
        $loan = new Loan();

        $user->setEmail('true@test.com')
        ->setLastname('lastname')
        ->setFirstname('firstname')
        ->setPassword('password')
        ->setAddress('address')
        ->setZipcode('12345')
        ->setCity('city')
        ->setRoles(['role'])
        ->setDateOfBirth($datetime)
        ->setIsConfirmed(true)
        ->setCreatedAt($dateimmu)
        ->setPhone('123')
        ->setMobilePhone('456')
        ->addLoan($loan);

        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getLastname() === 'false');
        $this->assertFalse($user->getFirstname() === 'false');
        $this->assertFalse($user->getPassword() === 'false');
        $this->assertFalse($user->getAddress() === 'false');
        $this->assertFalse($user->getZipcode() === 'false');
        $this->assertFalse($user->getCity() === 'false');
        $this->assertFalse($user->getRoles() === ['false']);
        $this->assertFalse($user->getDateOfBirth() === new DateTime());
        $this->assertFalse($user->isIsConfirmed() === false);
        $this->assertFalse($user->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($user->getPhone() === 'false');
        $this->assertFalse($user->getMobilePhone() === 'false');
        $this->assertNotContains(new Loan(), $user->getLoans());
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getAddress());
        $this->assertEmpty($user->getZipcode());
        $this->assertEmpty($user->getCity());
        $this->assertEmpty($user->getRoles());
        $this->assertEmpty($user->getDateOfBirth());
        $this->assertEmpty($user->isIsConfirmed());
        $this->assertEmpty($user->getCreatedAt() === new DateTimeImmutable());
        $this->assertEmpty($user->getPhone());
        $this->assertEmpty($user->getMobilePhone());
        $this->assertEmpty($user->getLoans());
    }
}

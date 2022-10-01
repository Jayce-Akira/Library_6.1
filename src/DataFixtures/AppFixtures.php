<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        $user = new User();

        $user->setEmail('user@admin.fr')
        ->setFirstname($faker->firstName())
        ->setLastname($faker->lastName())
        ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ->setAddress($faker->address())
        ->setZipcode(str_replace(" ", "", $faker->postcode()))
        ->setCity($faker->city());

        $password = $this->encoder->hashPassword($user, 'azerty');
        $user->setPassword($password);

        $manager->persist($user);
        
        for($u = 0; $u < 5; $u++) {
            $users = new User();
            $users->setEmail($faker->email())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setRoles(['ROLE_USER'])
                ->setAddress($faker->address())
                ->setZipcode(str_replace(" ", "", $faker->postcode()))
                ->setCity($faker->city())
                ->setPassword($faker->password());

            $manager->persist($users);

        }

        for ($i = 0; $i < 5; $i++) {
            $type = new Type();
            $type->setName($faker->word());

            $manager->persist($type);
            
            for ($j = 0; $j < 8; $j++) {
                $books = new Book();

                $books->setTitle($faker->words(3, true))
                ->setImgCover('placeholder.png')
                ->setDescription($faker->words(10, true))
                ->setAuthor($faker->firstName())
                ->setDatePublished($faker->dateTimeBetween('- 6 year' , 'now'))
                ->setEditor($faker->lastName())
                ->setNbOfBook(5)
                ->setType($type);

                $manager->persist($books);
            }
        }


        $manager->flush();
    }
}

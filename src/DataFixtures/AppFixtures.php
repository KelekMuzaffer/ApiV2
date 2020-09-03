<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    /**
     * Encoder le password
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create();

        for ($u = 0; $u < 10; $u++) {
            $user = new User();

            $passHash = $this->encoder->encodePassword($user, 'password');

            $user->setEmail($fake->email)
                ->setPassword($passHash);

            $manager->persist($user);

            for ($a = 0; $a < random_int(5, 15); $a++) {
                $article = (new Article())->setAuthor($user)
                    ->setContent($fake->text(50))
                    ->setPrice($fake->numberBetween(5,50))
                    ->setName($fake->text(20));

                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}

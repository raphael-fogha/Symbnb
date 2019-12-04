<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');

        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Raphael')
                  ->setLastName('Fogha')
                  ->setEmail('kitruix@outlook.fr')
                  ->setHash($this->encoder->encodePassword($adminUser,'password'))
                  ->setPicture('https://randomuser.me/api/portraits/men/28.jpg')
                  ->setIntroduction($faker->sentence())
                  ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(3)). '</p>')
                  ->addUserRole($adminRole);
                  
        $manager->persist($adminUser);

        //Gestion des utilisateurs
        $users = [];
        $genders = ['male','female'];

        for($i = 1; $i <= 10 ; $i++ )
        {
            $user = new User();

            $gender = $faker->randomElement($genders);

            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            $picture .= ($gender == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user,'password');

            $user->setFirstName($faker->firstname($gender))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                 ->setHash($hash)
                 ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }


        //Gestion des annonces
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0,count($users) - 1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 6))
                ->setAuthor($user);

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            $manager->persist($ad);
        }


        $manager->flush();
    }
}

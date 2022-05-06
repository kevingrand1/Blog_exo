<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $admin = (new User())
                ->setEmail('admin@admin.fr')
                ->setFirstName('John')
                ->setLastName('Doe')
                ->setRoles(['ROLE_ADMIN'])
            ;
            $admin->setPassword($this->passwordHasher->hashPassword($admin, 'Admin1234'));
            $manager->persist($admin);

        for ($u = 0; $u < 10; $u++) {
            $user = (new User())
                ->setEmail($faker->email())
                ->setFirstName($faker->lastName())
                ->setLastName($faker->lastName())
                ->setRoles(['ROLE_ADMIN'])
            ;
            $user->setPassword($this->passwordHasher->hashPassword($user, 'Admin1234'));
            $manager->persist($user);
            $this->addReference('user'.$u, $user);
        }

        for ($c = 0; $c < 10; $c++) {
            $category = (new Category())
                ->setName($faker->safeColorName());

            $manager->persist($category);
            $this->addReference('category'.$c, $category);
        }

        for ($i = 0; $i < 50; $i++) {
            /** @var Category $category */
            $category = $this->getReference('category'.mt_rand(0, 9));
            /** @var User $user */
            $user = $this->getReference('user'.mt_rand(0, 9));

            $post = (new Post())
                ->setTitle($faker->safeColorName())
                ->setContent($faker->paragraphs(3, true))
                ->setIsActive($faker->boolean())
                ->setCategory($category)
                ->setUser($user)
            ;
            $manager->persist($post);
        }

        $manager->flush();
    }
}

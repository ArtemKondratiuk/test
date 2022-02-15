<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        public UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $password = $this->hasher->hashPassword($user, '12345678');
        $user->setUsername('admin')
            ->setEmail('admin@gmail.com')
            ->setPassword($password)
            ->setRoles(["ROLE_ADMIN"])
        ;

        $manager->persist($user);

        $category = new Category();
        $category->setName('category');
        $manager->persist($category);
        $this->addReference('category', $category);

        $post = new Post();
        $categories = $this->getReference('category');
        $post->setTitle('title')
            ->setText('text')
            ->setAuthor($user)
            ->addCategory($categories)
        ;

        $manager->persist($post);

        $manager->flush();
    }
}

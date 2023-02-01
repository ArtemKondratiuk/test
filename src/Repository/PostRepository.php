<?php

namespace App\Repository;

use App\Dto\NewCategoryDto;
use App\Dto\NewPostDto;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        public EntityManagerInterface $em,
        public Security $security
    )
    {
        parent::__construct($registry, Post::class);
    }

    public function showPost(): array
    {
        return $this->findBy(['author' => $this->security->getUser()]);
    }

    public function showPostById(int $id): ?Post
    {
        return $this->find($id);
    }

    public function newPost(NewPostDto $newPostDto, NewCategoryDto $newCategoryDto): Post
    {
        $post = new Post();
        $category = new Category();

        $category->setName($newCategoryDto->name);

        $post->setTitle($newPostDto->title)
            ->setText($newPostDto->text)
            ->setAuthor($this->security->getUser())
            ->addCategory($category)
        ;

        $this->em->persist($category);
        $this->em->persist($post);
        $this->em->flush();

        return $post;
    }

    public function editPost(NewPostDto $newPostDto, NewCategoryDto $newCategoryDto, Post $post): Post
    {
        $category = new Category;
        $category->setName($newCategoryDto->name);
        $post->setTitle($newPostDto->title)
            ->setText($newPostDto->text)
            ->setAuthor($this->security->getUser())
            ->addCategory($category)
        ;

        $this->em->flush();

        return $post;
    }

    public function removePost(Post $post): void
    {
        $this->em->remove($post);
        $this->em->flush();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

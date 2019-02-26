<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{

    /**
     * @inheritdoc
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Find the latest posts.
     *
     * @param string $locale
     * @param int    $page
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function findLatest(string $locale, int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p')
                   ->where('p.createdAt <= :now')
                   ->andWhere('p.locale = :locale' )
                   ->orderBy('p.createdAt', 'DESC')
                   ->setParameter('now', new \DateTime())
                   ->setParameter('locale', $locale);

        return $this->createPaginator($qb->getQuery(), $page);
    }

    /**
     * Create the paginator.
     *
     * @param Query $query
     * @param int   $page
     *
     * @return \Pagerfanta\Pagerfanta
     */
    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));

        $paginator->setMaxPerPage(Post::NUM_POST_PER_PAGE);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

}

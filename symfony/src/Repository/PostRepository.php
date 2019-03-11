<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends AbstractRepository
{

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return Post::class;
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
                   ->leftJoin('p.comments', 'c')
                   ->leftJoin('p.likes', 'l')
                   ->leftJoin('p.user', 'u')
                   ->addSelect('c')
                   ->addSelect('l')
                   ->addSelect('u')
                   ->where('p.locale = :locale')
                   ->orderBy('p.createdAt', 'DESC')
                   ->setParameter('locale', $locale)
        ;

        return $this->createPaginator($qb->getQuery(), $page);
    }

    /**
     * Find the latest posts by user.
     *
     * @param int $userId
     * @param int $page
     *
     * @return \Pagerfanta\Pagerfanta
     */
    public function findLatestByUser(int $userId, int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p')
                   ->where('p.user = :user')
                   ->leftJoin('p.comments', 'c')
                   ->leftJoin('p.likes', 'l')
                   ->leftJoin('p.user', 'u')
                   ->addSelect('c')
                   ->addSelect('l')
                   ->addSelect('u')
                   ->orderBy('p.createdAt', 'DESC')
                   ->setParameter('user', $userId)
        ;

        return $this->createPaginator($qb->getQuery(), $page);
    }

    /**
     * Get all post paginated.
     *
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findAllLatest(int $page): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p')
                   ->leftJoin('p.comments', 'c')
                   ->leftJoin('p.likes', 'l')
                   ->leftJoin('p.user', 'u')
                   ->addSelect('c')
                   ->addSelect('l')
                   ->addSelect('u')
                   ->orderBy('p.createdAt', 'DESC')
        ;

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

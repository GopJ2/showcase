<?php
declare( strict_types = 1);

namespace App\Repository;

use App\Entity\Note;
use App\Entity\User;
use App\Query\Note\GetPaginatedNotesByUserQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @param Note $note
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Note $note): void
    {
        $this->_em->persist($note);
        $this->_em->flush();
    }

    /**
     * @param GetPaginatedNotesByUserQuery $query
     * @return array
     */
    public function getNotesByUserPaginated(GetPaginatedNotesByUserQuery $query): array
    {
        return $this->createQueryBuilder('n')
            ->select('n.id', 'n.description')
            ->where('n.user = :user')
            ->setParameter('user', $query->getUser())
            ->setFirstResult($query->getSkip())
            ->setMaxResults($query->getTake())
            ->getQuery()
            ->getResult();
    }
}

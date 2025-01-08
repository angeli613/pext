<?php

namespace App\Repository;

use App\Entity\Expenses;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expenses>
 */
class ExpensesRepository extends ServiceEntityRepository{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Expenses::class);
    }

    //    /**
    //     * @return Expenses[] Returns an array of Expenses objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Expenses
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findByMonthAndYear(int $month, int $year): array {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT e.*, c.name AS category_name
            FROM expenses e
            LEFT JOIN category c ON e.category_id = c.id
            WHERE EXTRACT(MONTH FROM e.date) = :month
            AND EXTRACT(YEAR FROM e.date) = :year
        ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['month' => $month, 'year' => $year]);
        $results = $resultSet->fetchAll();

        $expenses = [];
        foreach ($results as $result) {
            $expenses[] = $this->createExpenseFromArray($result);
        }

        return $expenses;
    }
    
    public function createExpenseFromArray(array $data): Expenses {
        $expense = new Expenses();
        $expense->getId($data['id']);
        $expense->setDate(new \DateTime($data['date']));
        $expense->setAmount($data['amount']);

        if (isset($data['category_id'])){
            $categoryRepository = $this->getEntityManager()->getRepository(Category::class);
            $category = $categoryRepository->find($data['category_id']);
            $expense->setCategory($category);
        }

        return $expense;
    }

    public function getTotalAmountByCategory():array {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT c.name AS category, SUM(e.Amount) AS total_expense
            FROM Category c, expenses e
            WHERE c.id = e.category_id
            GROUP BY c.name
        ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([]);
        $results = $resultSet->fetchAll();
        
        return $results;
    }
}

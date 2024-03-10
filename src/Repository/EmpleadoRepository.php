<?php

namespace App\Repository;

use App\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Empleado>
 *
 * @method Empleado|null find($id, $lockMode = null, $lockVersion = null)
 * @method Empleado|null findOneBy(array $criteria, array $orderBy = null)
 * @method Empleado[]    findAll()
 * @method Empleado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleado::class);
    }

    //    /**
    //     * @return Empleado[] Returns an array of Empleado objects
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

    //    public function findOneBySomeField($value): ?Empleado
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function consulta1(): array
    {
        return $this->createQueryBuilder('empleado')
            ->select(
                'empleado.nombre',
                'empleado.puesto',
                'empleado.apellido',
                'empleado.email'
            )
            ->getQuery()
            ->getResult();
    }

    public function consulta4($idEmpleado): array
    {
        return $this->createQueryBuilder('empleado')
            ->select(
                'empleado.nombre as nombreEmpleado',
                'empleado.apellido',
                'empleado.puesto',
                'empleado.email',
                'servicio.nombre as nombreServicio',
                'servicio.precio'
            )
            ->innerJoin('empleado.servicio', 'servicio')
            ->where('empleado.id = :idEmpleado')
            ->setParameter('idEmpleado', $idEmpleado)
            ->getQuery()
            ->getResult();
    }
}

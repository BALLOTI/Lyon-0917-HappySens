<?php

namespace AppBundle\Repository;

/**
 * CompanyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CompanyRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSkillInCompagny($companyId) {

        $qb = $this
            ->createQueryBuilder('c')
            ->select([ '(avg(us.level)) as level', 'count(s.nameSkill) as nbSalary', 's.nameSkill as nameSkill'])
            ->join('c.users', 'u')
            ->join('u.userskills', 'us')
            ->join('us.skill', 's')
            ->orderBy('nbSalary', "desc")
            ->addOrderBy('level', "desc")
            ->setParameter('idCompany', $companyId)
            ->groupBy('s.nameSkill')
            ->setMaxResults(5)
             ->where('c.id=:idCompany')
            ->getQuery();
        return $qb->getResult();
    }

    public function getReferentHappySens($companyId) {
       $qb = $this->createQueryBuilder('c')
           ->select('u.firstName', 'u.lastName', 'u.slug')
           ->join('c.users', 'u')
           ->setParameter('idCompany', $companyId)
           ->where('c.id=:idCompany')
           ->andWhere('u.status=2')
           ->getQuery();
        return $qb->getResult();
    }
}

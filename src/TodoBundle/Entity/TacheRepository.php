<?php

namespace TodoBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TacheRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TacheRepository extends EntityRepository
{

    /**
     * Return taches by etat
     * @param $etat
     * @param $projet
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByEtat($etat,$projet) {

        $query = $this->createQueryBuilder("tache")
            ->select("tache")
            ->where("tache.etat = :etat")
            ->andWhere("tache.encorbeille <> 1")
            ->setParameter("etat",$etat);

        if($etat->getNom() == "A faire") {
            $query
                ->orWhere("tache.etat is NULL");
        }

        if(!is_null($projet)) {
            $query
                ->where("tache.projet = :projet")
                ->setParameter("projet",$projet);
        }
        $taches = $query->getQuery()->getArrayResult();

        return $taches;

    }


    /**
     * @param $idtache
     * @param int $idetat
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getSpentTime($idtache,$idetat = 2) {

        $sql = "
            SELECT
                date_debut,
                date_fin,
                DATEDIFF(date_fin,date_debut) as 'nbr_jours'
            FROM etat_tache
            WHERE id_tache = $idtache and id_etat = $idetat
        ";

        $conn = $this->_em->getConnection();
        $results = $conn->query($sql)->fetchAll();

        return $results;

    }

}

<?php

namespace TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatTache
 *
 * @ORM\Table(name="etat_tache")
 * @ORM\Entity(repositoryClass="TodoBundle\Entity\EtatTacheRepository")
 */
class EtatTache
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="\TodoBundle\Entity\Etat")
     * @ORM\JoinColumn(name="id_etat", referencedColumnName="id")
     */
    private $etat;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="\TodoBundle\Entity\Tache")
     * @ORM\JoinColumn(name="id_tache", referencedColumnName="id")
     */
    private $tache;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return EtatTache
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return EtatTache
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set etat
     *
     * @param \TodoBundle\Entity\Etat $etat
     * @return EtatTache
     */
    public function setEtat(\TodoBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \TodoBundle\Entity\Etat 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set tache
     *
     * @param \TodoBundle\Entity\Tache $tache
     * @return EtatTache
     */
    public function setTache(\TodoBundle\Entity\Tache $tache = null)
    {
        $this->tache = $tache;

        return $this;
    }

    /**
     * Get tache
     *
     * @return \TodoBundle\Entity\Tache 
     */
    public function getTache()
    {
        return $this->tache;
    }
}

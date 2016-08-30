<?php

namespace TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TodoBundle\Entity\TacheRepository")
 */
class Tache
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps_passes", type="datetime")
     */
    private $tempsPasses;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps_prevu", type="datetime")
     */
    private $tempsPrevu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="code_couleur", type="string", length=255)
     */
    private $codeCouleur;


    /**
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="taches")
     * @ORM\JoinColumn(name="id_projet", referencedColumnName="id")
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", inversedBy="tachesEnCours")
     * @ORM\JoinColumn(name="id_user_assigned", referencedColumnName="id")
     */
    private $userAssigned;


    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="Etat")
     * @ORM\JoinColumn(name="id_etat", referencedColumnName="id")
     */
    private $etat;


    /**
     * @ORM\ManyToOne(targetEntity="Complexity")
     * @ORM\JoinColumn(name="id_complexity", referencedColumnName="id")
     */
    private $complexity;

    /**
     * @ORM\ManyToOne(targetEntity="Tache")
     * @ORM\JoinColumn(name="id_tache_parente", referencedColumnName="id")
     */
    private $tacheParentes;


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
     * Set nom
     *
     * @param string $nom
     * @return Tache
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set tempsPasses
     *
     * @param \DateTime $tempsPasses
     * @return Tache
     */
    public function setTempsPasses($tempsPasses)
    {
        $this->tempsPasses = $tempsPasses;

        return $this;
    }

    /**
     * Get tempsPasses
     *
     * @return \DateTime 
     */
    public function getTempsPasses()
    {
        return $this->tempsPasses;
    }

    /**
     * Set tempsPrevu
     *
     * @param \DateTime $tempsPrevu
     * @return Tache
     */
    public function setTempsPrevu($tempsPrevu)
    {
        $this->tempsPrevu = $tempsPrevu;

        return $this;
    }

    /**
     * Get tempsPrevu
     *
     * @return \DateTime 
     */
    public function getTempsPrevu()
    {
        return $this->tempsPrevu;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Tache
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set codeCouleur
     *
     * @param string $codeCouleur
     * @return Tache
     */
    public function setCodeCouleur($codeCouleur)
    {
        $this->codeCouleur = $codeCouleur;

        return $this;
    }

    /**
     * Get codeCouleur
     *
     * @return string 
     */
    public function getCodeCouleur()
    {
        return $this->codeCouleur;
    }
}

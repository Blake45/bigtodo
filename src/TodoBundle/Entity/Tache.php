<?php

namespace TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tache
 *
 * @ORM\Table("tache")
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
     * @ORM\Column(name="temps_passes", type="integer")
     */
    private $tempsPasses = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps_prevu", type="integer")
     */
    private $tempsPrevu = 0;

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
    private $codeCouleur = "#b3e5fc";


    /**
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="taches")
     * @ORM\JoinColumn(name="id_projet", referencedColumnName="id", nullable=true)
     */
    private $projet;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", inversedBy="tachesEnCours")
     * @ORM\JoinColumn(name="id_user_assigned", referencedColumnName="id")
     */
    private $userAssigned;

    /**
     * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User", inversedBy="tachesCrees")
     * @ORM\JoinColumn(name="id_user_creator", referencedColumnName="id")
     */
    private $user;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var boolean
     *
     * @ORM\Column(name="isblocked", type="boolean")
     */
    private $isBlocked=false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="en_corbeille", type="boolean")
     */
    private $encorbeille=false;


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

    /**
     * Set projet
     *
     * @param \TodoBundle\Entity\Projet $projet
     * @return Tache
     */
    public function setProjet(\TodoBundle\Entity\Projet $projet = null)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return \TodoBundle\Entity\Projet 
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Set userAssigned
     *
     * @param \UserBundle\Entity\User $userAssigned
     * @return Tache
     */
    public function setUserAssigned(\UserBundle\Entity\User $userAssigned = null)
    {
        $this->userAssigned = $userAssigned;

        return $this;
    }

    /**
     * Get userAssigned
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUserAssigned()
    {
        return $this->userAssigned;
    }

    /**
     * Set etat
     *
     * @param \TodoBundle\Entity\Etat $etat
     * @return Tache
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
     * Set complexity
     *
     * @param \TodoBundle\Entity\Complexity $complexity
     * @return Tache
     */
    public function setComplexity(\TodoBundle\Entity\Complexity $complexity = null)
    {
        $this->complexity = $complexity;

        return $this;
    }

    /**
     * Get complexity
     *
     * @return \TodoBundle\Entity\Complexity 
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * Set tacheParentes
     *
     * @param \TodoBundle\Entity\Tache $tacheParentes
     * @return Tache
     */
    public function setTacheParentes(\TodoBundle\Entity\Tache $tacheParentes = null)
    {
        $this->tacheParentes = $tacheParentes;

        return $this;
    }

    /**
     * Get tacheParentes
     *
     * @return \TodoBundle\Entity\Tache 
     */
    public function getTacheParentes()
    {
        return $this->tacheParentes;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tache
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Tache
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set isBlocked
     *
     * @param boolean $isBlocked
     * @return Tache
     */
    public function setIsBlocked($isBlocked)
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    /**
     * Get isBlocked
     *
     * @return boolean 
     */
    public function getIsBlocked()
    {
        return $this->isBlocked;
    }

    /**
     * Set encorbeille
     *
     * @param boolean $encorbeille
     * @return Tache
     */
    public function setEncorbeille($encorbeille)
    {
        $this->encorbeille = $encorbeille;

        return $this;
    }

    /**
     * Get encorbeille
     *
     * @return boolean 
     */
    public function getEncorbeille()
    {
        return $this->encorbeille;
    }
}

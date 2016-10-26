<?php

namespace TodoBundle\Service;


class Front extends \Twig_Extension
{
    const DUREE_JOURS = 25200;
    const DUREE_HEURE = 3600;
    const DUREE_MIN = 60;

    public function getFunctions()
    {
        return array(
            'getNomColonne' => new \Twig_Function_Method($this, 'getNomColonne'),
            'displayTime' => new \Twig_Function_Method($this, 'displayTime'),
        );
    }

    /**
     * Return the name of the column
     * @param $id_colonne
     * @return string
     */
    public function getNomColonne($id_colonne) {

        switch($id_colonne) {
            case "a_faire":
                $nom = "A faire";
                break;
            case "en_cours":
                $nom = "En cours";
                break;
            case "finis":
                $nom = "Terminée";
                break;
            case "en_attente":
                $nom = "En attente";
                break;
            default: $nom = "A faire";; break;
        }
        return $nom;

    }

    /**
     * Return the display of the time (seconds) for a task
     * @param $time
     * @return string
     */
    public function displayTime($seconds) {

        $jours = floor($seconds / self::DUREE_JOURS);
        $extractheures = $seconds % self::DUREE_JOURS;

        $heures = floor($extractheures / self::DUREE_HEURE);
        $extractmin = $extractheures % self::DUREE_HEURE;

        $minutes = floor($extractmin / self::DUREE_MIN);

        $display = $jours > 0 ? "$jours j":"";
        $display .= $heures > 0 ? " $heures h" : "";
        $display .= $minutes > 0 ? " $minutes min":"";

        return $display;
    }

    public function getName()
    {
        return 'todo.front_functions';
    }
}
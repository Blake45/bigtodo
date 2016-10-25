<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 25/10/2016
 * Time: 16:42
 */

namespace TodoBundle\Service;


class Front extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            'getNomColonne' => new \Twig_Function_Method($this, 'getNomColonne'),
        );
    }

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

    public function getName()
    {
        return 'todo.front_functions';
    }
}
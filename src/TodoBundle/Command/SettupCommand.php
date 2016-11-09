<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 03/11/2016
 * Time: 14:27
 */

namespace TodoBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SettupCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName("todo:settup")
            ->setDescription("Settup all data to database for the app")
            ->setHelp("This command help you to initialize the database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            "Init database : Etat, etc"
        ]);

        $this->getContainer()->get("todo.handle_etat")->initTableEtat();

    }

}
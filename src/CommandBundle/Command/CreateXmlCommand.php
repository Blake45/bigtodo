<?php


namespace CommandBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class CreateXmlCommand extends Command
{

    private $parametres;
    private $type;
    private $xml;

    protected function configure()
    {
        $this
            ->setName('xml:build')
            ->setDescription("construit un fichier xml")
            ->setHelp("php app/console xml:build {type} {params}")
            ->addArgument('type', InputArgument::REQUIRED, "Type de fichier xml finale")
            ->addArgument('param', InputArgument::IS_ARRAY, "Données pour la construction du xml");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->type = $input->getArgument('type');
        $this->parametres = $input->getArgument('param');

        if ($this->type == 'image') {

            $this->getImages();

        }
    }

    private function getImages()
    {
        $finder = new Finder();
        foreach ($this->parametres as $dir_img) {

            $finder->files()->in($dir_img);
            foreach ($finder as $file) {
                var_dump($file);
            }

        }
    }


    public function buildXmlForImages($rootName, $aFiles)
    {
        $xml = new SimpleXmlElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><$rootName />");

        if (is_array($aFiles)) {
            foreach ($aFiles as $file) {
                $xml = $xml->addChild($file);
            }
        }
    }


    protected function addNode($xml, $key, $value)
    {
        if ($value === false) {
            return;
        }

        if ($value instanceof SimpleXmlElement) {
            $parent = $xml->addChild($key);
            foreach ($value as $subkey => $val) {
                $child = $parent->addChild($subkey, (string) htmlspecialchars($val));
                foreach ($val->attributes() as $attribute => $attributeValue) {
                    $child->addAttribute($attribute, $attributeValue);
                }
            }
        } else {
            $xml->addChild($key, htmlspecialchars($value));
        }
    }
}
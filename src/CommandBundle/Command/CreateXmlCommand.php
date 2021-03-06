<?php


namespace CommandBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class CreateXmlCommand extends Command
{

    private $type;
    private $serializer;
    private $input;
    private $output;
    private $helper;
    private $aXml;

    protected function configure()
    {
        $this
            ->setName('xml:build')
            ->setDescription("construit un fichier xml")
            ->setHelp("php app/console xml:build {type} {params}")
            ->addArgument('type', InputArgument::REQUIRED, "Type de fichier xml finale");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->type = $this->input->getArgument('type');
        $this->helper = $this->getHelper('question');
        $this->aXml = array();


        if ($this->type == 'image') {

            $this->serializer = new XmlEncoder();
            $this->serializer->setRootNodeName('images');

            $question = new Question("Combien de produits ?");
            $nombre_produits = $this->getAnswer($this->helper, $question);

            foreach (range(1,$nombre_produits) as $i) {
                $qRepertoire =  new Question("Chemin du dossier images : ");
                $chemin_images = $this->getAnswer($this->helper, $qRepertoire);
                $images = $this->askWichImages($chemin_images);
                $this->aXml ['images'][] = $this->buildData($images);
            }

            var_dump($this->serializer->encode($this->aXml, "UTF-8"));

        }
    }

    private function getImages($dir_img)
    {
        $images = array();
        $finder = new Finder();

        $finder->files()->in($dir_img);
        foreach ($finder as $file) {
            $images [] = $file;
        }

        return $images;
    }

    public function askWichImages($dir_img)
    {
        $liste_images = $this->getImages($dir_img);

        $question = new ChoiceQuestion("Quels images souhaitez vous ajouter au produit ? ", $liste_images);
        $question->setMultiselect(true);
        $question->setErrorMessage("Veuillez choisir une image dans la liste bon sang!");

        $images = $this->helper->ask($this->input, $this->output, $question);
        $this->output->writeln("Vous avez choisi ces images " . implode(", ", $images));

        $files = array();
        foreach ($images as $path_image) {
            $files [] = new File($path_image);
        }
        return $files;
    }

    public function buildData($aFiles)
    {
        $faces = array();
        if (is_array($aFiles)) {
            foreach ($aFiles as $file) {
                $faces [] = $this->addFaceNode($file);
            }
            return $this->addImageNode($faces);
        }
    }

    private function addFaceNode(File $image, $server_path = '/tmp/')
    {
        $qFace = new Question("Quel est la face de l'image ? ");
        $face = $this->getAnswer($this->helper, $qFace);
        return array(
            "@fichier" => $server_path.$image->getFilename(),
            "@md5sum" => "0133e3801c5bcb3aeb600dd067b7595d",
            "@octets" => $image->getSize(),
            "@type" => $face
        );
    }

    private function addImageNode($faces)
    {
        $qSeqMode = new Question("Quel est le seqmode de l'image ? ");
        $seqmode = $this->getAnswer($this->helper, $qSeqMode);

        $qSeqRefer = new Question("Quel est le seqrefer de l'image ? ");
        $seqrefer  = $this->getAnswer($this->helper, $qSeqRefer);

        $qnomProduit = new Question("Quel est le nom du produit ? ");
        $nomProduit = $this->getAnswer($this->helper, $qnomProduit);

        $image = array(
            "image" => array(
                        "@seqmode" => $seqmode,
                        "@seqrefer" => $seqrefer,
                        "@desc" => $nomProduit,
                        "face" => $faces
                    )
        );

        return $image;
    }

    private function getAnswer($helper, $question)
    {
        $this->output->writeln(get_class($helper));
        if (!$answer = $helper->ask($this->input, $this->output, $question)) {
            exit;
        }
        return $answer;
    }
}
<?php

namespace App\Command;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PostAdd extends Command
{
    protected static $defaultName = 'Redis';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Команда для работы с кешем')
            ->addArgument('text', InputArgument::OPTIONAL, 'Текст сообщения поста')
            ->addArgument('alias', InputArgument::OPTIONAL, 'Альяс сообщения поста');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $text = $input->getArgument('text');

        if ($text) {

            $post = new Post();

            $post->setContent($text);
            $post->setIpv4('localhost');

            $this->entityManager->persist($post);
            $this->entityManager->flush();


        } else {
            $io->error('Необходимо указать текст записи');
        }


        return Command::SUCCESS;
    }
}

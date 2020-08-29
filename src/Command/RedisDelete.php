<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RedisDelete extends Command
{
    protected static $defaultName = 'Redis';

    protected function configure()
    {
        $this
            ->setDescription('Команда для работы с кешем')
            ->addArgument('key', InputArgument::OPTIONAL, 'Ключ, который необходимо удалить')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $key = $input->getArgument('key');

        if ($key) {
            $redis = new \Predis\Client();
            $redis->del($key);
            $io->success('Ключ успешно удален');
        } else {
            $io->error('Необходимо указать ключ');
        }


        return Command::SUCCESS;
    }
}

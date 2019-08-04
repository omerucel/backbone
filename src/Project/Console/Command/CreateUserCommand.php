<?php

namespace Project\Console\Command;

use Illuminate\Database\Capsule\Manager;
use Project\Entity\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends CommandAbstract
{
    protected function configure()
    {
        $this->setName('project:user:create')
            ->setDescription('Yeni kullanıcı oluşturur.')
            ->addOption('email', null, InputOption::VALUE_REQUIRED)
            ->addOption('password', null, InputOption::VALUE_REQUIRED)
            ->addOption('name', null, InputOption::VALUE_REQUIRED)
            ->addOption('surname', null, InputOption::VALUE_REQUIRED)
            ->addOption('role', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get(Manager::class);
        $user = new User();
        $user->email = $input->getOption('email');
        $user->name = $input->getOption('name');
        $user->surname = $input->getOption('surname');
        $user->role = $input->getOption('role');
        $user->setPassword($input->getOption('password'));
        $user->save();
        $output->writeln('User created successfully!');
    }
}

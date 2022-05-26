<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create:admin';
    protected static $defaultDescription = 'Creates a new Admin';

    public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $userPasswordHasher) {
        parent::__construct();
    }        
    

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->addArgument('Email', InputArgument::REQUIRED, 'Enter Email')
            ->addArgument('Password', InputArgument::REQUIRED, 'Enter password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // ... put here the code to create the user
        $admin = new User();

        $admin->setFirstName('John');
        $admin->setLastName('Doe');
        $admin->setEmail($input->getArgument('Email'));

        $hashedPassword = $this->userPasswordHasher->hashPassword($admin, $input->getArgument('Password'));
        
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }

    
}
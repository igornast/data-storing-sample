<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[
    AsCommand(
        name: 'app:user',
        description: 'The command provide simple User management actions.'
    )
]
final class UserCommand extends Command
{
    public function __construct(
        private readonly UserService $userService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('new', null, InputOption::VALUE_NONE, 'Add a new user.')
            ->addOption('find', null, InputOption::VALUE_NONE, 'Find a user by a given id.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (true === $input->getOption('new')) {
            $name = 'John Doe';
            $output->writeln('<comment>"--new" option, creating a new user...</comment>');
            $this->userService->create($name);
            $output->writeln(sprintf('<comment>Created a new user "%s".</comment>', $name));
        }

        if (true === $input->getOption('find')) {
            $output->writeln('<comment>"--find" option, searching for a user...</comment>');
            $user = $this->userService->find('60bb0ca5-25d1-43bd-98e5-6a878c00a0d8');
            $output->writeln(sprintf('<comment>Found "%s".</comment>', $user->getName()));
        }

        $output->writeln('<info>Execution completed.</info>');

        return Command::SUCCESS;
    }
}

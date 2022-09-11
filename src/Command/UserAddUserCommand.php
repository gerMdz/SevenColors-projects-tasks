<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use function Symfony\Component\String\u;

class UserAddUserCommand extends Command
{
    protected static $defaultName = 'user:add-user';
    protected static $defaultDescription = 'Create the initial user of the application';

    private SymfonyStyle $io;

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordEncoder;
    private Validator $validator;
    private UserRepository $users;


    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $encoder, Validator $validator, UserRepository $users)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->passwordEncoder = $encoder;
        $this->validator = $validator;
        $this->users = $users;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Crear usuarios')
            ->setHelp($this->getCommandHelp())
            // commands can optionally define arguments and/or options (mandatory and optional)
            // see https://symfony.com/doc/current/components/console/console_arguments.html
            ->addArgument('email', InputArgument::OPTIONAL, 'El email del nuevo usuario')
            ->addArgument('password', InputArgument::OPTIONAL, 'Clave en texto plano del nuevo usuario')
            ->addArgument('primerNombre', InputArgument::OPTIONAL, 'Primer nombre del usuario, se usará para identificación')
            ->addOption('role', null, InputOption::VALUE_OPTIONAL, 'Si lo asigna se creará con ese rol, sino usuario normal "--role="')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so, you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (null !== $input->getArgument('password') && null !== $input->getArgument('email') && null !== $input->getArgument('primerNombre')) {
            return;
        }

        $this->io->title('Add User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console user:add-user email@example.com password primerNombre (firstName)',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
        ]);

        // Ask for the email if it's not defined
        $email = $input->getArgument('email');
        if (null !== $email) {
            $this->io->text(' > <info>Email</info>: '.$email);
        } else {
            $email = $this->io->ask('Email', null, [$this->validator, 'validateEmail']);
            $input->setArgument('email', $email);
        }

        // Ask for the password if it's not defined
        $password = $input->getArgument('password');
        if (null !== $password) {
            $this->io->text(' > <info>Password</info>: '.u('*')->repeat(u($password)->length()));
        } else {
            $password = $this->io->askHidden('Password (your type will be hidden)', [$this->validator, 'validatePassword']);
            $input->setArgument('password', $password);
        }


        // Ask for the primer nombre if it's not defined
        $primerNombre = $input->getArgument('primerNombre');
        if (null !== $primerNombre) {
            $this->io->text(' > <info>Primer Nombre</info>: '.$primerNombre);
        } else {
            $primerNombre = $this->io->ask('Primer Nombre', null, [$this->validator, 'validatePrimerNombre']);
            $input->setArgument('primerNombre', $primerNombre);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('user:add-user');

        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');
        $primerNombre = $input->getArgument('primerNombre');
        $isAdmin = $input->getOption('role');

        // make sure to validate the user data is correct
        $this->validateUserData($email, $plainPassword, $primerNombre);

        // create the user and encode its password
        $user = new User();
        $user->setEmail($email);
        $user->setRoles([$isAdmin ? 'ROLE_'.strtoupper($isAdmin) : 'ROLE_USER']);
        $user->setIsActive(true);

        // See https://symfony.com/doc/current/security.html#c-encoding-passwords
        $encodedPassword = $this->passwordEncoder->hashPassword($user, $plainPassword);
        $user->setPassword($encodedPassword);
        $user->setFirstName($primerNombre);


        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->io->success(sprintf('%s was successfully created: %s ', $isAdmin ? $isAdmin . ' user' : 'User', $user->getEmail()));

        $event = $stopwatch->stop('user:add-user');
        if ($output->isVerbose()) {
            $this->io->comment(sprintf('New user database id: %d / Elapsed time: %.2f ms / Consumed memory: %.2f MB', $user->getId(), $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }

        return Command::SUCCESS;
    }

    private function validateUserData($email, $plainPassword, $primerNombre): void
    {
        // first check if a user with the same email already exists.
        $existingUser = $this->users->findOneBy(['email' => $email]);

        if (null !== $existingUser) {
            throw new RuntimeException(sprintf('There is already a user registered with the "%s" email.', $email));
        }

        // validate password and email if is not this input means interactive.
        $this->validator->validatePassword($plainPassword);
        $this->validator->validateEmail($email);
        $this->validator->validatePrimerNombre($primerNombre);

    }

    /**
     * The command help is usually included in to configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command creates new users and saves them in the database:

  <info>php %command.primerNombre%</info> <comment> password email</comment>

By default the command creates regular users. To create other rol users,
add the <comment>--role</comment> option:

  <info>php %command.primerNombre%</info>  password email <comment>--role</comment>

If you omit any of the three required arguments, the command will ask you to
provide the missing values:

  # command will ask you for the email
  <info>php %command.primerNombre%</info> <comment>email password</comment>

  # command will ask you for the email and password
  <info>php %command.primerNombre%</info> <comment>email</comment>

  # command will ask you for all arguments
  <info>php %command.primerNombre%</info>

HELP;
    }
}

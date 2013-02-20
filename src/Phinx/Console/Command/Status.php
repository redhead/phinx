<?php

namespace Phinx\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
    
class Status extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
         
        $this->setName('status')
             ->setDescription('Show migration status')
             ->setHelp(<<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

<info>phinx status -e development</info>
EOT
        );         
    }

    /**
     * Show the migration status.
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        
        $environment = $this->getConfig()->getDefaultEnvironment();
        
        // print the status
        $this->getManager()->printStatus($environment);
    }
}
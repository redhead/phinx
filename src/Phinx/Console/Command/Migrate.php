<?php

namespace Phinx\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
    
class Migrate extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
     protected function configure()
     {
         parent::configure();
         
         $this->setName('migrate')
              ->setDescription('Migrate the database')
              ->addOption('--target', '-t', InputArgument::OPTIONAL, 'The version number to migrate to')
              ->setHelp(<<<EOT
The <info>migrate</info> command runs all available migrations, optionally up to a specific version

<info>phinx migrate</info>
<info>phinx migrate -t 20110103081132</info>

EOT
              );
    }

    /**
     * Migrate the database.
     * 
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);
        
        $version = $input->getOption('target');
        $environment = $this->getConfig()->getDefaultEnvironment();
        
        $envOptions = $this->getConfig()->getEnvironment($environment);
        $output->writeln('<info>using adapter</info> ' . $envOptions['adapter']);
        $output->writeln('<info>using database</info> ' . $envOptions['name']);

        // run the migrations
        $start = microtime(true);
        $this->getManager()->migrate($environment, $version);
        $end = microtime(true);
        
        $output->writeln('');
        $output->writeln('<comment>All Done. Took ' . sprintf('%.4fs', $end - $start) . '</comment>');
    }
}
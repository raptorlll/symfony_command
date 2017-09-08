<?php

namespace AppBundle\Command;

use AppBundle\Service\Import\ImportProducts;
use AppBundle\Service\Import\Mode\ModeFactory;
use AppBundle\Service\Import\Mode\ModeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProductsCommand extends ContainerAwareCommand
{

    /**
     * Configuration for a command
     */
    protected function configure()
    {
        $this
            // the name of the command
            ->setName('import-csv')
            // short description while command running
            ->setDescription('Importing products from csv.')
            // the full command description when use --help method
            ->setHelp('This command allows you to import products from csv to db.')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'File name to import'
            )
            ->addArgument(
                'mode',
                InputArgument::OPTIONAL,
                "Run console command in 'production' (without arguments) with recording in database 
                \n or in 'test' mode",
                ImportProducts::MODE_PRODUCTION
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Start',
            '============',
        ]);
        /** @var ImportProducts $importProductsService */
        $importProductsService = $this
            ->getContainer()
            ->get('app.import_products');
        $fileName = $input->getArgument('filename');
        $modeName = $input->getArgument('mode');

        $filePath = realpath($this
                ->getContainer()
                ->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . ImportProducts::FOLDER . DIRECTORY_SEPARATOR . $fileName);

        $output->writeln([
            'Full file path '. $filePath,
        ]);

        // check is correct file path
        if (!$filePath || !file_exists($filePath)) {
            throw new InvalidArgumentException('Path is incorrect: file does not exists');
        }

        // check is mode correct
        if (!in_array($modeName, [ImportProducts::MODE_PRODUCTION, ImportProducts::MODE_TEST])) {
            throw new InvalidArgumentException('Choose please correct import mode');
        }

        /** @var ModeInterface $mode */
        $mode = ModeFactory::getMode($modeName);
        $importProductsService->parse($filePath, $mode);

        $output->writeln(
            '<info>'.$mode->getSavingInformation().'</info>'
        );
        $output->writeln(
            '<error>'.$mode->getErrorInformation().'</error>'
        );

        $output->writeln([
            '============',
            'End',
        ]);

    }
}
<?php

namespace Eermolaev\Challenge\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseUrlToCSVCommand
 * @package Eermolaev\Challenge\Console\Command
 */
class ParseUrlToCSVCommand extends Command
{
    const INPUT_ARG_URL = 'url';
    const INPUT_OPT_PRODUCT_NAME = 'product_name_pattern';
    const INPUT_OPT_PRODUCT_PRICE = 'product_price_pattern';

    /**
     * CleanSystemLogsCommand constructor.
     */
    public function __construct()
    {

        parent::__construct();
    }

    public function configure()
    {

        $this->setName('eermolaev_challenge:parse_url_to_csv')
            ->setDescription('Parse product names with price and output a csv to stdout.')
            ->addArgument(
                self::INPUT_ARG_URL,
                InputArgument::REQUIRED,
                'Specifies type of synchronization. Supported types: ' . implode(', ', $this->getSyncTypeValues())
            )
            ->addOption(
                self::INPUT_OPT_PRODUCT_NAME,
                'n',
                InputOption::VALUE_NONE,
                'Product name pattern',
                ''
            )
            ->addOption(
                self::INPUT_OPT_PRODUCT_PRICE,
                'p',
                InputOption::VALUE_NONE,
                'Product price pattern',
                ''
            );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {


        return Cli::RETURN_SUCCESS;
    }
}

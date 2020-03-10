<?php

namespace Eermolaev\Challenge\Console\Command;

use Eermolaev\Challenge\Model\CSVWriter;
use Eermolaev\Challenge\Model\DomDecorator;
use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseUrlToCSVCommand
 * @package Eermolaev\Challenge\Console\Command
 */
class ParseUrlToCSVCommand extends Command
{
    const INPUT_ARG_URL = 'url';

    const PRODUCT_TYPE_QUERY = '//*[@itemtype="http://schema.org/Product"]';
    const PRODUCT_NAME_QUERY = './/*[@itemprop="name"]';
    const PRODUCT_PRICE_QUERY = './/*[@itemprop="price"]';
    const PRODUCT_CURRENCY_QUERY = './/*[@itemprop="priceCurrency"]';

    /** @var CSVWriter */
    protected $csvWriter;

    /** @var DomDecorator */
    protected $domDecorator;

    /**
     * ParseUrlToCSVCommand constructor.
     * @param CSVWriter $csvWriter
     */
    public function __construct(
        CSVWriter $csvWriter,
        DomDecorator $domDecorator
    )
    {
        $this->csvWriter = $csvWriter;
        $this->domDecorator = $domDecorator;
        parent::__construct();
    }

    /**
     *
     */
    public function configure()
    {
        $this->setName('eermolaev_challenge:parse_url_to_csv')
            ->setDescription('Parse product names with price and output a csv to stdout.')
            ->addArgument(
                self::INPUT_ARG_URL,
                InputArgument::REQUIRED,
                'URL'
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

        $url = $input->getArgument(self::INPUT_ARG_URL);

        $this->domDecorator->load($url);

        $elements = $this->domDecorator->query(self::PRODUCT_TYPE_QUERY);

        $this->csvWriter->outputAsCsv([
            'Product Name',
            'Price',
            'Currency'
        ]);

        foreach ($elements as $element) {

            $name = $this->domDecorator->parseName(self::PRODUCT_NAME_QUERY, $element);
            $price = $this->domDecorator->parsePrice(self::PRODUCT_PRICE_QUERY, $element);
            $priceCurrency = $this->domDecorator->parseCurrency(self::PRODUCT_CURRENCY_QUERY, $element);

            $this->csvWriter->outputAsCsv([
                $name,
                $price,
                $priceCurrency
            ]);
        }

        return Cli::RETURN_SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\LotteriesResultsFinderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LotteryCommand extends Command
{
    protected static $defaultName = 'lottery:results';

    /**
     * @var LotteriesResultsFinderInterface
     */
    private $finder;

    public function __construct(LotteriesResultsFinderInterface $finder)
    {
        $this->finder = $finder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Scrape data from lotteries sites and save them in json')
            ->addArgument('filename', InputArgument::REQUIRED, 'filename');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->finder->findResults();
        $filename = $input->getArgument('filename');
        file_put_contents($filename, json_encode($results));
        $output->writeln('Done');
        return 0;
    }
}
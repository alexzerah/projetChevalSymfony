<?php
namespace App\Command;

use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMailCommand extends Command
{
    private $weekendRepository;
    private $exhibitRepository;
    private $partyRepository;

    public function __construct(WeekendRepository $weekendRepository, ExhibitRepository $exhibitRepository, PartyRepository $partyRepository)
    {
        $this->weekendRepository = $weekendRepository;
        $this->exhibitRepository = $exhibitRepository;
        $this->partyRepository = $partyRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:send-mail')
            ->setDescription('Sends a mail.')
            ->setHelp('This command allows you send a mail foreach events tomorrow ...blah blah')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dump($this->weekendRepository->getNextDayEvents());die;
    }
}
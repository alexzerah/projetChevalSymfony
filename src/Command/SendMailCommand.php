<?php
namespace App\Command;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\Weekend;
use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMailCommand extends Command
{
    private $weekendRepository;
    private $exhibitRepository;
    private $partyRepository;
    private $mailer;

    public function __construct(WeekendRepository $weekendRepository, ExhibitRepository $exhibitRepository, PartyRepository $partyRepository, Swift_Mailer $mailer)
    {
        $this->weekendRepository = $weekendRepository;
        $this->exhibitRepository = $exhibitRepository;
        $this->partyRepository = $partyRepository;
        $this->mailer = $mailer;

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
        $weekends = $this->weekendRepository->getNextDayWeekends();
        $exhibits = $this->exhibitRepository->getNextDayExhibits();
        $parties = $this->partyRepository->getNextDayParties();

        $events = array_merge($weekends, $exhibits, $parties);

        foreach ($events as $event) {
            // wait for users/events relations to get attendees

            $mailBody = '';

            if ($event instanceof Weekend) {
                $mailBody = 'Weekend : ' . $event->getName();
                $mailBody .= ' / Lieu : ' . $event->getLocation();
                $mailBody .= ' / Date : de ' . $event->getDate()->format('d-m-Y H:i:s') . ' à ' . $event->getEndDate()->format('d-m-Y H:i:s');
                $mailBody .= ' / Détails : ' . $event->getDetails();
            } elseif ($event instanceof Exhibit) {
                $mailBody = 'Exposition : ' . $event->getName();
                $mailBody .= ' / Lieu : ' . $event->getLocation();
                $mailBody .= ' / Date : le ' . $event->getDate()->format('d-m-Y H:i:s');
                $mailBody .= ' / Détails : ' . $event->getDetails();
            } elseif ($event instanceof Party) {
                $mailBody = 'Soirée : ' . $event->getName();
                $mailBody .= ' / Lieu : ' . $event->getLocation();
                $mailBody .= ' / Date : ' . $event->getDate()->format('d-m-Y H:i:s');
                $mailBody .= ' / Détails : ' . $event->getDetails();
            } else {
                $output->writeln('Event type is unknown');
            }
            print_r($mailBody);
            $receivers = [];
            foreach ($event->getUsers() as $users) {
                $receivers[] = $users->getEmail();
            }
            print_r($receivers);
            $message = (new Swift_Message('Un événement aura lieu demain !'))
                ->setFrom(['chevalproject@gmail.com' => 'Projet Cheval'])
                ->setTo('anjuere.corentin@gmail.com')
                ->setBody($mailBody);
            $this->mailer->send($message);
        }
    }
}

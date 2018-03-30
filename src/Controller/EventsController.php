<?php

namespace App\Controller;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\Weekend;
use App\Form\SubscribeSingleExhibit;
use App\Form\UnsubscribeSingleExhibit;
use App\Form\UserFormType;
use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\UserRepository;
use App\Repository\WeekendRepository;
use App\Services\Concatenate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use GuzzleHttp\Client;
class EventsController extends Controller
{
    /**
     * @Route("/event/{slug}", name="events_event"),
     */
    public function showEvent(WeekendRepository $weekendRepository,
                              PartyRepository $partyRepository,
                              ExhibitRepository $exhibitRepository,
                              Request $request,
                              $slug)
    {
        // Call the function that give us one event based on the name for each entities
        $theParty = $partyRepository->getTheParty($slug);
        $theWeekend = $weekendRepository->getTheWeekend($slug);
        $theExhibit = $exhibitRepository->getTheExhibit($slug);

        // Check if no wrong event has been provided
        if (!$theParty && !$theWeekend && !$theExhibit) {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }

        $queryWiki = 'konoha';

        /*$apiWiki = 'https://fr.wikipedia.org/w/api.php?format=json&action=query&generator=search&gsrnamespace=0&gsrlimit=10&prop=pageimages%7Cextracts&pilimit=max&exintro&explaintext&exsentences=1&exlimit=max&gsrsearch=' . $queryWiki;
        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $apiWiki);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);*/

        $apiWeather = 'http://api.openweathermap.org/data/2.5/weather?q=Paris,fr&units=metric&APPID=a60f4c70672119a8c5b03f7592382596&';
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $apiWeather);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);

        /*$responseWiki = curl_exec($ch1);*/
        $responseWeather = curl_exec($ch2);

        /*$data = json_decode($responseWiki, true);
        $desc = ((array_shift($data["query"]["pages"]))["extract"]);*/


        // If using JSON...
        /*$dataWiki = json_decode($responseWiki);/**/
        $dataWeather = json_decode($responseWeather);/**/
        $apiWeatherOk = $dataWeather->main->temp;

        $client = new Client();
        $res = $client->request('GET', $apiWeather, [
        ]);

        $resFinale = json_decode($res->getBody()->getContents(), true)['main']['temp'];
        /*var_dump($resFinale);
        die;*/
        /*        echo $res->getStatusCode();
        // "200"
                echo $res->getHeader('content-type');
        // 'application/json; charset=utf8'
                echo $res->getBody();
        // {"type":"User"...*/

        return $this->render('site\event.html.twig', [
            'party' => $theParty,
            'weekend' => $theWeekend,
            'exhibit' => $theExhibit,
            'subject' => 'Konoha',
            /*'wikiSubject' => $desc,*/
            'weatherTemp' => $resFinale
        ]);
    }

    /**
     * @Route("/event", name="event_home"),
     */
    public function eventNotFound(request $response)
    {
        throw $this->createNotFoundException('Veuillez soumettre un évènement !');

    }

    /**
     * @Route("/", name="events_nextEvents")
     */
    public function getNextEvents(WeekendRepository $weekendRepository,
                                  PartyRepository $partyRepository,
                                  ExhibitRepository $exhibitRepository,
                                  Concatenate $concatenate)
    {
        // Call the function that give us events when event.date > today for each entities
        $nextWeekends = $weekendRepository->getNextWeekends();
        $nextParties = $partyRepository->getNextParties();
        $nextExhibits = $exhibitRepository->getNextExhibits();

        // Call concatenate service
        $nextEvents = $concatenate->doConcatenate(
            $nextWeekends,
            $nextParties,
            $nextExhibits
        );

        return $this->render('site\home.html.twig', [
            'controller_name' => 'EventsController',
            'nextEvents' => $nextEvents,
        ]);
    }

    /**
     * @Route("/listeEvenements", name="events_previousEvents")
     */
    public function getPreviousEvents(WeekendRepository $weekendRepository,
                                      PartyRepository $partyRepository,
                                      ExhibitRepository $exhibitRepository,
                                      Concatenate $concatenate)
    {
        // Call the function that give us events when event.date < today for each entities
        $previousWeekends = $weekendRepository->getPreviousWeekends();
        $previousParties = $partyRepository->getPreviousParties();
        $previousExhibits = $exhibitRepository->getPreviousExhibits();

        // Call concatenate service
        $previousEvents = $concatenate->doConcatenate(
            $previousWeekends,
            $previousParties,
            $previousExhibits
        );

        return $this->render('site\listeEvent.html.twig', [
            'controller_name' => 'EventsController',
            'previousEvents' => $previousEvents,
        ]);
    }

    /**
     * @Route("/evenement/inscription/{eventType}", name="event_subscribe")
     */
    public function subscribeEventAction(Request $request, string $eventType)
    {
        switch ($eventType) {
            case 'exhibit':
                $repository = $this->getDoctrine()->getRepository(Exhibit::class);
                break;
            case 'party':
                $repository = $this->getDoctrine()->getRepository(Party::class);
                break;
            case 'weekend':
                $repository = $this->getDoctrine()->getRepository(Weekend::class);
                break;
        }

        $event = $repository->find($request->get('eventId'));

        if ($event instanceof Exhibit || $event instanceof Party || $event instanceof Weekend) {
            $event->addUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_event', ['slug' => $event->getSlug()]);
        } else {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }
    }

    /**
     * @Route("/evenement/desinscription/{eventType}", name="event_unsubscribe")
     */
    public function unsubscribeEventAction(Request $request, string $eventType)
    {
        switch ($eventType) {
            case 'exhibit':
                $repository = $this->getDoctrine()->getRepository(Exhibit::class);
                break;
            case 'party':
                $repository = $this->getDoctrine()->getRepository(Party::class);
                break;
            case 'weekend':
                $repository = $this->getDoctrine()->getRepository(Weekend::class);
                break;
        }

        $event = $repository->find($request->get('eventId'));

        if ($event instanceof Exhibit || $event instanceof Party || $event instanceof Weekend) {
            $event->removeUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_event', ['slug' => $event->getSlug()]);
        } else {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }
    }
}

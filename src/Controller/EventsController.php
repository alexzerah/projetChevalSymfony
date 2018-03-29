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

        return $this->render('site\event.html.twig', [
            'party' => $theParty,
            'weekend' => $theWeekend,
            'exhibit' => $theExhibit
        ]);
    }

    /**
     * @Route("/event", name="event_home"),
     */
    public function eventNotFound(request $response)
    {
        /*throw $this->createNotFoundException('Aucun événement trouvé !');*/

        // search Songs of Frank Sinatra
        /*$headers = array('Accept' => 'application/json');
        $query = array('input' => 'paris', 'appid' => 'L594T8-Y5R7GAYLL3', 'output' => 'json');
        $query2 = array('q' => 'Paris, fr', 'units' => 'metric', 'APPID' => 'a60f4c70672119a8c5b03f7592382596');*/

        $api = 'http://api.openweathermap.org/data/2.5/weather?q=Paris,fr&units=metric&APPID=a60f4c70672119a8c5b03f7592382596&' .

//            $response = Unirest\Request::post('https://api.openweathermap.org/data/2.5/weather', $headers, $query);
//        $response = Unirest\Request::post('https://api.openweathermap.org/data/2.5/weather?id=2172797&APPID=a60f4c70672119a8c5b03f7592382596', $headers);
//        $response = Unirest\Request::get('http://api.wolframalpha.com/v2/query', $headers, $query);
//        $response2 = Unirest\Request::get('http://api.openweathermap.org/data/2.5/weather', $headers, $query2);


        // Display the result
//        dump($response->body->queryresult);die;
//        dump($response2->body->main->temp);die;

//        $weatherWolphormAlpha = $response->body->queryresult->pods[6]->subpods[0]->plaintext;
//        $weatherWolphormAlpha2 = $response2->body;
//        $weatherWolphormAlpha2Temp = $weatherWolphormAlpha2->main->temp;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response3 = curl_exec($ch);



        // If using JSON...
        $data = json_decode($response3);/**/

        $apiOk = $data->main->temp;

//        dump($apiOk);die;



//        $oldString = array("|","relative humidity:","wind:", "overcast");
//        $newString = array("","L'humidité relative est de", "la vitesse du vent sera de ", "");
//        $weatherWolphormAlphaFR = "Pour la ville de Paris, la température sera de ";
//        $weatherWolphormAlphaFR = $weatherWolphormAlphaFR . str_replace($oldString, $newString, $weatherWolphormAlpha);

       /* while ($row = mysqli_fetch_assoc($weatherWolphormAlpha)) {
            print_r ($row);
        }*/

        return $this->render('site/weather.html.twig', [
            'weatherWolphormAlpha' => $apiOk,
        ]);
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

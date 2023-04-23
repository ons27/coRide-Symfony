<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use GuzzleHttp\Client; //Pour récupérer les données de l'API, nous allons utiliser la bibliothèque Guzzle HTTP Client qui permet de faire des requêtes HTTP.


class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_dashboard')]
    public function index(): Response
    {
        $client = new Client(); //créé une nouvelle instance de la classe Client de Guzzle HTTP Client
        $response = $client->get('http://api.openweathermap.org/data/2.5/weather?q=Tunis&appid=77c6aae16d64cc09bcc37f49849919e6'); //envoyé une requête GET à l'URL de l'API OpenWeatherMap avec la ville Tunis et l'ID de l'app. La réponse de l'API est stockée dans la variable $response.
        $data = json_decode($response->getBody()->getContents(), true); //extrait les données JSON de la réponse ensuite décodé les données JSON en utilisant json_decode()
        //extrait la température et la description de la météo :
        $temperature = $data['main']['temp'];
        $description = $data['weather'][0]['description'];

        //pour avoir la date systeme
        $date = new \DateTime();
        $dateFormatted = $date->format('Y-m-d');

        //date sous format samedi 22 avril 2023 : 
        // définition du fuseau horaire de la Tunisie
        date_default_timezone_set('Africa/Tunis');
        // récupération de la date actuelle au format timestamp
        $now = time();
        // formattage de la date selon le format souhaité
        $jour = strftime('%A %e %B %Y', $now);

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'temperature' => $temperature,
            'description' => $description,
            'date' => $dateFormatted,
            'jour' => $jour,
        ]);
    }

}

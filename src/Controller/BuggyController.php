<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuggyController extends AbstractController
{
    #[Route('/bug', name: 'buggy_route')]
    public function buggyAction(): Response
    {
        $data = $this->getData();
        $message = $data['nonexistent_key'] ?? 'Je ne bug plus !';
        return $this->render('welcome.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * Retourne des données sous forme de tableau associatif.
     *
     * @return string[] Tableau associatif avec des clés et des valeurs de type string
     */
    private function getData(): array
    {
        return [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
    }
}

<?php

namespace App\Tests\Controller;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EntrepriseControllerTest extends WebTestCase
{

    private $client;

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testResearchDatabase(): void
    {
        $research = "IB";

        $entreprises = $this->entityManager->getRepository(Entreprise::class)->findAllByResarch($research);
        $test = array();

        foreach($entreprises as $entreprise) {
            $test[$entreprise->getSymbole()] = $entreprise->getNom();
        }

        $this->client->request('GET', "/research/entreprise/database/".$research);
        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertJsonStringEqualsJsonString($response->getContent(), json_encode($test));
    }

    protected function setDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
        $this->client = null;
    }
}

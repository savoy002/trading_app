<?php

namespace App\Tests\Repository;

use \DateTime;
use App\Entity\Date;
use App\Entity\Entreprise;
use App\Entity\Valeur;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ValeurRepositoryTest extends KernelTestCase
{
	private ?EntityManager $entityManager;

	protected function setUp(): void
	{
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
	}

	public function testFindByEntrepriseDate()
	{
		$type = "M";
		$date = new DateTime('2025-05-01');
		$entreprise = $this->entityManager->getRepository(Entreprise::class)->findOneBy(['nom' => 'Tesla']);
		$valeurs = $this->entityManager->getRepository(Valeur::class)->findByEntrepriseDate($entreprise->getId(), $date, $type, 10);
		$this->assertNotEmpty($valeurs, "Erreur aucune valeur n'a été retourné.");
		foreach($valeurs as $valeur) {
			$this->assertEquals($valeur->getDate()->getType(), $type, "Erreur l'une des valeur n'a pas le type de date voulue.");
			$this->assertLessThanOrEqual($valeur->getDate()->getValeur(), $date, "Erreur une valeur a une date inférieur à la date voulue.");
			$this->assertEquals($valeur->getEntreprise()->getId(), $entreprise->getId(), "Erreur l'une des valeurs n'a pas l'entreprise voulue.");
		}
		
		$valeurs = $this->entityManager->getRepository(Valeur::class)->findByEntrepriseDate($entreprise->getId(), $date, $type, 1);
		$this->assertNotEmpty($valeurs, "Erreur aucune valeur n'a été retourné.");
		$this->assertEquals(count($valeurs), 1, "Erreur une seul valeur aurait dû être retournée.");

	}

	protected function tearDown(): void
	{
		parent::tearDown();

		$this->entityManager->close();
		$this->entityManager = null;
	}
}


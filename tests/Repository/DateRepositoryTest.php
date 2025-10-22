<?php

namespace App\Tests\Repository;

use App\Entity\Date;
use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class DateRepositoryTest extends KernelTestCase
{
	private ?EntityManager $entityManager;

	protected function setUp(): void
	{
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
	}

	public function testFindByEntreprise()
	{
		$entreprise = $this->entityManager->getRepository(Entreprise::class)->findOneBy(['nom' => 'IBM']);
		$dates = $this->entityManager->getRepository(Date::class)->findByEntreprise($entreprise->getId());

		foreach ($dates as $date) {
			if($date != null) {
				$stop = false;
				for($i = 0; $i < count($date->getValeurs()) && !$stop; $i++) {
					$stop = $date->getValeurs()[$i]->getEntreprise()->getId() == $entreprise->getId();
				}
				if(!$stop) {
					$this->assert("Erreur une des dates retournées n'a aucune valeur correspondant à l'entreprise.");
				}
			}
		}

		$dates = $this->entityManager->getRepository(Date::class)->findByEntreprise($entreprise->getId(), 'J');
		foreach ($dates as $date) {
			if($date != null) {
				$this->assertEquals($date->getType(), 'J', "Erreur l'une des dates retournées n'est pas du type jour.");
			}
		}

	}

	public function tearDown(): void
	{
		parent::tearDown();

		$this->entityManager->close();
		$this->entityManager = null;
	}

}

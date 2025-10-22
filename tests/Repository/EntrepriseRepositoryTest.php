<?php

namespace App\Tests\Repository;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class EntrepriseRepositoryTest extends KernelTestCase
{

	private ?EntityManager $entityManager;

	protected function setUp(): void
	{
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
	}

	public function testFindAllByResarch()
	{
		$entreprises = $this->entityManager->getRepository(Entreprise::class)->findAllByResarch("IBM");
		if(!empty($entreprises)) {
			$this->assertEquals("IBM", $entreprises[0]->getSymbole(), "L'entreprise n'a pas été trouvé après la recherche avec majuscule.");
		} else {
			$this->assert("La liste d'entreprise est vide après une recherche avec majuscule.");
		}
		
		$entreprises = $this->entityManager->getRepository(Entreprise::class)->findAllByResarch("TESLA");
		if(!empty($entreprises)) {
			$this->assertEquals("TESLA", $entreprises[0]->getSymbole(), "L'entreprise n'a pas été trouvé après la recherche avec majuscule et minuscule.");
		} else {
			$this->assertNotEmpty($entreprises, "La liste d'entreprise est vide après une recherche avec majuscule et minuscule.");
		}
		
		$entreprises = $this->entityManager->getRepository(Entreprise::class)->findAllByResarch("IB");
		if(!empty($entreprises)) {
			$this->assertEquals("IBM", $entreprises[0]->getSymbole(), "L'entreprise n'a pas été trouvé après la recherche de nom incomplet.");
		} else {
			$this->assert("La liste d'entreprise est vide après une recherche de nom incomplet.");
		}

	}

	protected function setDown(): void
	{
		parent::tearDown();

		$this->entityManager->close();
        $this->entityManager = null;
	}

}

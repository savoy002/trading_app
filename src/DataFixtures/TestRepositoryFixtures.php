<?php

namespace App\DataFixtures;

use \DateTime;
use \DateTimeImmutable;
use App\Entity\Date as DateInfo;
use App\Entity\Entreprise;
use App\Entity\TypeDate;
use App\Entity\Valeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestRepositoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ibm = $this->createEntreprise("IBM", "IBM");
        $tesla = $this->createEntreprise("Tesla", "TESLA");

        $semaine = TypeDate::Semaine;
        //$semaine = TypeDate::S;

        //$test = new DateTimeImmutable('2025-05-26');
        $test = new DateTime('2025-05-26');

        $date1 = $this->createDate($test, $semaine);

        $valeur1 = $this->createValeur(10000, 11000, 9000, 10500, 150, $ibm, $date1);

        $manager->persist($ibm);
        $manager->persist($tesla);
        $manager->persist($date1);
        $manager->persist($valeur1);

        $manager->flush();
    }

    private function createEntreprise(String $nom, String $symbole, String $information = ""): Entreprise
    {
        $entreprise = new Entreprise();
        $entreprise->setNom($nom);
        $entreprise->setSymbole($symbole);
        $entreprise->setInformation($information);
        return $entreprise;
    }

    private function createDate(DateTime $valeur, TypeDate $type): DateInfo
    {
        $date = new DateInfo();
        $date->setValeur($valeur);
        $date->setType($type->value);
        return $date;
    }

    private function createValeur(int $ouverture, int $haute, int $basse, int $fermeture, int $volume, Entreprise $entreprise, DateInfo $date): Valeur
    {
        $valeur = new Valeur;
        $valeur->setOuverture($ouverture);
        $valeur->setHaute($haute);
        $valeur->setBasse($basse);
        $valeur->setFermeture($fermeture);
        $valeur->setVolume($volume);
        $entreprise->addValeur($valeur);
        $date->addValeur($valeur);
        return $valeur;
    }

}

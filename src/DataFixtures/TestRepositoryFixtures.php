<?php

namespace App\DataFixtures;

use \DateTime;
use App\Entity\Date;
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
        $jour = TypeDate::Jour;
        $mois = TypeDate::Mois;

        $semaine1 = new DateTime('2025-05-26');
        $jour1 = new DateTime('2025-05-26');
        $mois1 = new DateTime('2025-04-01');
        $mois2 = new DateTime('2025-05-01');
        $mois3 = new DateTime('2025-06-01');

        $date1 = $this->createDate($semaine1, $semaine);
        $date2 = $this->createDate($jour1, $jour);
        $date3 = $this->createDate($mois1, $mois);
        $date4 = $this->createDate($mois2, $mois);
        $date5 = $this->createDate($mois3, $mois);

        $valeur1 = $this->createValeur(10000, 11000, 9000, 10500, 150, $ibm, $date1);
        $valeur2 = $this->createValeur(10000, 11000, 9000, 10500, 150, $ibm, $date2);
        $valeur3 = $this->createValeur(10000, 11000, 9000, 10500, 150, $tesla, $date3);
        $valeur4 = $this->createValeur(10000, 11000, 9000, 10500, 150, $tesla, $date4);
        $valeur5 = $this->createValeur(10000, 11000, 9000, 10500, 150, $tesla, $date5);

        $manager->persist($ibm);
        $manager->persist($tesla);
        $manager->persist($date1);
        $manager->persist($date2);
        $manager->persist($date3);
        $manager->persist($date4);
        $manager->persist($date5);
        $manager->persist($valeur1);
        $manager->persist($valeur2);
        $manager->persist($valeur3);
        $manager->persist($valeur4);
        $manager->persist($valeur5);

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

    private function createDate(DateTime $valeur, TypeDate $type): Date
    {
        $date = new Date();
        $date->setValeur($valeur);
        $date->setType($type->value);
        return $date;
    }

    private function createValeur(int $ouverture, int $haute, int $basse, int $fermeture, int $volume, Entreprise $entreprise, Date $date): Valeur
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

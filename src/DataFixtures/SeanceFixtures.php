<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Seance;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Class SeanceFixtures
 * @package App\DataFixtures
 */
class SeanceFixtures extends Fixture
{
    /**
     * @var EntityManagerInterface $manager
     */
    protected $manager;

    /**
     * SeanceFixtures constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $seances = Yaml::parseFile(__DIR__ . '/fixtures/seances.yaml');

        $repository = $manager->getRepository(Movie::class);
        $movies = $repository->findAll();
        $now = new DateTime('now');

        for ($day = 12; $day <= 15; $day++) {
            /** @var Movie $movie */
            foreach ($movies as $movie) {
                /** @var Seance $seance */
                foreach ($seances as $data) {
                    foreach ($data['hours'] as $hour) {
                        $seance = new Seance();
                        $seance->setMedia($movie);
                        $seance->setMaxSubscriptions($data['maxSubscriptions']);
                        $date = new DateTime($day . '-' . $now->format('m-Y') . ' ' . $hour);
                        $seance->setDate($date);
                        $this->manager->persist($seance);
                    }
                }
            }
        }

        $this->manager->flush();
    }
}
<?php


namespace App\DataFixtures;


use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class MovieFixtures
 * @package App\DataFixtures
 */
class MovieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $movies = Yaml::parseFile(__DIR__ . '/fixtures/movies.yaml');

        foreach ($movies['movies'] as $title => $movie) {

            $movie = $this->instantiate($movie['description'], $movie['date'], $movie['duration'], $movie['author'], $movie['content'], $title);
            $manager->persist($movie);
        }

        $manager->flush();
    }

    /**
     * @param string $description
     * @param string $date
     * @param string $duration
     * @param string $author
     * @param string $content
     * @param string|null $title
     * @return Movie
     */
    public function instantiate(
        string $description,
        string $date,
        string $duration,
        string $author,
        string $content,
        string $title = null
    ): Movie
    {
        $movie = new Movie();
        $movie->setDescription($description);
        #$movie->setDate($dateTime);
        $test = \DateTime::createFromFormat('Ymd:H:i:s', $date);
        $movie->setDate($test);
        $movie->setDuration($duration);
        $movie->setAuthor($author);
        $movie->setContent($content);
        $movie->setTitle($title);
        return $movie;
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        [
            'title' => "La liste",
            'number' => 1,
            'synopsis' => 'Raymond Reddington, le criminel le plus recherché au monde, se rend mystérieusement aux autorités.',
        ],
        [
            'title' => " Le freelance",
            'number' => 2,
            'synopsis' => '
            Red pressent une catastrophe imminente qui serait l\'œuvre d\'un assassin appelé "The Freelancer"',
        ],
        [
            'title' => "Wujing",
            'number' => 3,
            'synopsis' => 'Wujing est un criminel chinois qui travaille officieusement pour son gouvernement. Il assassine les agents des services secrets étrangers. ',
        ],
        [
            'title' => " Le marmiton",
            'number' => 4,
            'synopsis' => '
            Liz doit participer au procès d\'un trafiquant de drogues nommé Hector Lorca. Elle a contribué à son arrestation quand elle travaillait au FBI',
        ],
        [
            'title' => " Le coursier",
            'number' => 5,
            'synopsis' => '
            Liz et Tom sont maintenant sous la surveillance du FBI. Un jeune homme, Seth Nelson, est enlevé. Ce dernier s\'avère être un génie de l\'informatique capable de craquer tous les codes sécurisés du monde. ',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (ProgramFixtures::PROGRAMS as $programTitle => $programDescription) {
            foreach (SeasonFixtures::SAISONS as $seasonTitle => $seasonDescription) {
                foreach (self::EPISODES as $number => $episodeDescription) {
                    $episode = new Episode();
                    $episode->setTitle($episodeDescription['title']);
                    $episode->setNumber($episodeDescription['number']);
                    $episode->setSynopsis($episodeDescription['synopsis']);
                    $episode->setSeason($this->getReference('season_'. $programTitle . '_' . $seasonTitle));
                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
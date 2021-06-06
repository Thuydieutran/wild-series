<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SAISONS = [
        'S01' => [
            'number' => 1,
            'description' => 'Raymond Reddington, le criminel le plus recherché au monde, se rend mystérieusement aux autorités. Mis en détention très surveillée,',
            'year' => 2013
        ],
        'S02' => [
            'number' => 2,
            'description' => 'Red pressent une catastrophe imminente qui serait l\'œuvre d\'un assassin appelé "The Freelancer".',
            'year' => 2014
        ],
        'S03' => [
            'number' => 3,
            'description' => '
            Wujing est un criminel chinois qui travaille officieusement pour son gouvernement. Il assassine les agents des services secrets étrangers. ',
            'year' => 2015
        ],
        'S04' => [
            'number' => 4,
            'description' => '
            Liz doit participer au procès d\'un trafiquant de drogues nommé Hector Lorca. Elle a contribué à son arrestation quand elle travaillait au FBI',
            'year' => 2016
        ],
        'S05' => [
            'number' => 5,
            'description' => '
            Liz et Tom sont maintenant sous la surveillance du FBI. Un jeune homme, Seth Nelson, est enlevé.',
            'year' => 2017
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (ProgramFixtures::PROGRAMS as $title => $description) {
            foreach (self::SAISONS as $number => $seasonDescription) {
                $season = new Season();
                $season->setNumber($seasonDescription['number']);
                $season->setYear($seasonDescription['year']);
                $season->setDescription($seasonDescription['description']);
                $season->setProgram($this->getReference('program_' . $title));
                $manager->persist($season);
                $this->addReference('season_' . $title . '_' . $number, $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
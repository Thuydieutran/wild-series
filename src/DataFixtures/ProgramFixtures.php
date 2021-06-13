<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Blacklist' => [
            'summary' => 'l’ancien agent du gouvernement Raymond Reddington fut l’un des fugitifs les plus recherchés aux États-Unis. En contact avec des criminels du monde entier, Red avait acquis le surnom de "concierge du crime',
            'poster' => 'https://fr.web.img3.acsta.net/pictures/19/08/29/09/30/2548353.jpg',
            'category' => 'Action'
        ],
        'Qui a tué Sara?' => [
            'summary' => 'Après 18 ans de prison, Álex se venge de la famille Lazcano qui l\'a accusé à tort du meurtre de sa sœur Sara pour sauver sa réputation. ',
            'poster' => 'https://fr.web.img3.acsta.net/c_310_420/pictures/21/02/26/15/19/5515196.jpg',
            'category' => 'Horreur'
        ],
        'Ça l\'emmène là! ' => [
            'summary' => 'Huit voleurs font une prise d\'otages dans la Maison royale de la Monnaie d\'Espagne, tandis qu\'un génie du crime manipule la police pour mettre son plan à exécution. ',
            'poster' => 'https://www.avoir-alire.com/IMG/arton42400.png',
            'category' => 'Action'
        ],
        'The Crown' => [
            'summary' => 'La série se concentre sur la Reine Elizabeth II, alors âgée de 25 ans et confrontée à la tâche démesurée de diriger la plus célèbre monarchie du monde tout en nouant des relations avec le légendaire premier ministre Sir Winston Churchill. L’empire britannique est en déclin, le monde politique en désarroi… une jeune femme monte alors sur le trône, à l’aube d’une nouvelle ère. ',
            'poster' => 'https://www.tvqc.com/wp-content/uploads/2020/11/960x0.jpg',
            'category' => 'Comédie'
        ],
        'Stranger Things' => [
            'summary' => 'A Hawkins, en 1983 dans l\'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver. Dans leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite.',
            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/91G+3AvGmeL.jpg',
            'category' => 'Aventure'
        ],

    ];

    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $title => $description) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($description['summary']);
            $program->setPoster($description['poster']);
            $program->setCategory($this->getReference('category_' . $description['category']));
            for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            } 
            $this->addReference('program_' . $title, $program);
            $program->setSlug($this->slugify->generate($program->getTitle()));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
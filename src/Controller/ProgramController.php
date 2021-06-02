<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProgramType;

/**

 * @Route("/programs", name="program_")

 */
class ProgramController extends AbstractController
{
    /**

     * Show all rows from Program’s entity

     *

     * @Route("/", name="index")

     * @return Response A response instance

     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('program/index.html.twig', [
        'programs' => $programs
        ]);
    }

    /**

    * Getting a program by id

    *

    *@Route("/{id}", name="show", methods={"GET"}, requirements={"id"="\d+"})
    * @Route("/{program_id}", name="show", methods={"GET"}, requirements={"program_id"="\d+"})
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})    
    * @return Response

    */

    public function show(Program $program):Response

    {
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy([
                'program' => $program,
            ]);        

        if (!$program) {

            throw $this->createNotFoundException(
                'No program with : '.$program.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

        /**
     * @Route("/new", name="new")
     *
     * @return Response
     */

    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($program);
            $em->flush();
            return $this->redirectToRoute('program_index');
        }
        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/{program_id}/seasons/{season_id}", name="season_show", methods={"GET"}, requirements={"program_id"="\d+","season_id"="\d+"})
    * * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
    * * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     * @return Response
     */

    public function showSeason(Program $program, Season $season): Response
    {
            $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy([
                'season' => $season,
            ]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }
        if (!$season) {
            throw $this->createNotFoundException(
                'No program with id : ' . $season . ' found in seasons\'s table.'
            );
        }
        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }

    /**
     * @Route("/{program_id}/seasons/{season_id}/episodes/{episode_id}", name="episode_show", methods={"GET"}, 
     * requirements={"program_id"="\d+","season_id"="\d+", "episode_id"="\d+"})
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_id": "id"}})
     * @return Response
     */

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}

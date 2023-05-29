<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{#[Route('/', name: 'index')]

    public function index(ProgramRepository $programRepository): Response
    {   $programs = $programRepository->findAll(); 
        return $this->render('program/index.html.twig', [
         'programs' => $programs,
        ]);
    }
    #[Route('/{id}/', methods: ['GET'],requirements: ['id'=>'\d+'], name: 'show')]

    public function show( Program $program): Response
    {
        if(!$program){
            throw $this->createNotfoundException(
              'No Program with id : ' .$id. ' found in program\'s table.'  
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
           ]);    
    }

    #[Route('/{program}/season/{season}/', name: 'season_show')]

    public function showSeason(Program $program,Season $season, EpisodeRepository $episodeRepository):Response
    {
    
        $episodes = $episodeRepository->findBy(['season' => $season]);
        if (!$program){
            throw $this->createNotFoundException('aucun program avec le numero :' .$programId . 'n\'a été trouvé dans les series');
        }
        if (!$season){
            throw $this->createNotFoundException('aucune saison avec le numero :' .$seasonId . 'n\'a été trouvé dans les saisons');
        }
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
           ]); 
    }

    #[Route('/{program}/season/{season}/episode/{episode}/', name: 'episode_show')]

    public function showEpisode(Program $program, Season $season, Episode $episode) : Response
    {
        if (!$program){
            throw $this->createNotFoundException('aucun program avec le numero :' .$program->getId() . 'n\'a été trouvé dans les series');
        }
        if (!$season){
            throw $this->createNotFoundException('aucune saison avec le numero :' .$season->getId() . 'n\'a été trouvé dans les saisons');
        }

        if (!$episode){
            throw $this->createNotFoundException('aucun episode avec le numero :' .$episode->getId() . 'n\'a été trouvé dans les saisons');
        }
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
           ]); 
    }

}
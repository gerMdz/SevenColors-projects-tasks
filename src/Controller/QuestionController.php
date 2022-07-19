<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

    }


    /**
     * @Route("/{page<\d+>}", name="app_homepage")
     */
    public function homepage(QuestionRepository $repository, int $page = 1)
    {
        $question = $repository->findAll();

        return $this->render('question/homepage.html.twig', [
            'pager' => $question,
        ]);
    }

    /**
     * @Route("/questions/new")
     * @IsGranted("ROLE_USER")
     */
    public function new()
    {
        return new Response('Sounds like a GREAT feature for V2!');
    }

    /**
     * @Route("/questions/{id}", name="app_question_show")
     */
    public function show(Question $question)
    {


        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/questions/edit/{id}", name="app_question_edit")
     */
    public function edit(Question $question)
    {
        $this->denyAccessUnlessGranted('EDIT', $question);


        return $this->render('question/edit.html.twig', [
            'question' => $question,
        ]);
    }


    /**
     * @Route("/questions/{slug}/vote", name="app_question_vote", methods="POST")
     */
    public function questionVote(Question $question, Request $request, EntityManagerInterface $entityManager)
    {
        $direction = $request->request->get('direction');

        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug()
        ]);
    }
}

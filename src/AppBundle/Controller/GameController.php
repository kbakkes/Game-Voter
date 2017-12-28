<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;

use AppBundle\Entity\Genre;
use AppBundle\Entity\User;
use AppBundle\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Game controller.
 *
 * @Route("/")
 */
class GameController extends Controller
{
    /**
     * Lists all game entities.
     *
     * @Route("/", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);

        $games = $repository->findBy(
            array('enabled' => true ));

        return $this->render('game/index.html.twig', array(
            'games' => $games,
        ));
    }


    /**
     * Lists all game entities for a specific genre
     *
     * @param Genre $genre
     * @Route("/genre/{genre}", name="game_index_genre")
     * @Method("GET")
     * @return Response
     */
    public function indexGenreAction(Genre $genre)
    {
        $repository = $this->getDoctrine()->getRepository(Game::class);

        $games = $repository->findBy(
            array('genre' => $genre ));

        return $this->render(':game:filtered.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * Gets all upvoted users for an specific game
     * @Route("/game/{id}/upvoters", name="game_upvoters")
     */
    public function showUpvoters(Game $game){
        return $this->render('game/voters.html.twig', array(
            'game' => $game,
        ));
    }

    /**
     * Gets all games from the current user
     * @Route("/profile/games", name="current_user_games")
     */
    public function showMyGames(){
        $em = $this->getDoctrine()->getManager();


        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $game = new Game();
        $user = $game->getUploader($currentUser);

        $repository = $this->getDoctrine()->getRepository(Game::class);

        $games = $repository->findBy(
            array('uploadedBy' => $user ),
            array('uploadedAt' => 'ASC'));


        // query builder  return games where uploaded by id = currentuser
        return $this->render(':game:mygames.html.twig', array(
            'games' => $games,
            'user' => $currentUser,
        ));
    }


    /**
     * Adds user to upvote array
     * @Route("/game/{id}/upvote", name="game_upvote")
     * @Method("POST")
     */
    public function addToUpvoters(Game $game){
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $game->addUpvoter($currentUser);

        $em->persist($game);

        $em->flush();
        return $this->redirectToRoute('game_index');
    }

    /**
     * Adds user to downvote array
     * @Route("/game/{id}/downvote", name="game_downvote")
     * @Method("POST")
     */
    public function addToDownvoters(Game $game){
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $game->addDownvoter($currentUser);

        $em->persist($game);

        $em->flush();
        return $this->redirectToRoute('game_index');
    }


    /**
     * @Route("/game/{id}/upvote/delete", name="game_remove_upvoter")
     * @Method("DELETE")
     */
    public function removeUpvoter(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $game->deleteUpvoter($currentUser);

        $em->persist($game);

        $em->flush();

        return new Response(null, 204);
    }

    /**
     * @Route("/game/{id}/downvote/delete", name="game_remove_downvoter")
     * @Method("DELETE")
     */
    public function removeDownvoter(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $game->deleteDownvoter($currentUser);

        $em->persist($game);

        $em->flush();

        return new Response(null, 204);
    }


    /**
     * Creates a new game entity.
     *
     * @Route("/game/new", name="game_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $game = new Game();

        $game->setUploadedAt();
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $game->setUploadedBy($currentUser);

        $form = $this->createForm('AppBundle\Form\GameType', $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_show', array('id' => $game->getId()));
        }

        return $this->render('game/new.html.twig', array(
            'game' => $game,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a game entity.
     *
     * @Route("/game/{id}", name="game_show")
     * @Method("GET")
     */
    public function showAction(Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);

        return $this->render('game/show.html.twig', array(
            'game' => $game,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing game entity.
     *
     * @Route("/game/{id}/edit", name="game_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('AppBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @param Game $game
     * @Route("/game/change-status/{id}", name="game_change_status")
     * @return \Symfony\Component\Form\Form The form
     */
    public function changeStatusAction(Game $game)
    {
        $em = $this->getDoctrine()->getManager();

        $game->changeStatus();

        $em->persist($game);
        $em->flush();

        return $this->redirectToRoute('current_user_games');
    }

    /**
     * Redirects back to the homepage
     * @Route("/game/redirect", name="game_redirect")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction()
    {
        return $this->redirectToRoute('game_index');
    }

    /**
     * Deletes a game entity.
     *
     * @Route("/game/{id}", name="game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

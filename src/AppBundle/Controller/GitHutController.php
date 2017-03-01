<?php

namespace AppBundle\Controller;

use AppBundle\Form\Model\SearchUsernameModel;
use AppBundle\Form\Type\SearchUsernameType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GitHutController extends Controller
{
    /**
     * @Route("/", name="githut")
     */
    public function indexAction(Request $request)
    {
        $searchUsername = new SearchUsernameModel();

        $form = $this->createForm(SearchUsernameType::class, $searchUsername);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchUsername = $form->getdata();
            $username = $searchUsername->getUsername();
            return $this->redirectToRoute('profile', ['username' => $username]);
        }

        $vars = [
            'form' => $form->createView()
        ];

        return $this->render(':default:index.html.twig', $vars);
    }

    /**
     * @Route("/search", name="navbar")
     */
    public function navSearchAction(Request $request)
    {
        $searchUsername = new SearchUsernameModel();

        $form = $this->createForm(SearchUsernameType::class, $searchUsername, [
            'action' => $this->generateUrl('navbar')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $searchUsername = $form->getdata();
                $navUsername = $searchUsername->getUsername();
                return $this->redirectToRoute('profile', ['username' => $navUsername]);
            } else {
                return $this->redirectToRoute('githut');
            }

        }

        $vars = [
            'form' => $form->createView()
        ];

        return $this->render(':default/partials:nav.html.twig', $vars);
    }

    /**
     * @Route("/{username}", name="profile")
     */
    public function profileAction($username)
    {
        $profile = $this->get('github_api')->getProfile($username);

        $vars = [
            'username' => $username,
            'repos' => $this->get('github_api')->getRepositories($username),
            'profile' => $profile
        ];

        return $this->render(':default:profile.html.twig', $vars);
    }

}
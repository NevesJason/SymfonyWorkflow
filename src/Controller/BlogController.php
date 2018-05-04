<?php
/**
 * Created by PhpStorm.
 * User: jneves
 * Date: 26/04/2018
 * Time: 11:03
 */

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\BlogPost;
use Symfony\Component\Workflow\Registry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\HttpFoundation\Response;


class BlogController extends Controller
{
    /**
     * @Route("/",name="edit_workflow")
     */
    public function edit(Registry $workflows)
    {
        $post = new BlogPost();
        $workflow = $workflows->get($post);
        $workflow->can($post, 'submit_to_review');//True
        $transitions = $workflow->getEnabledTransitions($post);//
        dump($transitions);
        dump($workflow->getMarking($post));

        try {
            $workflow->apply($post, 'submit_to_review');//drafted->in_review
        } catch (LogicException $exception) {
            dump($exception);
        }
        dump($workflow->getMarking($post));
        $workflow->apply($post, 'request_changes');
        dump($workflow->getMarking($post));

        $workflow->apply($post, 'apply_changes');
        dump($workflow->getMarking($post));

        $workflow->apply($post, 'publish');
        
        dump($workflow->getMarking($post));

        $transitions = $workflow->getEnabledTransitions($post);
        dump($transitions);//vide
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response('add');
    }
}
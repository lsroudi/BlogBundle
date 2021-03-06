<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Form\Handler\CommentHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Model\CommentModel;
use Desarrolla2\Bundle\BlogBundle\Form\Type\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment controller.
 *
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * Creates a new Comment entity.
     *
     * @Route("/{post_id}", name="_blog_comment_create", requirements={"post_id" = "\d+"}, defaults={"post_id" = "1" })
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:Post')->find($request->get('post_id', false));
        if (!$post) {
            throw $this->createNotFoundException('Unable to find post.');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(new CommentType(), new CommentModel($comment));
        if ($request->getMethod() == 'POST') {
            $formHandler = new CommentHandler($form, $request, $em, $this->container->get('blog.sanitizer.manager'), $comment);

            if ($formHandler->process()) {
                return $this->redirect($this->generateUrl('_comment_message'));
            }
        }

        return array(
            'form' => $form->createView(),
            'post' => $post,
        );
    }

    /**
     *
     * @Route("/message/", name="_comment_message")
     * @Method("GET")
     * @Template()
     */
    public function messageAction(Request $request)
    {
    }
}

<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Desarrolla2\Bundle\BlogBundle\Entity\PostView;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use DateTime;

/**
 * PostViewRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostViewRepository extends EntityRepository
{
    /**
     * @param Post $post
     */
    public function add(Post $post)
    {
        $em = $this->getEntityManager();

        $date = new DateTime();

        $click = $this->findOneBy(
            array(
                'postId' => $post->getId(),
                'date' => $date
            )
        );
        if (!$click) {
            $click = new PostView();
            $click->setPost($post);
            $click->setDate($date);
        }

        $click->increment();

        $em->persist($click);
        $em->flush();
    }
}

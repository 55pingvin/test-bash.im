<?php


namespace App\Services;


use App\Entity\Complaint;
use App\Entity\Post;
use App\Repository\ComplaintRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @var Post $post
 * @var EntityManager $post
 */

class ComplaintService
{

    public $post;
    public $complaintRepository;

    /**
     * ComplaintService constructor.
     * @param ComplaintRepository $complaintRepository
     * @param Post $post
     */
    public function __construct(ComplaintRepository $complaintRepository, Post $post)
    {
        $this->complaintRepository = $complaintRepository;
        $this->post = $post;
    }

    /**
     * Метод сохранения жалобы на пост
     * @param $text
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($text): bool
    {
        if ($this->post && $text) {
            $complaint = new Complaint();

            $complaint->setContent(strip_tags($text));
            $complaint->setPost($this->post);

            $this->complaintRepository->save($complaint);

            if ($complaint->getId()) {
                return true;
            }
        }

        return false;
    }


}
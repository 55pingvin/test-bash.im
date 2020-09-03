<?php


namespace App\Services;


use App\Entity\Post;
use App\Entity\PostRate;
use App\Repository\PostRateRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class RateService
{
    private $post;
    private $type;
    private $ipv4;
    private $postRateRepository;
    private $postRepository;

    /**
     * RateService constructor.
     * @param PostRateRepository $postRateRepository
     * @param PostRepository $postRepository
     * @param Post $post
     * @param string $type
     * @param string $ipv4
     */
    public function __construct(
        PostRateRepository $postRateRepository,
        PostRepository$postRepository,
        Post $post,
        string $type,
        string $ipv4
    )
    {
        $this->post = $post;
        $this->type = $type;
        $this->ipv4 = $ipv4;
        $this->postRateRepository = $postRateRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Метод голосования за пост
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function rate()
    {
        $result = false;

        $postRate = $this->postRateRepository->findOneBy(
            [
                'post' => $this->post->getId(),
                'ipv4' => $this->ipv4       // Такая проверка будет печальной если пользователь сидит за NAT один проголосует, а другие нет
            ]
        );

        if (!$postRate) {

            if ($this->post && $this->type) {

                $rate = ($this->type === 'like') ? 1 : -1;

                $postRate = new PostRate();
                $postRate->setPost($this->post);
                $postRate->setRate($rate);
                $postRate->setIpv4($this->ipv4);

                $this->post->setRate($rate);

                $this->postRateRepository->save($postRate);
                $this->postRepository->save($this->post);

                $result = $this->post->getRate();
            }
        }

        return $result;
    }

}
<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource(
 *
 *     collectionOperations={
 *          "get"={
 *               "normalization_context"={"groups"={"article_info"}}
 *              },
 *          "post"
 *          },
 *      itemOperations={
 *                  "get"={
 *                      "normalization_context"={"groups"={"article_details_read"}}
 *                  },
 *                  "put",
 *                  "patch",
 *                  "delete"
 *              }
 * )
 */
class Article
{
    /**
     * Centralisation de la createdAt
     */
    use Timestapable;

    /**
     * Centralise de la Gestion Id avec un trait
     */
    use ResourceId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"article_info","user_details_read","article_details_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"article_info","user_details_read","article_details_read"})
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"article_details_read","article_info"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"article_details_read"})
     */
    private $author;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }
}

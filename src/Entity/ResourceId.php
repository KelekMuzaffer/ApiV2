<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/** Centralise la gestion de id et le rajouter dans les entité avec : use ResourceId */
trait ResourceId {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_info", "user_details_read","article_details_read","article_info"})
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as PersonAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource(
    order: ["name" => "ASC"],
    collectionOperations: [
        'get' => ['normalization_context' => ['groups' => 'collection:get']],
        'post'
    ],
    itemOperations: [
        'get'
    ]
)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("collection:get")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("collection:get")]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("collection:get")]
    private $prename;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    #[PersonAssert\AgeConstraint()]
    #[Groups("collection:get")]
    private $birthdate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrename(): ?string
    {
        return $this->prename;
    }

    public function setPrename(string $prename): self
    {
        $this->prename = $prename;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return int|null
     */
    #[Groups("collection:get")]
    public function getAge(): ?int
    {
        if ($this->birthdate instanceof \DateTime) {
            $referenceDateTime = new \DateTime("now");

            return $referenceDateTime->diff($this->birthdate, true)->y;
        }

        return null;
    }
}

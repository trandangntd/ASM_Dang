<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CusName;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCusName(): ?string
    {
        return $this->CusName;
    }

    public function setCusName(?string $CusName): self
    {
        $this->CusName = $CusName;

        return $this;
    }

    public function getPassword(): ?int
    {
        return $this->Password;
    }

    public function setPassword(?int $Password): self
    {
        $this->Password = $Password;

        return $this;
    }
}

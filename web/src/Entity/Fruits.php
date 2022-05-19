<?php

namespace App\Entity;

use App\Repository\FruitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitsRepository::class)]
class Fruits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $fruitname;

    #[ORM\Column(type: 'string', length: 30)]
    private $color;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $taste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruitname(): ?string
    {
        return $this->fruitname;
    }

    public function setFruitname(string $fruitname): self
    {
        $this->fruitname = $fruitname;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getTaste(): ?string
    {
        return $this->taste;
    }

    public function setTaste(?string $taste): self
    {
        $this->taste = $taste;

        return $this;
    }
}

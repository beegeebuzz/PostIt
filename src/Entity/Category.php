<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PostIt", mappedBy="category")
     */
    private $postIts;

    public function __construct()
    {
        $this->postIts = new ArrayCollection();
    }

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

    /**
     * @return Collection|PostIt[]
     */
    public function getPostIts(): Collection
    {
        return $this->postIts;
    }

    public function addPostIt(PostIt $postIt): self
    {
        if (!$this->postIts->contains($postIt)) {
            $this->postIts[] = $postIt;
            $postIt->setCategory($this);
        }

        return $this;
    }

    public function removePostIt(PostIt $postIt): self
    {
        if ($this->postIts->contains($postIt)) {
            $this->postIts->removeElement($postIt);
            // set the owning side to null (unless already changed)
            if ($postIt->getCategory() === $this) {
                $postIt->setCategory(null);
            }
        }

        return $this;
    }
}

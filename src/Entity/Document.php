<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attachment", mappedBy="document")
	 * @ORM\OrderBy({"position" = "ASC"})
     */
    private $attachment;   

    public function __construct()		
    {        
		$this->attachment = new ArrayCollection();
    }

    public function getId()
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
	
	public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }   

    /**
     * @return Collection|Attachment[]
     */
    public function getAttachment(): Collection
    {
        return $this->attachment;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachment->contains($attachment)) {
            $this->attachment[] = $attachment;
            $attachment->setDocument($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachment->contains($attachment)) {
            $this->attachment->removeElement($attachment);
            // set the owning side to null (unless already changed)
            if ($attachment->getDocument() === $this) {
                $attachment->setDocument(null);
            }
        }

        return $this;
    }      
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttachmentRepository")
 */
class Attachment
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
     * @ORM\Column(type="string", length=255)
     */
    private $orig_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $filesize;
	
	/**
     * @ORM\Column(type="integer")
     */
    private $position;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", inversedBy="attachment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $document;

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

	public function getOrigName(): ?string
    {
        return $this->orig_name;
    }

    public function setOrigName(string $orig_name): self
    {
        $this->orig_name = $orig_name;

        return $this;
    } 	

    public function getFilesize(): ?integer
    {
        return $this->filesize;
    }

    public function setFilesize(integer $filesize): self
    {
        $this->filesize = $filesize;

        return $this;
    }
	
	 public function getPosition(): ?integer
    {
        return $this->position;
    }

    public function setPosition(integer $filesize): self
    {
        $this->position = $position;

        return $this;
    }
	
	public function getDocument(): ?Document
    {
        return $this->document;
    }
	
	public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }
}

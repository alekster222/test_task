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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_image;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document", inversedBy="attachment")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $document;

    public function __construct()
    {
        $this->position = 0;
        $this->is_image = 0;
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

	public function getOrigName(): ?string
    {
        return $this->orig_name;
    }

    public function setOrigName(string $orig_name): self
    {
        $this->orig_name = $orig_name;

        return $this;
    }

    public function getFilesize()
    {
        return $this->filesize;
    }

    public function setFilesize($filesize): self
    {
        $this->filesize = $filesize;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getIsImage()
    {
        return $this->is_image;
    }

    public function setIsImage($is_image): self
    {
        $this->is_image = $is_image;

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

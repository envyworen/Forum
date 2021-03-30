<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $reponse;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_topic;

    /**
     * @ORM\Column(type="integer")
     */
    private $best_rep;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getIdTopic(): ?int
    {
        return $this->id_topic;
    }

    public function setIdTopic(int $id_topic): self
    {
        $this->id_topic = $id_topic;

        return $this;
    }

    public function getBestRep(): ?int
    {
        return $this->best_rep;
    }

    public function setBestRep(int $best_rep): self
    {
        $this->best_rep = $best_rep;

        return $this;
    }





}

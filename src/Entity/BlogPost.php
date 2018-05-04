<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="BlogPost")
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostRepository")
 */
class BlogPost
{
    /**
 * @ORM\Id()
 * @ORM\GeneratedValue()
 * @ORM\Column(type="integer")
 */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $currentPlace;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id =$id;
    }

    public function getMarking()
    {
        return $this->currentPlace;
    }
    public function setMarking($place)
    {

        $this->currentPlace = $place;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
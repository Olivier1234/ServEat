<?php
/**
 * Created by PhpStorm.
 * User: gambierolivier
 * Date: 07/02/2019
 * Time: 14:18
 */

namespace App\Entity\Traits;


trait IdsTraits
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

}
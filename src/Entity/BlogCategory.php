<?php

namespace App\Entity;

use App\Repository\BlogCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="blog_categories")
 * @ORM\Entity
 * ...(repositoryClass=BlogCategoryRepository::class)
 */
class BlogCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

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

    public static function getCategoriesArray($doctrine) {
        $cats = $doctrine
            ->getRepository(BlogCategory::class)
            ->findBy([], ['id'=>'asc']);
        $categories = [];
        for($i = 0; $i < count($cats); $i++) {
            $categories[$cats[$i]->getId()] = $cats[$i]->getName();
        }
        return $categories;
    }
}

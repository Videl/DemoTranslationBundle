<?php

namespace A2lix\DemoTranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A2lix\DemoTranslationBundle\Entity\Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="A2lix\DemoTranslationBundle\Repository\CategoryRepository")
 * @Gedmo\TranslationEntity(class="A2lix\DemoTranslationBundle\Entity\Translation\CategoryTranslation")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(length=100)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var boolean $isMain
     *
     * @ORM\Column(type="boolean")
     */
    private $isMain = false;

    /**
     * @ORM\OneToMany(
     * 	 targetEntity="A2lix\DemoTranslationBundle\Entity\Translation\CategoryTranslation",
     * 	 mappedBy="object",
     * 	 cascade={"persist", "remove"}
     * )
     * @Assert\Valid(deep = true)
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isMain
     *
     * @param boolean $isMain
     * @return Category
     */
    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;
        return $this;
    }

    /**
     * Get isMain
     *
     * @return boolean $isMain
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * Set translations
     *
     * @param ArrayCollection $translations
     * @return Category
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * Get translations
     *
     * @return ArrayCollection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Add translation
     *
     * @param CategoryTranslation
     */
    public function addTranslation($translation)
    {
        if ($translation->getContent()) {
            $translation->setObject($this);
            $this->translations->add($translation);
        }
    }

    /**
     * Remove translation
     *
     * @param CategoryTranslation
     */
    public function removeTranslation($translation)
    {
        $this->translations->removeElement($translation);
    }

}
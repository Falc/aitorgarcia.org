<?php

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AitorGarcia\PortfolioBundle\Entity
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity(repositoryClass="AitorGarcia\PortfolioBundle\Entity\ProjectRepository")
 * @Gedmo\TranslationEntity(class="AitorGarcia\PortfolioBundle\Entity\Translation\ProjectTranslation")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Gedmo\Translatable
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $client;

    /**
     * @ORM\Column(type="string")
     */
    protected $link;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $url;

    /**
     * @ORM\ManyToMany(targetEntity="Technology", inversedBy="projects")
     * @ORM\JoinTable(name="project_technologies")
     */
    protected $technologies;

    /**
     * @ORM\OneToMany(targetEntity="ProjectScreenshot", mappedBy="project", cascade={"persist", "remove"})
     * @ORM\OrderBy({"weight" = "ASC", "id" = "ASC"})
     */
    protected $screenshots;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->technologies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->screenshots = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set client
     *
     * @param string $client
     * @return Project
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Project
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Project
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add technology
     *
     * @param AitorGarcia\PortfolioBundle\Entity\Technology $technology
     * @return Project
     */
    public function addTechnology(\AitorGarcia\PortfolioBundle\Entity\Technology $technology)
    {
        $this->technologies[] = $technology;
    
        return $this;
    }

    /**
     * Remove technology
     *
     * @param AitorGarcia\PortfolioBundle\Entity\Technology $technology
     */
    public function removeTechnology(\AitorGarcia\PortfolioBundle\Entity\Technology $technology)
    {
        $this->technologies->removeElement($technology);
    }

    /**
     * Get technologies
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * Add screenshot
     *
     * @param AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot $screenshot
     * @return Project
     */
    public function addScreenshot(\AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot $screenshot)
    {
        $screenshot->setProject($this);
        $this->screenshots[] = $screenshot;
    
        return $this;
    }

    /**
     * Remove screenshot
     *
     * @param AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot $screenshot
     */
    public function removeScreenshot(\AitorGarcia\PortfolioBundle\Entity\ProjectScreenshot $screenshot)
    {
        $this->screenshots->removeElement($screenshot);
    }

    /**
     * Get screenshots
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }

    /**
     * Get the creation date
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}

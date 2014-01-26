<?php
/**
 * This file contains the Project class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2012-2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a project.
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AitorGarcia\PortfolioBundle\Entity\Translation\ProjectTranslation")
 */
class Project
{
    /**
     * The project ID.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * The project name.
     *
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    protected $name;

    /**
     * The project description.
     *
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * The project client.
     *
     * This is optional. The project view will not display the client block if no client was entered.
     *
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max="255")
     */
    protected $client;

    /**
     * A link to the project.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @Assert\Url()
     */
    protected $link;

    /**
     * A link to the source code.
     *
     * This is optional. The project view will not display the "Source Code" button if not source code link was entered.
     *
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Url()
     */
    protected $sourceLink;

    /**
     * The project slug.
     *
     * @var string
     *
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * This represents the ManyToMany Projects-Technologies relationship.
     *
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Technology", inversedBy="projects", cascade={"persist"})
     * @ORM\JoinTable(name="project_technologies")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\Count(min = "1", minMessage = "projects.select_min_technologies")
     */
    protected $technologies;

    /**
     * This represents the OneToMany Project-Screenshots relationship.
     *
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="ProjectScreenshot", mappedBy="project", cascade={"persist", "remove"})
     * @ORM\OrderBy({"weight" = "ASC", "id" = "ASC"})
     */
    protected $screenshots;

    /**
     * The project creation date.
     *
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * The translation locale code.
     *
     * @var string
     *
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->screenshots = new ArrayCollection();
    }
    
    /**
     * Gets the ID.
     *
     * @return  integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the name.
     *
     * @param   string  $name
     * @return  Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the name.
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the description.
     *
     * @param   string  $description
     * @return  Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Gets the description.
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the client.
     *
     * @param   string  $client
     * @return  Project
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Gets the client.
     *
     * @return  string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets the link.
     *
     * @param   string  $link
     * @return  Project
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Gets the link.
     *
     * @return  string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the source link.
     *
     * @param   string  $sourceLink
     * @return  Project
     */
    public function setSourceLink($sourceLink)
    {
        $this->sourceLink = $sourceLink;

        return $this;
    }

    /**
     * Gets the source link.
     *
     * @return  string
     */
    public function getSourceLink()
    {
        return $this->sourceLink;
    }

    /**
     * Sets the slug.
     *
     * @param   string  $slug
     * @return  Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Gets the slug.
     *
     * @return  string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Adds a technology.
     *
     * @param   Technology   $technology
     * @return  Project
     */
    public function addTechnology(Technology $technology)
    {
        $this->technologies[] = $technology;
    
        return $this;
    }

    /**
     * Removes a technology.
     *
     * @param   Technology   $technology
     */
    public function removeTechnology(Technology $technology)
    {
        $this->technologies->removeElement($technology);
    }

    /**
     * Gets the technologies.
     *
     * @return  Doctrine\Common\Collections\Collection
     */
    public function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * Adds a screenshot.
     *
     * @param   ProjectScreenshot    $screenshot
     * @return  Project
     */
    public function addScreenshot(ProjectScreenshot $screenshot)
    {
        $screenshot->setProject($this);
        $this->screenshots[] = $screenshot;
    
        return $this;
    }

    /**
     * Removes a screenshot.
     *
     * @param   ProjectScreenshot    $screenshot
     */
    public function removeScreenshot(ProjectScreenshot $screenshot)
    {
        $this->screenshots->removeElement($screenshot);
    }

    /**
     * Gets the screenshots.
     *
     * @return  Doctrine\Common\Collections\Collection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }

    /**
     * Gets the creation date.
     *
     * @return  DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the locale.
     *
     * @param   string  $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
}

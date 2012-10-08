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
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

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
     * Constructor
     */
    public function __construct()
    {
        $this->technologies = new \Doctrine\Common\Collections\ArrayCollection();
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
}

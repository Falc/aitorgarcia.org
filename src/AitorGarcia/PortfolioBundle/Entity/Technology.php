<?php
/**
 * This file contains the Technology class.
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
 * Represents a technology.
 *
 * @ORM\Table(name="technologies")
 * @ORM\Entity(repositoryClass="AitorGarcia\PortfolioBundle\Entity\TechnologyRepository")
 */
class Technology
{
    /**
     * The technology ID.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * The technology name.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    protected $name;

    /**
     * The technology slug.
     *
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * This represents the ManyToMany Projects-Technologies relationship.
     *
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="technologies")
     */
    protected $projects;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
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
     * Gets the name.
     *
     * @return  string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param   string  $name
     * @return  Technology
     */
    public function setName($name)
    {
        $this->name = $name;
    
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
     * Sets the slug.
     *
     * @param   string  $slug
     * @return  Tag
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Adds a project.
     *
     * @param   Project $project
     * @return  Technology
     */
    public function addProject(Project $project)
    {
        $this->projects[] = $project;
    
        return $this;
    }

    /**
     * Removes a project.
     *
     * @param   Project $project
     */
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Gets the projects.
     *
     * @return  Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}

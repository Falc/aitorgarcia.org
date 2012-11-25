<?php
/**
 * This file contains the Technology class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a technology.
 *
 * @ORM\Table(name="technologies")
 * @ORM\Entity
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
     * @Assert\MaxLength(255)
     */
    protected $name;

    /**
     * This represents the ManyToMany project-technologies relationship.
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
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return  Technology
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
     * Adds a project.
     *
     * @param   Project $project
     * @return  Technology
     */
    public function addProject(\AitorGarcia\PortfolioBundle\Entity\Project $project)
    {
        $this->projects[] = $project;
    
        return $this;
    }

    /**
     * Removes a project.
     *
     * @param   Project $project
     */
    public function removeProject(\AitorGarcia\PortfolioBundle\Entity\Project $project)
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

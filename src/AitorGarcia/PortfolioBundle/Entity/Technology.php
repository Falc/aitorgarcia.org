<?php

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AitorGarcia\PortfolioBundle\Entity
 *
 * @ORM\Table(name="technologies")
 * @ORM\Entity
 */
class Technology
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
    * @ORM\ManyToMany(targetEntity="Project", mappedBy="technologies")
    */
	protected $projects;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Technology
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
     * Add projects
     *
     * @param AitorGarcia\PortfolioBundle\Entity\Project $project
     * @return Technology
     */
    public function addProject(\AitorGarcia\PortfolioBundle\Entity\Project $project)
    {
        $this->projects[] = $project;
    
        return $this;
    }

    /**
     * Remove project
     *
     * @param AitorGarcia\PortfolioBundle\Entity\Project $project
     */
    public function removeProject(\AitorGarcia\PortfolioBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }
}

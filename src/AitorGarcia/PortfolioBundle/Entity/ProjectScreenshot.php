<?php

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AitorGarcia\PortfolioBundle\Entity
 *
 * @ORM\Table(name="project_screenshots")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ProjectScreenshot
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
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @Assert\File(maxSize="2M")
     */
    public $file;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="screenshots")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return ProjectScreenshot
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
     * Set path
     *
     * @param string $path
     * @return ProjectScreenshot
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set project
     *
     * @param AitorGarcia\PortfolioBundle\Entity\Project $project
     * @return ProjectScreenshot
     */
    public function setProject(\AitorGarcia\PortfolioBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return AitorGarcia\PortfolioBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ($this->file !== null)
        {
            // Sanitize and/or generate a unique name if needed
            // $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();

            // I don't sanitize it because nobody except me will be able to upload photos
            $this->path = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->file === null)
        {
            return;
        }

        // Move the file to the correct place
        $this->file->move($this->getUploadRootDir(), $this->path);

        // Clean the file property
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath())
        {
            unlink($file);
        }
    }

    /**
     * Get the absolute directory path where screenshots should be stored
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Get the screenshots directory (relative to /web/files/)
     *
     * @return string
     */
    protected function getUploadDir()
    {
        // Get rid of the __DIR__ so it doesn't screw when displaying images in the view.
        return 'files/project-screenshots';
    }

    /**
     * Get the absolute path
     */
    public function getAbsolutePath()
    {
        return ($this->path === null) ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Get the web path (relative to /web/)
     */
    public function getWebPath()
    {
        return ($this->path === null) ? null : $this->getUploadDir().'/'.$this->path;
    }
}

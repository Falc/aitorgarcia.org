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

        // Create a thumbnail
        $this->createThumbnail(600, 400);

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
            $thumbnail = str_replace('.jpg', '_thumb.jpg', $file);

            unlink($file);
            unlink($thumbnail);
        }
    }

    /**
     * Creates a thumbnail with the specified size
     */
    protected function createThumbnail($dest_width = 300, $dest_height = 200)
    {
        // Get the source image and its size
        $src_image = imagecreatefromjpeg($this->getAbsolutePath());
        $src_width = imagesx($src_image);
        $src_height = imagesy($src_image);

        // Get the ratio and adapt the size to the ratio
        $ratio = min($src_width / $dest_width, $src_height / $dest_height);
        $width = $dest_width * $ratio;
        $height = $dest_height * $ratio;

        // If the image size is bigger than the desired size, it must be cropped
        $src_x = ($src_width > $width) ? ($src_width - $width) / 2 : 0; // Center horizontally
        $src_y = 0; // Top

        // Resize the source image
        $dest_image = imagecreatetruecolor($dest_width, $dest_height);
        imagecopyresampled(
	        $dest_image, $src_image, 0, 0, $src_x, $src_y,
	        $dest_width, $dest_height, $width, $height
        );

        // Set the dest_path and save the thumbnail
        $dest_path = str_replace('.jpg', '_thumb.jpg', $this->getAbsolutePath());
        imagejpeg($dest_image, $dest_path, 88);
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

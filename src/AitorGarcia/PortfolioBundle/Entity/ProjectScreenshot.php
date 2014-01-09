<?php
/**
 * This file contains the ProjectScreenshot class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a project screenshot.
 *
 * @ORM\Table(name="project_screenshots")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AitorGarcia\PortfolioBundle\Entity\Translation\ProjectScreenshotTranslation")
 * @ORM\HasLifecycleCallbacks
 */
class ProjectScreenshot
{
    /**
     * The screenshot ID.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * The screenshot name.
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
     * The screenshot file path.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * The screenshot weight.
     *
     * A screenshot with a weight (i.e. 2) will be displayed below/after screenshots with a lower weight (<2).
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\Type(type="numeric")
     */
    protected $weight = 0;

    /**
     * The screenshot file, represented through the File class. 
     *
     * @var \Symfony\Component\HttpFoundation\File\File
     *
     * @Assert\File(maxSize="2M")
     */
    protected $file;

    /**
     * This represents the ManyToOne project-screenshots relationship.
     *
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="screenshots")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * The translation locale code.
     *
     * @var string
     *
     * @Gedmo\Locale
     */
    protected $locale;
    
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
     * @return  ProjectScreenshot
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
     * Sets the path.
     *
     * @param   string  $path
     * @return  ProjectScreenshot
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the path.
     *
     * @return  string  $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the weight.
     *
     * @param   integer $weight
     * @return  ProjectScreenshot
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Gets the weight.
     *
     * @return  integer $weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets file.
     *
     * @param   UploadedFile    $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return  UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the project.
     *
     * @param   Project $project
     * @return  ProjectScreenshot
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Gets the project.
     *
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Gets the file name and sets the path.
     *
     * This is a lifecycle callback that executes before persisting/updating the project screenshot in the database.
     *
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
     * Moves the file to the correct place.
     *
     * This is a lifecycle callback that executes after persisting/updating the project screenshot in the database.
     *
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
        // Disabled: I don't need thumnails at the moment but this code could be useful
        //$this->createThumbnail(480, 320);

        // Clean the file property
        $this->file = null;
    }

    /**
     * Deletes the file.
     *
     * This is a lifecycle callback that executes after deleting the project screenshot in the database.
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath())
        {
            unlink($file);
            // Disabled: I don't need thumnails at the moment but this code could be useful
            //$thumbnail = str_replace('.jpg', '_thumb.jpg', $file);
            //unlink($thumbnail);
        }
    }

    /**
     * Creates a thumbnail with the specified size.
     *
     * @param   integer $dest_width     The thumbnail width. Default is 300px.
     * @param   integer $dest_height    The thumbnail height. Default is 200px.
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
     * Gets the absolute directory path where screenshots should be stored.
     *
     * @return  string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Gets the screenshots directory (relative to /web/files/).
     *
     * @return  string
     */
    protected function getUploadDir()
    {
        // Get rid of the __DIR__ so it doesn't screw when displaying images in the view.
        return 'files/project-screenshots';
    }

    /**
     * Gets the absolute path.
     *
     * @return  string|null
     */
    public function getAbsolutePath()
    {
        return ($this->path === null) ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Gets the thumbnail absolute path.
     *
     * @return  string|null
     */
    public function getThumbAbsolutePath()
    {
        return str_replace('.jpg', '_thumb.jpg', $this->getAbsolutePath());
    }

    /**
     * Gets the web path (relative to /web/).
     *
     * @return  string|null
     */
    public function getWebPath()
    {
        return ($this->path === null) ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * Gets the thumb web path (relative to /web/).
     *
     * @return  string|null
     */
    public function getThumbWebPath()
    {
        return str_replace('.jpg', '_thumb.jpg', $this->getWebPath());
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

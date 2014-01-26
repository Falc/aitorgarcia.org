<?php
/**
 * This file contains the Comment class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a comment..
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity
 */
class Comment
{
    /**
     * The comment ID.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * The comment body.
     *
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $body;

    /**
     * The name of the author.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    protected $author;

    /**
     * The email of the author.
     *
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     * @Assert\Email()
     */
    protected $email;

    /**
     * The website of the author.
     *
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Url()
     */
    protected $website;

    /**
     * The post creation date.
     *
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * This represents the ManyToOne Comments-Post relationship.
     *
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * Constructor.
     */
    public function __construct()
    {
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
     * Gets the body.
     *
     * @return  string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the body.
     *
     * @param   string  $body
     * @return  Post
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Gets the name of the author.
     *
     * @return  string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the name of the author.
     *
     * @param   string  $author
     * @return  Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Gets the email of the author.
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email of the author.
     *
     * @param   string  $email
     * @return  Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the website of the author.
     *
     * @return  string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the website of the author.
     *
     * @param   string  $website
     * @return  Comment
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
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
     * Gets the post.
     *
     * @return  Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Sets the post.
     *
     * @param   Post    $post
     * @return  Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }
}

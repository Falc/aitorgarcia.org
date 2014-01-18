<?php
/**
 * This file contains the Comment class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2014 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
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
    protected $authorName;

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
    protected $authorEmail;

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
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Sets the name of the author.
     *
     * @param   string  $authorName
     * @return  Comment
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Gets the email of the author.
     *
     * @return  string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Sets the email of the author.
     *
     * @param   string  $authorEmail
     * @return  Comment
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

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

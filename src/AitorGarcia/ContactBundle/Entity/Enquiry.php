<?php
/**
 * This file contains the Enquiry class.
 *
 * @author		Aitor García <aitor.falc@gmail.com>
 * @copyright	2012-2013 Aitor García <aitor.falc@gmail.com>
 * @license		https://github.com/Falc/aitorgarcia.org/blob/master/LICENSE Simplified BSD License
 */

namespace AitorGarcia\ContactBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents an enquiry.
 */
class Enquiry
{
    /**
     * The enquirer name.
     *
     * @var string
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * The enquirer email.
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * The enquiry subject.
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="80")
     */
    protected $subject;

    /**
     * The enquiry body.
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="20")
     */
    protected $body;

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
     * @return  Enquiry
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the email.
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email.
     *
     * @param   string  $email
     * @return  Enquiry
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the subject.
     *
     * @return  string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the subject.
     *
     * @param   string  $subject
     * @return  Enquiry
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
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
     * @return  Enquiry
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}

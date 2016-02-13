<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @Assert\NotBlank()
     */
    protected $name = '';
    /**
     * @Assert\NotBlank()
     */
    protected $email = '';
    /**
     * @Assert\NotBlank()
     */
    protected $message = '';

    /**
     * Name getter
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Name Setter
     * 
     * @param \string $name Name
     * 
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Email getter
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Email Setter
     * 
     * @param \string $email Email
     * 
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Message getter
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Message Setter
     * 
     * @param \string $message Message
     * 
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
<?php
namespace AppBundle\Domain;

/**
 * Class Package
 * @package AppBundle\Domain
 */
class Package
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $name;

    /**
     * Package constructor.
     * @param string $uid
     * @param string $name
     */
    public function __construct($uid, $name)
    {
        $this->uid = $uid;
        $this->name = $name;
    }
}

<?php
namespace AppBundle\Domain;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Project
 * @package AppBundle\Domain
 */
class Project
{
    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $license;

    /**
     * @var string
     */
    private $framework;

    /**
     * @var string
     */
    private $version;

    /**
     * @var array
     */
    private $prodPackages;

    /**
     * @var array
     */
    private $devPackages;

    /**
     * @var string
     */
    private $log;

    /**
     * @var string
     */
    private $downloadPath;

    public function __construct()
    {
        $this->prodPackages = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLicensing()
    {
        return $this->license;
    }

    /**
     * @param string $license
     */
    public function setLicensing($license)
    {
        $this->license = $license;
    }

    /**
     * @return string
     */
    public function getFramework()
    {
        return $this->framework;
    }

    /**
     * @param string $framework
     */
    public function setFramework($framework)
    {
        $this->framework = $framework;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return array
     */
    public function getProdPackages()
    {
        return $this->prodPackages;
    }

    /**
     * @param array $prodPackages
     */
    public function setProdPackages(array $prodPackages)
    {
        $this->prodPackages = $prodPackages;
    }

    /**
     * @param Package $package
     */
    public function addProdPackage(Package $package)
    {
        $this->prodPackages[] = $package;
    }

    /**
     * @return array
     */
    public function getDevPackages()
    {
        return $this->devPackages;
    }

    /**
     * @param array $devPackages
     */
    public function setDevPackages(array $devPackages)
    {
        $this->devPackages = $devPackages;
    }

    /**
     * @param Package $package
     */
    public function addPackage(Package $package)
    {
        $this->devPackages[] = $package;
    }

    /**
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param string $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * @return string
     */
    public function getDownloadPath()
    {
        return $this->downloadPath;
    }

    /**
     * @param string $downloadPath
     */
    public function setDownloadPath($downloadPath)
    {
        $this->downloadPath = $downloadPath;
    }
}
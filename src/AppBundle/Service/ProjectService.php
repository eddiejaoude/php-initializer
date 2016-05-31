<?php
namespace AppBundle\Service;

use AppBundle\Domain\Project;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Class ProjectService
 * @package AppBundle\Service
 */
class ProjectService
{
    /**
     * @var string
     */
    private $tmp_path;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * ProjectService constructor.
     * @param Filesystem $filesystem
     * @param $tmp_path
     */
    public function __construct(Filesystem $filesystem, $tmp_path)
    {
        $this->filesystem = $filesystem;
        $this->tmp_path = $tmp_path;
    }

    /**
     * @param Project $project
     * @return string
     */
    public function create(Project $project)
    {
        // 1. down symfony phar
        $ownerPath = getcwd() . $this->tmp_path . DIRECTORY_SEPARATOR . $project->getOwner();
        $projectPath = $ownerPath . DIRECTORY_SEPARATOR . $project->getName();
        $symfony = $ownerPath . DIRECTORY_SEPARATOR . "symfony.phar";
        $this->filesystem->remove($projectPath);
        $this->filesystem->dumpFile(
            $symfony,
            file_get_contents("https://symfony.com/installer")
        );

        // 2. create project
        $process = new Process('cd ' . $ownerPath . "; php " . $symfony . " new " . $project->getName() . " " . $project->getVersion());
        $process->run();


        // 3. update composer.json
        $composer = json_decode(file_get_contents($projectPath . DIRECTORY_SEPARATOR . "composer.json"), true);
        $composer['name'] = $project->getOwner() . "/" . $project->getName();
        $composer['license'] = $project->getLicensing();
        file_put_contents(
            $projectPath . DIRECTORY_SEPARATOR . "composer.json",
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return $projectPath;
    }
}
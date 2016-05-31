<?php
namespace AppBundle\Service;

use Alchemy\Zippy\Zippy;
use AppBundle\Domain\Project;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

/**
 * Class PackageService
 * @package AppBundle\Service
 */
class PackageService
{

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * PackageService constructor.
     * @param ProjectService $projectService
     * @param Filesystem $filesystem
     */
    public function __construct(ProjectService $projectService, Filesystem $filesystem)
    {
        $this->projectService = $projectService;
        $this->filesystem = $filesystem;
    }

    /**
     * @param Project $project
     * @return Project
     * @throws \Exception
     */
    public function create(Project $project)
    {
        $log = '';

        // 1. create symfony project on cli with name & version
        $projectPath = $this->projectService->create($project);

        // 2. download composer
        $composer = $projectPath . DIRECTORY_SEPARATOR . 'composer-setup.php';
        $installer = file_get_contents("https://getcomposer.org/installer");
        $this->filesystem->dumpFile(
            $composer,
            $installer
        );
        if (hash_file('SHA384', $composer) !== '070854512ef404f16bac87071a6db9fd9721da1684cd4589b1196c3faf71b9a2682e2311b36a5079825e155ac7ce150d') {
            throw new \Exception('Composer download error');
        }
        $process = new Process('cd ' . $projectPath . "; php composer-setup.php");
        $process->run();
        unlink($composer);

        // 2. add dependencies
        foreach ($project->getProdPackages() as $package) {
            $process = new Process('cd ' . $projectPath . "; php composer.phar require " . $package);
            $process->run();
            $log .= PHP_EOL . $process->getErrorOutput() . PHP_EOL . $process->getOutput();
        }
        foreach ($project->getDevPackages() as $package) {
            $process = new Process('cd ' . $projectPath . "; php composer.phar require --dev " . $package);
            $process->run();
            $log .= PHP_EOL . $process->getErrorOutput() . PHP_EOL . $process->getOutput();
        }
        
        $project->setLog($log);

        // 4. create zip for link download
        $zippy = Zippy::load();
        $archivePath = $projectPath . DIRECTORY_SEPARATOR . '../' . $project->getName() . '.zip';
        $archive = $zippy->create($archivePath,
            array(
            $project->getName() => $projectPath
        ), true);

        return $project;
    }
}
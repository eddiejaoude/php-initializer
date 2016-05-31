<?php

namespace AppBundle\Controller;

use AppBundle\Domain\Project;
use AppBundle\Form\ProjectForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $path = $this->container->getParameter('tmp_path');
        $project = new Project();
        $form = $this->createForm(ProjectForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Project $project */
            $project = $this->get('app.service.package_service')
                ->create($form->getData());
        }

        return $this->render('default/index.html.twig',
            [
                'form' => $form->createView(),
                'log' => $project->getLog(),
                'download' => '/download/' . $project->getOwner() . '/' . $project->getName()
            ]
        );
    }

    /**
     * @Route("/download/{owner}/{project}", name="download")
     */
    public function downloadAction($owner, $project)
    {
        $path = getcwd() . $this->getParameter('tmp_path');
        $file = $path . DIRECTORY_SEPARATOR . $owner . DIRECTORY_SEPARATOR . $project . '.zip';

        if (empty($owner) || empty($project) || !file_exists($file)) {
            throw new \Exception('Invalid "Owner" or "Project"');
        }

        return new BinaryFileResponse($file);
    }
}

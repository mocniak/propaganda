<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\ImageService;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    public function articleAction($id)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $article = $articleService->getArticle(Uuid::fromString($id));
        return $this->render('default/article.html.twig', ['article' => $article]);
    }

    public function imageContentAction($id)
    {
        /** @var ImageService $imageService */
        $imageService = $this->container->get('propaganda.image');
        $imageFile = $imageService->getImageFile(UUID::fromString($id));
        $headers = ['Content-Type' => $imageFile->getMimeType()];
        return new Response($imageFile->getContent(), 200, $headers);
    }
}

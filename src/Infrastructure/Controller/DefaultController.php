<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\FeaturedArticlesService;
use Propaganda\Domain\ImageService;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /** @var FeaturedArticlesService $featuredArticlesService */
        $featuredArticlesService = $this->container->get('propaganda.featured_articles');
        $featuredArticles = $featuredArticlesService->getFeatured();
        $articles = $featuredArticlesService->getNotFeatured(10);

        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'featuredArticles' => $featuredArticles
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

<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\EventService;
use Propaganda\Domain\FeaturedArticlesService;
use Propaganda\Domain\ImageService;
use Propaganda\Domain\Repository\VideoRepositoryInterface;
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

        /** @var EventService $eventService */
        $eventService = $this->container->get('propaganda.event');
        $events = $eventService->getUpcoming(5);

        /** @var VideoRepositoryInterface $videoRepository */
        $videoRepository = $this->container->get('propaganda.video_repository');
        $videos = $videoRepository->getNewest(5);
        return $this->render('default/index.html.twig', [
            'articles' => $articles,
            'featuredArticles' => $featuredArticles,
            'events' => $events,
            'videos' => $videos
        ]);
    }

    public function articleAction(string $slug)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $article = $articleService->getArticleBySlug($slug);
        return $this->render('default/article.html.twig', ['article' => $article]);
    }

    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }


    public function aboutUsAction()
    {
        return $this->render('default/about_us.html.twig');
    }

    public function recentArticles($limit)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $articles = $articleService->getRecent((int)$limit);
        return $this->render('default/recent_articles_sidebar.html.twig', ['articles' => $articles]);
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

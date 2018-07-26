<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\Dto\EditArticleRequest;
use Propaganda\Domain\Dto\EditEventRequest;
use Propaganda\Domain\Dto\EditFeaturedArticlesRequest;
use Propaganda\Domain\Dto\NewArticleRequest;
use Propaganda\Domain\Dto\NewEventRequest;
use Propaganda\Domain\Dto\NewImageRequest;
use Propaganda\Domain\Dto\NewVideoRequest;
use Propaganda\Domain\Entity\Article\ContentInterface;
use Propaganda\Domain\Entity\Article\Image;
use Propaganda\Domain\Entity\Article\Text;
use Propaganda\Domain\Entity\Article\YoutubeVideo;
use Propaganda\Domain\EventService;
use Propaganda\Domain\FeaturedArticlesService;
use Propaganda\Domain\ImageService;
use Propaganda\Domain\Repository\ArticleRepositoryInterface;
use Propaganda\Domain\Repository\EventRepositoryInterface;
use Propaganda\Domain\Repository\ImageRepositoryInterface;
use Propaganda\Domain\Repository\VideoRepositoryInterface;
use Propaganda\Domain\VideoService;
use Propaganda\Infrastructure\FormType\CreateArticleType;
use Propaganda\Infrastructure\FormType\CreateEventType;
use Propaganda\Infrastructure\FormType\CreateImageType;
use Propaganda\Infrastructure\FormType\CreateVideoType;
use Propaganda\Infrastructure\FormType\EditEventType;
use Propaganda\Infrastructure\FormType\EditFeaturedArticlesType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function dashboardAction()
    {
        /** @var ArticleRepositoryInterface $articleRepository */
        $articleRepository = $this->container->get('propaganda.article_repository');
        $articles = $articleRepository->getNewest(20);
        /** @var EventRepositoryInterface $eventRepository */
        $eventRepository = $this->container->get('propaganda.event_repository');
        $events = $eventRepository->getUpcoming(20);
        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->container->get('propaganda.image_repository');
        $images = $imageRepository->getNewest(20);
        /** @var VideoRepositoryInterface $videoRepository */
        $videoRepository = $this->container->get('propaganda.video_repository');
        $videos = $videoRepository->getNewest(20);

        return $this->render('admin/dashboard.html.twig', [
            'articles' => $articles,
            'events' => $events,
            'images' => $images,
            'videos' => $videos
        ]);
    }

    public function createArticleAction(Request $request)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $newArticleRequest = new NewArticleRequest();

        $form = $this->createForm(CreateArticleType::class, $newArticleRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newArticleResponse = $articleService->addArticle($newArticleRequest);

            return $this->redirectToRoute('edit_article', ['id' => $newArticleResponse->id]);
        }

        return $this->render('admin/createArticle.html.twig', ['form' => $form->createView()]);
    }

    public function getArticleDataAction($id, Request $request)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $article = $articleService->getArticle(Uuid::fromString($id));

        $content = [];

        /** @var ContentInterface $item */
        foreach ($article->getContent() as $item) {
            $content[] = [
                'type' => $item->getType(),
                'value' => $item->getValue()
            ];
        }

        $data = [
            "title" => $article->getTitle(),
            "author" => $article->getAuthor(),
            "slug" => $article->getSlug(),
            "content" => $content,
            "coverImage" => $article->getCoverImageId() ? $article->getCoverImageId()->toString() : ''
        ];

        return new JsonResponse($data);
    }

    public function submitEditArticleAction($id, Request $request)
    {
        if ($request->getMethod() === "OPTIONS") return new Response('OPTIONS');

        $data = json_decode($request->getContent(), true);

        $content = [];

        foreach ($data['content'] as $item) {
            if ($item['type'] === 'text') {
                $contentItem = new Text($item['value']);
            } elseif ($item['type'] === 'video') {
                $contentItem = new YoutubeVideo($item['value']);
            } elseif ($item['type'] === 'image') {
                $contentItem = new Image(Uuid::fromString($item['value']));
            } else {
                continue;
            }
            $content[] = $contentItem;
        }
        $coverImageId = $data['coverImage'] ? Uuid::fromString($data['coverImage']) : null;

        $editArticleRequest = new EditArticleRequest(
            Uuid::fromString($id),
            $data['title'],
            $content,
            $coverImageId,
            $data['author'],
            $data['slug']
        );
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $response = $articleService->editArticle($editArticleRequest);

        return new Response((string)$response->success);
    }

    public function editArticlePageAction($id)
    {
        return $this->render('admin/editArticle.html.twig', ['articleId' => $id]);
    }

    public function createEventAction(Request $request)
    {
        /** @var EventService $eventService */
        $eventService = $this->container->get('propaganda.event');
        $newEventRequest = new NewEventRequest();

        $form = $this->createForm(CreateEventType::class, $newEventRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newEventResponse = $eventService->addEvent($newEventRequest);
            return $this->redirectToRoute('edit_event', ['id' => $newEventResponse->id]);
        }

        return $this->render('admin/createEvent.html.twig', ['form' => $form->createView()]);
    }

    public function editEventAction($id, Request $request)
    {
        /** @var EventService $eventService */
        $eventService = $this->container->get('propaganda.event');

        $event = $eventService->getEvent(Uuid::fromString($id));

        $editEventRequest = EditEventRequest::fromEvent($event);

        $form = $this->createForm(EditEventType::class, $editEventRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventService->editEvent($editEventRequest);
            return $this->redirectToRoute('edit_event', ['id' => $event->getId()->toString()]);
        }

        return $this->render('admin/editEvent.html.twig', ['form' => $form->createView()]);
    }

    public function createImageAction(Request $request)
    {
        /** @var ArticleService $articleService */
        $form = $this->createForm(CreateImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            $content = (file_get_contents($uploadedFile->getRealPath()));
            $mimeType = $uploadedFile->getClientMimeType();

            $newImageRequest = new NewImageRequest($mimeType, $content, $form['description']->getData());

            /** @var ImageService $imageService */
            $imageService = $this->container->get('propaganda.image');
            $imageService->addImage($newImageRequest);

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/createArticle.html.twig', ['form' => $form->createView()]);
    }

    public function createVideoAction(Request $request)
    {
        /** @var VideoService $videoService */
        $videoService = $this->container->get('propaganda.video');
        $videoService->addEmptyVideo();

        return $this->redirectToRoute('edit_video',/* here! */);
    }

    public function editVideoAction(Request $request)
    {
        /** @var ArticleService $articleService */
        $form = $this->createForm(CreateVideoType::class);
        $newVideoRequest = new NewVideoRequest();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var VideoService $videoService */
            $videoService = $this->container->get('propaganda.video');
            $videoService->addVideo($newVideoRequest);

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('admin/addVideo.html.twig', ['form' => $form->createView()]);
    }

    public function editFeaturedArticlesAction(Request $request)
    {
        /** @var FeaturedArticlesService $featuredArticlesService */
        $featuredArticlesService = $this->container->get('propaganda.featured_articles');
        $featuredArticlesIds = $featuredArticlesService->getFeaturedArticlesIds();
        $editFeaturedArticlesRequest = new EditFeaturedArticlesRequest($featuredArticlesIds->getAll());
        $form = $this->createForm(EditFeaturedArticlesType::class, $editFeaturedArticlesRequest);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $featuredArticlesService->editFeaturedArticles($editFeaturedArticlesRequest);
        }
        return $this->render('admin/editFeatured.html.twig', ['form' => $form->createView()]);
    }
}
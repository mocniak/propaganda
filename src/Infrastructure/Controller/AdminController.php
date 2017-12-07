<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\Dto\EditArticleRequest;
use Propaganda\Domain\Dto\NewArticleRequest;
use Propaganda\Domain\Dto\NewImageRequest;
use Propaganda\Domain\Entity\Article\ContentInterface;
use Propaganda\Domain\Entity\Article\Image;
use Propaganda\Domain\Entity\Article\Text;
use Propaganda\Domain\Entity\Article\YoutubeVideo;
use Propaganda\Domain\ImageService;
use Propaganda\Infrastructure\FormType\CreateArticleType;
use Propaganda\Infrastructure\FormType\CreateImageType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
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
            "content" => $content
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

        $editArticleRequest = new EditArticleRequest(Uuid::fromString($id), $data['title'], $content);
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $response = $articleService->editArticle($editArticleRequest);

        return new Response((string)$response->success);
    }

    public function editArticlePageAction($id)
    {
        return $this->render('admin/editArticle.html.twig', ['articleId' => $id]);
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
            $response = $imageService->addImage($newImageRequest);
            return new Response(var_dump($response));
        }
        return $this->render('admin/createArticle.html.twig', ['form' => $form->createView()]);
    }
}
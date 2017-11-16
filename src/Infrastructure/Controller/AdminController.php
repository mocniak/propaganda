<?php

namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\Dto\EditArticleRequest;
use Propaganda\Domain\Dto\NewArticleRequest;
use Propaganda\Infrastructure\Type\CreateArticleType;
use Propaganda\Infrastructure\Type\EditArticleType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
            $newArticleRequest = $form->getData();
            $newArticleResponse = $articleService->addArticle($newArticleRequest);
            return new Response(var_dump($newArticleResponse));
        }
        return $this->render('admin/createArticle.html.twig', ['form' => $form->createView()]);
    }

    public function editArticleAction($id, Request $request)
    {
        /** @var ArticleService $articleService */
        $articleService = $this->container->get('propaganda.article');
        $article = $articleService->getArticle(Uuid::fromString($id));
        $editArticleRequest = EditArticleRequest::fromArticle($article);

        $form = $this->createForm(
            EditArticleType::class,
            $editArticleRequest, [
            'action' => $this->generateUrl('submit_edit_article')
        ]);

        return $this->render('admin/editArticle.html.twig', ['form' => $form->createView()]);
    }

    public function submitEditArticleAction(Request $request)
    {
        $form = $this->createForm(EditArticleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newArticleRequest = $form->getData();
            /** @var ArticleService $articleService */
            $articleService = $this->container->get('propaganda.article');
            $editArticleResponse = $articleService->editArticle($newArticleRequest);
            return new Response(var_dump($editArticleResponse));
        }
        return new Response('ok');
    }
}
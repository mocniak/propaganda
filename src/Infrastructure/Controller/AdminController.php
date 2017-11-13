<?php
namespace Propaganda\Infrastructure\Controller;

use Propaganda\Domain\ArticleService;
use Propaganda\Domain\Dto\NewArticleRequest;
use Propaganda\Infrastructure\Type\CreateArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function createArticleAction(Request $request) {
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
        return $this->render('admin/createArticle.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function editArticleAction(Request $request) {
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
        return $this->render('admin/createArticle.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
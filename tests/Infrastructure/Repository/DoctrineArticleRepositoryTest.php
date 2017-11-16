<?php

namespace Tests\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use Propaganda\Domain\Entity\Article;
use Propaganda\Domain\Entity\Article\Text;
use Propaganda\Infrastructure\Repository\DoctrineArticleRepository;
use Ramsey\Uuid\Uuid;

class DoctrineArticleRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->repository = new DoctrineArticleRepository();
    }

    public function testRepositoryStoresArticle() {
        $article = new Article(
            'some-title',
            [
                new Text('<p>Some text since it is a common value object</p>'),
                new Article\Image(Uuid::uuid4()),
                new Text('<p>Some more text.</p>')
            ]
        );

    }
}

<?php

use function DI\object;
use Doctrine\DBAL\Connection;
use SuperBlog\Model\ArticleRepository;
use SuperBlog\Persistence\InMemoryArticleRepository;
use SuperBlog\Provider\CustomSchemaProvider;

return [
    // Bind an interface to an implementation
    ArticleRepository::class => object(\SuperBlog\Persistence\DatabaseArticleRepository::class),

    // Configure Twig
    Twig_Environment::class  => function () {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../src/SuperBlog/Views');
        return new Twig_Environment($loader);
    },

    'db.url' => 'sqlite:///' . __DIR__ . '/db.sqlite3',

    //'db.url' => 'mysql://root:root@localhost/di-demo?charset=utf8',

    Connection::class => function (\DI\Container $container) {
        $config           = new \Doctrine\DBAL\Configuration();
        $connectionParams = ['url' => $container->get('db.url')];
        return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
    }
];

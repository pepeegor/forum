<?php

use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\Promise\PromiseInterface;

require_once 'forum_simulator.php';

class ForumSimulatorTest extends TestCase
{
    private $loop;

    protected function setUp(): void
    {
        $this->loop = Factory::create();
    }

    public function testCreateForum()
    {
        $simulator = new ForumSimulator($this->loop);
        $result = $simulator->createForum('Тестовый раздел', 'Описание');
        $this->assertTrue($result);
        $this->assertCount(1, $simulator->getForums());
        $this->assertEquals('Тестовый раздел', $simulator->getForums()[0]['name']);
        $this->assertEquals('Описание', $simulator->getForums()[0]['description']);
    }

    public function testCreateTopic()
    {
        $simulator = new ForumSimulator($this->loop);
        $simulator->createForum('Тестовый раздел', 'Описание');
        $result = $simulator->createTopic(1, 'Тестовая тема');
        $this->assertTrue($result);
        $this->assertCount(1, $simulator->getTopics());
        $this->assertEquals(1, $simulator->getTopics()[0]['forum_id']);
        $this->assertEquals('Тестовая тема', $simulator->getTopics()[0]['title']);
    }

    public function testCreatePost()
    {
        $simulator = new ForumSimulator($this->loop);
        $simulator->createForum('Тестовый раздел', 'Описание');
        $simulator->createTopic(1, 'Тестовая тема');
        $result = $simulator->createPost(1, 'Тестовое сообщение');
        $this->assertTrue($result);
        $this->assertCount(1, $simulator->getPosts());
        $this->assertEquals(1, $simulator->getPosts()[0]['topic_id']);
        $this->assertEquals('Тестовое сообщение', $simulator->getPosts()[0]['content']);
        $this->assertEquals(0, $simulator->getPosts()[0]['likes']);
    }

    public function testAddLike()
    {
        $simulator = new ForumSimulator($this->loop);
        $simulator->createForum('Тестовый раздел', 'Описание');
        $simulator->createTopic(1, 'Тестовая тема');
        $simulator->createPost(1, 'Тестовое сообщение');

        $promise = $simulator->addLike(1);

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        $promise->then(function ($result) {
            $this->assertEquals(['likes' => 1], $result);
        });

        $this->loop->run();
    }

    public function testAddDislike()
    {
        $simulator = new ForumSimulator($this->loop);
        $simulator->createForum('Тестовый раздел', 'Описание');
        $simulator->createTopic(1, 'Тестовая тема');
        $simulator->createPost(1, 'Тестовое сообщение');

        $promise = $simulator->addDislike(1);

        $this->assertInstanceOf(PromiseInterface::class, $promise);

        $promise->then(function ($result) {
            $this->assertEquals(['likes' => -1], $result);
        });

        $this->loop->run();
    }
}
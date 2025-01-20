<?php

use PHPUnit\Framework\TestCase;
require_once 'forum_simulator.php';

class ForumSimulatorTest extends TestCase
{
    public function testCreateForum()
    {
        $simulator = new ForumSimulator();
        $result = $simulator->createForum('Тестовый раздел', 'Описание');
        $this->assertTrue($result);
        $this->assertCount(1, $simulator->getForums());
        $this->assertEquals('Тестовый раздел', $simulator->getForums()[0]['name']);
        $this->assertEquals('Описание', $simulator->getForums()[0]['description']);
    }

    public function testCreateTopic()
    {
        $simulator = new ForumSimulator();
        $simulator->createForum('Тестовый раздел', 'Описание');
        $result = $simulator->createTopic(1, 'Тестовая тема');
        $this->assertTrue($result);
        $this->assertCount(1, $simulator->getTopics());
        $this->assertEquals(1, $simulator->getTopics()[0]['forum_id']);
        $this->assertEquals('Тестовая тема', $simulator->getTopics()[0]['title']);
    }

    public function testCreatePost()
    {
        $simulator = new ForumSimulator();
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
        $simulator = new ForumSimulator();
        $simulator->createForum('Тестовый раздел', 'Описание');
        $simulator->createTopic(1, 'Тестовая тема');
        $simulator->createPost(1, 'Тестовое сообщение');
        $result = $simulator->addLike(1);
        $this->assertEquals(['likes' => 1], $result);
    }

    public function testAddDislike()
    {
        $simulator = new ForumSimulator();
        $simulator->createForum('Тестовый раздел', 'Описание');
        $simulator->createTopic(1, 'Тестовая тема');
        $simulator->createPost(1, 'Тестовое сообщение');
        $result = $simulator->addDislike(1);
        $this->assertEquals(['likes' => -1], $result);
    }
}
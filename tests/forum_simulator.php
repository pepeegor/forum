<?php

class ForumSimulator
{

    private array $forums = [];
    private array $topics = [];
    private array $posts = [];

    public function createForum(string $name, string $description): bool
    {
        $this->forums[] = [
            'id' => count($this->forums) + 1,
            'name' => $name,
            'description' => $description,
        ];
        return true;
    }

    public function createTopic(int $forumId, string $title): bool
    {
        $this->topics[] = [
            'id' => count($this->topics) + 1,
            'forum_id' => $forumId,
            'title' => $title,
        ];
        return true;
    }

    public function createPost(int $topicId, string $content): bool
    {
        $this->posts[] = [
            'id' => count($this->posts) + 1,
            'topic_id' => $topicId,
            'content' => $content,
            'likes' => 0,
        ];
        return true;
    }

    public function addLike(int $postId): array
    {
        foreach ($this->posts as &$post) {
            if ($post['id'] === $postId) {
                $post['likes']++;
                return ['likes' => $post['likes']];
            }
        }
        return ['error' => 'Сообщение не найдено'];
    }

    public function addDislike(int $postId): array
    {
        foreach ($this->posts as &$post) {
            if ($post['id'] === $postId) {
                $post['likes']--;
                return ['likes' => $post['likes']];
            }
        }
        return ['error' => 'Сообщение не найдено'];
    }

    // Getters для доступа к данным форума (для проверок в тестах)
    public function getForums(): array
    {
        return $this->forums;
    }

    public function getTopics(): array
    {
        return $this->topics;
    }

    public function getPosts(): array
    {
        return $this->posts;
    }
}
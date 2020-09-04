<?php

namespace MVC\model;

use MVC\services\Db;

class News extends ActiveRecordEntity
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $slug;

    /** @var int */
    protected $status;

    /** @var int */
    protected $date;

    /** @var string */
    protected $content;

    /** @var string */
    protected $image;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    protected static function getTableName(): string
    {
        return 'news';
    }
}

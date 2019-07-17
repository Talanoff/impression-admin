<?php


namespace Talanoff\ImpressionAdmin\Helpers;


class Breadcrumb
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $link;

    /**
     * Breadcrumb constructor.
     * @param  string  $name
     * @param  null  $link
     */
    public function __construct(string $name, $link = null)
    {
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * @return object
     */
    public function create()
    {
        return (object) [
            'name' => $this->name,
            'link' => $this->link
        ];
    }
}
<?php

namespace BlockReassurance;

class ImageURLProvider
{
    private $linkGenerator;

    /** @var string */
    private $name;

    /**
     * @param $linkGenerator
     * @param string $name
     */
    public function __construct($linkGenerator, $name)
    {
        $this->linkGenerator = $linkGenerator;
        $this->name = $name;
    }

    /**
     * @param string $image
     *
     * @return string
     */
    public function getImageURL($image)
    {
        return $this->linkGenerator->getMediaLink(__PS_BASE_URI__ . 'modules/' . $this->name . '/img/' . $image);
    }
}
<?php

namespace Hladenkyi\Editor;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Storable;

class Editor extends Field
{
    use Storable;

    public $component = 'editor';

    public function __construct(string $name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute);
        $this->resolveCallback = $resolveCallback;

        $this->disk($this->getDefaultStorageDisk());
        $this->path($this->getStorageDir());

        $this->autoDeleteImages();

        $this->hideFromIndex();

        $this->withMeta([
            'options' => config('tiny-editor', []),
        ]);
    }


    public function autoDeleteImages(bool $deleteImage = true): static
    {
        $this->deleteImages = $deleteImage;

        $this->withMeta(
            ['autoDeleteImage' => $deleteImage]
        );

        return $this;
    }
}

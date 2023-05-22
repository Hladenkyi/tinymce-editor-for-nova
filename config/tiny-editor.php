<?php

return [
    'init' => [
        'menubar' => false,
        'autoresize_bottom_margin' => 40,
        'branding' => false,
        'image_caption' => true,
        'paste_as_text' => true,
        'autosave_interval' => '20s',
        'autosave_retention' => '30m',
        'contextmenu' => false,
        'file_picker_types' => 'image',
        'image_dimensions' => false,
        'relative_urls' => false,
        'remove_script_host' => false,
        'document_base_url' => env('APP_URL'),
        'image_class_list' => [
            ['title' => 'None', 'value' => ''],
            ['title' => 'Обкладинка', 'value' => 'stretched'],
        ],
    ],
    'plugins' => [
        'advlist',
        'anchor',
        'autolink',
        'autosave',
        'lists',
        'link',
        'image',
        'media',
        'table',
        'code',
        'preview',
        'wordcount',
        'autoresize',
    ],
    'toolbar' => [
        'styles h2 | bold italic underline strikethrough blockquote | image |
                 align bullist numlist outdent indent | link anchor table | code preview |
                 undo redo restoredraft',
    ],
    'apiKey' => env('TINYMCE_API_KEY', ''),
];

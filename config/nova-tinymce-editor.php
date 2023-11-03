<?php

return [
    'cloudChannel' => '6', // 5 or 6

    /**
     * Get your API key at https://www.tiny.cloud and put it here or in your .env file
     */
    'apiKey' => env('TINYMCE_API_KEY', ''),

    /**
     * The default skin to use.
     */
    'skin' => 'oxide-dark',

    /**
     * The default options to send to the editor.
     * See https://www.tiny.cloud/docs/configure/ for all available options (check for 5 or 6 version).
     */
    'init' => [
        'menubar' => false,
        'autoresize_bottom_margin' => 40,
        'branding' => false,
        'image_caption' => true,
        'paste_as_text' => true,
        'autosave_interval' => '20s',
        'autosave_retention' => '30m',
        'browser_spellcheck' => true,
        'contextmenu' => false,
        'images_upload_url' => '/media/blog/upload',
    ],
    'plugins' => [
        'advlist',
        'anchor',
        'autolink',
        'autosave',
        'fullscreen',
        'lists',
        'link',
        'image',
        'media',
        'table',
        'code',
        'wordcount',
        'autoresize',
        'codesample'
    ],
    'toolbar' => [ 
        'undo redo restoredraft | h2 h3 h4 |
        bold italic underline strikethrough blockquote removeformat |
        align bullist numlist outdent indent | image media link anchor table | code mceInsertRawHTML fullscreen spoiler | cut copy paste | ToggleSidebar codesample',
    ],

    /**
     * Extra configurations for the editor.
     */
    'extra' => [
        'upload_images' => [
            'enabled' => true, // Set true for enable images local upload
            'folder' => 'images',
            'maxSize' => 2048, // KB
        ],
    ],
];

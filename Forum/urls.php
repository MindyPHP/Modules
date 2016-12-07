<?php

return [
    '/' => [
        'name' => 'index',
        'callback' => '\Modules\Forum\Controllers\ForumController:index'
    ],
    '/{pk:\d+}-{slug:[A-Za-z0-9-]+}' => [
        'name' => 'forum',
        'callback' => '\Modules\Forum\Controllers\ForumController:forum'
    ],

    '/{pk:\d+}-{slug:[A-Za-z0-9-]+}/{id:\d+}' => [
        'name' => 'topic',
        'callback' => '\Modules\Forum\Controllers\TopicController:view'
    ],
    '/topic-add/{pk:\d+}-{slug:[A-Za-z0-9-]+}' => [
        'name' => 'topic_add',
        'callback' => '\Modules\Forum\Controllers\TopicController:add'
    ],
    '/topic/update/{pk:\d+}' => [
        'name' => 'topic_update',
        'callback' => '\Modules\Forum\Controllers\TopicController:update'
    ],
    '/topic/delete/{pk:\d+}' => [
        'name' => 'topic_delete',
        'callback' => '\Modules\Forum\Controllers\TopicController:delete'
    ],

    '/post/update/{pk:\d+}' => [
        'name' => 'post_update',
        'callback' => '\Modules\Forum\Controllers\PostController:update'
    ],
    '/post/delete/{pk:\d+}' => [
        'name' => 'post_delete',
        'callback' => '\Modules\Forum\Controllers\PostController:delete'
    ],
    '/post/reply/{pk:\d+}-{slug:[A-Za-z0-9-]+}/{id:\d+}' => [
        'name' => 'topic_reply',
        'callback' => '\Modules\Forum\Controllers\PostController:reply'
    ],
    '/attachment/upload' => [
        'name' => 'attachment_upload',
        'callback' => '\Modules\Forum\Controllers\AttachmentController:upload'
    ],
    '/new_threads' => [
        'name' => 'new_threads',
        'callback' => '\Modules\Forum\Controllers\TopicController:newThreads'
    ],
    '/go' => [
        'name' => 'go',
        'callback' => '\Modules\Forum\Controllers\GoController:go'
    ]
];

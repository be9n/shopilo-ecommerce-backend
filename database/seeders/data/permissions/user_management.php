<?php


return [
    'name' => 'user_management',
    'title' => 'User Management',
    'description' => 'All permissions related to user management.',
    'children' => [
        [
            'name' => 'user_management.users',
            'title' => 'Users',
            'description' => 'All permissions related to managing users.',
            'children' => [
                [
                    'name' => 'user_management.users.view_all',
                    'title' => 'View All',
                    'description' => 'View all users in the system.',
                ],
                [
                    'name' => 'user_management.users.view',
                    'title' => 'View',
                    'description' => 'View a single user\'s details.',
                ],
                [
                    'name' => 'user_management.users.create',
                    'title' => 'Create',
                    'description' => 'Create new user accounts.',
                ],
                [
                    'name' => 'user_management.users.edit',
                    'title' => 'Edit',
                    'description' => 'Edit existing user accounts.',
                ],
                [
                    'name' => 'user_management.users.delete',
                    'title' => 'Delete',
                    'description' => 'Delete user accounts.',
                ],
            ],
        ],
        [
            'name' => 'user_management.roles',
            'title' => 'Roles',
            'description' => 'All permissions related to managing roles.',
            'children' => [
                [
                    'name' => 'user_management.roles.view_all',
                    'title' => 'View All',
                    'description' => 'View all roles in the system.',
                ],
                [
                    'name' => 'user_management.roles.view',
                    'title' => 'View',
                    'description' => 'View a single role\'s details.',
                ],
                [
                    'name' => 'user_management.roles.create',
                    'title' => 'Create',
                    'description' => 'Create new role.',
                ],
                [
                    'name' => 'user_management.roles.edit',
                    'title' => 'Edit',
                    'description' => 'Edit existing role.',
                ],
                [
                    'name' => 'user_management.roles.delete',
                    'title' => 'Delete',
                    'description' => 'Delete role.',
                ],
            ],
        ],
    ],
];

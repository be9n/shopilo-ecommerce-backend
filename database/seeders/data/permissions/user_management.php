<?php

return [
    // Group-level permission
    [
        'name' => 'user_management',
        'title' => 'User Management',
        'group' => 'user_management',
        'section' => 'user_management',
        'description' => 'All permissions related to user management.'
    ],

    // Sub-group: Users
    [
        'name' => 'user_management.users',
        'title' => 'Users',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'All permissions related to managing users.'
    ],
    [
        'name' => 'user_management.users.view_all',
        'title' => 'View All',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'View all users in the system.'
    ],
    [
        'name' => 'user_management.users.view',
        'title' => 'View',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'View a single user\'s details.'
    ],
    [
        'name' => 'user_management.users.create',
        'title' => 'Create',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'Create new user accounts.'
    ],
    [
        'name' => 'user_management.users.edit',
        'title' => 'Edit',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'Edit existing user accounts.'
    ],
    [
        'name' => 'user_management.users.delete',
        'title' => 'Delete',
        'group' => 'users',
        'section' => 'user_management',
        'description' => 'Delete user accounts.'
    ],

    // Sub-group: Roles
    [
        'name' => 'user_management.roles',
        'title' => 'Roles',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'All permissions related to managing roles.'
    ],
    [
        'name' => 'user_management.roles.view_all',
        'title' => 'View All',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'View all roles in the system.'
    ],
    [
        'name' => 'user_management.roles.view',
        'title' => 'View',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'View a single role\'s details.'
    ],
    [
        'name' => 'user_management.roles.create',
        'title' => 'Create',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'Create new role.'
    ],
    [
        'name' => 'user_management.roles.edit',
        'title' => 'Edit',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'Edit existing role.'
    ],
    [
        'name' => 'user_management.roles.delete',
        'title' => 'Delete',
        'group' => 'roles',
        'section' => 'user_management',
        'description' => 'Delete role.'
    ],
];

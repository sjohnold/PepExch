<?php

return [

    // 1. User Management
    [
        'name' => 'User Management',
        'permissions' => [
            [
                'title' => 'View Users',
                'permission' => 'users.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'View Trash Users',
                'permission' => 'users.trash',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update User Status',
                'permission' => 'users.updateStatus',
                'role' => ['Admin']
            ],

            [
                'title' => 'View User Review',
                'permission' => 'users.review',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update User Review',
                'permission' => 'users.updateReview',
                'role' => ['Admin']
            ],
        ],
    ],

    // Dashboard
    [
        'name' => 'Dashboard',
        'permissions' => [
            [
                'title' => 'View Dashboard',
                'permission' => 'dashboard.view',
                'role' => ['Admin']
            ],
        ],
    ],

    // General Settings
    [
        'name' => 'General Settings',
        'permissions' => [
            [
                'title' => 'View General Settings',
                'permission' => 'general-settings.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Logo',
                'permission' => 'general-settings.update.logo',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Fabicon',
                'permission' => 'general-settings.update.fabicon',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Footer Logo',
                'permission' => 'general-settings.update.footerlogo',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Additional Settings',
                'permission' => 'general-settings.update.additional',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Social Links',
                'permission' => 'general-settings.update.social-links',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Download Links',
                'permission' => 'general-settings.update.downloadlink',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Mail Settings',
                'permission' => 'general-settings.update.mail',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update SMS Settings',
                'permission' => 'general-settings.update.sms',
                'role' => ['Admin']
            ],
        ],
    ],

    // Business Settings
    [
        'name' => 'Business Settings',
        'permissions' => [
            [
                'title' => 'View Business Settings',
                'permission' => 'business-settings.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Business Settings',
                'permission' => 'business-settings.update',
                'role' => ['Admin']
            ],
        ],
    ],

    // Security and Policy
    [
        'name' => 'Security and Policy',
        'permissions' => [
            [
                'title' => 'View Policy',
                'permission' => 'policy.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Policy',
                'permission' => 'policy.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Policy',
                'permission' => 'policy.update',
                'role' => ['Admin']
            ],
        ],
    ],


    // 2. Selling Post Management
    [
        'name' => 'Selling Post Management',
        'permissions' => [
            [
                'title' => 'View Posts',
                'permission' => 'posts.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'View Trash Posts',
                'permission' => 'posts.trash',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Post',
                'permission' => 'posts.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Post',
                'permission' => 'posts.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Post Status',
                'permission' => 'posts.updateStatus',
                'role' => ['Admin']
            ],
        ],
    ],

    // 3. Role Management
    [
        'name' => 'Roles Management',
        'permissions' => [
            [
                'title' => 'View Roles',
                'permission' => 'roles.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Role',
                'permission' => 'roles.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Role',
                'permission' => 'roles.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Role',
                'permission' => 'roles.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Role',
                'permission' => 'roles.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Role',
                'permission' => 'roles.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Role',
                'permission' => 'roles.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 4. Boost Plan Management
    [
        'name' => 'Boost Plan Management',
        'permissions' => [
            [
                'title' => 'View Boost Plans',
                'permission' => 'plans.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Boost Plan',
                'permission' => 'plans.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Boost Plan',
                'permission' => 'plans.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Boost Plan',
                'permission' => 'plans.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Boost Plan',
                'permission' => 'plans.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Boost Plan',
                'permission' => 'plans.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Boost Plan',
                'permission' => 'plans.destroy',
                'role' => ['Admin']
            ],
            [
                'title' => 'View Sold Boost Plans',
                'permission' => 'plans.sold',
                'role' => ['Admin']
            ],
            [
                'title' => 'View Boost Plan Trash',
                'permission' => 'plans.trash',
                'role' => ['Admin']
            ],
        ],
    ],

    // 5. Transaction Management
    [
        'name' => 'Transaction Management',
        'permissions' => [
            [
                'title' => 'View Transactions',
                'permission' => 'transactions.index',
                'role' => ['Admin']
            ],
        ],
    ],

    // 6. Category Management
    [
        'name' => 'Category Management',
        'permissions' => [
            [
                'title' => 'View Categories',
                'permission' => 'category.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Category',
                'permission' => 'category.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Category',
                'permission' => 'category.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Category',
                'permission' => 'category.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Category',
                'permission' => 'category.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Category',
                'permission' => 'category.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Category',
                'permission' => 'category.destroy',
                'role' => ['Admin']
            ],
            [
                'title' => 'Toggle Category Status',
                'permission' => 'category.toggleStatus',
                'role' => ['Admin']
            ],
        ],
    ],

    // 7. Color Management
    [
        'name' => 'Color Management',
        'permissions' => [
            [
                'title' => 'View Colors',
                'permission' => 'colors.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Color',
                'permission' => 'colors.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Color',
                'permission' => 'colors.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Color',
                'permission' => 'colors.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Color',
                'permission' => 'colors.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Color',
                'permission' => 'colors.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Color',
                'permission' => 'colors.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 8. Attribute Management
    [
        'name' => 'Attribute Management',
        'permissions' => [
            [
                'title' => 'View Attributes',
                'permission' => 'attributes.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Attribute',
                'permission' => 'attributes.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Attribute',
                'permission' => 'attributes.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Attribute',
                'permission' => 'attributes.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Attribute',
                'permission' => 'attributes.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Attribute',
                'permission' => 'attributes.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Attribute',
                'permission' => 'attributes.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 9. Banner Management
    [
        'name' => 'Banner Management',
        'permissions' => [
            [
                'title' => 'View Banners',
                'permission' => 'banners.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Banner',
                'permission' => 'banners.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Banner',
                'permission' => 'banners.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Banner',
                'permission' => 'banners.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Banner',
                'permission' => 'banners.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Banner',
                'permission' => 'banners.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Banner',
                'permission' => 'banners.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 10. Theme Management
    [
        'name' => 'Theme Management',
        'permissions' => [
            [
                'title' => 'View Theme',
                'permission' => 'theme.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Theme',
                'permission' => 'theme.update',
                'role' => ['Admin']
            ],
        ],
    ],

    // 11. Legal Page Management
    [
        'name' => 'Legal Page Management',
        'permissions' => [
            [
                'title' => 'View Legal Pages',
                'permission' => 'legal.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Legal Page',
                'permission' => 'legal.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Legal Page',
                'permission' => 'legal.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Legal Page',
                'permission' => 'legal.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Legal Page',
                'permission' => 'legal.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Legal Page',
                'permission' => 'legal.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 12. Testimonial Management
    [
        'name' => 'Testimonial Management',
        'permissions' => [
            [
                'title' => 'View Testimonials',
                'permission' => 'testimonials.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Testimonial',
                'permission' => 'testimonials.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Testimonial',
                'permission' => 'testimonials.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Testimonial',
                'permission' => 'testimonials.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Testimonial',
                'permission' => 'testimonials.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Testimonial',
                'permission' => 'testimonials.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Testimonial',
                'permission' => 'testimonials.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 13. Service Management
    [
        'name' => 'Service Management',
        'permissions' => [
            [
                'title' => 'View Services',
                'permission' => 'services.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Service',
                'permission' => 'services.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Service',
                'permission' => 'services.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Service',
                'permission' => 'services.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Service',
                'permission' => 'services.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Service',
                'permission' => 'services.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 14. Language Management
    [
        'name' => 'Language Management',
        'permissions' => [
            [
                'title' => 'View Languages',
                'permission' => 'languages.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Language',
                'permission' => 'languages.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Language',
                'permission' => 'languages.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Language',
                'permission' => 'languages.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Language',
                'permission' => 'languages.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Language',
                'permission' => 'languages.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 15. Brand Management
    [
        'name' => 'Brand Management',
        'permissions' => [
            [
                'title' => 'View Brands',
                'permission' => 'brand.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Brand',
                'permission' => 'brand.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Brand',
                'permission' => 'brand.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Brand',
                'permission' => 'brand.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Brand',
                'permission' => 'brand.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Brand',
                'permission' => 'brand.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Brand',
                'permission' => 'brand.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 16. Announcement Management
    [
        'name' => 'Announcement Management',
        'permissions' => [
            [
                'title' => 'View Announcements',
                'permission' => 'announcements.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Announcement',
                'permission' => 'announcements.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Announcement',
                'permission' => 'announcements.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Announcement',
                'permission' => 'announcements.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Announcement',
                'permission' => 'announcements.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Announcement',
                'permission' => 'announcements.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Announcement',
                'permission' => 'announcements.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

    // 17. Contact / Support Management
    [
        'name' => 'Contact / Support Management',
        'permissions' => [
            [
                'title' => 'View Contacts',
                'permission' => 'contact.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Show Contact',
                'permission' => 'contact.show',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Contact',
                'permission' => 'contact.destroy',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Contact',
                'permission' => 'contact.store',
                'role' => ['Admin']
            ],
        ],
    ],


    // 18. Fast Selling Management
    [
        'name' => 'Fast Selling Management',
        'permissions' => [
            [
                'title' => 'View Fast Selling',
                'permission' => 'fast-selling.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Fast Selling',
                'permission' => 'fast-selling.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Fast Selling',
                'permission' => 'fast-selling.update',
                'role' => ['Admin']
            ],
        ],
    ],

    // 19. Payment Gateway Management
    [
        'name' => 'Payment Gateway Management',
        'permissions' => [
            [
                'title' => 'View Payment Gateways',
                'permission' => 'payment-gateways.index',
                'role' => ['Admin']
            ],
            [
                'title' => 'Create Payment Gateway',
                'permission' => 'payment-gateways.create',
                'role' => ['Admin']
            ],
            [
                'title' => 'Store Payment Gateway',
                'permission' => 'payment-gateways.store',
                'role' => ['Admin']
            ],
            [
                'title' => 'Edit Payment Gateway',
                'permission' => 'payment-gateways.edit',
                'role' => ['Admin']
            ],
            [
                'title' => 'Update Payment Gateway',
                'permission' => 'payment-gateways.update',
                'role' => ['Admin']
            ],
            [
                'title' => 'Delete Payment Gateway',
                'permission' => 'payment-gateways.destroy',
                'role' => ['Admin']
            ],
        ],
    ],

];

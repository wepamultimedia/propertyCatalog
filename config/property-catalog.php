<?php

// config for Wepa/PropertyCatalog
return [
    'routes' => [
        'categories_slug_prefix' => [],
        'properties_slug_prefix' => [],
    ],
    'backend_menu' => [
        [
            'label' => 'en:Properties|es:Propiedades',
            'icon' => 'office-building',
            'route' => '#',
            'active' => 'admin.property_catalog*',
            'can' => 'admin.auth',
            'children' => [
                [
                    'label' => 'en:Types|es:Tipos',
                    'route' => 'admin.property_catalog.types.index',
                    'active' => 'admin.property_catalog.types*',
                    'can' => 'admin.auth',
                ],
                [
                    'label' => 'en:Categories|es:Categorías',
                    'route' => 'admin.property_catalog.categories.index',
                    'active' => 'admin.property_catalog.categories*',
                    'can' => 'admin.auth',
                ],
                [
                    'label' => 'en:Properties|es:Propiedades',
                    'route' => 'admin.property_catalog.properties.index',
                    'active' => 'admin.property_catalog.properties*',
                    'can' => 'admin.auth',
                ],
            ],
        ],
    ],
];

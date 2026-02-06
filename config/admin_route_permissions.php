<?php

/**
 * Maps admin route name prefixes to permission keys (from admin_permissions).
 * If a route matches a key here, the user must have that permission (unless full access).
 * Routes not listed (e.g. dashboard, profile) are allowed for any admin.
 */
return [
    'adminpages.users' => 'manage_users',
    'adminpages.motels' => 'manage_motels',
    'adminpages.amenities' => 'manage_amenities',
    'adminpages.bnb-rules' => 'manage_bnb_rules',
    'adminpages.countries' => 'manage_countries',
    'adminpages.regions' => 'manage_regions',
    'adminpages.districts' => 'manage_districts',
    'adminpages.motel-types' => 'manage_motel_types',
    'adminpages.room-types' => 'manage_room_types',
    'adminpages.customers' => 'manage_customers',
    'adminpages.contact-messages' => 'manage_contact_messages',
    'adminpages.chats' => 'manage_chats',
    'adminpages.terms-of-service' => 'manage_terms_of_service',
];

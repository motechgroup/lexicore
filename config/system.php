<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Installer Settings
    |--------------------------------------------------------------------------
    |
    | Controls whether the web installer is enabled. Once the product is
    | successfully configured, this will be set to false.
    |
    */
    'installer_completed' => env('LEXCORE_INSTALLER_COMPLETED', false),

    /*
    |--------------------------------------------------------------------------
    | System Version
    |--------------------------------------------------------------------------
    |
    | The current version of the LexCore application. Used for verifying
    | update compatibility.
    |
    */
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | General Metadata
    |--------------------------------------------------------------------------
    |
    | Basic credentials and details for the law firm system, managed during
    | installation and updated through system settings.
    |
    */
    'firm_name' => env('LEXCORE_FIRM_NAME', 'LexCore Law Firm'),
    'firm_email' => env('LEXCORE_FIRM_EMAIL', 'admin@lexcore.test'),
    'firm_phone' => env('LEXCORE_FIRM_PHONE', '+1 (555) 019-2834'),
    'firm_address' => env('LEXCORE_FIRM_ADDRESS', '100 Legal Way, Suite 400, New York, NY'),

    /*
    |--------------------------------------------------------------------------
    | Backups Configuration
    |--------------------------------------------------------------------------
    |
    | Configurable via installer. Sets whether automated backups are enabled
    | and defines the retention period.
    |
    */
    'backup' => [
        'enabled' => env('LEXCORE_BACKUP_ENABLED', true),
        'disk' => env('LEXCORE_BACKUP_DISK', 'local'),
        'frequency' => env('LEXCORE_BACKUP_FREQUENCY', 'daily'), // daily, weekly
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Rules
    |--------------------------------------------------------------------------
    |
    | Strict rules for secure file attachments and legal document uploads.
    | Optimized for shared hosting file size constraints.
    |
    */
    'uploads' => [
        'max_size_kb' => env('LEXCORE_MAX_UPLOAD_SIZE', 10240), // 10MB default
        'allowed_mimes' => [
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf',
            'png', 'jpg', 'jpeg', 'gif', 'zip',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding & Aesthetics
    |--------------------------------------------------------------------------
    |
    | Customize the main interface look. Default primary color is a premium
    | navy/indigo palette, representing professionalism and trust.
    |
    */
    'branding' => [
        'theme_color' => env('LEXCORE_THEME_COLOR', 'slate'), // slate, indigo, blue, amber
        'dark_mode_default' => env('LEXCORE_DARK_MODE_DEFAULT', true),
        'logo_path' => env('LEXCORE_LOGO_PATH', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Shared Hosting Workarounds
    |--------------------------------------------------------------------------
    |
    | Flags to tune performance for cheap or restrictive hosting environments.
    |
    */
    'hosting' => [
        'force_https' => env('LEXCORE_FORCE_HTTPS', false),
        'optimize_assets' => env('LEXCORE_OPTIMIZE_ASSETS', true),
        'use_queue_for_emails' => env('LEXCORE_USE_QUEUE_FOR_EMAILS', false), // set to false for instant sending if queue worker is not running on shared hosting
    ],
];

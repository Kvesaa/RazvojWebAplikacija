<?php

use Knuckles\Scribe\Extracting\Strategies;
return [
    /*
     * The type of documentation output to generate.
     * - "static" will generate a static HTMl page in the /public/api/docs folder,
     * - "laravel" will generate the documentation as a Blade view, so you can add routing and authentication.
     */
    'type' => 'static',

    /*
     * Settings for `static` type output.
     */
    'static' => [
        /*
         * HTML documentation, assets and Postman collections will be generated to this folder.
         * Source Markdown will be generated to resources/docs.
         */
        'output_path' => 'public/api/docs',
    ],

    /*
     * Settings for `laravel` type output.
     */
    'laravel' => [
        /*
         * Whether to automatically create a docs endpoint for you to view your generated docs.
         * If this is false, you can still set up routing manually.
         */
        'add_routes' => true,

        /*
         * URL path to use for the docs endpoint (if `add_routes` is true).
         * By default, `/docs` will point to the HTML version and `/docs.postman` to the Postman collection.
         * If you'd like different values, specify the base path here.
         */
        'docs_url' => 'api/docs',

        /*
         * Middleware to attach to the docs endpoint (if `add_routes` is true).
         */
        'middleware' => [],
        // Directory within `public` in which to store CSS and JS assets.
        // By default, assets are stored in `public/vendor/scribe`.
        // If set, assets will be stored in `public/{{assets_directory}}`
        'assets_directory' => null,
    ],

    /*
     * How is your API authenticated? This information will be used in the displayed docs, generated examples and response calls.
     * Available options: bearer, basic, apikey, cookie
     */
    'auth' => [
        'enabled' => true,
        'in' => 'bearer',
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY'),
        'placeholder' => '{YOUR_AUTH_KEY}',
        'extra_info' => 'You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.',
        // Set this to true if your API should be authenticated by default. If so, you must also set `enabled` (above) to true.
        // You can then use @unauthenticated or @authenticated on individual endpoints to change their status from the default.
        'default' => false,
    ],

    /*
     * Text to place in the "Introduction" section, right after the `description`
     */
    'intro_text' => <<<INTRO
This documentation aims to provide all the information you need to work with our API.

<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile), and you can switch the programming language of the examples with the tabs in the top right (or from the menu on mobile).</aside>
INTRO
,

    /*
     * Example requests for each endpoint will be shown in each of these languages.
     * Supported options are: bash, javascript, php, python
     * To add a language of your own, see https://scribe.knuckles.wtf/laravel/advanced/example-requests
     *
     */
    'example_languages' => [
        'bash',
        'javascript',
        'php',
    ],

    /*
     * Generate a Postman collection (v2.1.0) in addition to HTML docs.
     * For 'static' docs, the collection will be generated to public/api/docs/collection.json.
     * For 'laravel' docs, it will be generated to storage/app/scribe/collection.json.
     * Setting this to false will skip collection generation.
     */
    'postman' => [
        'enabled' => true,
        'overrides' => [
            // 'info.version' => '2.0.0',
        ],
    ],

    /*
     * Generate an OpenAPI spec (v3.0.1) in addition to docs.
     * For 'static' docs, the collection will be generated to public/api/docs/openapi.yaml.
     * For 'laravel' docs, it will be generated to storage/app/scribe/openapi.yaml.
     * Setting this to false will skip OpenAPI spec generation.
     */
    'openapi' => [
        'enabled' => true,
        'overrides' => [
            // 'info.version' => '2.0.0',
        ],
    ],

    /*
     * Name for your group of endpoints (by default, this will be extracted from your config('app.name')).
     */
    'title' => null,

    /*
     * A short description of your API. Will be included in the docs webpage, Postman collection and OpenAPI spec.
     */
    'description' => 'Aviation Management API Documentation',

    /*
     * The base URL displayed in the docs. If this is empty, Scribe will use the value of config('app.url').
     */
    'base_url' => null,

    /*
     * Tell Scribe what routes to generate documentation for.
     * Each group contains rules defining what routes should be included ('include' and/or 'exclude'),
     * and settings which should be applied to them when generating documentation
     * (each group will be merged into the route's settings).
     */
    'routes' => [
        [
            /*
             * Specify conditions to determine what routes will be parsed in this group.
             * A route must satisfy ALL conditions to be included.
             */
            'match' => [
                /*
                 * Match only routes whose paths match this pattern (use * as a wildcard to match any characters).
                 */
                'prefixes' => ['api/*'],

                /*
                 * Match only routes registered under this version. This option is ignored for Laravel 5.7+.
                 */
                'versions' => ['v1'],

                /*
                 * Match only routes whose names match this pattern (use * as a wildcard to match any characters).
                 */
                'names' => ['*'],

                /*
                 * Match only routes whose domains match this pattern (use * as a wildcard to match any characters).
                 */
                'domains' => ['*'],
            ],

            /*
             * Include these routes even if they did not match the rules above.
             * The route can be referenced by path, name or controller@method.
             */
            'include' => [
                // 'users.index', 'healthcheck*'
            ],

            /*
             * Exclude these routes even if they matched the rules above.
             * The route can be referenced by path, name or controller@method.
             */
            'exclude' => [
                // 'users.create', 'admin.*'
            ],

            /*
             * Settings to be applied to all routes in this group when generating documentation.
             */
            'apply' => [
                /*
                 * Headers to be added to the example requests
                 */
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],

                /*
                 * Query parameters to be added to the example requests
                 */
                'queryParameters' => [
                    // 'key' => 'value',
                ],

                /*
                 * Body parameters to be added to the example requests
                 */
                'bodyParameters' => [
                    // 'key' => 'value',
                ],

                /*
                 * File upload parameters to be added to the example requests
                 */
                'fileParameters' => [
                    // 'key' => 'path/to/file',
                ],

                /*
                 * Response headers to be added to the example responses
                 */
                'responseHeaders' => [
                    // 'key' => 'value',
                ],

                /*
                 * Response calls to be made for the example requests
                 */
                'responses' => [
                    // ['status' => 200, 'content' => ['key' => 'value']],
                ],

                /*
                 * This will be merged with automatically generated responses and will take precedence over them.
                 */
                'responseCalls' => [
                    /*
                     * Settings for `responseCalls`
                     */
                    'only' => [
                        // 'users.store', 'users.update'
                    ],
                    'except' => [
                        // 'users.index'
                    ],
                ],
            ],
        ],
    ],

    /*
     * The logo to be displayed in the sidebar. By default, the app's logo (if available) is used.
     * This should be a path or URL to an image file (SVG works best).
     */
    'logo' => false,

    /*
     * With API groups, you can categorize your API endpoints. Each group will be shown as a separate section in the docs.
     * The group name will be used as the title, and the description will be shown below it.
     */
    'groups' => [
        /*
         * Endpoints which don't define a @group will be placed in this default group.
         */
        'default' => 'Endpoints',
        // By default, Scribe will sort groups alphabetically, and endpoints in the order their routes are defined.
        // You can override this by listing the groups, subgroups and endpoints here in the order you want them.
        // See https://scribe.knuckles.wtf/blog/laravel-v4#easier-sorting and https://scribe.knuckles.wtf/laravel/reference/config#order for details
        'order' => [],
    ],

    /*
     * Custom logo path. This will be used as the value of the src attribute for the <img> tag,
     * so make sure it points to an accessible URL or path. Set to false to not use a logo.
     *
     * For example, if your logo is in public/img:
     * - 'logo' => '../img/logo.png' // for `static` type (output folder is public/api/docs)
     * - 'logo' => 'img/logo.png' // for `laravel` type
     *
     */
    'logo' => false,

    /*
     * The theme to use for the generated documentation.
     * Available themes: default, slate, dark
     */
    'theme' => 'default',

    /*
     * Whether to show the "Try it out" button for endpoints.
     */
    'try_it_out' => [
        'enabled' => true,
        'base_url' => null,
        // [Laravel Sanctum] Fetch a CSRF token before each request, and add it as an X-XSRF-TOKEN header.
        'use_csrf' => false,
        // The URL to fetch the CSRF token from (if `use_csrf` is true).
        'csrf_url' => '/sanctum/csrf-cookie',
    ],
    'external' => ['html_attributes' => []],
    // Customize the "Last updated" value displayed in the docs by specifying tokens and formats.
    // Examples:
    // - {date:F j Y} => March 28, 2022
    // - {git:short} => Short hash of the last Git commit
    // Available tokens are `{date:<format>}` and `{git:<format>}`.
    // The format you pass to `date` will be passed to PHP's `date()` function.
    // The format you pass to `git` can be either "short" or "long".
    'last_updated' => 'Last updated: {date:F j, Y}',
    'examples' => [
        // Set this to any number (e.g. 1234) to generate the same example values for parameters on each run,
        'faker_seed' => null,
        // With API resources and transformers, Scribe tries to generate example models to use in your API responses.
        // By default, Scribe will try the model's factory, and if that fails, try fetching the first from the database.
        // You can reorder or remove strategies here.
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'],
    ],
    'fractal' => [
        // If you are using a custom serializer with league/fractal, you can specify it here.
        'serializer' => null,
    ],
    'routeMatcher' => \Knuckles\Scribe\Matching\RouteMatcher::class,
];






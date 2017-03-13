<?php

use CedricZiel\JetbrainsPluginBadges\PluginDataService;
use Goutte\Client;
use Silex\Application;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();

$app['plugin-cache'] = function () {
    $dir = dirname(__DIR__.'/../var/cache/plugin/');

    return new FilesystemCache('', 3, $dir);
};

$app->get(
    'plugin/{plugin}/downloads/svg',
    function (Application $application, $plugin) {

        $pluginData = new PluginDataService(new Client(), $application['plugin-cache']);
        $count = $pluginData->totalDownloads($plugin);

        $downloadsBadge = <<<BADGE
<svg xmlns="http://www.w3.org/2000/svg" width="98" height="20">
    <linearGradient id="b" x2="0" y2="100%">
        <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
        <stop offset="1" stop-opacity=".1"/>
    </linearGradient>
    <mask id="a">
        <rect width="98" height="20" rx="3" fill="#fff"/>
    </mask>
    <g mask="url(#a)">
        <rect width="69" height="20" fill="#555"/>
        <rect x="69" width="29" height="20" fill="#097ABB"/>
        <rect width="98" height="20" fill="url(#b)"/>
    </g>
    <g fill="#fff" text-anchor="middle" font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11">
        <text x="35.5" y="15" fill="#010101" fill-opacity=".3">downloads</text>
        <text x="35.5" y="14">downloads</text>
        <text x="82.5" y="15" fill="#010101" fill-opacity=".3">$count</text>
        <text x="82.5" y="14">$count</text>
    </g>
</svg>
BADGE;

        $response = new Response($downloadsBadge, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'image/svg+xml');

        return $response;
    }
);

$app->run();

<?php

namespace CedricZiel\JetbrainsPluginBadges;

use Goutte\Client;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\BrowserKit\Client as AbstractClient;

class PluginDataService
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @param AbstractClient $client
     */
    public function __construct(AbstractClient $client, CacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * @param int $plugin
     *
     * @return int
     */
    public function totalDownloads(int $plugin): int
    {
        $cacheKey = sprintf('plugin-download-%d', $plugin);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $client = new Client();
        $client->followRedirects(true);
        $crawler = $client->request('GET', sprintf('https://plugins.jetbrains.com/plugin/%d', $plugin));
        $count = $crawler->filter('.plugin-info__item.plugin-info__downloads')->text();
        $count = (int)trim($count);

        $this->cache->set($cacheKey, $count);

        return $count;
    }
}

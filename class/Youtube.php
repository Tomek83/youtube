<?php
namespace youtube\classes;

use youtube\interfaces;

class Youtube
{
    /**
     * @var string
     */
    private $html;
    /**
     * @var string
     */
    private $videoId;
    /**
     * @var array
     */
    protected $video = [];
    /**
     * @var interfaces\Fetch
     */
    protected $fetch;
    /**
     * @var interfaces\Dom
     */
    protected $dom;

    /**
     * @param interfaces\Fetch $fetch
     * @param interfaces\Dom $dom
     */
    public function __construct(interfaces\Fetch $fetch, interfaces\Dom $dom)
    {
        $this->fetch = $fetch;

        $this->dom = $dom;
    }

    /**
     * @param string $url
     * @throws \Exception
     */
    public function getVideo($url)
    {
        preg_match('/https?\:\/\/www\.youtube\.com\/watch\?v\=([a-z\_0-9\-]+)(&|$)/i', trim($url), $match);

        $this->videoId = (empty($match[1])) ? null : $match[1];

        if (is_null($this->videoId)) throw new \Exception('error getting id from URL');

        $this->html = $this->fetch->getContent($url);

        if (empty($this->html)) throw new \Exception('error getting video URL');

        $this->parseResult($this->getMeta(), $this->getInfo());
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getInfo()
    {
        $status = $this->fetch->getContent(sprintf(YT_STATUS_URL, $this->videoId));

        if (empty($status)) {
            throw new \Exception('error getting status URL');
        } else {
            parse_str($status, $result);

            if (empty($result)) throw new \Exception('error parsing status response');

            return $result;
        }
    }

    /**
     * @return array
     */
    protected function getMeta()
    {
        $this->dom->loadHtml($this->html);

        return $this->dom->getMeta();
    }

    /**
     * @param array $pageMeta
     * @param array $videoInfo
     */
    protected function parseResult(array $pageMeta, array $videoInfo)
    {
        $this->video['id'] = $this->videoId;
        $this->video['status'] = ($videoInfo['status'] == 'ok') ? 1 : 0;
        $this->video['title'] = (empty($pageMeta['og:title'])) ? '' : trim($pageMeta['og:title']);
        $this->video['image'] = (empty($pageMeta['og:image'])) ? '' : trim($pageMeta['og:image']);
        $this->video['embed_on'] = (empty($videoInfo['allow_embed'])) ? 0 : 1;
        $this->video['embed_src'] = sprintf(YT_EMBED_SOURCE, $this->videoId);
        $this->video['time'] = (empty($videoInfo['length_seconds'])) ? 0 : (int)$videoInfo['length_seconds'];
    }

    /**
     * @return array
     */
    public function videoData()
    {
        return $this->video;
    }
}
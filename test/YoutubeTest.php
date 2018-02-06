<?php

use PHPUnit\Framework\TestCase;
use youtube\classes\Youtube;
use youtube\classes\HtmlFetch;
use youtube\classes\HtmlDom;

class YoutubeTest extends TestCase
{
    /**
     * @var Youtube
     */
    public $youtube;

    public function setUp()
    {
        $this->youtube = new Youtube(new HtmlFetch(), new HtmlDom());
    }

    public function tearDown()
    {
        unset($this->youtube);

        $this->youtube = null;
    }

    /**
     * @param string $url
     * @param array $expectedData
     * @dataProvider videoData
     */
    public function testData($url, array $expectedData)
    {
        $this->youtube->getVideo($url);

        $this->assertEquals($expectedData, $this->youtube->videoData());
    }

    /**
     * @param string $url
     * @expectedException Exception
     * @dataProvider errorData
     */
    public function testError($url)
    {
        $this->youtube->getVideo($url);
    }

    public function videoData()
    {
        return [
            [
                'https://www.youtube.com/watch?v=k1CNKAkQyHY',
                [
                    'id' => 'k1CNKAkQyHY',
                    'status' => 1,
                    'title' => 'Rozenek: "Lepiej wiedzieć jak jeść ślimaki, niż nie wiedzieć!"',
                    'image' => 'https://i.ytimg.com/vi/k1CNKAkQyHY/maxresdefault.jpg',
                    'embed_on' => 1,
                    'embed_src' => 'https://www.youtube.com/embed/k1CNKAkQyHY',
                    'time' => 241
                ]
            ],
            [
                'http://www.youtube.com/watch?v=k1CNKAkQyHY',
                [
                    'id' => 'k1CNKAkQyHY',
                    'status' => 1,
                    'title' => 'Rozenek: "Lepiej wiedzieć jak jeść ślimaki, niż nie wiedzieć!"',
                    'image' => 'https://i.ytimg.com/vi/k1CNKAkQyHY/maxresdefault.jpg',
                    'embed_on' => 1,
                    'embed_src' => 'https://www.youtube.com/embed/k1CNKAkQyHY',
                    'time' => 241
                ]
            ],
            [
                'https://www.youtube.com/watch?v=ybOBk9Eytv4',
                [
                    'id' => 'ybOBk9Eytv4',
                    'status' => 0,
                    'title' => 'Ludzie wolą pokemony, niż obchody Powstania Warszawskiego',
                    'image' => 'https://i.ytimg.com/vi/ybOBk9Eytv4/maxresdefault.jpg',
                    'embed_on' => 0,
                    'embed_src' => 'https://www.youtube.com/embed/ybOBk9Eytv4',
                    'time' => 0
                ]
            ],
            [
                'https://www.youtube.com/watch?v=XXXXXXXX',
                [
                    'id' => 'XXXXXXXX',
                    'status' => 0,
                    'title' => null,
                    'image' => null,
                    'embed_on' => 0,
                    'embed_src' => 'https://www.youtube.com/embed/XXXXXXXX',
                    'time' => 0
                ]
            ]
        ];
    }

    public function errorData()
    {
        return [
            [''],
            ['https://www.youtube.com/watch?v='],
            ['www.example.com/vid?v=234'],
            ['http://www.youtube.com/']
        ];
    }
}
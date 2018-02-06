Author: tomek.antczak@gmail.com
This simple PHP package provides ability to fetch some basic information about youtube video. It's useful when you want to provide ability for users to place video on your site (for instance in comments) by taking just link to youtube. Phpunit test is available for this class. You can install this package in your project via composer

{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/Tomek83/youtube"
    }
  ],
  "require": {
    "youtube/youtube": "dev-master"
  }
}

Usage (PHP CLI):

./run.php https://www.youtube.com/watch?v=k1CNKAkQyHY

Output:

Array
(
    [id] => k1CNKAkQyHY
    [status] => 1
    [title] => Rozenek: "Lepiej wiedzieć jak jeść ślimaki, niż nie wiedzieć!"
    [image] => https://i.ytimg.com/vi/k1CNKAkQyHY/maxresdefault.jpg
    [embed_on] => 1
    [embed_src] => https://www.youtube.com/embed/k1CNKAkQyHY
    [time] => 241
)

Example on locked video:

./run.php https://www.youtube.com/watch?v=ybOBk9Eytv4

Array
(
    [id] => ybOBk9Eytv4
    [status] => 0
    [title] => Ludzie wolą pokemony, niż obchody Powstania Warszawskiego
    [image] => https://i.ytimg.com/vi/ybOBk9Eytv4/maxresdefault.jpg
    [embed_on] => 0
    [embed_src] => https://www.youtube.com/embed/ybOBk9Eytv4
    [time] => 0
)

Results:

id – youtube video id
status – tells you if placing video on other sites is enabled
title – video title taken from og meta headers
image – video image taken from og meta headers
embed_on – tells you if placing video in iframe on others sites is enabled
embed_src – embed url to place in iframe src parameter
time – video time in seconds

If status value is 1 then video is not locked for embedding, otherwise if status is 0 then video is only available to watch on youtube. In this case time and embed_on will have 0 values


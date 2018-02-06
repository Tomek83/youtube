<?php

setlocale(LC_ALL, 'pl_PL.utf8');

mb_internal_encoding('UTF-8');

mb_regex_encoding('UTF-8');

define('YT_STATUS_URL', 'http://www.youtube.com/get_video_info?iframe=1&el=embedded&sts=16667&hl=pl_PL&asv=3&video_id=%s');

define('YT_STATUS_TIMEOUT', 6);

define('YT_EMBED_SOURCE', 'https://www.youtube.com/embed/%s');
<?php

class yt_stat {
	public $__info;
	private $__meta;
	private $__dom;
	public function yt_stat ($__url) {
		$this->__info=array();
		$this->__meta=array();
		$this->__dom=new DomDocument();
		preg_match('/https?\:\/\/www\.youtube\.com\/watch\?v\=([a-z\_0-9\-]+)(&|$)/i', trim($__url), $__m);
		$__v_id=(empty($__m[1])) ? NULL : $__m[1];
		if (is_null($__v_id)) throw new Exception('Error getting id from URL');
		$__i_doc=@file_get_contents(trim($__url), FALSE, stream_context_create(array('http'=>array('timeout'=>YT_STATUS_TIMEOUT))));
		if (empty($__i_doc)) {
			throw new Exception('Error getting video URL');
		}
		else {
			$this->get_meta($__i_doc);
		}
		$__i_stat=@file_get_contents(sprintf(YT_STATUS_URL, $__v_id), FALSE, stream_context_create(array('http'=>array('timeout'=>YT_STATUS_TIMEOUT))));
		if (empty($__i_stat)) {
			throw new Exception('Error getting status URL');
		}
		else {
			parse_str($__i_stat, $__i_arr);
		}
		if (!empty($__i_arr)) {
			$this->__info['id']=trim($__v_id);
			$this->__info['stat']=($__i_arr['status']=='ok') ? 1 : 0;
			$this->__info['title']=(empty($this->__meta['og:title'])) ? '' : trim($this->__meta['og:title']);
			$this->__info['image']=(empty($this->__meta['og:image'])) ? '' : trim($this->__meta['og:image']);
			$this->__info['embed_on']=(empty($__i_arr['allow_embed'])) ? 0 : 1;
			$this->__info['embed_src']=sprintf(YT_EMBED_SOURCE, $__v_id);
			$this->__info['time']=(empty($__i_arr['length_seconds'])) ? 0 : (int)$__i_arr['length_seconds'];
		}
		else {
			throw new Exception('Error parsing status response');
		}
	}
	private function get_meta ($__html) {
		$this->__dom->loadHTML(mb_convert_encoding($__html, 'HTML-ENTITIES', 'UTF-8'));
		$__xp=new DOMXPath($this->__dom);
		$__qu='//*/meta[starts-with(@property, \'og:\')]';
		$__me=$__xp->query($__qu);
		foreach ($__me as $__v) {
			$this->__meta[trim($__v->getAttribute('property'))]=trim($__v->getAttribute('content'));
		}
	}
}

?>

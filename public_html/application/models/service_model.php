<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_Model extends CI_Model {

    function getSliderNews() {
        
        $this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->join('site_news', 'news.id = site_news.id_news');
		$this->db->where('site_news.widget', 'manset');
		$this->db->order_by('news.date', 'desc');
		$this->db->limit(10);
		$result = $this->db->get('news')->result_array();
		foreach($result as &$item) {
			$item['summary'] = $this->textSlice($item['summary']);
		}
		return $result;
    }
	
	function getNews() {
		$news = $this->_sliderNews();
		$this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->where_not_in('news.id', $news);
		$this->db->order_by('news.date', 'desc');
		$this->db->limit(10);
		$result = $this->db->get('news')->result_array();
		foreach($result as &$item) {
			$item['summary'] = $this->textSlice($item['summary']);
		}
		return $result;
	}
	
	function _sliderNews() 
	{
		$this->db->flush_cache();
		$this->db->select('news.id as id');
		$this->db->join('site_news', 'news.id = site_news.id_news');
		$this->db->where('site_news.widget', 'manset');
		$return = $this->db->get('news')->result_array();
		foreach($return as $item) {
			$data[] = $item['id'];
		}
		return $data;
	}
	
	function loadNews($start) 
	{
		$news = $this->_sliderNews();
		$this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->where_not_in('news.id', $news);
		$this->db->order_by('news.date', 'desc');
		$this->db->limit(2, $start);
		$result = $this->db->get('news')->result_array();
		foreach($result as &$item) {
			$item['summary'] = $this->textSlice($item['summary']);
		}
		return $result;
	
	}
	
	function getCategoryNews($id, $start = false) 
	{
		$this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->where('news.id_category', $id);
		$this->db->order_by('news.date', 'desc');
		if($start) {
			$this->db->limit(1, $start);
		} else {
			$this->db->limit(15);
		}
		$result = $this->db->get('news')->result_array();
		foreach($result as &$item) {
			$item['summary'] = $this->textSlice($item['summary']);
		}
		return $result;
	
	}
	
	function newsDetail($id) 
	{

		$this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image, news.body as content');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->where('news.id', $id);
		$result = $this->db->get('news')->row_array();
		$result['content'] = base64_decode($result['content']);
		return $result;
	
	}
	
	function textSlice($text, $count = 80) 
	{
		$text = explode('.', $text);
		$text = explode('?', $text[0]);
		$text = strip_tags($text[0]);
		$text = str_replace(array("\t","\r","\n"), ' ',$text);
		$text_bol = explode(' ', $text);
		$text = '';
		for($i = 0; $i < count($text_bol); $i++) {
			 if ($text_bol[$i] != '')
				  $text .= trim($text_bol[$i]).' ';
		}
		if( preg_match('/(.*?)\s/i', substr( $text, $count), $dizi) )
			$text = substr($text, 0, $count + strlen($dizi[0]));
		return $text.' ...';
	}
	
	function getSpecial($widget, $start = false) 
	{
		$this->db->flush_cache();
		$this->db->select('news.id as id, news.title as title, news.summary as summary, image.name as image');
		$this->db->join('image', 'news.id = image.id_news');
		$this->db->join('site_news', 'news.id = site_news.id_news');
		$this->db->where('site_news.widget', $widget);
		$this->db->order_by('news.date', 'desc');
		if($start) {
			$this->db->limit(1, $start);
		} else {
			$this->db->limit(15);
		}
		$result = $this->db->get('news')->result_array();
		foreach($result as &$item) {
			$item['summary'] = $this->textSlice($item['summary']);
		}
		return $result; 
	}

    
}
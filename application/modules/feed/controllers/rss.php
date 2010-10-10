<?php

class Rss extends Controller
{
	function Rss()
	{
		parent::Controller();
		
		$this->load->module_model('blog', 'blog_model', 'blog');
		$this->load->module_model('blog', 'comments_model', 'comments');
		$this->load->module_model('blog', 'users_model', 'users');
		$this->load->module_language('feed', 'feed');
		$this->load->helper('xml');
	}
	
	function posts()
	{
		if ($this->system->settings['enable_rss'] == 1)
		{
			$data['posts'] = $this->blog->get_posts();
			
			header("Content-Type: application/xml");
			$this->system->load_normal('feed/rss_posts', $data);
		}
	}

	function comments()
	{
		if ($this->system->settings['enable_rss'] == 1)
		{
			if ($data['comments'] = $this->comments->get_latest_comments())
			{
				foreach ($data['comments'] as $key => $comment)
				{
					if ($comment['user_id'] != "")
					{
						$display_name = $this->users->get_user_display_name($comment['user_id']);
						$data['comments'][$key]['author'] = $display_name;
					}
					else
					{
						$data['comments'][$key]['author'] = $comment['author'];
					}
				}
			}
			
			header("Content-Type: application/xml");
			$this->system->load_normal('feed/rss_comments', $data);
		}
	}
}

/* End of file rss.php */
/* Location: ./application/modules/feed/controllers/rss.php */
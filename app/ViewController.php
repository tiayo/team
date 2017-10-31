<?php

namespace App;

class ViewController
{
    protected $get;

    public function __construct()
    {
        $this->get = new GetController();
    }

    public function index()
    {
        //获取html代码
        $index = file_get_contents(dirname(__DIR__).'/view/index.html');

        $index = $this->article($index);

        return $index;
    }

    public function article($index)
    {
        $articles = json_decode($this->get->get(), true);

        $replace = null;

        foreach ($articles as $article) {

            $picture = substr($article['picture'], 0, 4) == 'http' ? $article['picture'] : config('site').$article['picture'];

            $replace .= "<div class='col-md-4'>
					<article class='article-post'>
						<a target='_blank' href='".config('site').'article'.$article['links']."'>
							<div class='article-image has-overlay' style='background-image: url(".$picture.")'>
								<span class='featured-tag'>最新资讯</span>
							</div>
							<figure>
								<figcaption>
									<h2>".$article['title']."</h2>
									<p>".strip_tags($article['abstract'])."...</p>
								</figcaption>
							</figure>
						</a>
						<ul class='article-footer'>
							<li class='article-category'>
								<a target='_blank' href='".config('site')."/category/9.html'>团队资讯</a>
							</li>
							<li class='article-comments'>
								<span>
								    <a target='_blank' href='".config('site').'article'.$article['links']."#pinglun'><i class='fa fa-comments'></i></a>
								</span>
							</li>
						</ul>
					</article>
				</div>";
        }

        return str_replace('{{ article }}', $replace, $index);
    }
}
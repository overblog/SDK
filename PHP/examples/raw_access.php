<?php

/*
 * This example demonstrates the usage of the raw API methods.
 *
 * By 'raw API methods' we mean that the mapping between these PHP calls
 * and the http methods is bijective.
 * These methods do not offer a simple way to create, let's say, a post
 * containing a simple video embed for example.
 */


include_once('../src/OverBlog.php');


// Here, replace consumerKey and consumerSecret with your application data
// and accessToken and accessSecret by the token of the user you want to
// act on behalf of.
// Try 'authorize.php' in examples directory to get a user access token

$ob = new OverBlog (
	array (
		'consumerKey'           => 'yourConsumerKey',
		'consumerSecret'        => 'yourConsumerSecret',
		'accessToken'           => 'yourToken',
		'accessSecret'          => 'yourTokenSecret',
	)
);


$blogHostName = 'www.example.com';

?>

<html>

<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>

<body>
<h1>API demonstration</h1>

<?php

//--------------------------------------------------------------------------------
// USER INFO
//--------------------------------------------------------------------------------
/*
*/
echo '<h2>User information</h2>'
	.'<pre>';
print_r($ob->getUserInfo());
echo '</pre>';


//--------------------------------------------------------------------------------
// BLOGS INFO
//--------------------------------------------------------------------------------
echo '<h2>Blog information before update</h2>'
	.'<pre>';
print_r(
	$ob->getBlogInfo (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
/*
echo '</pre>';

$ob->updateBlogInfo (
	array (
		'blog_hostname'	=> $blogHostName,
		'name'			=> 'name of blog randomly changed '.mt_rand(1111,9999),
		'description'	=> 'description of the blog also randomly changed '.mt_rand(1111,9999),
	)
);


echo '<h2>Blog information after update</h2>'
	.'<pre>';
print_r(
	$ob->getBlogInfo (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
echo '</pre>';


echo '<h2>The social networks you intent to push to</h2>'
	.'<pre>';
print_r(
	$ob->getSocialNetworksForPush (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
echo '</pre>';
*/

/*
// Image upload to debug

print_r(
	$ob->uploadImage (
		array (
			'blog_hostname'	=> $blogHostName,
			'file'			=> '/Users/lionel/Desktop/id/ball-chair-transparent.jpg',
		)
	)
);
*/

//--------------------------------------------------------------------------------
// POSTS
//--------------------------------------------------------------------------------
/*
echo '<h2>The posts published on your blog</h2>';
$posts = $ob->getPublishedPosts (
	array (
		'blog_hostname'	=> $blogHostName,
	)
);

echo '<ul>';
foreach ($posts->response as $post)
{
	$cover = null;
	if(!is_null($post->cover))
	{
		$cover = '<img src="http://'.$post->cover->basepath.$post->cover->filepath.'" style="float:left; width: 150px; margin-right: 30px;" />';
	}

	$originsList = '';
	foreach($post->origin as $k => $origin)
	{
		if($k > 0){$originsList .= ', ';}
		$originsList .= $origin;
	}

	$tagsList = '';
	foreach($post->tags as $k => $tag)
	{
		if($k > 0){$tagsList .= ', ';}
		$tagsList .= $tag;
	}

	echo  '<li>'
		. $cover
		. '[<a href="http://admin.over-blog-kiwi.com/write/'.$post->id.'">#' . $post->id .'</a>] '
		. '<strong><a href="'.$post->url.'">'.$post->title.'</a></strong>'
		. '<ul>'
		. '<li>Created on '.$post->date.'</li>'
		. '<li>origin: '.$originsList.'</li>'
		. '<li>tags: '.$tagsList.'</li>'
		. '<li>'.$post->total_comment.' comments</li>'
		. '</ul>'
		. '<p>'.$post->snippet.'</p>'
		. '</li>';
}
echo '</ul>';
*/


/*
print_r(
	$ob->getPost (
		array (
			'blog_hostname'		=> $blogHostName,
			'id'				=> 652663,
			'contentFormat'		=> OverBlog::OB_API_CONTENTFORMAT_RAWJSON,
			'richTextFormat'	=> 0,
		)
	)
);


print_r(
	$ob->editPost (
		array (
			'blog_hostname'	=> $blogHostName,
			'id'			=> 652523661,
			'title'			=> 'Title modified by API',
		)
	)
);

print_r(
	$ob->deletePost (
		array (
			'blog_hostname'	=> $blogHostName,
			'id'			=> 621369,
		)
	)
);
echo '<h2>Creating post</h2>'
	.'<pre>';
print_r(
	$ob->createPost (
		array (
			'blog_hostname'	=> $blogHostName,
			'title'			=> 'Post created by API',
			'status'		=> OverBlog::OB_API_STATUS_PUBLISHED,
			'tags'			=> 'api,test,overblog',
			'date'			=> '2012-07-04 21:30:00',
			'social'		=> array('facebook', 'twitter'),
			'author'		=> 'Me with the API SDK',
			'sections'		=> array (
				'sections'	 => array (
					array (
						'class'		=> 'quote',
						'link'		=> 'http://fr.wikipedia.org/',
						'text'		=> 'They didn\'t know it was impossible, so they did it!',
						'author'	=> 'Mark Twain',
					),
					array (
						'class'			=> 'map',
						'coordinates'	=> array (
							'coordinates' => array (
								'title'			=> 'Office',
								'description'	=> 'LoungeUp Office',
								'latitude'		=> 43.5988649,
								'longitude'		=> 1.4559587,
							),
						),
						'description'	=> 'If you meet to meet LoungeUp in Toulouse',
					)
				)
			)
		)
	)
);
echo '</pre>';
*/

//--------------------------------------------------------------------------------
// LiveStream
//--------------------------------------------------------------------------------
/*
echo '<h2>Making Livestream</h2>'
	.'<pre>';
print_r(
	$ob->createLiveStreamPost (
		array (
			'blog_hostname'	=> $blogHostName,
			'title'			=> 'Concert Livestream',
			'author'		=> 'Joe la musique',
			'tags'			=> 'livestream,video,music',
			'desc'			=> 'Guys you\'are watching my concert',
			'social'		=> array('facebook', 'twitter'),
		)
	)
);
echo '</pre>';
*/


//--------------------------------------------------------------------------------
// COMMENTS
//--------------------------------------------------------------------------------
/*
echo '<h2>Get blog comments</h2>'
	.'<pre>';
print_r(
	$ob->getBlogComments(
		array (
			'blog_hostname'		=> $blogHostName,
			'state'				=> OverBlog::OB_API_STATUS_PUBLISHED,
			'limit'				=> 10,
			'offset'			=> 0,
		)
	)
);
echo '</pre>';

echo '<h2>Create Comment</h2>'
	.'<pre>';
print_r(
	$ob->createComment(
		array (
			'id_post'			=> 130,
			'text'				=> 'This is a comment',
		)
	)
);
echo '</pre>';

echo '<h2>Get post comments</h2>'
	.'<pre>';
print_r(
	$ob->getPostComments(
		array (
			'id_post'			=> 130,
			'limit'				=> 10,
			'offset'			=> 0,
		)
	)
);
echo '</pre>';

/*
echo '<h2>Reply to a Comment</h2>'
	.'<pre>';
print_r(
	$ob->replyToComment(
		array (
			'id_comment'		=> 130,
			'text'				=> 'This is a comment reply',
		)
	)
);
echo '</pre>';
*/


//--------------------------------------------------------------------------------
// STATS
//--------------------------------------------------------------------------------
/*

echo '<h2>Stats: Get Most Popular Pages Stats</h2>'
	.'<pre>';
print_r(
	$ob->getMostPopularPagesStats(
		array (
			'blog_hostname'		=> $blogHostName,
			'month'				=> '2012-07-01',
		)
	)
);
echo '</pre>';

echo '<h2>Get Stats for a period</h2>'
	.'<pre>';
print_r(
	$ob->getStats(
		array (
			'blog_hostname'		=> $blogHostName,
			'start'				=> '2012-07-01',
			'end'				=> '2012-07-30',
		)
	)
);
echo '</pre>';

echo '<h2>Get Total Stats for a period</h2>'
	.'<pre>';
print_r(
	$ob->getTotalStats(
		array (
			'blog_hostname'		=> $blogHostName,
			'start'				=> '2012-07-01',
			'end'				=> '2012-07-30',
		)
	)
);
echo '</pre>';
*/

?>

</body>
</html>

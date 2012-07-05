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
		'consumerKey'		=> '------',
		'consumerSecret'	=> '------',
		'accessToken'		=> '------',
		'accessSecret'		=> '------',
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

echo '<h2>User information</h2><pre>';
print_r($ob->getUserInfo());
echo '</pre>';


echo '<h2>Blog information before update</h2><pre>';
print_r(
	$ob->getBlogInfo (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
echo '</pre>';

/*
$ob->updateBlogInfo (
	array (
		'blog_hostname'	=> $blogHostName,
		'name'			=> 'name of blog randomly changed '.mt_rand(1111,9999),
		'description'	=> 'description of the blog also randomly changed '.mt_rand(1111,9999),
	)
);


echo '<h2>Blog information after update</h2><pre>';
print_r(
	$ob->getBlogInfo (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
echo '</pre>';
*/


echo '<h2>The social networks you intent to push to</h2><pre>';
print_r(
	$ob->getSocialNetworksForPush (
		array (
			'blog_hostname'	=> $blogHostName,
		)
	)
);
echo '</pre>';

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

echo '<h2>The posts published on your blog</h2>';
$posts = $ob->getPublishedPosts (
	array (
		'blog_hostname'	=> $blogHostName,
	)
);

echo '<ul>';
foreach ($posts->response as $post)
{
	echo '<li> [#' . $post->id .'] '.$post->date.' | '.$post->title.'</li>';
}
echo '</ul>';


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

print_r(
	$ob->createPost (
		array (
			'blog_hostname'	=> $blogHostName,
			'title'			=> 'Post created by API',
			'status'		=> OverBlog::OB_API_STATUS_PUBLISHED,
			'tags'			=> 'api,test,overblog',
			'date'			=> '2012-07-04 21:30:00',
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
*/


?>

</body>
</html>

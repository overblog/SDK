<?php

/*
 * This example demonstrates how to create 
 * a simple post made of text and of an image.
 */

include_once('../src/OverBlog.php');
include_once('constants.php');



$ob = new OverBlog (
	array (
		'consumerKey'		=> OB_API_MY_CONSUMER_KEY,
		'consumerSecret'	=> OB_API_MY_CONSUMER_SECRET,
		'accessToken'		=> OB_API_MY_ACCESS_TOKEN,
		'accessSecret'		=> OB_API_MY_ACCESS_SECRET,
	)
);


try {
	$ob->createTextPost (
		OB_API_MY_BLOG_HOSTNAME,
		'This is a test post at '.date('c'),
		'<h1>Title</h1><p>This is my post</p><p>The date is : <em>'.date('c').'</em></p>',
		array (
			'image'			=> '/path/to/my/image.png',
			'imageAlign'	=> OverBlog::OB_API_IMAGE_ALIGN_RIGHT,
			'imageSize'		=> OverBlog::OB_API_IMAGE_SIZE_DEFAULT,
		)
	);
}
catch (OverBlogException $e)
{
	print 'Oops. Something went wrong...';
}

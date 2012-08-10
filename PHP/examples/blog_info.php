<?php

/*
 * This example demonstrates how to retrieve and
 * update a blog data
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

if (isset($_POST['name']) || isset($_POST['desc']))
{
	echo '<h1>Update</h1>';

	$updateParams = array (
		'blog_hostname' => OB_API_MY_BLOG_HOSTNAME
	);

	if (isset($_POST['name']))
	{
		$updateParams['name'] = stripslashes($_POST['name']);
	}
	if (isset($_POST['desc']))
	{
		$updateParams['description'] = stripslashes($_POST['desc']);
	}

	$updated = $ob->updateBlogInfo (
		$updateParams
	);

	if ($updated->meta->status == 200)
	{
		echo 'The data has been updated with success';
	}
	else
	{
		echo 'An error occured :';
		var_dump($updated);
	}
}

$blogInfo = $ob->getBlogInfo (
	array (
		'blog_hostname'	=> OB_API_MY_BLOG_HOSTNAME,
	)
);

if ($blogInfo->meta->status != '200')
{
	print "An error occured.\n";
	var_dump($blogInfo);
	die();
}

?>

<h1><?php echo OB_API_MY_BLOG_HOSTNAME; ?></h1>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

Created : <?php echo $blogInfo->response->blog->creation_date; ?><br/>
Last post : <?php echo $blogInfo->response->blog->last_post_date; ?><br/>

Avatar :
<?php

if ($blogInfo->response->blog->avatar)
{
	echo '<img src="http://' .
		$blogInfo->response->blog->avatar->basepath .
		$blogInfo->response->blog->avatar->filepath .
		'"/>';
}
else
{
	echo 'None.';
}

?>
<br/>

Name : <input type="text" name="name" value="<?php echo htmlspecialchars($blogInfo->response->blog->name); ?>"><br/>
Description : <input type="text" name="desc" value="<?php echo htmlspecialchars($blogInfo->response->blog->description); ?>"><br/>

<input type="submit" value="Update"/>

</form>

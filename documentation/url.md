url can prefix the application it lives in
url
-> /
-> /admin/
-> /*/

url( 'home@about' )
roots to about page with prefix

url( 'home@index' )
roots to the prefix

url('css/bootstrap.min.css');
roots to the asset directory appends the prefix

url( 'blog@article', ['id' => 1, 'title' =>, 'my title'] )
roots to blog/article/{id}/{title}

In case of dynamic routes all dynamic routes will be build to a routes file.
dynamic routes need to be set in the the settings application.

in wrong selection it well return an decent error.

when multi_language is set the url_struture will change by adding the language code to all routes
{language}/blog/article/{id}/{title}

don't change to multi_language while in production, you will loose SEO value.

## Full URL combinations
{domain.com}/{application}/{language}/route/{paramA}/{paramB}?query=string

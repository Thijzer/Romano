# Todo

filenames like index.tiwg in your EDI don't say to much
> better ::  blog_index.twig

this makes the file structure a little bit weird

> example :: Themes/romano/ blog/blog_article.twig

> better :: Themes/romano/ blog_article.twig

this will make a directory explode but at least the order is correct
Instead move the files into modular structure

> example :: Blog
> env :: www/default
> for 1 page with 5 components (articles, pagination, recent articles, login, archive)

> Models / Post (1 model per entity) 1 or 2
> Controllers / Blog (many method controllers per resourse/page) 1/5
> Views / blog_index , blog_article , /base (many views per resource/page) 5
> Resources / blog_index, blog_article (1 resource per page) 1 (named_resources so 1 folder can hold only 1 named resource)
> Assets /

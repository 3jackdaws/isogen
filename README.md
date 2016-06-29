# ISOGEN.NET
My personal website
##Purpose
Isogen.net is a place for me to post about projects I do for fun or for class.  I like experimenting with new things and I thought it would be interesting to write about the the exciting (for me) things I do while I do them.

##Why do everything from scratch?
Well, not everything is from scratch.  I used Twitter's Bootstrap for most of the styling of the site and I use ~~JQuery for the JavaScript framework~~ pure JavaScript, now, for all the browser based stuff.  I could have done all the CSS and JS myself, but custom CSS classes take a lot of time to set up properly.  I also use a neat preloading library called InstantClick.

There is some PHP that makes up the site right now.  All of the PHP is custom made for the site and more will continue to be added as time goes on.

As for the reason I am not using Wordpress or some other blog frmaework, I like to build things from the ground up.  I don't like not knowing how the things I use work.  I don't want a system where I just upload a markdown file or something and the system automagically creates directories and database entries.  Well, actually I do want that, but I want to write the code myself and I eventually will.

##Features
####Automatic Page Preloading
InstantClick preloads all <A> tags on mouse over and swaps the body out on mouse down.

####Article upload page
Articles are added to the website by uploading an article markup file.  Article markup files require "tags" to tell the parser what the article's attributes are.  The markup file must be an html file and have the following tags (includes examples).

* `<author>`Ian Murphy</author>
* `<date>`January 1, 2016</date>
* `<header>`big_header_image.jpg</header>
* `<h1>`Title of article</h1>
* `<h2>`Sub title of article</h2>
* `<article>`Body of article text goes in here</article>

Optional tags:

* <img>image_in_article.jpg</img>

When uploading, the parser requires a .html file and an image file before one can even click the parse button.  After parsing successfully, a user can see what the article looks like in a preview window.  From here, the user can choose to publish the article.


######Problems
Preloading doesn't work on mobile devices because there is no "hover" event on a smartphone.  Mobile devices do not break the site, but they do not benefit from preloading.

##Upcoming Features
* Site-wide search
* Database integration for articles
* Article upload and automatic directory creation via web interface
* Author cards
* Dynamic suggested article footer area

# ISOGEN.NET
My personal website
##Purpose
Isogen.net is a place for me to post about projects I do for fun or for class.  I like experimenting with new things and I thought it would be interesting to write about the the exciting (for me) things I do while I do them.

##Why do everything from scratch?
Well, not everything is from scratch.  I used Twitter's Bootstrap for most of the styling of the site and I use JQuery for the JavaScript framework.  I could have done all the CSS and JS myself, but custom CSS classes take a lot of time to set up properly and JQuery makes it really quick and easy to set up things the way I want.  
There is some PHP that makes up the site right now.  All of the PHP is custom made for the site and more will continue to be added as time goes on.

As for the reason I am not using Wordpress or some other blog frmaework, I like to build things from the ground up.  I don't like not knowing how the things I use work.  I don't want a system where I just upload a markdown file or something and the system automagically creates directories and database entries.  Well, actually I do want that, but I want to write the code myself and I eventually will.

##Features
####Automatic Page Preloading
Website sections are preloaded on mouse hover.  When the section is clicked, the page is swapped out instantly.  This also works with articles and posts.  
Pages can still be bookmarked and links can be shared.  This is achieved by having index files at the article directories that redirect to the homepage with some GET variables.  The page requested is then loaded based on the GET vars submitted and the url is swapped out with the original one.  It looks pretty seemless.

######Problems
Preloading doesn't work on mobile devices because there is no "hover" event on a smartphone.  Mobile devices do not break the site, but they do not benefit from preloading.


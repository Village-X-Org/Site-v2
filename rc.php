<?php
    	define("CACHED_HIGHLIGHTED_FILENAME", "cached/project_highlighted");
	define("CACHED_CHARTS_FILENAME", "cached/project_charts");
	define("CACHED_LISTING_FILENAME", "cached/project_listing");
	define("CACHED_PROJECT_PREFIX", "cached/project_");
    define("CACHED_SHOP_FILENAME", "cached/shop_listing");
    	foreach (glob(CACHED_PROJECT_PREFIX.'*') as $filename) {
		  print $filename."\n";
        	@unlink($filename);	
	    }
        foreach (glob("cached/newsfeed_*") as $filename) {
            print $filename."\n";
            @unlink($filename); 
        }
    	if (file_exists(CACHED_HIGHLIGHTED_FILENAME)) {
		    print CACHED_HIGHLIGHTED_FILENAME."\n";
       	    @unlink(CACHED_HIGHLIGHTED_FILENAME);
    	}
    	if (file_exists(CACHED_LISTING_FILENAME)) {
		    print CACHED_LISTING_FILENAME."\n";
        	@unlink(CACHED_LISTING_FILENAME);
    	}
        foreach (glob(CACHED_SHOP_FILENAME.'*') as $filename) {
            print $filename."\n";
            @unlink($filename); 
        }
    	if (file_exists(CACHED_CHARTS_FILENAME)) {
		    print CACHED_CHARTS_FILENAME."\n";
        	@unlink(CACHED_CHARTS_FILENAME);
    	}
?>

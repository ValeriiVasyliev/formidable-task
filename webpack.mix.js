const mix = require('laravel-mix');
const fs = require('fs');
const version = "<?php return '" + JSON.stringify(Date.now()) + "';";

mix.js('assets/src/js/admin.js', 'assets/dist/js/')
   .css('assets/src/css/admin.css', 'assets/dist/css')
   .css('assets/src/css/front.css', 'assets/dist/css')
   .options({ processCssUrls: false });

fs.writeFile(`assets/version.php`, version, function (err) {
	if (err) {
		return console.log(err);
	}
});

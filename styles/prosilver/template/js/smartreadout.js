(function($) {	// Avoid conflicts with other libraries

'use strict';

$(function() {

	switch(smartreadout.script) {
		case 'index':

			if (smartreadout.allow_smartreadout)
			{
				$('#smart_read_out').load(smartreadout.smartreadout_url);

				setInterval(function() {
					$('#smart_read_out').load(smartreadout.smartreadout_url);
				}, (smartreadout.smartreadout_refresh));
			}
		break;
	}
});

})(jQuery); // Avoid conflicts with other libraries

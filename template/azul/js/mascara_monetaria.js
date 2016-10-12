(function($) {

	$.fn.priceFormat = function(options)
	{

		var defaults =
		{
			prefix: 'US$ ',
			centsSeparator: '.',
			thousandsSeparator: ',',
			limit: false,
			centsLimit: 2,
			clearPrefix: false,
			allowNegative: false
		};

		var options = $.extend(defaults, options);

		return this.each(function()
		{


			var obj = $(this);
			var is_number = /[0-9]/;


			var prefix = options.prefix;
			var centsSeparator = options.centsSeparator;
			var thousandsSeparator = options.thousandsSeparator;
			var limit = options.limit;
			var centsLimit = options.centsLimit;
			var clearPrefix = options.clearPrefix;
			var allowNegative = options.allowNegative;


			function to_numbers (str)
			{
				var formatted = '';
				for (var i=0;i<(str.length);i++)
				{
					char_ = str.charAt(i);
					if (formatted.length==0 && char_==0) char_ = false;

					if (char_ && char_.match(is_number))
					{
						if (limit)
						{
							if (formatted.length < limit) formatted = formatted+char_;
						}
						else
						{
							formatted = formatted+char_;
						}
					}
				}

				return formatted;
			}


			function fill_with_zeroes (str)
			{
				while (str.length<(centsLimit+1)) str = '0'+str;
				return str;
			}


			function price_format (str)
			{
				// formatting settings
				var formatted = fill_with_zeroes(to_numbers(str));
				var thousandsFormatted = '';
				var thousandsCount = 0;

				// split integer from cents
				var centsVal = formatted.substr(formatted.length-centsLimit,centsLimit);
				var integerVal = formatted.substr(0,formatted.length-centsLimit);

				// apply cents pontuation
				formatted = integerVal+centsSeparator+centsVal;

				// apply thousands pontuation
				if (thousandsSeparator)
				{
					for (var j=integerVal.length;j>0;j--)
					{
						char_ = integerVal.substr(j-1,1);
						thousandsCount++;
						if (thousandsCount%3==0) char_ = thousandsSeparator+char_;
						thousandsFormatted = char_+thousandsFormatted;
					}
					if (thousandsFormatted.substr(0,1)==thousandsSeparator) thousandsFormatted = thousandsFormatted.substring(1,thousandsFormatted.length);
					formatted = thousandsFormatted+centsSeparator+centsVal;
				}

				// if the string contains a dash, it is negative - add it to the begining (except for zero)
				if (allowNegative && str.indexOf('-') != -1 && (integerVal != 0 || centsVal != 0)) formatted = '-' + formatted;

				// apply the prefix
				if (prefix) formatted = prefix+formatted;

				return formatted;
			}


			function key_check (e)
			{
				var code = (e.keyCode ? e.keyCode : e.which);
				var typed = String.fromCharCode(code);
				var functional = false;
				var str = obj.val();
				var newValue = price_format(str+typed);

				// allow key numbers, 0 to 9
				if((code >= 48 && code <= 57) || (code >= 96 && code <= 105)) functional = true;

				// check Backspace, Tab, Enter, Delete, and left/right arrows
				if (code ==  8) functional = true;
				if (code ==  9) functional = true;
				if (code == 13) functional = true;
				if (code == 46) functional = true;
				if (code == 37) functional = true;
				if (code == 39) functional = true;
				if (allowNegative && (code == 189 || code == 109)) functional = true; // dash as well

				if (!functional)
				{
					e.preventDefault();
					e.stopPropagation();
					if (str!=newValue) obj.val(newValue);
				}

			}


			function price_it ()
			{
				var str = obj.val();
				var price = price_format(str);
				if (str != price) obj.val(price);
			}


			function add_prefix()
			{
				var val = obj.val();
				obj.val(prefix + val);
			}


			function clear_prefix()
			{
				if($.trim(prefix) != '' && clearPrefix)
				{
					var array = obj.val().split(prefix);
					obj.val(array[1]);
				}
			}


			$(this).bind('keydown', key_check);
			$(this).bind('keyup', price_it);


			if(clearPrefix)
			{
				$(this).bind('focusout', function()
				{
					clear_prefix();
				});

				$(this).bind('focusin', function()
				{
					add_prefix();
				});
			}


			if ($(this).val().length>0)
			{
				price_it();
				clear_prefix();
			}


		});

	};

})(jQuery);
/**
 * TwitterMentions
 * jQuery Plugin to Display Twitter Mentions
 * http://www.ctrl-zetta.com/#code
 * http://www.infectedfx.net/
 *
 * Copyright (c) 2009 zetta & infectedfx
 *
 * Released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Since  : 0.1 - 10/07/2009
 */
(function(jQuery){
  /** public methods **/

  jQuery.fn.twitterMentions = function (user, options) {
   try
   {
    var
      opts = jQuery.extend({}, jQuery.fn.twitterMentions.defaults, options),
      c = jQuery.isFunction(opts.callback) ? opts.callback: _build,
      url = 'http://search.twitter.com/search.json'
      params = { q : _query(user), page : opts.page, rpp : opts.maximum };

    return this.each(function(i, e) {
      jQuery.ajax({
        url: url,
        data: params,
        dataType: 'jsonp',
        success: function (o) {
          c.apply(this, [(o.results) ? o.results: o, e, opts]);
        }
      });
    });
   } catch (e){}
  };
  /** defaults **/
  jQuery.fn.twitterMentions.defaults = {
    user: null,
    callback: null,
    page : 1,
    maximum : 10,
	avatar : true,
    ulClass : 'twitter-mentions',
	odd : true,
	oddClass : 'odd'
  };

  /** private methods **/
  var _build = function (object, element, opts)
  {
    var html = '<ul class="'+ opts.ulClass +'">';
    for ( var i = 0; i < object.length; i++ )
    {
        current = object[i];
		user = current.from_user;
		text = current.text.replace(/(https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/, function (u) {
            var shortUrl = (u.length > 30) ? u.substr(0, 30) + '...': u;
            return '<a href="' + u + '">' + shortUrl + '</a>';
		}).replace(/@([a-zA-Z0-9_]+)/g, '@<a href="http://twitter.com/$1">$1</a>').replace(/(?:^|\s)#([^\s\.\+:!]+)/g, function (a, u) {
            return ' <a href="http://twitter.com/search?q=' + encodeURIComponent(u) + '">#' + u + '</a>';
        });
        html += '<li'+( (opts.odd && i%2 ) ? ' class="'+opts.oddClass+'"' : '')+'>'+( opts.avatar ? '<a href="http://twitter.com/'+user+'"><img src="'+ current.profile_image_url +'"></a>' : '')+'<strong>'+ user + '</strong> '+ text +'</li>' ;
    }
    html+='</ul>';
    $(element).html(html);
  };
  
  var _query = function(q)
  {
    if( typeof q == 'string' )
        return '@'+q;
    else if( typeof q == 'object' )
        return '@'+q.join(' OR @');
    throw 'data type not supported';
  }
})(jQuery);





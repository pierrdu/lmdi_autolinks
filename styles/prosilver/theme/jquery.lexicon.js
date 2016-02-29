var $acronym;

function showEntry(e) 
{
	var cache = [];	// cache MRU list
	var cacheSize = 0;	// size of cache in chars (bytes?)
	var source = "ext/lmdi/gloss/core/lexicon.php";
	var id = this.className.substr(2);

	$("#lexiconEntry").remove();

	if (id) 
	{
	//	cached = checkCache(id);
	//	if (cached) {
	//	displayEntry(cached['id']);
	//	} else{
	$acronym = this;
	$('<div class="loading" id="lexiconEntry"><br><br><br></div>').insertAfter($acronym);
	$.get(source, {id: id}, function(txt) {
		$('#lexiconEntry').html(txt).removeClass('loading');
		$('#lexiconClose').click(function() { $("#lexiconEntry").remove(); return false; } );
	// addToCache(id, entry, txt.length);
	});
	// }
	}
}

function checkCache(id) 
{
	for (var i = 0; i < cache.length; i++)
	if (cache[i]['id'] == id) {
		cache.unshift(cache.splice(i, 1)[0]);
		return cache[0];
		}
	return false;
}

function addToCache(id, size) 
{
	while (cache.length && (cacheSize + size > options.maxCacheSize)) 
	{
		var cached = cache.pop();
		cacheSize -= cached['size'];
	}
	cache.push (
		{
		id: id,
		size: size
		}
		);
	cacheSize += size;
}

function displayEntry(entry) 
{
	if (!entry)
		return;
	$results.html(entry).show();
}

$(document).ready(function() {
	$("acronym").each(function(e){
		if (this.className) $(this).bind("click",showEntry);
		});
	});
function autolinks_check_all(source) {
	var checkboxes = document.getElementsByName('mark_autolinks_forum[]');
	var n=checkboxes.length;
	for(var i=0; i<n; i++) {
		checkboxes[i].checked = source.checked;
	}
}

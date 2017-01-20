function fetchSearchResults(searchQuery) {
  console.log(searchQuery);
}

// callback when the search query value changes
$('#searchQuery').on('change keyup paste', (event) => {
  // event.preventDefault();
  let searchQuery = $('#searchQuery').val();
  fetchSearchResults(searchQuery);
});

$('#searchQuery').focus((event) => {
  $('#searchResults').css('display', 'block');
});

$('#searchQuery').focusout((event) => {
  if ($('#searchQuery').val() === '') {
    $('#searchResults').css('display', 'none');
  }
  
});
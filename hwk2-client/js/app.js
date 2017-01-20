/* DOM manipulation */

// show the div that contains search suggestions
function showSearchSuggestions() {
  $('#searchSuggestions').css('display', 'block');
};

// hide the div that contains search suggestions
function hideSearchSuggestions() {
  if ($('#searchQuery').val() === '') {
    $('#searchSuggestions').css('display', 'none');
  }
};

// render an array of search result strings (replace state)
function renderSearchSuggestions(searchSuggestions) {
  $('ul').empty();
  for (let searchSuggestion of searchSuggestions) {
    $('#searchSuggestions ul').append(`<li>${searchSuggestion}</li>`);
  }
}


/* Logic */
var data = ['micro', 'microwave', 'dog', 'cat', 'bird', 'person', 'plane', 'cow'];

// fetch a list of search suggestions for a particular search query
function fetchSearchSuggestions(searchQuery) {
  let shuffled = _.shuffle(data);
  return _.slice(shuffled, 0, 2);
}

// callback when the search query value changes
$('#searchQuery').on('change keyup', (event) => {
  let searchQuery = $('#searchQuery').val();
  if (searchQuery) {
    let searchSuggestions = fetchSearchSuggestions(searchQuery);
    renderSearchSuggestions(searchSuggestions);
    if ($('#searchSuggestions').css('display') === 'none') {
      // this is needed to handle the case where they start typing without losing focus and the suggestions don't show up
      showSearchSuggestions();
    }
  } else {
    hideSearchSuggestions();
  }

});



$('#searchQuery').focus((event) => {
  showSearchSuggestions();
});

$('#searchQuery').focusout((event) => {
  hideSearchSuggestions();
});
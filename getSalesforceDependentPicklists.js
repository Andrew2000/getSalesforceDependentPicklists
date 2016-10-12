var JSONString = '[["Parent 1",["Child 1-1","Child 1-2"]],["Parent 2",["Child 2-1","Child 2-2"]],["Parent 3",["Child 3-1","Child 3-2"]],["Parent 4",["Child 4-1","Child 4-2"]],["Parent 5",["Child 5-1","Child 5-2"]],["Parent 6",["Child 6-1","Child 6-2"]],["Parent 7",["Child 7-1","Child 7-2"]],["Parent 8",["Child 8-1","Child 8-2"]],["Parent 9",["Child 9-1","Child 9-2"]],["Parent 10",["Child 10-1","Child 10-2"]]]';

var items = JSON.parse(JSONString);
var one = document.getElementById("one");
var two = document.getElementById("two");

for (var key in items) {

  if (items.hasOwnProperty(key)) {
    //console.log('Market is ' + items[key][0]);

    //loop the properties to build the first select
    var option = new Option(items[key][0], key);
    one.appendChild(option);

    //for (var key2 in items[key][1]) {
    //if (items[key][1].hasOwnProperty(key2)) {
    //console.log('          Sales Exec is ' + items[key][1][key2]);
    //}
    //}
  }
}

//add event handler on the first
one.addEventListener("change", function(e) {
  var value = e.target.value;

  //clear the second
  for (var i = two.options.length; i > 0; i--) {
    two.options[i - 1].remove();
  }

  //append items to the second
  for (var key in items) {
    if (items.hasOwnProperty(key)) {
      for (var key2 in items[key][1]) {
        if (items[key][1].hasOwnProperty(key2)) {
          if (items[key][0] == one.options[one.selectedIndex].text) {
            var option = new Option(items[key][1][key2], items[key][1][key2]);
            two.appendChild(option);


          }
        }
      }
    }
  }


});

//force a change event to set the second dropdown to the default
var changeEvent = new Event('change');
one.dispatchEvent(changeEvent);

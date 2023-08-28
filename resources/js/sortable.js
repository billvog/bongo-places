import Sortable from "sortablejs";

var el = document.getElementById("sortable-items");
var sortable = Sortable.create(el, {
    animation: 300,
});

window.sortable = sortable;

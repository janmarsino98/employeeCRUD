function select_tab(event) {
    all_tabs = document.getElementsByClassName("navoption");
    tab_contents = document.getElementsByClassName("container");

    for (i = 0; i < all_tabs.length; i++) {
        if (all_tabs[i].classList.contains('selected')) {
            all_tabs[i].classList.remove('selected');
        }
    }

    event.target.classList.add('selected');

    let eventID = event.target.id.replace("option", "");
    console.log("The evnet ID is: " + eventID)
    for (i = 0; i < tab_contents.length; i++) {
        console.log(tab_contents[i].id)
        if (tab_contents[i].id.includes(eventID)) {
            tab_contents[i].hidden = false
        } else {
            tab_contents[i].hidden = true
        }

    }



}

var all_tabs = document.getElementsByClassName("navoption");
for (var i = 0; i < all_tabs.length; i++) {
    all_tabs[i].addEventListener("click", select_tab);
}
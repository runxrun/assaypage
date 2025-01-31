function autocomplete(inp, arr) {
    var currentFocus;

    inp.addEventListener("input", function (e) {
        var a,
            b,
            i,
            val = this.value;

        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;

        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        this.parentNode.appendChild(a);

        for (i = 0; i < arr.length; i++) {
            if (arr[i].toUpperCase().includes(val.toUpperCase())) {
                b = document.createElement("DIV");

                var startIndex = arr[i].toUpperCase().indexOf(val.toUpperCase());
                b.innerHTML = arr[i].substr(0, startIndex);
                b.innerHTML += "<strong>" + arr[i].substr(startIndex, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(startIndex + val.length);

                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";

                b.addEventListener("click", function (e) {
                    inp.value = this.getElementsByTagName("input")[0].value;

                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });

    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            currentFocus++;

            addActive(x);
        } else if (e.keyCode == 38) {
            currentFocus--;

            addActive(x);
        } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;

        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = x.length - 1;

        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}

var dataMusical = [
    "Guitar",
    "Piano",
    "Drum",
    "Violin",
    "Flute",
    "Saxophone",
    "Trumpet",
    "Harp",
    "Cello",
    "Clarinet",
    "Trombone",
    "Accordion",
    "Banjo",
    "Mandolin",
    "Ukulele",
    "Bass Guitar",
    "Oboe",
    "Bassoon",
    "Harmonica",
    "Bagpipes",
    "Marimba",
    "Xylophone",
    "Timpani",
    "Cymbals",
    "Triangle",
    "Tambourine",
    "Castanets",
    "Gong",
    "Synthesizer",
    "Enya Nova Go Mini Acoustic Guitar Carbon Integral Molded 1/4 Size Mini Guitar Beginner Kit with Guitar Case (Black)",
    "Yamaha 6-string series A1M acoustic electric guitar mahogany, tobacco sunburst, dreadnought cutaway TBS",
];

autocomplete(document.getElementById("searchAutoComplete"), dataMusical);

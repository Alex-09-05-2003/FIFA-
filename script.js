// Schimbă textul unui paragraf la apăsarea unui buton
function schimbaTextul() {
    const paragraf = document.getElementById("paragraf");
    if (paragraf) {
        paragraf.innerHTML = "Textul a fost schimbat!";
    }
}

// Adaugă un mesaj în consolă când pagina este încărcată
window.onload = function () {
    console.log("Pagina a fost încărcată cu succes!");
};
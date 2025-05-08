import "./bootstrap";
import * as bootstrap from 'bootstrap'; 

document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Procura por um modal que tenha um campo com erro
    let modais = document.querySelectorAll(".modal");

    for (let modal of modais) {
        if (modal.querySelector(".is-invalid")) {
            let myModal = new bootstrap.Modal(modal);
            myModal.show();
            break; // Para o loop após abrir o primeiro modal com erro
        }
    }
});

import './bootstrap';

import Alpine from 'alpinejs';

import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

window.toast = (message, type = "success") => {
    Toastify({
        text: message,
        duration: 3000,
        gravity: "bottom", 
        position: "right",
        style: {
          background: "#ffcc00",
          color: "#000000",
          borderRadius: "8px",
        },
    }).showToast();
};

window.Alpine = Alpine;

Alpine.start();

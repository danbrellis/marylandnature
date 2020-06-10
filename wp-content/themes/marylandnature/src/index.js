import "./styles/all.scss";

import Vue from "vue/dist/vue.js";
import { library, dom } from "@fortawesome/fontawesome-svg-core";
import {
  faCalendarAlt,
  faEnvelope,
  faExclamationCircle,
  faHeart,
  faMapPin,
  faPaperPlane,
  faPhone,
  faSearch,
    faTags,
} from "@fortawesome/free-solid-svg-icons";
import {
  faCheckSquare,
  faClock
} from "@fortawesome/free-regular-svg-icons";
import {
  faFacebook,
  faInstagram,
  faMeetup,
  faTwitter,
} from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "alpinejs";

//for using icon package in html
dom.watch();

library.add(
  faCalendarAlt,
  faClock,
  faCheckSquare,
  faEnvelope,
  faExclamationCircle,
  faHeart,
  faMapPin,
  faPaperPlane,
  faPhone,
  faSearch,
    faTags
);
library.add(faFacebook, faInstagram, faMeetup, faTwitter);

Vue.component("font-awesome-icon", FontAwesomeIcon);

document.addEventListener("DOMContentLoaded", (event) => {
  /* Add animation to sidebar menu */
  const sidebarMenu = document.getElementById("menu-sidebar-menu");
  if (sidebarMenu) {
    let submenus = sidebarMenu.getElementsByClassName("sub-menu");
    Array.from(submenus).forEach((menu) => {
      let display = menu.style.display;
      menu.style.setProperty("display", "block");
      let h = menu.scrollHeight;
      menu.style.setProperty("display", display);
      menu.style.setProperty("--height", h + "px");
    });
  }
});

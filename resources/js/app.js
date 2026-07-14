require('./bootstrap');

require('alpinejs');


// // Initialization for ES Users
// import { Select, Ripple, Modal, initTE } from "tw-elements";
// initTE({ Select, Ripple, Modal });

// import { Datepicker, Input } from "tw-elements";

const myInput = new Input(document.getElementById("myDatepicker"));
const options = {
  format: "dd-mm-yyyy",
};
const myDatepicker = new Datepicker(
  document.getElementById("myDatepicker"),
  options
);
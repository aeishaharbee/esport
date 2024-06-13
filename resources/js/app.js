import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import "flowbite";

import Datepicker from "flowbite-datepicker/Datepicker";
import DateRangePicker from "flowbite-datepicker/DateRangePicker";

const datepickerEl = document.getElementById("datepickerId");
if (datepickerEl) {
    new Datepicker(datepickerEl, {
        // options
    });
}

// Initialize Date Range Picker
const dateRangePickerEl = document.getElementById("dateRangePickerId");
if (dateRangePickerEl) {
    new DateRangePicker(dateRangePickerEl, {
        // options
    });
}

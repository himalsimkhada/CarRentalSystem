import "./bootstrap";
import "laravel-datatables-vite";

// Import Alertify (directly from node_modules)
import alertify from 'alertifyjs';
window.alertify = alertify;

import swal from "sweetalert2";
window.Swal = swal;

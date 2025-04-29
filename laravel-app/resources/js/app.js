import './bootstrap';
import * as docx from 'docx';
window.docx = docx; // Expose to global scope
console.log("-----")
console.log('app.js loaded, docx:', window.docx);
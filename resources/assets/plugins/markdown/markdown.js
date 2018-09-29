import markdown_css from './markdown_css.js';
import markdown_theme from './markdown_theme.js';
let  markdown_theme_dom, add_where;
markdown_theme_dom = document.createElement("style");
markdown_theme_dom.innerHTML = markdown_css + markdown_theme;
add_where = document.getElementsByTagName("head")[0];
if(null !== document.getElementById("markdown_container")) {
  add_where.appendChild(markdown_theme_dom);
  let $, arr_addClass;
  $ = document.querySelectorAll.bind(document);
  arr_addClass = $("#markdown_container > pre");
  for(let i = 0; i < arr_addClass.length; i++) {
    arr_addClass[i].className += " prettyprint linenums ";
  }
}
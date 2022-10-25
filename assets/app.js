/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'iconify-icon';
import './styles/global.scss';
import './styles/basic_styles.css';
import 'bootstrap/scss/bootstrap.scss';

//import '~/bootstrap/scss/bootstrap.scss';
const $ = require('jquery');
global.$ = global.jQuery = $;

//am4art
/*import './js/amcharts/core';
import './js/amcharts/charts';
import './js/amcharts/wordCloud';
import './js/amcharts/moonrisekingdom';
import './js/amcharts/animated';*/

am4core = global.am4core = require("@amcharts/amcharts4/core");
am4charts = global.am4charts = require("@amcharts/amcharts4/charts");
am4plugins_wordCloud = global.am4plugins_wordCloud = require( "@amcharts/amcharts4/plugins/wordCloud");
//am4themes_animated = global.am4themes_animated = require( "@amcharts/amcharts4/themes/animated");
am4themes_moonrisekingdom = global.am4themes_moonrisekingdom = require( "@amcharts/amcharts4/themes/moonrisekingdom");

// start the Stimulus application
import 'bootstrap';



//import 'bootstrap/scss/bootstrap.scss';


global.$ = global.jQuery = require('jquery');




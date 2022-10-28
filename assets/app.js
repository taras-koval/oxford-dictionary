/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import './styles/app.css';
import 'iconify-icon';
import './styles/global.scss';
import './styles/basic_styles.css';
import 'bootstrap/scss/bootstrap.scss';
import 'jquery-ui/themes/base/autocomplete.css';
import 'jquery-bootstrap-theme/css/custom-theme/jquery-ui-1.10.3.custom.css';

const $ = require('jquery');
global.$ = global.jQuery = $;

am4core = global.am4core = require("@amcharts/amcharts4/core");
am4charts = global.am4charts = require("@amcharts/amcharts4/charts");
am4plugins_wordCloud = global.am4plugins_wordCloud = require( "@amcharts/amcharts4/plugins/wordCloud");
am4themes_moonrisekingdom = global.am4themes_moonrisekingdom = require( "@amcharts/amcharts4/themes/moonrisekingdom");

const autocomplete = require("jquery-ui/ui/widgets/autocomplete"); //require( "jquery-ui/ui/widgets/autocomplete" );
import quickSearch from "./js/quickSearch";
import 'bootstrap';

global.$ = global.jQuery = require('jquery');
